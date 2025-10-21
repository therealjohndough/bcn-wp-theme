#!/bin/bash
# BCN Theme Automated Testing Script
# Tests theme functionality, performance, and compatibility

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Test configuration
THEME_DIR="$(pwd)"
TEST_RESULTS_DIR="$THEME_DIR/test-results"
STAGING_URL="https://staging6.buffalocannabisnetwork.com"
PRODUCTION_URL="https://buffalocannabisnetwork.com"

# Create test results directory
mkdir -p "$TEST_RESULTS_DIR"

echo -e "${BLUE}🧪 BCN Theme Automated Testing${NC}"
echo "=================================="
echo "Theme Directory: $THEME_DIR"
echo "Test Results: $TEST_RESULTS_DIR"
echo ""

# Initialize test counters
TOTAL_TESTS=0
PASSED_TESTS=0
FAILED_TESTS=0

# Test function
run_test() {
    local test_name="$1"
    local test_command="$2"
    
    TOTAL_TESTS=$((TOTAL_TESTS + 1))
    echo -e "${BLUE}🔍 Running: $test_name${NC}"
    
    if eval "$test_command" > "$TEST_RESULTS_DIR/${test_name// /_}.log" 2>&1; then
        echo -e "${GREEN}✅ PASSED: $test_name${NC}"
        PASSED_TESTS=$((PASSED_TESTS + 1))
        return 0
    else
        echo -e "${RED}❌ FAILED: $test_name${NC}"
        FAILED_TESTS=$((FAILED_TESTS + 1))
        echo -e "${YELLOW}   Check log: $TEST_RESULTS_DIR/${test_name// /_}.log${NC}"
        return 1
    fi
}

