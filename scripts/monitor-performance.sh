#!/bin/bash
# BCN Theme Performance Monitoring Script
# Monitors theme performance, accessibility, and functionality

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
MONITORING_DIR="$(pwd)/monitoring-results"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# Create monitoring directory
mkdir -p "$MONITORING_DIR"

echo -e "${BLUE}📊 BCN Theme Performance Monitoring${NC}"
echo "====================================="
echo "Timestamp: $(date)"
echo "Monitoring Directory: $MONITORING_DIR"
echo ""

# Function to check URL performance
check_url_performance() {
    local url="$1"
    local environment="$2"
    local output_file="$MONITORING_DIR/${environment}_performance_${TIMESTAMP}.json"
    
    echo -e "${BLUE}🔍 Checking $environment performance...${NC}"
    
    # Use curl to get basic performance metrics
    curl -w "@-" -o /dev/null -s "$url" << 'EOF' > "$output_file"
{
    "time_namelookup": %{time_namelookup},
    "time_connect": %{time_connect},
    "time_appconnect": %{time_appconnect},
    "time_pretransfer": %{time_pretransfer},
    "time_redirect": %{time_redirect},
    "time_starttransfer": %{time_starttransfer},
    "time_total": %{time_total},
    "http_code": %{http_code},
    "size_download": %{size_download},
    "speed_download": %{speed_download}
}
EOF
    
    # Parse and display results
    local http_code=$(jq -r '.http_code' "$output_file")
    local total_time=$(jq -r '.time_total' "$output_file")
    local download_size=$(jq -r '.size_download' "$output_file")
    local download_speed=$(jq -r '.speed_download' "$output_file")
    
    echo "  HTTP Status: $http_code"
    echo "  Total Time: ${total_time}s"
    echo "  Download Size: $(($download_size / 1024))KB"
    echo "  Download Speed: $(($download_speed / 1024))KB/s"
    
    # Check if performance is acceptable
    if (( $(echo "$total_time > 3.0" | bc -l) )); then
        echo -e "  ${YELLOW}⚠️  Warning: Page load time is slow (>3s)${NC}"
    else
        echo -e "  ${GREEN}✅ Page load time is acceptable${NC}"
    fi
}

# Function to check specific pages
check_page_performance() {
    local base_url="$1"
    local environment="$2"
    local pages=(
        "/"
        "/members/"
        "/events/"
        "/about/"
        "/contact/"
    )
    
    echo -e "${BLUE}🔍 Checking $environment page performance...${NC}"
    
    for page in "${pages[@]}"; do
        local full_url="${base_url}${page}"
        local page_name=$(echo "$page" | sed 's/\///g' || echo "home")
        local output_file="$MONITORING_DIR/${environment}_${page_name}_${TIMESTAMP}.json"
        
        echo "  Checking: $full_url"
        
        curl -w "@-" -o /dev/null -s "$full_url" << 'EOF' > "$output_file"
{
    "url": "%{url_effective}",
    "http_code": %{http_code},
    "time_total": %{time_total},
    "size_download": %{size_download},
    "speed_download": %{speed_download}
}
EOF
        
        local http_code=$(jq -r '.http_code' "$output_file")
        local total_time=$(jq -r '.time_total' "$output_file")
        
        if [ "$http_code" = "200" ]; then
            echo -e "    ${GREEN}✅ $page_name: ${total_time}s${NC}"
        else
            echo -e "    ${RED}❌ $page_name: HTTP $http_code${NC}"
        fi
    done
}

# Function to check member directory functionality
check_member_directory() {
    local base_url="$1"
    local environment="$2"
    local output_file="$MONITORING_DIR/${environment}_member_directory_${TIMESTAMP}.json"
    
    echo -e "${BLUE}🔍 Checking $environment member directory...${NC}"
    
    # Check if member directory page loads
    local member_url="${base_url}/members/"
    local response=$(curl -s -o /dev/null -w "%{http_code}" "$member_url")
    
    if [ "$response" = "200" ]; then
        echo -e "  ${GREEN}✅ Member directory page loads successfully${NC}"
        
        # Check for member cards
        local page_content=$(curl -s "$member_url")
        if echo "$page_content" | grep -q "member-card"; then
            echo -e "  ${GREEN}✅ Member cards found on page${NC}"
        else
            echo -e "  ${YELLOW}⚠️  Warning: Member cards not found${NC}"
        fi
        
        # Check for enhanced features
        if echo "$page_content" | grep -q "member-card-enhanced"; then
            echo -e "  ${GREEN}✅ Enhanced member cards detected${NC}"
        else
            echo -e "  ${YELLOW}⚠️  Warning: Enhanced member cards not detected${NC}"
        fi
        
        # Check for filtering functionality
        if echo "$page_content" | grep -q "member-archive.*filter"; then
            echo -e "  ${GREEN}✅ Filtering functionality detected${NC}"
        else
            echo -e "  ${YELLOW}⚠️  Warning: Filtering functionality not detected${NC}"
        fi
        
    else
        echo -e "  ${RED}❌ Member directory page failed to load (HTTP $response)${NC}"
    fi
}

