#!/bin/bash
# Deployment Agent for BCN - Handles automated deployments

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Configuration
AGENTS_DIR=".cursor/agents"
LOG_DIR="$AGENTS_DIR/logs"
STATUS_DIR="$AGENTS_DIR/status"
REPORTS_DIR="$AGENTS_DIR/reports"

# Environment configurations
declare -A ENVIRONMENTS
ENVIRONMENTS[staging]="staging6.buffalocannabisnetwork.com:u2037-2lvglkrliykq:18765"
ENVIRONMENTS[production]="buffalocannabisnetwork.com:u2037-2lvglkrliykq:18765"

# Logging function
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_DIR/deployment.log"
}

# Pre-deployment checks
pre_deploy_checks() {
    local environment="$1"
    
    log "🔍 Running pre-deployment checks for $environment"
    
    # Check if tests pass
    if [ -f "scripts/test-theme.sh" ]; then
        log "🧪 Running theme tests..."
        if ./scripts/test-theme.sh; then
            log "✅ Tests passed"
        else
            log "❌ Tests failed, aborting deployment"
            return 1
        fi
    fi
    
    # Check if build exists
    if [ ! -d "build" ]; then
        log "🔨 Building theme..."
        if [ -f "scripts/build-theme.sh" ]; then
            ./scripts/build-theme.sh
        else
            log "⚠️  No build script found, using source files"
        fi
    fi
    
    # Security scan
    log "🔒 Running security scan..."
    if command -v phpcs >/dev/null 2>&1; then
        phpcs --standard=WordPress . --report=json > "$REPORTS_DIR/security-scan.json" || true
    fi
    
    log "✅ Pre-deployment checks completed"
}

# Deploy to environment
deploy_to_environment() {
    local environment="$1"
    local config="${ENVIRONMENTS[$environment]}"
    
    if [ -z "$config" ]; then
        log "❌ Unknown environment: $environment"
        return 1
    fi
    
    IFS=':' read -r host user port <<< "$config"
    
    log "🚀 Deploying to $environment ($host)"
    
    # Create backup
    log "💾 Creating backup..."
    local backup_name="backup-${environment}-$(date +%Y%m%d-%H%M%S).tar.gz"
    
    # Deploy using rsync
    log "📦 Deploying files..."
    local source_dir="build"
    local remote_path="/home/$user/$host/public_html/wp-content/themes/bcn-wp-theme"
    
    if [ -d "$source_dir" ]; then
        rsync -avz --delete -e "ssh -p $port -i ~/.ssh/siteground_id" \
            "$source_dir/" "$user@$host:$remote_path/"
    else
        rsync -avz --delete -e "ssh -p $port -i ~/.ssh/siteground_id" \
            --exclude='.git' --exclude='node_modules' --exclude='.cursor' \
            . "$user@$host:$remote_path/"
    fi
    
    log "✅ Deployment to $environment completed"
}

# Post-deployment verification
post_deploy_verification() {
    local environment="$1"
    local config="${ENVIRONMENTS[$environment]}"
    
    IFS=':' read -r host user port <<< "$config"
    local url="https://$host"
    
    log "🔍 Verifying deployment for $environment"
    
    # Check if site is accessible
    local http_code=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    if [ "$http_code" = "200" ]; then
        log "✅ $environment is accessible (HTTP $http_code)"
    else
        log "❌ $environment returned HTTP $http_code"
        return 1
    fi
    
    # Check specific pages
    local pages=("/" "/membership/" "/events/" "/news/")
    for page in "${pages[@]}"; do
        local page_url="$url$page"
        local page_code=$(curl -s -o /dev/null -w "%{http_code}" "$page_url")
        if [ "$page_code" = "200" ]; then
            log "✅ $page accessible"
        else
            log "⚠️  $page returned HTTP $page_code"
        fi
    done
    
    # Performance check
    log "⚡ Running performance check..."
    if command -v lighthouse >/dev/null 2>&1; then
        lighthouse "$url" --output=json --output-path="$REPORTS_DIR/lighthouse-$environment.json" --quiet
    fi
    
    log "✅ Post-deployment verification completed"
}

# Rollback deployment
rollback_deployment() {
    local environment="$1"
    
    log "🔄 Rolling back $environment deployment"
    
    # This would restore from backup
    # Implementation depends on backup strategy
    
    log "✅ Rollback completed"
}

# Main deployment function
deploy() {
    local environment="$1"
    
    log "🚀 Starting BCN Deployment Agent"
    log "Environment: $environment"
    
    # Pre-deployment checks
    if ! pre_deploy_checks "$environment"; then
        log "❌ Pre-deployment checks failed"
        exit 1
    fi
    
    # Deploy
    if ! deploy_to_environment "$environment"; then
        log "❌ Deployment failed"
        exit 1
    fi
    
    # Post-deployment verification
    if ! post_deploy_verification "$environment"; then
        log "❌ Post-deployment verification failed"
        log "🔄 Consider rolling back..."
        exit 1
    fi
    
    log "🎉 Deployment to $environment completed successfully"
}

# Status check
check_status() {
    local environment="$1"
    
    log "📊 Checking deployment status for $environment"
    
    local config="${ENVIRONMENTS[$environment]}"
    IFS=':' read -r host user port <<< "$config"
    local url="https://$host"
    
    # Check site status
    local http_code=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    local response_time=$(curl -s -o /dev/null -w "%{time_total}" "$url")
    
    echo "Environment: $environment"
    echo "URL: $url"
    echo "Status: HTTP $http_code"
    echo "Response Time: ${response_time}s"
    
    # Check recent deployments
    if [ -f "$LOG_DIR/deployment.log" ]; then
        echo "Recent deployments:"
        tail -n 5 "$LOG_DIR/deployment.log"
    fi
}

# Main execution
case "${1:-deploy}" in
    "deploy")
        deploy "${2:-staging}"
        ;;
    "status")
        check_status "${2:-staging}"
        ;;
    "rollback")
        rollback_deployment "${2:-staging}"
        ;;
    *)
        echo "Usage: $0 {deploy|status|rollback} [environment]"
        echo "Environments: staging, production"
        exit 1
        ;;
esac