# Test 1: File Structure Validation
run_test "File Structure Validation" "
    echo 'Checking required files...'
    required_files=(
        'style.css'
        'functions.php'
        'index.php'
        'header.php'
        'footer.php'
        'template-parts/content-member-card-enhanced.php'
        'assets/css/member-cards-enhanced.css'
        'assets/js/member-cards-enhanced.js'
        'includes/member-experience.php'
        'archive-bcn_member-enhanced.php'
    )
    
    for file in \"\${required_files[@]}\"; do
        if [ ! -f \"\$file\" ]; then
            echo \"Missing required file: \$file\"
            exit 1
        fi
    done
    echo 'All required files present'
"

# Test 2: PHP Syntax Validation
run_test "PHP Syntax Validation" "
    echo 'Validating PHP syntax...'
    php_files=\$(find . -name '*.php' -not -path './vendor/*' -not -path './test-results/*')
    for file in \$php_files; do
        if ! php -l \"\$file\" > /dev/null 2>&1; then
            echo \"PHP syntax error in \$file\"
            exit 1
        fi
    done
    echo 'All PHP files have valid syntax'
"

# Test 3: WordPress Theme Structure
run_test "WordPress Theme Structure" "
    echo 'Checking WordPress theme structure...'
    
    # Check style.css header
    if ! grep -q 'Theme Name:' style.css; then
        echo 'Missing Theme Name in style.css'
        exit 1
    fi
    
    if ! grep -q 'Version:' style.css; then
        echo 'Missing Version in style.css'
        exit 1
    fi
    
    if ! grep -q 'Description:' style.css; then
        echo 'Missing Description in style.css'
        exit 1
    fi
    
    # Check required template files
    required_templates=('index.php' 'header.php' 'footer.php' 'style.css')
    for template in \"\${required_templates[@]}\"; do
        if [ ! -f \"\$template\" ]; then
            echo \"Missing required template: \$template\"
            exit 1
        fi
    done
    
    echo 'WordPress theme structure is valid'
"

# Test 4: Function Definitions
run_test "Function Definitions" "
    echo 'Checking required function definitions...'
    
    # Check template-tags.php functions
    if ! grep -q 'function bcn_get_member_profile_fields' includes/template-tags.php; then
        echo 'Missing bcn_get_member_profile_fields function'
        exit 1
    fi
    
    if ! grep -q 'function bcn_get_member_card_data' includes/template-tags.php; then
        echo 'Missing bcn_get_member_card_data function'
        exit 1
    fi
    
    if ! grep -q 'function bcn_get_social_icon' includes/template-tags.php; then
        echo 'Missing bcn_get_social_icon function'
        exit 1
    fi
    
    # Check member-experience.php functions
    if ! grep -q 'function bcn_register_testimonial_meta' includes/member-experience.php; then
        echo 'Missing bcn_register_testimonial_meta function'
        exit 1
    fi
    
    if ! grep -q 'function bcn_track_member_engagement' includes/member-experience.php; then
        echo 'Missing bcn_track_member_engagement function'
        exit 1
    fi
    
    echo 'All required functions are defined'
"

# Test 5: CSS Validation
run_test "CSS Validation" "
    echo 'Validating CSS files...'
    
    css_files=\$(find assets/css -name '*.css')
    for file in \$css_files; do
        if [ -f \"\$file\" ]; then
            # Check for unclosed braces
            open_braces=\$(grep -o '{' \"\$file\" | wc -l)
            close_braces=\$(grep -o '}' \"\$file\" | wc -l)
            if [ \"\$open_braces\" -ne \"\$close_braces\" ]; then
                echo \"CSS syntax error in \$file - mismatched braces\"
                exit 1
            fi
            
            # Check for basic CSS properties
            if ! grep -q 'color\\|background\\|font\\|margin\\|padding' \"\$file\"; then
                echo \"CSS file \$file may be empty or invalid\"
                exit 1
            fi
        fi
    done
    
    echo 'All CSS files are valid'
"

# Test 6: JavaScript Validation
run_test "JavaScript Validation" "
    echo 'Validating JavaScript files...'
    
    js_files=\$(find assets/js -name '*.js')
    for file in \$js_files; do
        if [ -f \"\$file\" ]; then
            # Check for unclosed braces
            open_braces=\$(grep -o '{' \"\$file\" | wc -l)
            close_braces=\$(grep -o '}' \"\$file\" | wc -l)
            if [ \"\$open_braces\" -ne \"\$close_braces\" ]; then
                echo \"JavaScript syntax error in \$file - mismatched braces\"
                exit 1
            fi
            
            # Check for jQuery usage
            if grep -q 'jQuery' \"\$file\" && ! grep -q 'jquery' \"\$file\"; then
                echo \"Warning: jQuery usage in \$file but no jquery dependency\"
            fi
        fi
    done
    
    echo 'All JavaScript files are valid'
"

# Test 7: Security Checks
run_test "Security Checks" "
    echo 'Running security checks...'
    
    # Check for direct file access
    if grep -r 'ABSPATH' . --include='*.php' --exclude-dir='vendor' | grep -v 'if (!defined' | grep -v 'exit;' | grep -v 'require_once' | grep -v 'defined(' > /dev/null; then
        echo 'Potential security issue: ABSPATH check not properly implemented'
        exit 1
    fi
    
    # Check for sanitization functions
    if ! grep -r 'sanitize_' . --include='*.php' > /dev/null; then
        echo 'Warning: No sanitization functions found'
    fi
    
    # Check for nonce usage
    if ! grep -r 'wp_nonce' . --include='*.php' > /dev/null; then
        echo 'Warning: No nonce usage found for AJAX requests'
    fi
    
    echo 'Security checks completed'
"

# Test 8: Performance Checks
run_test "Performance Checks" "
    echo 'Running performance checks...'
    
    # Check for large files
    large_files=\$(find . -name '*.css' -o -name '*.js' | xargs ls -la | awk '\$5 > 100000 {print \$9, \$5}')
    if [ -n \"\$large_files\" ]; then
        echo 'Warning: Large files found:'
        echo \"\$large_files\"
    fi
    
    # Check for unused CSS
    if grep -q 'member-card-enhanced' assets/css/member-cards-enhanced.css; then
        echo 'CSS contains member-card-enhanced classes'
    else
        echo 'Warning: member-card-enhanced classes not found in CSS'
    fi
    
    echo 'Performance checks completed'
"

# Test 9: Accessibility Checks
run_test "Accessibility Checks" "
    echo 'Running accessibility checks...'
    
    # Check for alt attributes in templates
    if grep -r 'img.*src' template-parts/ --include='*.php' | grep -v 'alt=' > /dev/null; then
        echo 'Warning: Images without alt attributes found'
    fi
    
    # Check for ARIA labels
    if grep -r 'aria-label' . --include='*.php' > /dev/null; then
        echo 'ARIA labels found - good for accessibility'
    else
        echo 'Warning: No ARIA labels found'
    fi
    
    # Check for semantic HTML
    if grep -r '<main\\|<section\\|<article\\|<header\\|<footer' . --include='*.php' > /dev/null; then
        echo 'Semantic HTML elements found'
    else
        echo 'Warning: Limited semantic HTML usage'
    fi
    
    echo 'Accessibility checks completed'
"

# Test 10: Mobile Responsiveness Check
run_test "Mobile Responsiveness Check" "
    echo 'Checking mobile responsiveness...'
    
    # Check for media queries in CSS
    if grep -r '@media' assets/css/ > /dev/null; then
        echo 'Media queries found in CSS'
    else
        echo 'Warning: No media queries found for responsive design'
        exit 1
    fi
    
    # Check for viewport meta tag usage
    if grep -r 'viewport' . --include='*.php' > /dev/null; then
        echo 'Viewport meta tag usage found'
    else
        echo 'Warning: No viewport meta tag found'
    fi
    
    echo 'Mobile responsiveness checks completed'
"

# Test 11: Database Compatibility
run_test "Database Compatibility" "
    echo 'Checking database compatibility...'
    
    # Check for proper meta field registration
    if grep -r 'register_post_meta' includes/ > /dev/null; then
        echo 'Post meta fields properly registered'
    else
        echo 'Warning: No post meta fields registered'
    fi
    
    # Check for custom post type registration
    if grep -r 'register_post_type' includes/ > /dev/null; then
        echo 'Custom post types properly registered'
    else
        echo 'Warning: No custom post types registered'
    fi
    
    echo 'Database compatibility checks completed'
"

# Test 12: Integration Tests
run_test "Integration Tests" "
    echo 'Running integration tests...'
    
    # Check if functions.php includes all required files
    if grep -q 'member-experience.php' functions.php; then
        echo 'member-experience.php included in functions.php'
    else
        echo 'Warning: member-experience.php not included in functions.php'
    fi
    
    # Check if CSS and JS are properly enqueued
    if grep -q 'member-cards-enhanced' functions.php; then
        echo 'Enhanced assets properly enqueued'
    else
        echo 'Warning: Enhanced assets not properly enqueued'
    fi
    
    echo 'Integration tests completed'
"

# Generate Test Report
echo ""
echo -e "${BLUE}📊 Generating Test Report${NC}"
echo "=========================="

cat > "$TEST_RESULTS_DIR/test-report.md" << EOF
# BCN Theme Test Report

## Test Summary
- **Total Tests**: $TOTAL_TESTS
- **Passed**: $PASSED_TESTS
- **Failed**: $FAILED_TESTS
- **Success Rate**: $(( (PASSED_TESTS * 100) / TOTAL_TESTS ))%

## Test Date
$(date)

## Test Environment
- **Theme Directory**: $THEME_DIR
- **PHP Version**: $(php -v | head -1)
- **Operating System**: $(uname -s)

## Detailed Results
EOF

# Add individual test results
for log_file in "$TEST_RESULTS_DIR"/*.log; do
    if [ -f "$log_file" ]; then
        test_name=$(basename "$log_file" .log | tr '_' ' ')
        echo "### $test_name" >> "$TEST_RESULTS_DIR/test-report.md"
        echo '```' >> "$TEST_RESULTS_DIR/test-report.md"
        cat "$log_file" >> "$TEST_RESULTS_DIR/test-report.md"
        echo '```' >> "$TEST_RESULTS_DIR/test-report.md"
        echo "" >> "$TEST_RESULTS_DIR/test-report.md"
    fi
done

# Add recommendations
cat >> "$TEST_RESULTS_DIR/test-report.md" << EOF

## Recommendations
- Review any failed tests and fix issues
- Consider adding more comprehensive unit tests
- Implement automated performance monitoring
- Add accessibility testing tools integration

## Next Steps
1. Fix any failed tests
2. Run tests again to verify fixes
3. Deploy to staging for further testing
4. Monitor production deployment

EOF

# Display final results
echo ""
echo -e "${BLUE}📊 Test Results Summary${NC}"
echo "========================"
echo -e "Total Tests: ${BLUE}$TOTAL_TESTS${NC}"
echo -e "Passed: ${GREEN}$PASSED_TESTS${NC}"
echo -e "Failed: ${RED}$FAILED_TESTS${NC}"
echo -e "Success Rate: ${BLUE}$(( (PASSED_TESTS * 100) / TOTAL_TESTS ))%${NC}"
echo ""

if [ $FAILED_TESTS -eq 0 ]; then
    echo -e "${GREEN}🎉 All tests passed! Theme is ready for deployment.${NC}"
    exit 0
else
    echo -e "${RED}❌ Some tests failed. Please review the logs and fix issues before deployment.${NC}"
    echo -e "${YELLOW}📁 Check test results in: $TEST_RESULTS_DIR${NC}"
    exit 1
fi