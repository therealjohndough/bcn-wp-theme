#!/bin/bash
# Performance Monitoring Agent for BCN

set -e

# Configuration
REPORTS_DIR=".cursor/agents/reports"
LOG_DIR=".cursor/agents/logs"
STAGING_URL="https://staging6.buffalocannabisnetwork.com"
PROD_URL="https://buffalocannabisnetwork.com"

# Create directories
mkdir -p "$REPORTS_DIR" "$LOG_DIR"

# Logging function
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_DIR/performance.log"
}

# Run Lighthouse audit
run_lighthouse() {
    local url="$1"
    local environment="$2"
    local output_file="$REPORTS_DIR/lighthouse-${environment}.json"
    
    log "🔍 Running Lighthouse audit for $environment"
    
    if command -v lighthouse >/dev/null 2>&1; then
        lighthouse "$url" \
            --output=json \
            --output-path="$output_file" \
            --chrome-flags="--headless" \
            --quiet
        
        # Extract scores
        local performance=$(jq -r '.categories.performance.score * 100' "$output_file" 2>/dev/null || echo "0")
        local accessibility=$(jq -r '.categories.accessibility.score * 100' "$output_file" 2>/dev/null || echo "0")
        local seo=$(jq -r '.categories.seo.score * 100' "$output_file" 2>/dev/null || echo "0")
        local best_practices=$(jq -r '.categories."best-practices".score * 100' "$output_file" 2>/dev/null || echo "0")
        
        log "📊 $environment Performance Scores:"
        log "  Performance: ${performance}%"
        log "  Accessibility: ${accessibility}%"
        log "  SEO: ${seo}%"
        log "  Best Practices: ${best_practices}%"
        
        # Check thresholds
        local thresholds=(90 90 90 90)
        local scores=($performance $accessibility $seo $best_practices)
        local categories=("Performance" "Accessibility" "SEO" "Best Practices")
        
        for i in "${!scores[@]}"; do
            if (( $(echo "${scores[$i]} < ${thresholds[$i]}" | bc -l) )); then
                log "⚠️  ${categories[$i]} below threshold: ${scores[$i]}% < ${thresholds[$i]}%"
            else
                log "✅ ${categories[$i]} meets threshold: ${scores[$i]}%"
            fi
        done
        
    else
        log "❌ Lighthouse not installed. Install with: npm install -g lighthouse"
        return 1
    fi
}

# Check page load times
check_page_speed() {
    local url="$1"
    local environment="$2"
    
    log "⏱️  Checking page speed for $environment"
    
    # Get page size
    local page_size=$(curl -s -o /dev/null -w "%{size_download}" "$url")
    local page_size_kb=$((page_size / 1024))
    
    # Get load time
    local load_time=$(curl -s -o /dev/null -w "%{time_total}" "$url")
    
    log "📏 $environment Page Metrics:"
    log "  Size: ${page_size_kb}KB"
    log "  Load Time: ${load_time}s"
    
    # Save metrics
    echo "{\"size_kb\": $page_size_kb, \"load_time\": $load_time, \"timestamp\": \"$(date -u +%Y-%m-%dT%H:%M:%SZ)\"}" > "$REPORTS_DIR/page-speed-${environment}.json"
}

# Check Core Web Vitals
check_core_web_vitals() {
    local url="$1"
    local environment="$2"
    
    log "🎯 Checking Core Web Vitals for $environment"
    
    # This would typically use PageSpeed Insights API or similar
    # For now, we'll use basic curl metrics
    local response_time=$(curl -s -o /dev/null -w "%{time_total}" "$url")
    local http_code=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    
    if [ "$http_code" = "200" ]; then
        log "✅ $environment is responding (${response_time}s)"
    else
        log "❌ $environment returned HTTP $http_code"
    fi
}

# Generate performance report
generate_report() {
    local report_file="$REPORTS_DIR/performance-report-$(date +%Y%m%d-%H%M%S).md"
    
    log "📋 Generating performance report"
    
    cat > "$report_file" << EOF
# BCN Performance Report
Generated: $(date)

## Staging Environment
- URL: $STAGING_URL
- Status: $(curl -s -o /dev/null -w "%{http_code}" "$STAGING_URL")

## Production Environment
- URL: $PROD_URL
- Status: $(curl -s -o /dev/null -w "%{http_code}" "$PROD_URL")

## Recent Lighthouse Scores
EOF

    # Add Lighthouse scores if available
    if [ -f "$REPORTS_DIR/lighthouse-staging.json" ]; then
        echo "### Staging" >> "$report_file"
        jq -r '.categories | to_entries[] | "- \(.key): \(.value.score * 100 | floor)%"' "$REPORTS_DIR/lighthouse-staging.json" >> "$report_file"
    fi
    
    if [ -f "$REPORTS_DIR/lighthouse-production.json" ]; then
        echo "### Production" >> "$report_file"
        jq -r '.categories | to_entries[] | "- \(.key): \(.value.score * 100 | floor)%"' "$REPORTS_DIR/lighthouse-production.json" >> "$report_file"
    fi
    
    log "📄 Report saved to: $report_file"
}

# Main execution
main() {
    log "🚀 Starting BCN Performance Monitoring"
    
    # Check staging
    run_lighthouse "$STAGING_URL" "staging"
    check_page_speed "$STAGING_URL" "staging"
    check_core_web_vitals "$STAGING_URL" "staging"
    
    # Check production
    run_lighthouse "$PROD_URL" "production"
    check_page_speed "$PROD_URL" "production"
    check_core_web_vitals "$PROD_URL" "production"
    
    # Generate report
    generate_report
    
    log "🎉 Performance monitoring completed"
}

# Run if called directly
if [ "${BASH_SOURCE[0]}" = "${0}" ]; then
    main "$@"
fi