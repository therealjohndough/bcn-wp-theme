#!/bin/bash
# Setup GitHub Secrets for automated deployment

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🔐 GitHub Secrets Setup Guide${NC}"
echo "============================="
echo ""

echo -e "${YELLOW}To enable automated deployment, you need to add these secrets to GitHub:${NC}"
echo ""

echo -e "${BLUE}1. Go to GitHub Repository Settings${NC}"
echo "   https://github.com/therealjohndough/bcn-wp-theme/settings/secrets/actions"
echo ""

echo -e "${BLUE}2. Add these secrets:${NC}"
echo ""

echo -e "${GREEN}SG_DEPLOY_KEY${NC}"
echo "   Description: SSH private key for staging deployment"
echo "   Value: Your private SSH key content"
echo "   (The private key that matches the public key you provided)"
echo ""

echo -e "${GREEN}SG_HOST${NC}"
echo "   Description: Staging server hostname"
echo "   Value: staging6.buffalocannabisnetwork.com"
echo ""

echo -e "${GREEN}SG_USER${NC}"
echo "   Description: Staging server username"
echo "   Value: u2037-2lvglkrliykq"
echo ""

echo -e "${GREEN}SG_PORT${NC}"
echo "   Description: Staging server port"
echo "   Value: 18765"
echo ""

echo -e "${GREEN}SG_REMOTE_PATH${NC}"
echo "   Description: Remote path for theme files"
echo "   Value: /home/u2037-2lvglkrliykq/staging6.buffalocannabisnetwork.com/public_html/wp-content/themes/bcn-wp-theme"
echo ""

echo -e "${BLUE}3. After adding secrets, the GitHub Actions workflow will automatically deploy on push to main${NC}"
echo ""

echo -e "${BLUE}4. You can also manually trigger deployment:${NC}"
echo "   - Go to Actions tab"
echo "   - Select 'Deploy BCN Theme with Tests'"
echo "   - Click 'Run workflow'"
echo "   - Select 'staging' environment"
echo ""

echo -e "${YELLOW}Note: If you don't have the private SSH key, you can use the manual deployment method instead.${NC}"
echo ""

echo -e "${GREEN}🎉 Once secrets are set up, automated deployment will work!${NC}"