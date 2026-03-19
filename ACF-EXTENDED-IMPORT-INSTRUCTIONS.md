# ACF Extended Post Types & Taxonomies - Import Instructions

## Overview
All custom post types and taxonomies are now managed via ACF Extended instead of hardcoded in `functions.php`. This allows you to manage them through the WordPress admin UI.

## Files Created
1. `acf-post-type-bcn_event.json` - Events post type
2. `acf-post-type-bcn_member.json` - Members post type  
3. `acf-taxonomy-event_type.json` - Event Type taxonomy
4. `acf-taxonomy-member_tier.json` - Membership Tier taxonomy

## Import Steps

### Method 1: Automatic Import (Recommended)
1. Upload all 4 JSON files to your server in the theme's `acf-json` directory:
   ```
   /wp-content/themes/buffalo-cannabis-network/acf-json/
   ```
2. ACF Extended will automatically detect and import them
3. Go to **Custom Fields → Post Types** in WordPress admin
4. You should see "Events" and "BCN Members" listed
5. Go to **Custom Fields → Taxonomies**
6. You should see "Event Type" and "Membership Tiers" listed

### Method 2: Manual Import via ACF UI
1. Go to **Custom Fields → Post Types** in WordPress admin
2. Click **"Add New"** or **"Import"**
3. Import each JSON file:
   - `acf-post-type-bcn_event.json`
   - `acf-post-type-bcn_member.json`
4. Go to **Custom Fields → Taxonomies**
5. Import:
   - `acf-taxonomy-event_type.json`
   - `acf-taxonomy-member_tier.json`

## After Import

1. **Verify Post Types Work:**
   - Check that "Events" and "BCN Members" appear in the WordPress admin menu
   - Create a test event and member to ensure they work

2. **Verify Taxonomies Work:**
   - When editing an event, you should see "Event Types" in the sidebar
   - When editing a member, you should see "Membership Tiers" in the sidebar

3. **Clear Cache:**
   - Clear WordPress cache
   - Clear browser cache
   - If using a caching plugin, flush it

## Fallback
If ACF Extended is disabled, the post types are still registered in `functions.php` (commented out). You can uncomment them as a fallback.

## Benefits
- ✅ Manage post types through WordPress admin UI
- ✅ No code changes needed to modify post type settings
- ✅ Version controlled via JSON files
- ✅ Easy to export/import between environments
- ✅ All settings in one place (ACF Extended)

