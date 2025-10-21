#!/bin/bash
# BCN Theme Complete Deployment with Testing
# Main deployment script that runs tests, builds, and deploys

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
THEME_DIR="$(dirname "$SCRIPT_DIR")"
ENVIRONMENT="${1:-staging}"
SKIP_TESTS="${2:-false}"

echo -e "${BLUE}🚀 BCN Theme Complete Deployment${NC}"
echo "=================================="
echo "Environment: $ENVIRONMENT"
echo "Skip Tests: $SKIP_TESTS"
echo "Theme Directory: $THEME_DIR"
echo ""

# Function to run tests
run_tests() {
    echo -e "${BLUE}🧪 Running Theme Tests${NC}"
    echo "======================="
    
    if [ "$SKIP_TESTS" = "true" ]; then
        echo -e "${YELLOW}⚠️  Skipping tests as requested${NC}"
        return 0
    fi
    
    if [ -f "$SCRIPT_DIR/test-theme.sh" ]; then
        if "$SCRIPT_DIR/test-theme.sh"; then
            echo -e "${GREEN}✅ All tests passed${NC}"
            return 0
        else
            echo -e "${RED}❌ Tests failed${NC}"
            return 1
        fi
    else
        echo -e "${YELLOW}⚠️  Test script not found, skipping tests${NC}"
        return 0
    fi
}

# Function to build theme
build_theme() {
    echo -e "${BLUE}🏗️  Building Theme${NC}"
    echo "=================="
    
    # Create build directory
    local build_dir="$THEME_DIR/build"
    rm -rf "$build_dir"
    mkdir -p "$build_dir"
    
    # Copy theme files
    echo "Copying theme files..."
    rsync -av --exclude='.git' --exclude='node_modules' --exclude='vendor' --exclude='.github' --exclude='*.md' --exclude='scripts' --exclude='test-results' --exclude='monitoring-results' --exclude='build' "$THEME_DIR/" "$build_dir/"
    
    # Optimize assets
    echo "Optimizing assets..."
    
    # Minify CSS
    find "$build_dir/assets/css" -name "*.css" -exec sh -c '
        echo "Minifying $1"
        sed "s/\/\*.*\*\///g; s/\s\+/ /g; s/;\s*/;/g; s/{\s*/{/g; s/}\s*/}/g" "$1" > "$1.tmp"
        mv "$1.tmp" "$1"
    ' _ {} \;
    
    # Minify JavaScript
    find "$build_dir/assets/js" -name "*.js" -exec sh -c '
        echo "Minifying $1"
        sed "s/\/\/.*$//g; s/\s\+/ /g; s/;\s*/;/g" "$1" > "$1.tmp"
        mv "$1.tmp" "$1"
    ' _ {} \;
    
    # Set permissions
    find "$build_dir" -name "*.sh" -exec chmod +x {} \;
    
    # Create build manifest
    cat > "$build_dir/BUILD_MANIFEST.txt" << EOF
BCN Theme Build Manifest
========================
Build Date: $(date)
Git Commit: $(git rev-parse HEAD 2>/dev/null || echo "unknown")
Git Branch: $(git branch --show-current 2>/dev/null || echo "unknown")
Environment: $ENVIRONMENT
Build Script: deploy-with-tests.sh

Files included:
$(find "$build_dir" -type f | sort)
EOF
    
    echo -e "${GREEN}✅ Theme build completed${NC}"
    echo "Build directory: $build_dir"
}

# Function to deploy theme
deploy_theme() {
    echo -e "${BLUE}🚀 Deploying Theme${NC}"
    echo "=================="
    
    if [ "$ENVIRONMENT" = "staging" ]; then
        echo "Deploying to staging environment..."
        
        # Use existing deploy script
        if [ -f "$SCRIPT_DIR/deploy-local.sh" ]; then
            "$SCRIPT_DIR/deploy-local.sh" staging
        else
            echo -e "${RED}❌ Deploy script not found${NC}"
            return 1
        fi
    elif [ "$ENVIRONMENT" = "production" ]; then
        echo "Deploying to production environment..."
        
        # Use existing deploy script
        if [ -f "$SCRIPT_DIR/deploy-local.sh" ]; then
            "$SCRIPT_DIR/deploy-local.sh" production
        else
            echo -e "${RED}❌ Deploy script not found${NC}"
            return 1
        fi
    else
        echo -e "${RED}❌ Invalid environment: $ENVIRONMENT${NC}"
        echo "Valid environments: staging, production"
        return 1
    fi
}

