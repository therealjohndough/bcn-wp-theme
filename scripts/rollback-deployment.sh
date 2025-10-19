#!/bin/bash
# BCN Theme Automated Rollback Script
# Rolls back to previous stable version in case of deployment issues

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
STAGING_URL="https://staging6.buffalocannabisnetwork.com"
PRODUCTION_URL="https://buffalocannabisnetwork.com"
BACKUP_DIR="/tmp/bcn-theme-backups"
ROLLBACK_LOG="rollback-$(date +%Y%m%d_%H%M%S).log"

echo -e "${BLUE}🔄 BCN Theme Automated Rollback${NC}"
echo "================================="
echo "Timestamp: $(date)"
echo "Log File: $ROLLBACK_LOG"
echo ""

# Function to log messages
log_message() {
    local message="$1"
    local level="$2"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] [$level] $message" | tee -a "$ROLLBACK_LOG"
}

# Function to check if environment is accessible
check_environment() {
    local url="$1"
    local env_name="$2"
    
    log_message "Checking $env_name accessibility..." "INFO"
    
    local response=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    if [ "$response" = "200" ]; then
        log_message "$env_name is accessible (HTTP $response)" "SUCCESS"
        return 0
    else
        log_message "$env_name is not accessible (HTTP $response)" "ERROR"
        return 1
    fi
}

# Function to create backup before rollback
create_backup() {
    local environment="$1"
    local backup_name="backup_${environment}_$(date +%Y%m%d_%H%M%S)"
    
    log_message "Creating backup for $environment..." "INFO"
    
    # Create backup directory
    mkdir -p "$BACKUP_DIR/$backup_name"
    
    # Set SSH parameters based on environment
    local host=""
    local user=""
    local port=""
    local remote_path=""
    
    if [ "$environment" = "staging" ]; then
        host="${SG_HOST:-staging6.buffalocannabisnetwork.com}"
        user="${SG_USER:-deploy}"
        port="${SG_PORT:-22}"
        remote_path="${SG_REMOTE_PATH:-/public_html/wp-content/themes/bcn-wp-theme}"
    else
        host="${PROD_HOST:-buffalocannabisnetwork.com}"
        user="${PROD_USER:-deploy}"
        port="${PROD_PORT:-22}"
        remote_path="${PROD_REMOTE_PATH:-/public_html/wp-content/themes/bcn-wp-theme}"
    fi
    
    # Create backup via SSH
    log_message "Creating backup from $user@$host:$remote_path" "INFO"
    
    if ssh -p "$port" "$user@$host" "tar -czf /tmp/$backup_name.tar.gz -C $remote_path ." 2>>"$ROLLBACK_LOG"; then
        log_message "Backup created successfully on remote server" "SUCCESS"
        
        # Download backup
        if scp -P "$port" "$user@$host:/tmp/$backup_name.tar.gz" "$BACKUP_DIR/$backup_name/" 2>>"$ROLLBACK_LOG"; then
            log_message "Backup downloaded to $BACKUP_DIR/$backup_name/" "SUCCESS"
            
            # Clean up remote backup
            ssh -p "$port" "$user@$host" "rm /tmp/$backup_name.tar.gz" 2>>"$ROLLBACK_LOG"
            
            echo "$backup_name" > "$BACKUP_DIR/latest_${environment}_backup"
            return 0
        else
            log_message "Failed to download backup" "ERROR"
            return 1
        fi
    else
        log_message "Failed to create backup on remote server" "ERROR"
        return 1
    fi
}

