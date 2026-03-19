#!/bin/bash

##############################################################################
# BCN Production Deployment Script
# Buffalo Cannabis Network - buffalocannabisnetwork.com
##############################################################################

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Script directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
THEME_DIR="$(dirname "$SCRIPT_DIR")"
WP_DIR="$(dirname "$(dirname "$(dirname "$THEME_DIR")")")"

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}   BCN PRODUCTION DEPLOYMENT${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Function to display errors
error() {
    echo -e "${RED}❌ ERROR: $1${NC}"
    exit 1
}

# Function to display success
success() {
    echo -e "${GREEN}✅ $1${NC}"
}

# Function to display info
info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

# Function to display warnings
warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

# Check if in WordPress directory
if [ ! -f "$WP_DIR/wp-config.php" ]; then
    error "Not in a WordPress installation directory"
fi

info "WordPress directory: $WP_DIR"
info "Theme directory: $THEME_DIR"
echo ""

# Confirm deployment
warning "You are about to deploy to PRODUCTION"
read -p "Are you sure you want to continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Deployment cancelled."
    exit 0
fi

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}   PRE-DEPLOYMENT CHECKS${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Check git status
info "Checking git status..."
cd "$WP_DIR" || error "Cannot change to WordPress directory"

if [ -d ".git" ]; then
    if [ -n "$(git status --porcelain)" ]; then
        warning "You have uncommitted changes:"
        git status --short
        echo ""
        read -p "Continue anyway? (yes/no): " cont
        if [ "$cont" != "yes" ]; then
            echo "Deployment cancelled."
            exit 0
        fi
    else
        success "Git repository is clean"
    fi
else
    warning "No git repository found"
fi

# Check for production remote
if [ -d ".git" ]; then
    info "Checking for production remote..."
    if git remote | grep -q "production"; then
        success "Production remote found"
    else
        warning "Production remote not configured"
        echo ""
        info "To add production remote, run:"
        echo "git remote add production ssh://user@server/path/to/production"
    fi
fi

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}   CREATING BACKUP${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Create backup
BACKUP_DIR="$HOME/bcn-backups"
BACKUP_DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="bcn_backup_$BACKUP_DATE.tar.gz"

info "Creating backup..."
mkdir -p "$BACKUP_DIR"

# Backup theme files
tar -czf "$BACKUP_DIR/$BACKUP_FILE" \
    -C "$WP_DIR" \
    wp-content/themes/buffalo-cannabis-network \
    2>/dev/null

if [ $? -eq 0 ]; then
    success "Backup created: $BACKUP_DIR/$BACKUP_FILE"
else
    error "Backup failed"
fi

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}   DEPLOYMENT TASKS${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Clear theme caches
info "Clearing theme caches..."
if [ -d "$WP_DIR/wp-content/cache" ]; then
    rm -rf "$WP_DIR/wp-content/cache/*"
    success "Theme cache cleared"
fi

# Clear SiteGround cache (if exists)
if [ -d "$WP_DIR/wp-content/cache/sgo-cache" ]; then
    info "Clearing SiteGround cache..."
    rm -rf "$WP_DIR/wp-content/cache/sgo-cache/*"
    success "SiteGround cache cleared"
fi

# Git push to production (if remote exists)
if [ -d ".git" ] && git remote | grep -q "production"; then
    info "Pushing to production..."
    git push production master
    if [ $? -eq 0 ]; then
        success "Code pushed to production"
    else
        error "Git push failed"
    fi
else
    warning "Skipping git push (no production remote)"
fi

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}   POST-DEPLOYMENT${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

info "Post-deployment checklist:"
echo ""
echo "   1. ✓ Backup created"
echo "   2. ✓ Caches cleared"
echo "   3. □ Visit site and verify functionality"
echo "   4. □ Test navigation and links"
echo "   5. □ Check mobile responsiveness"
echo "   6. □ Verify contact forms work"
echo "   7. □ Test event galleries"
echo "   8. □ Check SEO meta tags (view source)"
echo "   9. □ Verify schema markup (Google Rich Results Test)"
echo "   10. □ Submit sitemap to Google Search Console"
echo ""

# Display important URLs
info "Important URLs:"
echo "   🌐 Site: https://buffalocannabisnetwork.com"
echo "   🗺️  Sitemap: https://buffalocannabisnetwork.com/?bcn_sitemap=1"
echo "   🔍 Google Rich Results: https://search.google.com/test/rich-results"
echo "   📊 Google Search Console: https://search.google.com/search-console"
echo ""

# Create deployment log
LOG_FILE="$BACKUP_DIR/deployment_log.txt"
echo "Deployment: $BACKUP_DATE" >> "$LOG_FILE"
echo "Backup: $BACKUP_FILE" >> "$LOG_FILE"
echo "User: $(whoami)" >> "$LOG_FILE"
echo "Branch: $(git rev-parse --abbrev-ref HEAD 2>/dev/null || echo 'N/A')" >> "$LOG_FILE"
echo "Commit: $(git rev-parse --short HEAD 2>/dev/null || echo 'N/A')" >> "$LOG_FILE"
echo "---" >> "$LOG_FILE"

success "Deployment log updated: $LOG_FILE"
echo ""

echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${GREEN}   ✅ DEPLOYMENT COMPLETE!${NC}"
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
echo -e "${YELLOW}⚠️  Remember to:${NC}"
echo "   - Test the live site thoroughly"
echo "   - Monitor error logs for the first 24 hours"
echo "   - Clear any additional caching (CloudFlare, etc.)"
echo ""

