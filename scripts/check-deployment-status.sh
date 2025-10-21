#!/bin/bash
# Check deployment status and provide manual deployment options

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🔍 BCN Theme Deployment Status${NC}"
echo "================================="
echo ""

# Check if staging site is accessible
echo -e "${BLUE}🌐 Checking Staging Site${NC}"
echo "=========================="

if curl -s -o /dev/null -w "%{http_code}" "https://staging6.buffalocannabisnetwork.com" | grep -q "200"; then
    echo -e "${GREEN}✅ Staging site is accessible${NC}"
else
    echo -e "${RED}❌ Staging site is not accessible${NC}"
fi

# Check member directory
echo ""
echo -e "${BLUE}👥 Checking Member Directory${NC}"
echo "============================="

if curl -s -o /dev/null -w "%{http_code}" "https://staging6.buffalocannabisnetwork.com/membership/" | grep -q "200"; then
    echo -e "${GREEN}✅ Member directory is accessible${NC}"
else
    echo -e "${YELLOW}⚠️  Member directory may not be accessible${NC}"
fi

# Check for enhanced features
echo ""
echo -e "${BLUE}🎨 Checking Enhanced Features${NC}"
echo "============================="

# Check if enhanced CSS is loading
if curl -s "https://staging6.buffalocannabisnetwork.com/wp-content/themes/bcn-wp-theme/assets/css/member-cards-enhanced.css" | grep -q "member-card-enhanced"; then
    echo -e "${GREEN}✅ Enhanced CSS is deployed${NC}"
else
    echo -e "${YELLOW}⚠️  Enhanced CSS not found${NC}"
fi

# Check if enhanced JS is loading
if curl -s "https://staging6.buffalocannabisnetwork.com/wp-content/themes/bcn-wp-theme/assets/js/member-cards-enhanced.js" | grep -q "member-card-enhanced"; then
    echo -e "${GREEN}✅ Enhanced JS is deployed${NC}"
else
    echo -e "${YELLOW}⚠️  Enhanced JS not found${NC}"
fi

# Check GitHub Actions status
echo ""
echo -e "${BLUE}🚀 GitHub Actions Status${NC}"
echo "======================="
echo "Repository: https://github.com/therealjohndough/bcn-wp-theme"
echo "Actions URL: https://github.com/therealjohndough/bcn-wp-theme/actions"
echo ""

# Check if deployment package exists
echo -e "${BLUE}📦 Deployment Package${NC}"
echo "====================="

if [ -f "bcn-theme-enhanced-*.tar.gz" ]; then
    echo -e "${GREEN}✅ Deployment package ready${NC}"
    echo "Package: $(ls bcn-theme-enhanced-*.tar.gz | head -1)"
    echo "Size: $(ls -lh bcn-theme-enhanced-*.tar.gz | awk '{print $5}')"
else
    echo -e "${YELLOW}⚠️  No deployment package found${NC}"
fi

echo ""
echo -e "${BLUE}📋 Next Steps${NC}"
echo "============="
echo "1. Check GitHub Actions: https://github.com/therealjohndough/bcn-wp-theme/actions"
echo "2. If GitHub Actions fails, use manual deployment:"
echo "   - Upload bcn-theme-enhanced-*.tar.gz to SiteGround"
echo "   - Extract to /public_html/wp-content/themes/bcn-wp-theme/"
echo "3. Verify deployment by checking the staging site"
echo "4. Test enhanced member features"
echo ""
echo -e "${GREEN}🎉 Ready for deployment!${NC}"