# Function to check CSS and JS loading
check_assets_loading() {
    local base_url="$1"
    local environment="$2"
    local output_file="$MONITORING_DIR/${environment}_assets_${TIMESTAMP}.json"
    
    echo -e "${BLUE}🔍 Checking $environment asset loading...${NC}"
    
    # Check main CSS file
    local css_url="${base_url}/wp-content/themes/bcn-wp-theme/assets/css/member-cards-enhanced.css"
    local css_response=$(curl -s -o /dev/null -w "%{http_code}" "$css_url")
    
    if [ "$css_response" = "200" ]; then
        echo -e "  ${GREEN}✅ Enhanced CSS loads successfully${NC}"
    else
        echo -e "  ${RED}❌ Enhanced CSS failed to load (HTTP $css_response)${NC}"
    fi
    
    # Check main JS file
    local js_url="${base_url}/wp-content/themes/bcn-wp-theme/assets/js/member-cards-enhanced.js"
    local js_response=$(curl -s -o /dev/null -w "%{http_code}" "$js_url")
    
    if [ "$js_response" = "200" ]; then
        echo -e "  ${GREEN}✅ Enhanced JS loads successfully${NC}"
    else
        echo -e "  ${RED}❌ Enhanced JS failed to load (HTTP $js_response)${NC}"
    fi
    
    # Check theme CSS
    local theme_css_url="${base_url}/wp-content/themes/bcn-wp-theme/style.css"
    local theme_css_response=$(curl -s -o /dev/null -w "%{http_code}" "$theme_css_url")
    
    if [ "$theme_css_response" = "200" ]; then
        echo -e "  ${GREEN}✅ Theme CSS loads successfully${NC}"
    else
        echo -e "  ${RED}❌ Theme CSS failed to load (HTTP $theme_css_response)${NC}"
    fi
}

# Function to check mobile responsiveness
check_mobile_responsiveness() {
    local base_url="$1"
    local environment="$2"
    
    echo -e "${BLUE}🔍 Checking $environment mobile responsiveness...${NC}"
    
    # Check if viewport meta tag is present
    local page_content=$(curl -s "$base_url")
    if echo "$page_content" | grep -q "viewport"; then
        echo -e "  ${GREEN}✅ Viewport meta tag found${NC}"
    else
        echo -e "  ${YELLOW}⚠️  Warning: Viewport meta tag not found${NC}"
    fi
    
    # Check for responsive CSS
    local css_content=$(curl -s "${base_url}/wp-content/themes/bcn-wp-theme/assets/css/member-cards-enhanced.css")
    if echo "$css_content" | grep -q "@media"; then
        echo -e "  ${GREEN}✅ Responsive CSS media queries found${NC}"
    else
        echo -e "  ${YELLOW}⚠️  Warning: No responsive CSS media queries found${NC}"
    fi
}