# Function to rollback to previous version
rollback_to_previous() {
    local environment="$1"
    
    log_message "Starting rollback for $environment..." "INFO"
    
    # Set SSH parameters
    local host=""
    local user=""
    local port=""
    local remote_path=""
    
    if [ "$environment" = "staging" ]; then
        host="${SG_HOST:-staging6.buffalocannabisnetwork.com}"
        user="${SG_USER:-deploy}"
        port="${SG_PORT:-22}"
        remote_path="${SG_REMOTE_PATH:-/public_html/wp-content/themes/bcn-wp-theme}"
    else
        host="${PROD_HOST:-buffalocannabisnetwork.com}"
        user="${PROD_USER:-deploy}"
        port="${PROD_PORT:-22}"
        remote_path="${PROD_REMOTE_PATH:-/public_html/wp-content/themes/bcn-wp-theme}"
    fi
    
    # Check if backup exists
    local latest_backup_file="$BACKUP_DIR/latest_${environment}_backup"
    if [ ! -f "$latest_backup_file" ]; then
        log_message "No backup found for $environment. Cannot rollback." "ERROR"
        return 1
    fi
    
    local backup_name=$(cat "$latest_backup_file")
    local backup_path="$BACKUP_DIR/$backup_name/$backup_name.tar.gz"
    
    if [ ! -f "$backup_path" ]; then
        log_message "Backup file not found: $backup_path" "ERROR"
        return 1
    fi
    
    log_message "Rolling back to backup: $backup_name" "INFO"
    
    # Upload and extract backup
    if scp -P "$port" "$backup_path" "$user@$host:/tmp/" 2>>"$ROLLBACK_LOG"; then
        log_message "Backup uploaded to remote server" "SUCCESS"
        
        # Extract backup
        if ssh -p "$port" "$user@$host" "cd $remote_path && tar -xzf /tmp/$backup_name.tar.gz && rm /tmp/$backup_name.tar.gz" 2>>"$ROLLBACK_LOG"; then
            log_message "Backup extracted successfully" "SUCCESS"
            
            # Set proper permissions
            if ssh -p "$port" "$user@$host" "chmod -R 755 $remote_path && find $remote_path -type f -name '*.php' -exec chmod 644 {} \;" 2>>"$ROLLBACK_LOG"; then
                log_message "Permissions set correctly" "SUCCESS"
                return 0
            else
                log_message "Failed to set permissions" "ERROR"
                return 1
            fi
        else
            log_message "Failed to extract backup" "ERROR"
            return 1
        fi
    else
        log_message "Failed to upload backup" "ERROR"
        return 1
    fi
}

# Function to rollback to specific git commit
rollback_to_commit() {
    local environment="$1"
    local commit_hash="$2"
    
    log_message "Rolling back to commit: $commit_hash" "INFO"
    
    # Checkout specific commit
    if git checkout "$commit_hash" 2>>"$ROLLBACK_LOG"; then
        log_message "Checked out commit $commit_hash" "SUCCESS"
        
        # Deploy the rolled back version
        if [ "$environment" = "staging" ]; then
            ./scripts/deploy-local.sh staging
        else
            ./scripts/deploy-local.sh production
        fi
        
        if [ $? -eq 0 ]; then
            log_message "Rollback deployment completed successfully" "SUCCESS"
            return 0
        else
            log_message "Rollback deployment failed" "ERROR"
            return 1
        fi
    else
        log_message "Failed to checkout commit $commit_hash" "ERROR"
        return 1
    fi
}

# Function to verify rollback
verify_rollback() {
    local environment="$1"
    local url=""
    
    if [ "$environment" = "staging" ]; then
        url="$STAGING_URL"
    else
        url="$PRODUCTION_URL"
    fi
    
    log_message "Verifying rollback for $environment..." "INFO"
    
    # Wait a moment for changes to propagate
    sleep 5
    
    # Check if site is accessible
    local response=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    if [ "$response" = "200" ]; then
        log_message "$environment is accessible after rollback" "SUCCESS"
        
        # Check if member directory works
        local member_response=$(curl -s -o /dev/null -w "%{http_code}" "$url/members/")
        if [ "$member_response" = "200" ]; then
            log_message "Member directory is working after rollback" "SUCCESS"
            return 0
        else
            log_message "Member directory is not working after rollback" "WARNING"
            return 1
        fi
    else
        log_message "$environment is not accessible after rollback (HTTP $response)" "ERROR"
        return 1
    fi
}

