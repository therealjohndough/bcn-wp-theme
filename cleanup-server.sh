#!/bin/bash
# Cleanup unnecessary files from production theme directory
# Run this via SSH to remove docs, .DS_Store, and other non-essential files

echo "Cleaning up unnecessary files from production theme..."
echo ""

# Files to remove (documentation, system files, etc.)
FILES_TO_REMOVE=(
    ".DS_Store"
    "ACF-SETUP.md"
    "DEPLOYMENT.md"
    "DISPENSARY-SHOWCASE-IMAGES.md"
    "HOMEPAGE-SETUP.md"
    "LAUNCH-SUMMARY.md"
    "MEMBER-DIRECTORY-GUIDE.md"
    "PREMIER-MEMBERS.md"
    "QUICK-START.md"
    "SETUP-GUIDE.md"
    "README.txt"
    "robots.txt"  # Should be in root, not theme
)

# Old template files (if they exist)
OLD_TEMPLATES=(
    "single event template.php"  # Old name, should use single-bcn_event.php
    # Note: archive-bcn-events.php is kept as it's actively maintained
    # and may be used for different post type slug variations
)

echo "Files to be removed:"
for file in "${FILES_TO_REMOVE[@]}"; do
    echo "  - $file"
done

for file in "${OLD_TEMPLATES[@]}"; do
    echo "  - $file (old template)"
done

echo ""
read -p "Continue with cleanup? (y/n) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Cleanup cancelled."
    exit 1
fi

# SSH command to remove files
ssh bcn-staging << 'EOF'
cd ~/www/buffalocannabisnetwork.com/public_html/wp-content/themes/buffalo-cannabis-network/

# Remove documentation and system files
rm -f .DS_Store
rm -f ACF-SETUP.md DEPLOYMENT.md DISPENSARY-SHOWCASE-IMAGES.md
rm -f HOMEPAGE-SETUP.md LAUNCH-SUMMARY.md MEMBER-DIRECTORY-GUIDE.md
rm -f PREMIER-MEMBERS.md QUICK-START.md SETUP-GUIDE.md
rm -f README.txt robots.txt

# Remove old template files if they exist
# Note: archive-bcn-events.php is NOT removed as it's actively maintained
rm -f "single event template.php"

echo "Cleanup complete!"
echo ""
echo "Remaining files:"
ls -lh | grep -E '\.(php|css)$' | head -20
EOF

echo ""
echo "✅ Cleanup finished!"

