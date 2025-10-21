#!/bin/bash

# Monitor Coespaces Script
# Usage: ./monitor-coespaces.sh [options]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_header() {
    echo -e "${BLUE}=== $1 ===${NC}"
}

# Parse options
MONITOR_ALL=false
MONITOR_SPECIFIC=""
SHOW_DETAILS=false
EXPORT_REPORT=false
REPORT_FORMAT="text"

while [[ $# -gt 0 ]]; do
    case $1 in
        --all)
            MONITOR_ALL=true
            shift
            ;;
        --coespace)
            MONITOR_SPECIFIC="$2"
            shift 2
            ;;
        --details)
            SHOW_DETAILS=true
            shift
            ;;
        --export)
            EXPORT_REPORT=true
            shift
            ;;
        --format)
            REPORT_FORMAT="$2"
            shift 2
            ;;
        --help)
            show_help
            exit 0
            ;;
        *)
            print_error "Unknown option: $1"
            show_help
            exit 1
            ;;
    esac
done

# Show help
show_help() {
    echo "Monitor Coespaces Script"
    echo ""
    echo "Usage: $0 [options]"
    echo ""
    echo "Options:"
    echo "  --all                    Monitor all coespaces"
    echo "  --coespace <name>        Monitor specific coespace"
    echo "  --details                Show detailed information"
    echo "  --export                 Export monitoring report"
    echo "  --format <format>        Report format (text, json, csv)"
    echo "  --help                   Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0 --all"
    echo "  $0 --coespace bcn-buffalo-cannabis-network --details"
    echo "  $0 --all --export --format json"
}

