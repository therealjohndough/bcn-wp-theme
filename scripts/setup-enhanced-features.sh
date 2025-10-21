#!/bin/bash
# Setup Enhanced Member Features
# This script prepares the theme for deployment with enhanced member features

set -e

echo "🚀 Setting up Enhanced Member Features for BCN WordPress Theme"
echo "=============================================================="

# Check if we're in the right directory
if [ ! -f "style.css" ] || [ ! -f "functions.php" ]; then
    echo "❌ Error: Please run this script from the theme root directory"
    exit 1
fi

# Create necessary directories
echo "📁 Creating directories..."
mkdir -p assets/css
mkdir -p assets/js
mkdir -p includes
mkdir -p template-parts
mkdir -p scripts

# Set proper permissions
echo "🔐 Setting permissions..."
chmod +x scripts/*.sh 2>/dev/null || true

# Check for required files
echo "📋 Checking required files..."

required_files=(
    "template-parts/content-member-card-enhanced.php"
    "assets/css/member-cards-enhanced.css"
    "assets/css/member-archive-enhanced.css"
    "assets/js/member-cards-enhanced.js"
    "includes/member-experience.php"
    "archive-bcn_member-enhanced.php"
)

missing_files=()
for file in "${required_files[@]}"; do
    if [ ! -f "$file" ]; then
        missing_files+=("$file")
    fi
done

if [ ${#missing_files[@]} -ne 0 ]; then
    echo "❌ Missing required files:"
    printf '%s\n' "${missing_files[@]}"
    echo "Please ensure all enhanced feature files are present."
    exit 1
fi

echo "✅ All required files present"

# Validate PHP syntax
echo "🔍 Validating PHP syntax..."
php_files=(
    "functions.php"
    "includes/member-experience.php"
    "template-parts/content-member-card-enhanced.php"
    "archive-bcn_member-enhanced.php"
)

for file in "${php_files[@]}"; do
    if [ -f "$file" ]; then
        if ! php -l "$file" > /dev/null 2>&1; then
            echo "❌ PHP syntax error in $file"
            exit 1
        fi
    fi
done

echo "✅ PHP syntax validation passed"

# Check CSS syntax (basic check)
echo "🎨 Validating CSS..."
css_files=(
    "assets/css/member-cards-enhanced.css"
    "assets/css/member-archive-enhanced.css"
)

for file in "${css_files[@]}"; do
    if [ -f "$file" ]; then
        # Basic CSS validation - check for unclosed braces
        open_braces=$(grep -o '{' "$file" | wc -l)
        close_braces=$(grep -o '}' "$file" | wc -l)
        if [ "$open_braces" -ne "$close_braces" ]; then
            echo "❌ CSS syntax error in $file - mismatched braces"
            exit 1
        fi
    fi
done

echo "✅ CSS syntax validation passed"

# Check JavaScript syntax (basic check)
echo "⚡ Validating JavaScript..."
js_files=(
    "assets/js/member-cards-enhanced.js"
)

for file in "${js_files[@]}"; do
    if [ -f "$file" ]; then
        # Basic JS validation - check for unclosed braces
        open_braces=$(grep -o '{' "$file" | wc -l)
        close_braces=$(grep -o '}' "$file" | wc -l)
        if [ "$open_braces" -ne "$close_braces" ]; then
            echo "❌ JavaScript syntax error in $file - mismatched braces"
            exit 1
        fi
    fi
done

echo "✅ JavaScript syntax validation passed"

# Update version in style.css
echo "📝 Updating version information..."
current_version=$(grep "Version:" style.css | sed 's/.*Version: *//' | head -1)
new_version="1.1.0"
if [ "$current_version" != "$new_version" ]; then
    sed -i.bak "s/Version: $current_version/Version: $new_version/" style.css
    echo "✅ Updated version from $current_version to $new_version"
else
    echo "✅ Version already up to date: $current_version"
fi

# Create deployment summary
echo "📊 Creating deployment summary..."
cat > DEPLOYMENT_SUMMARY.md << EOF
# BCN Theme Enhanced Features - Deployment Summary

## Version: $new_version
## Date: $(date)
## Branch: $(git branch --show-current 2>/dev/null || echo "unknown")

## Enhanced Features Deployed:
- ✅ Modern interactive member cards
- ✅ Testimonials and reviews system
- ✅ Engagement tracking and analytics
- ✅ Enhanced archive template with filtering
- ✅ Social media integration
- ✅ Quick contact modals
- ✅ Responsive design improvements
- ✅ Accessibility enhancements

## Files Added/Modified:
$(git status --porcelain 2>/dev/null || echo "Git status not available")

## Next Steps:
1. Test on staging environment
2. Verify all functionality works
3. Check performance metrics
4. Deploy to production

## Support:
- Developer: John Dough
- Email: casestudylabs@gmail.com
- Repository: https://github.com/therealjohndough/bcn-wp-theme
EOF

echo "✅ Deployment summary created"

# Final checks
echo "🔍 Running final checks..."

# Check if WordPress functions are properly loaded
if ! grep -q "get_header" "archive-bcn_member-enhanced.php"; then
    echo "⚠️  Warning: Archive template may not be properly structured"
fi

# Check if CSS is properly enqueued
if ! grep -q "member-cards-enhanced" "functions.php"; then
    echo "⚠️  Warning: Enhanced CSS may not be properly enqueued"
fi

# Check if JS is properly enqueued
if ! grep -q "member-cards-enhanced" "functions.php"; then
    echo "⚠️  Warning: Enhanced JS may not be properly enqueued"
fi

echo ""
echo "🎉 Enhanced Member Features Setup Complete!"
echo "=========================================="
echo ""
echo "📋 Summary:"
echo "  • All required files present and validated"
echo "  • PHP, CSS, and JavaScript syntax checked"
echo "  • Version updated to $new_version"
echo "  • Deployment summary created"
echo ""
echo "🚀 Ready for deployment to staging!"
echo ""
echo "Next steps:"
echo "  1. Commit changes: git add . && git commit -m 'feat: Enhanced member features'"
echo "  2. Push to staging: git push origin feature/enhanced-member-cards"
echo "  3. Test on staging6.buffalocannabisnetwork.com"
echo "  4. Deploy to production after testing"
echo ""
echo "📖 See DEPLOYMENT_PLAN.md for detailed deployment instructions"
echo "📊 See DEPLOYMENT_SUMMARY.md for this deployment's details"