#!/bin/bash
# SiteGround Deployment Script
# Uses correct SiteGround SSH credentials

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# SiteGround Configuration
HOST="staging6.buffalocannabisnetwork.com"
USER="u2037-2lvglkrliykq"
PORT="18765"
SSH_KEY="$HOME/.ssh/siteground_id"
REMOTE_PATH="/home/u2037-2lvglkrliykq/staging6.buffalocannabisnetwork.com/public_html/wp-content/themes/bcn-wp-theme"
SOURCE_DIR="./build"

echo -e "${BLUE}🚀 SiteGround Deployment${NC}"
echo "======================="
echo "Host: $HOST"
echo "User: $USER"
echo "Port: $PORT"
echo "Remote Path: $REMOTE_PATH"
echo "Source: $SOURCE_DIR"
echo ""

# Check if source directory exists
if [ ! -d "$SOURCE_DIR" ]; then
    echo -e "${RED}❌ Source directory $SOURCE_DIR not found${NC}"
    echo "Please run the build process first:"
    echo "  ./scripts/setup-enhanced-features.sh"
    exit 1
fi

# Check if SSH key exists
if [ ! -f "$SSH_KEY" ]; then
    echo -e "${RED}❌ SSH key $SSH_KEY not found${NC}"
    echo "Please ensure your SiteGround SSH key is in place"
    exit 1
fi

# Test SSH connection
echo -e "${BLUE}🔍 Testing SSH connection...${NC}"
if ssh -o ConnectTimeout=10 -p "$PORT" -i "$SSH_KEY" "$USER@$HOST" "echo 'SSH connection successful'" 2>/dev/null; then
    echo -e "${GREEN}✅ SSH connection successful${NC}"
else
    echo -e "${RED}❌ SSH connection failed${NC}"
    echo "Please check your SSH key and credentials"
    echo "You may need to add your public key to SiteGround:"
    echo "  cat $SSH_KEY.pub"
    exit 1
fi

# Create backup
echo -e "${BLUE}📦 Creating backup...${NC}"
BACKUP_NAME="backup_$(date +%Y%m%d_%H%M%S)"
if ssh -p "$PORT" -i "$SSH_KEY" "$USER@$HOST" "cp -r $REMOTE_PATH $REMOTE_PATH.$BACKUP_NAME" 2>/dev/null; then
    echo -e "${GREEN}✅ Backup created: $BACKUP_NAME${NC}"
else
    echo -e "${YELLOW}⚠️  Could not create backup, continuing with deployment${NC}"
fi

# Deploy files
echo -e "${BLUE}📤 Deploying files...${NC}"
if rsync -avz --delete -e "ssh -p $PORT -i $SSH_KEY" "$SOURCE_DIR/" "$USER@$HOST:$REMOTE_PATH/"; then
    echo -e "${GREEN}✅ Files deployed successfully${NC}"
else
    echo -e "${RED}❌ Deployment failed${NC}"
    exit 1
fi

# Set permissions
echo -e "${BLUE}🔐 Setting permissions...${NC}"
if ssh -p "$PORT" -i "$SSH_KEY" "$USER@$HOST" "chmod -R 755 $REMOTE_PATH && find $REMOTE_PATH -type f -name '*.php' -exec chmod 644 {} \;" 2>/dev/null; then
    echo -e "${GREEN}✅ Permissions set correctly${NC}"
else
    echo -e "${YELLOW}⚠️  Could not set permissions, but deployment completed${NC}"
fi

# Verify deployment
echo -e "${BLUE}🔍 Verifying deployment...${NC}"
if curl -s -o /dev/null -w "%{http_code}" "https://staging6.buffalocannabisnetwork.com" | grep -q "200"; then
    echo -e "${GREEN}✅ Staging site is accessible${NC}"
else
    echo -e "${YELLOW}⚠️  Staging site may not be accessible${NC}"
fi

# Check member directory
if curl -s -o /dev/null -w "%{http_code}" "https://staging6.buffalocannabisnetwork.com/membership/" | grep -q "200"; then
    echo -e "${GREEN}✅ Member directory is accessible${NC}"
else
    echo -e "${YELLOW}⚠️  Member directory may not be accessible${NC}"
fi

echo ""
echo -e "${GREEN}🎉 Deployment completed!${NC}"
echo "Staging URL: https://staging6.buffalocannabisnetwork.com"
echo "Member Directory: https://staging6.buffalocannabisnetwork.com/membership/"
echo ""
echo "Next steps:"
echo "1. Test the enhanced member features"
echo "2. Check responsive design"
echo "3. Verify performance"
echo "4. Deploy to production if tests pass"