# Function to check accessibility
check_accessibility() {
    local base_url="$1"
    local environment="$2"
    
    echo -e "${BLUE}🔍 Checking $environment accessibility...${NC}"
    
    local page_content=$(curl -s "$base_url")
    
    # Check for alt attributes on images
    local images_without_alt=$(echo "$page_content" | grep -o '<img[^>]*>' | grep -v 'alt=' | wc -l)
    if [ "$images_without_alt" -eq 0 ]; then
        echo -e "  ${GREEN}✅ All images have alt attributes${NC}"
    else
        echo -e "  ${YELLOW}⚠️  Warning: $images_without_alt images without alt attributes${NC}"
    fi
    
    # Check for ARIA labels
    local aria_labels=$(echo "$page_content" | grep -o 'aria-label=' | wc -l)
    if [ "$aria_labels" -gt 0 ]; then
        echo -e "  ${GREEN}✅ ARIA labels found ($aria_labels)${NC}"
    else
        echo -e "  ${YELLOW}⚠️  Warning: No ARIA labels found${NC}"
    fi
    
    # Check for semantic HTML
    local semantic_elements=$(echo "$page_content" | grep -o '<main\|<section\|<article\|<header\|<footer' | wc -l)
    if [ "$semantic_elements" -gt 0 ]; then
        echo -e "  ${GREEN}✅ Semantic HTML elements found ($semantic_elements)${NC}"
    else
        echo -e "  ${YELLOW}⚠️  Warning: Limited semantic HTML usage${NC}"
    fi
}

# Function to generate monitoring report
generate_monitoring_report() {
    local report_file="$MONITORING_DIR/monitoring-report-${TIMESTAMP}.md"
    
    echo -e "${BLUE}📊 Generating monitoring report...${NC}"
    
    cat > "$report_file" << EOF
# BCN Theme Performance Monitoring Report

## Report Details
- **Generated**: $(date)
- **Timestamp**: $TIMESTAMP
- **Monitoring Directory**: $MONITORING_DIR

## Staging Environment
- **URL**: $STAGING_URL
- **Status**: $(curl -s -o /dev/null -w "%{http_code}" "$STAGING_URL")

## Production Environment
- **URL**: $PRODUCTION_URL
- **Status**: $(curl -s -o /dev/null -w "%{http_code}" "$PRODUCTION_URL")

## Performance Metrics
EOF

    # Add performance data from JSON files
    for json_file in "$MONITORING_DIR"/*_performance_*.json; do
        if [ -f "$json_file" ]; then
            local env_name=$(basename "$json_file" | cut -d'_' -f1)
            echo "### $env_name Performance" >> "$report_file"
            echo '```json' >> "$report_file"
            cat "$json_file" >> "$report_file"
            echo '```' >> "$report_file"
            echo "" >> "$report_file"
        fi
    done

    cat >> "$report_file" << EOF

## Recommendations
1. Monitor page load times regularly
2. Optimize images and assets
3. Implement caching strategies
4. Monitor user engagement metrics
5. Regular accessibility audits

## Next Steps
1. Review performance metrics
2. Address any issues found
3. Set up automated monitoring
4. Plan performance optimizations

EOF

    echo -e "${GREEN}✅ Monitoring report generated: $report_file${NC}"
}

# Main execution
echo -e "${BLUE}🚀 Starting performance monitoring...${NC}"
echo ""

# Check if required tools are available
if ! command -v curl &> /dev/null; then
    echo -e "${RED}❌ Error: curl is required but not installed${NC}"
    exit 1
fi

if ! command -v jq &> /dev/null; then
    echo -e "${YELLOW}⚠️  Warning: jq is not installed. Some features may not work properly.${NC}"
fi

# Monitor staging environment
echo -e "${BLUE}🔍 Monitoring Staging Environment${NC}"
echo "=================================="
check_url_performance "$STAGING_URL" "staging"
check_page_performance "$STAGING_URL" "staging"
check_member_directory "$STAGING_URL" "staging"
check_assets_loading "$STAGING_URL" "staging"
check_mobile_responsiveness "$STAGING_URL" "staging"
check_accessibility "$STAGING_URL" "staging"

echo ""

# Monitor production environment
echo -e "${BLUE}🔍 Monitoring Production Environment${NC}"
echo "====================================="
check_url_performance "$PRODUCTION_URL" "production"
check_page_performance "$PRODUCTION_URL" "production"
check_member_directory "$PRODUCTION_URL" "production"
check_assets_loading "$PRODUCTION_URL" "production"
check_mobile_responsiveness "$PRODUCTION_URL" "production"
check_accessibility "$PRODUCTION_URL" "production"

echo ""

# Generate monitoring report
generate_monitoring_report

echo -e "${GREEN}🎉 Performance monitoring completed!${NC}"
echo -e "${BLUE}📁 Results saved to: $MONITORING_DIR${NC}"
echo ""
echo -e "${YELLOW}💡 Tip: Run this script regularly to monitor theme performance${NC}"