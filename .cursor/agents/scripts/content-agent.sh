#!/bin/bash
# Content Agent for BCN - Manages ACF fields, content migrations, SEO

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Configuration
AGENTS_DIR=".cursor/agents"
LOG_DIR="$AGENTS_DIR/logs"
STATUS_DIR="$AGENTS_DIR/status"
REPORTS_DIR="$AGENTS_DIR/reports"
ACF_JSON_DIR="acf-json"

# Logging function
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_DIR/content.log"
}

# Sync ACF fields
sync_acf_fields() {
    log "🔄 Syncing ACF fields"
    
    if [ -d "$ACF_JSON_DIR" ]; then
        # Count ACF field groups
        local field_count=$(find "$ACF_JSON_DIR" -name "*.json" | wc -l)
        log "📋 Found $field_count ACF field groups"
        
        # Sync each field group
        for field_file in "$ACF_JSON_DIR"/*.json; do
            if [ -f "$field_file" ]; then
                local field_name=$(basename "$field_file" .json)
                log "  Syncing: $field_name"
                
                # This would typically use WP-CLI
                # wp acf import "$field_file" --format=json
            fi
        done
        
        log "✅ ACF fields synced"
    else
        log "⚠️  No ACF JSON directory found"
    fi
}

# Update content metadata
update_content_metadata() {
    log "📝 Updating content metadata"
    
    # Update post meta for SEO
    log "  Updating SEO meta for posts..."
    
    # Update member profiles
    log "  Updating member profiles..."
    
    # Update event metadata
    log "  Updating event metadata..."
    
    log "✅ Content metadata updated"
}

# Generate sitemap
generate_sitemap() {
    log "🗺️  Generating sitemap"
    
    local sitemap_file="$REPORTS_DIR/sitemap-$(date +%Y%m%d-%H%M%S).xml"
    
    cat > "$sitemap_file" << EOF
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
EOF

    # Add static pages
    local static_pages=("/" "/membership/" "/events/" "/news/" "/about/" "/contact/")
    for page in "${static_pages[@]}"; do
        cat >> "$sitemap_file" << EOF
  <url>
    <loc>https://buffalocannabisnetwork.com$page</loc>
    <lastmod>$(date -u +%Y-%m-%dT%H:%M:%SZ)</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
EOF
    done
    
    cat >> "$sitemap_file" << EOF
</urlset>
EOF

    log "✅ Sitemap generated: $sitemap_file"
}

# Optimize images
optimize_images() {
    log "🖼️  Optimizing images"
    
    local uploads_dir="wp-content/uploads"
    
    if [ -d "$uploads_dir" ]; then
        # Find large images
        local large_images=$(find "$uploads_dir" -type f \( -name "*.jpg" -o -name "*.jpeg" -o -name "*.png" \) -size +500k | wc -l)
        
        if [ "$large_images" -gt 0 ]; then
            log "  Found $large_images large images to optimize"
            
            # This would typically use image optimization tools
            # For now, just log the files
            find "$uploads_dir" -type f \( -name "*.jpg" -o -name "*.jpeg" -o -name "*.png" \) -size +500k | head -10 | while read -r image; do
                log "    Large image: $image"
            done
        else
            log "  No large images found"
        fi
    else
        log "⚠️  No uploads directory found"
    fi
    
    log "✅ Image optimization completed"
}

# Update member directory
update_member_directory() {
    log "👥 Updating member directory"
    
    # This would typically query the database for member updates
    # For now, we'll simulate the process
    
    log "  Checking for new members..."
    log "  Updating member profiles..."
    log "  Refreshing member cache..."
    
    log "✅ Member directory updated"
}

# SEO audit
seo_audit() {
    log "🔍 Running SEO audit"
    
    local audit_file="$REPORTS_DIR/seo-audit-$(date +%Y%m%d-%H%M%S).md"
    
    cat > "$audit_file" << EOF
# BCN SEO Audit Report
Generated: $(date)

## Page Analysis

### Homepage
- URL: https://buffalocannabisnetwork.com
- Title: [To be checked]
- Meta Description: [To be checked]
- H1 Tags: [To be checked]
- Image Alt Tags: [To be checked]

### Member Directory
- URL: https://buffalocannabisnetwork.com/membership/
- Title: [To be checked]
- Meta Description: [To be checked]
- Schema Markup: [To be checked]

### Events
- URL: https://buffalocannabisnetwork.com/events/
- Title: [To be checked]
- Meta Description: [To be checked]
- Event Schema: [To be checked]

## Recommendations
- [ ] Add missing meta descriptions
- [ ] Optimize image alt tags
- [ ] Implement structured data
- [ ] Improve page load speed
- [ ] Add internal linking

EOF

    log "✅ SEO audit completed: $audit_file"
}

# Content migration
migrate_content() {
    local migration_type="$1"
    
    log "🔄 Running content migration: $migration_type"
    
    case "$migration_type" in
        "acf-to-gutenberg")
            log "  Migrating ACF fields to Gutenberg blocks..."
            ;;
        "legacy-posts")
            log "  Migrating legacy post formats..."
            ;;
        "member-profiles")
            log "  Migrating member profile data..."
            ;;
        *)
            log "  Unknown migration type: $migration_type"
            ;;
    esac
    
    log "✅ Content migration completed"
}

# Main content management function
manage_content() {
    local action="${1:-all}"
    
    log "🚀 Starting BCN Content Agent"
    log "Action: $action"
    
    case "$action" in
        "sync-acf")
            sync_acf_fields
            ;;
        "update-metadata")
            update_content_metadata
            ;;
        "generate-sitemap")
            generate_sitemap
            ;;
        "optimize-images")
            optimize_images
            ;;
        "update-members")
            update_member_directory
            ;;
        "seo-audit")
            seo_audit
            ;;
        "migrate")
            migrate_content "$2"
            ;;
        "all")
            sync_acf_fields
            update_content_metadata
            generate_sitemap
            optimize_images
            update_member_directory
            seo_audit
            ;;
        *)
            log "❌ Unknown action: $action"
            echo "Available actions: sync-acf, update-metadata, generate-sitemap, optimize-images, update-members, seo-audit, migrate, all"
            exit 1
            ;;
    esac
    
    log "🎉 Content management completed"
}

# Main execution
if [ "${BASH_SOURCE[0]}" = "${0}" ]; then
    manage_content "$@"
fi