# Function to verify deployment
verify_deployment() {
    echo -e "${BLUE}🔍 Verifying Deployment${NC}"
    echo "======================="
    
    local url=""
    if [ "$ENVIRONMENT" = "staging" ]; then
        url="https://staging6.buffalocannabisnetwork.com"
    else
        url="https://buffalocannabisnetwork.com"
    fi
    
    echo "Checking $url..."
    
    # Check if site is accessible
    local response=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    if [ "$response" = "200" ]; then
        echo -e "${GREEN}✅ Site is accessible (HTTP $response)${NC}"
    else
        echo -e "${RED}❌ Site is not accessible (HTTP $response)${NC}"
        return 1
    fi
    
    # Check member directory
    local member_response=$(curl -s -o /dev/null -w "%{http_code}" "$url/members/")
    if [ "$member_response" = "200" ]; then
        echo -e "${GREEN}✅ Member directory is working${NC}"
    else
        echo -e "${YELLOW}⚠️  Member directory may have issues (HTTP $member_response)${NC}"
    fi
    
    # Check enhanced assets
    local css_response=$(curl -s -o /dev/null -w "%{http_code}" "$url/wp-content/themes/bcn-wp-theme/assets/css/member-cards-enhanced.css")
    if [ "$css_response" = "200" ]; then
        echo -e "${GREEN}✅ Enhanced CSS is loading${NC}"
    else
        echo -e "${YELLOW}⚠️  Enhanced CSS may not be loading (HTTP $css_response)${NC}"
    fi
    
    local js_response=$(curl -s -o /dev/null -w "%{http_code}" "$url/wp-content/themes/bcn-wp-theme/assets/js/member-cards-enhanced.js")
    if [ "$js_response" = "200" ]; then
        echo -e "${GREEN}✅ Enhanced JS is loading${NC}"
    else
        echo -e "${YELLOW}⚠️  Enhanced JS may not be loading (HTTP $js_response)${NC}"
    fi
}

# Function to run post-deployment monitoring
run_monitoring() {
    echo -e "${BLUE}📊 Running Post-Deployment Monitoring${NC}"
    echo "====================================="
    
    if [ -f "$SCRIPT_DIR/monitor-performance.sh" ]; then
        echo "Running performance monitoring..."
        "$SCRIPT_DIR/monitor-performance.sh"
    else
        echo -e "${YELLOW}⚠️  Monitoring script not found, skipping monitoring${NC}"
    fi
}

# Function to show deployment summary
show_summary() {
    echo ""
    echo -e "${BLUE}📊 Deployment Summary${NC}"
    echo "===================="
    echo "Environment: $ENVIRONMENT"
    echo "Date: $(date)"
    echo "Git Commit: $(git rev-parse HEAD 2>/dev/null || echo "unknown")"
    echo "Git Branch: $(git branch --show-current 2>/dev/null || echo "unknown")"
    echo ""
    
    if [ "$ENVIRONMENT" = "staging" ]; then
        echo "Staging URL: https://staging6.buffalocannabisnetwork.com"
        echo "Member Directory: https://staging6.buffalocannabisnetwork.com/members/"
    else
        echo "Production URL: https://buffalocannabisnetwork.com"
        echo "Member Directory: https://buffalocannabisnetwork.com/members/"
    fi
    
    echo ""
    echo "Next Steps:"
    echo "1. Test all enhanced member features"
    echo "2. Verify responsive design"
    echo "3. Check performance metrics"
    echo "4. Monitor for any issues"
    
    if [ "$ENVIRONMENT" = "staging" ]; then
        echo "5. Deploy to production if tests pass"
    fi
}

# Main execution
main() {
    echo -e "${BLUE}🚀 Starting BCN Theme Deployment${NC}"
    echo "=================================="
    echo ""
    
    # Step 1: Run tests
    if ! run_tests; then
        echo -e "${RED}❌ Deployment aborted due to test failures${NC}"
        exit 1
    fi
    
    # Step 2: Build theme
    if ! build_theme; then
        echo -e "${RED}❌ Deployment aborted due to build failure${NC}"
        exit 1
    fi
    
    # Step 3: Deploy theme
    if ! deploy_theme; then
        echo -e "${RED}❌ Deployment aborted due to deployment failure${NC}"
        exit 1
    fi
    
    # Step 4: Verify deployment
    if ! verify_deployment; then
        echo -e "${RED}❌ Deployment verification failed${NC}"
        echo -e "${YELLOW}💡 Consider running rollback script if needed${NC}"
        exit 1
    fi
    
    # Step 5: Run monitoring
    run_monitoring
    
    # Step 6: Show summary
    show_summary
    
    echo ""
    echo -e "${GREEN}🎉 Deployment completed successfully!${NC}"
}

# Show help if requested
if [ "${1:-}" = "help" ] || [ "${1:-}" = "-h" ] || [ "${1:-}" = "--help" ]; then
    echo -e "${BLUE}BCN Theme Deployment Script${NC}"
    echo "============================="
    echo ""
    echo "Usage: $0 [environment] [skip_tests]"
    echo ""
    echo "Arguments:"
    echo "  environment    Target environment (staging|production) [default: staging]"
    echo "  skip_tests     Skip running tests (true|false) [default: false]"
    echo ""
    echo "Examples:"
    echo "  $0                    # Deploy to staging with tests"
    echo "  $0 staging            # Deploy to staging with tests"
    echo "  $0 production         # Deploy to production with tests"
    echo "  $0 staging true       # Deploy to staging without tests"
    echo "  $0 production true    # Deploy to production without tests"
    echo ""
    echo "Available Scripts:"
    echo "  test-theme.sh         # Run theme tests"
    echo "  monitor-performance.sh # Monitor performance"
    echo "  rollback-deployment.sh # Rollback deployment"
    echo ""
    exit 0
fi

# Run main function
main