# Function to list available backups
list_backups() {
    echo -e "${BLUE}📋 Available Backups${NC}"
    echo "=================="
    
    if [ -d "$BACKUP_DIR" ]; then
        for backup in "$BACKUP_DIR"/*/; do
            if [ -d "$backup" ]; then
                local backup_name=$(basename "$backup")
                local backup_date=$(echo "$backup_name" | grep -o '[0-9]\{8\}_[0-9]\{6\}')
                echo "  $backup_name ($backup_date)"
            fi
        done
    else
        echo "  No backups found"
    fi
}

# Function to show recent commits
show_recent_commits() {
    echo -e "${BLUE}📋 Recent Commits${NC}"
    echo "================"
    git log --oneline -10
}

# Main execution
case "${1:-help}" in
    "staging")
        echo -e "${BLUE}🔄 Rolling back staging environment${NC}"
        echo "=================================="
        
        # Create backup first
        if create_backup "staging"; then
            log_message "Backup created successfully" "SUCCESS"
        else
            log_message "Failed to create backup, proceeding with rollback" "WARNING"
        fi
        
        # Rollback
        if rollback_to_previous "staging"; then
            log_message "Staging rollback completed" "SUCCESS"
            
            # Verify rollback
            if verify_rollback "staging"; then
                log_message "Staging rollback verified successfully" "SUCCESS"
                echo -e "${GREEN}✅ Staging rollback completed successfully!${NC}"
            else
                log_message "Staging rollback verification failed" "ERROR"
                echo -e "${RED}❌ Staging rollback verification failed${NC}"
            fi
        else
            log_message "Staging rollback failed" "ERROR"
            echo -e "${RED}❌ Staging rollback failed${NC}"
            exit 1
        fi
        ;;
        
    "production")
        echo -e "${BLUE}🔄 Rolling back production environment${NC}"
        echo "====================================="
        
        # Create backup first
        if create_backup "production"; then
            log_message "Backup created successfully" "SUCCESS"
        else
            log_message "Failed to create backup, proceeding with rollback" "WARNING"
        fi
        
        # Rollback
        if rollback_to_previous "production"; then
            log_message "Production rollback completed" "SUCCESS"
            
            # Verify rollback
            if verify_rollback "production"; then
                log_message "Production rollback verified successfully" "SUCCESS"
                echo -e "${GREEN}✅ Production rollback completed successfully!${NC}"
            else
                log_message "Production rollback verification failed" "ERROR"
                echo -e "${RED}❌ Production rollback verification failed${NC}"
            fi
        else
            log_message "Production rollback failed" "ERROR"
            echo -e "${RED}❌ Production rollback failed${NC}"
            exit 1
        fi
        ;;
        
    "commit")
        if [ -z "$2" ]; then
            echo -e "${RED}❌ Error: Please provide commit hash${NC}"
            echo "Usage: $0 commit <commit_hash> [staging|production]"
            exit 1
        fi
        
        local commit_hash="$2"
        local environment="${3:-staging}"
        
        echo -e "${BLUE}🔄 Rolling back to commit: $commit_hash${NC}"
        echo "========================================="
        
        if rollback_to_commit "$environment" "$commit_hash"; then
            echo -e "${GREEN}✅ Rollback to commit $commit_hash completed!${NC}"
        else
            echo -e "${RED}❌ Rollback to commit $commit_hash failed!${NC}"
            exit 1
        fi
        ;;
        
    "list")
        list_backups
        ;;
        
    "commits")
        show_recent_commits
        ;;
        
    "verify")
        local environment="${2:-staging}"
        echo -e "${BLUE}🔍 Verifying $environment environment${NC}"
        echo "=================================="
        
        if verify_rollback "$environment"; then
            echo -e "${GREEN}✅ $environment environment is working correctly${NC}"
        else
            echo -e "${RED}❌ $environment environment has issues${NC}"
            exit 1
        fi
        ;;
        
    "help"|*)
        echo -e "${BLUE}BCN Theme Rollback Script${NC}"
        echo "========================"
        echo ""
        echo "Usage: $0 <command> [options]"
        echo ""
        echo "Commands:"
        echo "  staging              Rollback staging environment"
        echo "  production           Rollback production environment"
        echo "  commit <hash> [env]  Rollback to specific commit"
        echo "  list                 List available backups"
        echo "  commits              Show recent commits"
        echo "  verify [env]         Verify environment status"
        echo "  help                 Show this help message"
        echo ""
        echo "Examples:"
        echo "  $0 staging                    # Rollback staging"
        echo "  $0 production                 # Rollback production"
        echo "  $0 commit abc123 staging     # Rollback to commit abc123 on staging"
        echo "  $0 list                      # List available backups"
        echo "  $0 verify staging            # Verify staging environment"
        echo ""
        echo "Environment Variables:"
        echo "  SG_HOST, SG_USER, SG_PORT, SG_REMOTE_PATH    # Staging server"
        echo "  PROD_HOST, PROD_USER, PROD_PORT, PROD_REMOTE_PATH  # Production server"
        ;;
esac

echo ""
echo -e "${BLUE}📝 Rollback log saved to: $ROLLBACK_LOG${NC}"