# 🚀 Manual Deployment Guide

## Quick Deployment to Staging

Since the automated deployment via SSH isn't working, here's how to manually deploy the enhanced BCN theme to staging.

### 📦 Deployment Package Ready

**File**: `bcn-theme-enhanced-20251019_013715.tar.gz` (52KB)
**Location**: `/Users/dough/Documents/GitHub/bcn-wp-theme/`

### 🔧 Deployment Steps

#### Option 1: SiteGround File Manager (Recommended)

1. **Login to SiteGround**
   - Go to your SiteGround cPanel
   - Navigate to File Manager

2. **Navigate to Theme Directory**
   - Go to `public_html/wp-content/themes/`
   - You should see the current `bcn-wp-theme` folder

3. **Backup Current Theme**
   - Right-click on `bcn-wp-theme` folder
   - Select "Rename" and rename it to `bcn-wp-theme-backup-$(date)`

4. **Upload New Theme**
   - Click "Upload" button
   - Select `bcn-theme-enhanced-20251019_013715.tar.gz`
   - Wait for upload to complete

5. **Extract the Package**
   - Right-click on the uploaded `.tar.gz` file
   - Select "Extract"
   - Choose "Extract files" option

6. **Rename the Extracted Folder**
   - The extraction will create a folder with the theme files
   - Rename it to `bcn-wp-theme`

7. **Set Permissions**
   - Right-click on `bcn-wp-theme` folder
   - Select "Permissions"
   - Set to `755` for folders and `644` for files

#### Option 2: FTP/SFTP Upload

1. **Connect via FTP**
   - Host: `staging6.buffalocannabisnetwork.com`
   - Username: `u2037-2lvglkrliykq`
   - Port: `21` (FTP) or `22` (SFTP)

2. **Navigate to Theme Directory**
   - Go to `/public_html/wp-content/themes/`

3. **Upload and Extract**
   - Upload the `.tar.gz` file
   - Extract it on the server
   - Rename to `bcn-wp-theme`

### ✅ Verification Steps

After deployment, verify the following:

1. **Staging Site Access**
   - Visit: https://staging6.buffalocannabisnetwork.com
   - Should load without errors

2. **Member Directory**
   - Visit: https://staging6.buffalocannabisnetwork.com/membership/
   - Should show the member directory page

3. **Enhanced Features**
   - Check if enhanced CSS loads: https://staging6.buffalocannabisnetwork.com/wp-content/themes/bcn-wp-theme/assets/css/member-cards-enhanced.css
   - Check if enhanced JS loads: https://staging6.buffalocannabisnetwork.com/wp-content/themes/bcn-wp-theme/assets/js/member-cards-enhanced.js

4. **WordPress Admin**
   - Login to WordPress admin
   - Go to Appearance → Themes
   - Verify the BCN theme is active

### 🎨 What's New in This Deployment

#### Enhanced Member Features
- **Modern Member Cards**: Interactive cards with engagement scores
- **Enhanced Member Directory**: Advanced filtering and search
- **Member Experience**: Testimonials, reviews, and engagement tracking
- **Responsive Design**: Mobile-optimized layouts
- **Performance Optimized**: Fast loading and smooth interactions

#### New Files Added
- `template-parts/content-member-card-enhanced.php`
- `assets/css/member-cards-enhanced.css`
- `assets/js/member-cards-enhanced.js`
- `archive-bcn_member-enhanced.php`
- `assets/css/member-archive-enhanced.css`
- `includes/member-experience.php`

### 🔧 Troubleshooting

#### If the site breaks:
1. **Quick Rollback**
   - Rename `bcn-wp-theme` to `bcn-wp-theme-broken`
   - Rename `bcn-wp-theme-backup-*` back to `bcn-wp-theme`

2. **Check File Permissions**
   - Ensure folders are `755` and files are `644`
   - PHP files should be `644`

3. **Check WordPress Theme**
   - Go to WordPress Admin → Appearance → Themes
   - Activate the BCN theme if needed

#### If enhanced features don't work:
1. **Clear Cache**
   - Clear any caching plugins
   - Clear browser cache

2. **Check File Upload**
   - Verify all files uploaded correctly
   - Check file sizes match expected

3. **Check WordPress**
   - Ensure WordPress is up to date
   - Check for plugin conflicts

### 📞 Support

If you encounter issues:
1. Check the error logs in WordPress admin
2. Verify all files are uploaded correctly
3. Test with a default WordPress theme first
4. Contact support if needed

### 🎉 Success!

Once deployed successfully, you'll have:
- ✅ Enhanced member cards with modern design
- ✅ Interactive member directory
- ✅ Member testimonials and reviews
- ✅ Engagement tracking
- ✅ Mobile-responsive design
- ✅ Performance optimizations

**Next Steps**: Test all features, then deploy to production when ready!