# Monitor all coespaces
monitor_all_coespaces() {
    print_header "Monitoring All Coespaces"
    
    COESPACES_DIR=".cursor/coespaces"
    TOTAL_COESPACES=0
    ACTIVE_COESPACES=0
    ISSUES_FOUND=0
    
    for coespace in "$COESPACES_DIR"/*; do
        if [ -d "$coespace" ] && [ -f "$coespace/coespace-config.json" ]; then
            coespace_name=$(basename "$coespace")
            monitor_coespace "$coespace_name"
            TOTAL_COESPACES=$((TOTAL_COESPACES + 1))
        fi
    done
    
    print_header "Monitoring Summary"
    echo "Total Coespaces: $TOTAL_COESPACES"
    echo "Active Coespaces: $ACTIVE_COESPACES"
    echo "Issues Found: $ISSUES_FOUND"
}

# Monitor specific coespace
monitor_specific_coespace() {
    print_header "Monitoring Coespace: $MONITOR_SPECIFIC"
    
    COESPACE_DIR=".cursor/coespaces/$MONITOR_SPECIFIC"
    
    if [ ! -d "$COESPACE_DIR" ]; then
        print_error "Coespace '$MONITOR_SPECIFIC' not found!"
        exit 1
    fi
    
    monitor_coespace "$MONITOR_SPECIFIC"
}

# Monitor individual coespace
monitor_coespace() {
    local coespace_name="$1"
    local coespace_dir=".cursor/coespaces/$coespace_name"
    
    print_header "Monitoring: $coespace_name"
    
    # Check coespace status
    check_coespace_status "$coespace_name"
    
    # Check development environment
    check_development_environment "$coespace_name"
    
    # Check deployment status
    check_deployment_status "$coespace_name"
    
    # Check resource usage
    check_resource_usage "$coespace_name"
    
    # Check security
    check_security "$coespace_name"
    
    # Check performance
    check_performance "$coespace_name"
    
    echo ""
}

# Check coespace status
check_coespace_status() {
    local coespace_name="$1"
    local coespace_dir=".cursor/coespaces/$coespace_name"
    
    print_status "Checking coespace status..."
    
    # Check if coespace is active
    if [ -f "$coespace_dir/.active" ]; then
        print_status "✓ Coespace is active"
    else
        print_warning "⚠ Coespace is not active"
    fi
    
    # Check last activity
    if [ -f "$coespace_dir/.last_activity" ]; then
        last_activity=$(cat "$coespace_dir/.last_activity")
        print_status "Last activity: $last_activity"
    else
        print_warning "No activity recorded"
    fi
    
    # Check configuration validity
    if jq empty "$coespace_dir/coespace-config.json" 2>/dev/null; then
        print_status "✓ Configuration is valid"
    else
        print_error "✗ Configuration is invalid"
    fi
}

# Check development environment
check_development_environment() {
    local coespace_name="$1"
    local coespace_dir=".cursor/coespaces/$coespace_name"
    
    print_status "Checking development environment..."
    
    # Check Docker containers
    if [ -f "$coespace_dir/docker-compose.yml" ]; then
        cd "$coespace_dir"
        
        if docker compose ps | grep -q "Up"; then
            print_status "✓ Docker containers are running"
        else
            print_warning "⚠ Docker containers are not running"
        fi
        
        cd - > /dev/null
    fi
    
    # Check dependencies
    if [ -f "$coespace_dir/package.json" ]; then
        if [ -d "$coespace_dir/node_modules" ]; then
            print_status "✓ Node.js dependencies installed"
        else
            print_warning "⚠ Node.js dependencies not installed"
        fi
    fi
    
    if [ -f "$coespace_dir/composer.json" ]; then
        if [ -d "$coespace_dir/vendor" ]; then
            print_status "✓ PHP dependencies installed"
        else
            print_warning "⚠ PHP dependencies not installed"
        fi
    fi
}

# Check deployment status
check_deployment_status() {
    local coespace_name="$1"
    local coespace_dir=".cursor/coespaces/$coespace_name"
    
    print_status "Checking deployment status..."
    
    # Check staging deployment
    staging_url=$(jq -r '.development.staging_url' "$coespace_dir/coespace-config.json")
    if [ "$staging_url" != "null" ] && [ "$staging_url" != "" ]; then
        if curl -s --head "$staging_url" | head -n 1 | grep -q "200 OK"; then
            print_status "✓ Staging environment is accessible"
        else
            print_warning "⚠ Staging environment is not accessible"
        fi
    fi
    
    # Check production deployment
    production_url=$(jq -r '.development.production_url' "$coespace_dir/coespace-config.json")
    if [ "$production_url" != "null" ] && [ "$production_url" != "" ]; then
        if curl -s --head "$production_url" | head -n 1 | grep -q "200 OK"; then
            print_status "✓ Production environment is accessible"
        else
            print_warning "⚠ Production environment is not accessible"
        fi
    fi
    
    # Check last deployment
    if [ -f "$coespace_dir/.last_deployment" ]; then
        last_deployment=$(cat "$coespace_dir/.last_deployment")
        print_status "Last deployment: $last_deployment"
    else
        print_warning "No deployment recorded"
    fi
}

# Check resource usage
check_resource_usage() {
    local coespace_name="$1"
    local coespace_dir=".cursor/coespaces/$coespace_name"
    
    print_status "Checking resource usage..."
    
    # Check disk usage
    disk_usage=$(du -sh "$coespace_dir" 2>/dev/null | cut -f1)
    print_status "Disk usage: $disk_usage"
    
    # Check Docker resource usage
    if [ -f "$coespace_dir/docker-compose.yml" ]; then
        cd "$coespace_dir"
        
        if docker compose ps | grep -q "Up"; then
            container_stats=$(docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}" 2>/dev/null | grep "$coespace_name" || true)
            if [ -n "$container_stats" ]; then
                print_status "Container resource usage:"
                echo "$container_stats"
            fi
        fi
        
        cd - > /dev/null
    fi
}

# Check security
check_security() {
    local coespace_name="$1"
    local coespace_dir=".cursor/coespaces/$coespace_name"
    
    print_status "Checking security..."
    
    # Check for .env file
    if [ -f "$coespace_dir/.env" ]; then
        print_status "✓ Environment file exists"
    else
        print_warning "⚠ Environment file missing"
    fi
    
    # Check for sensitive files
    sensitive_files=(".env" "wp-config.php" "config.php")
    for file in "${sensitive_files[@]}"; do
        if [ -f "$coespace_dir/$file" ]; then
            if grep -q "$file" "$coespace_dir/.gitignore" 2>/dev/null; then
                print_status "✓ $file is in .gitignore"
            else
                print_warning "⚠ $file is not in .gitignore"
            fi
        fi
    done
    
    # Check for outdated dependencies
    if [ -f "$coespace_dir/package.json" ]; then
        if [ -f "$coespace_dir/package-lock.json" ]; then
            if npm audit --audit-level moderate 2>/dev/null | grep -q "found 0 vulnerabilities"; then
                print_status "✓ No security vulnerabilities found"
            else
                print_warning "⚠ Security vulnerabilities found in Node.js dependencies"
            fi
        fi
    fi
}

# Check performance
check_performance() {
    local coespace_name="$1"
    local coespace_dir=".cursor/coespaces/$coespace_name"
    
    print_status "Checking performance..."
    
    # Check staging performance
    staging_url=$(jq -r '.development.staging_url' "$coespace_dir/coespace-config.json")
    if [ "$staging_url" != "null" ] && [ "$staging_url" != "" ]; then
        response_time=$(curl -o /dev/null -s -w "%{time_total}" "$staging_url" 2>/dev/null || echo "N/A")
        if [ "$response_time" != "N/A" ]; then
            print_status "Staging response time: ${response_time}s"
        fi
    fi
    
    # Check production performance
    production_url=$(jq -r '.development.production_url' "$coespace_dir/coespace-config.json")
    if [ "$production_url" != "null" ] && [ "$production_url" != "" ]; then
        response_time=$(curl -o /dev/null -s -w "%{time_total}" "$production_url" 2>/dev/null || echo "N/A")
        if [ "$response_time" != "N/A" ]; then
            print_status "Production response time: ${response_time}s"
        fi
    fi
    
    # Check build size
    if [ -d "$coespace_dir/dist" ]; then
        build_size=$(du -sh "$coespace_dir/dist" 2>/dev/null | cut -f1)
        print_status "Build size: $build_size"
    fi
}

# Export monitoring report
export_report() {
    local format="$1"
    
    print_header "Exporting Monitoring Report"
    
    case "$format" in
        "json")
            export_json_report
            ;;
        "csv")
            export_csv_report
            ;;
        "text"|*)
            export_text_report
            ;;
    esac
}

# Export JSON report
export_json_report() {
    local report_file="coespace-monitoring-report-$(date +%Y%m%d-%H%M%S).json"
    
    echo "{" > "$report_file"
    echo "  \"timestamp\": \"$(date -Iseconds)\"," >> "$report_file"
    echo "  \"coespaces\": [" >> "$report_file"
    
    # Add coespace data here
    
    echo "  ]" >> "$report_file"
    echo "}" >> "$report_file"
    
    print_status "JSON report exported to: $report_file"
}

# Export CSV report
export_csv_report() {
    local report_file="coespace-monitoring-report-$(date +%Y%m%d-%H%M%S).csv"
    
    echo "Coespace,Status,Last Activity,Staging Status,Production Status,Disk Usage" > "$report_file"
    
    # Add coespace data here
    
    print_status "CSV report exported to: $report_file"
}

# Export text report
export_text_report() {
    local report_file="coespace-monitoring-report-$(date +%Y%m%d-%H%M%S).txt"
    
    {
        echo "Coespace Monitoring Report"
        echo "Generated: $(date)"
        echo "================================"
        echo ""
        
        # Add coespace data here
        
    } > "$report_file"
    
    print_status "Text report exported to: $report_file"
}

# Main script logic
if [ "$MONITOR_ALL" = true ]; then
    monitor_all_coespaces
elif [ -n "$MONITOR_SPECIFIC" ]; then
    monitor_specific_coespace
else
    show_help
    exit 1
fi

if [ "$EXPORT_REPORT" = true ]; then
    export_report "$REPORT_FORMAT"
fi