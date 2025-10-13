# Quick Start Guide - Buffalo Cannabis Network WordPress Theme

## Installation & Setup (5 Minutes)

### Prerequisites
- WordPress 5.0 or higher installed
- PHP 7.4 or higher
- Basic WordPress admin access

### Step 1: Install the Theme (2 minutes)

**Option A: Via GitHub**
```bash
cd /path/to/wordpress/wp-content/themes/
git clone https://github.com/therealjohndough/bcn-wp-theme.git
```

**Option B: Via Download**
1. Download ZIP from GitHub
2. Go to WordPress Admin → Appearance → Themes → Add New → Upload Theme
3. Choose the ZIP file and click "Install Now"
4. Click "Activate"

**Option C: Manual Upload**
1. Download and unzip the theme
2. Upload the `bcn-wp-theme` folder to `/wp-content/themes/`
3. Go to Appearance → Themes
4. Click "Activate" on Buffalo Cannabis Network

### Step 2: Basic Configuration (2 minutes)

**1. Set Site Title & Tagline**
- Go to Settings → General
- Enter your Site Title (e.g., "Buffalo Cannabis Network")
- Enter your Tagline (e.g., "Building a Better Cannabis Community")
- Save Changes

**2. Configure Permalinks**
- Go to Settings → Permalinks
- Select "Post name" (recommended)
- Click "Save Changes"

### Step 3: Create Your First Menu (1 minute)

1. Go to Appearance → Menus
2. Click "Create a new menu"
3. Name it "Main Menu"
4. Check "Primary Menu" location
5. Add pages from the left column
6. Click "Save Menu"

### Step 4: Customize Colors (Optional)

1. Go to Appearance → Customize → Theme Colors
2. Adjust Primary Color (default: #2d5016)
3. Adjust Secondary Color (default: #7cb342)
4. Click "Publish"

---

## Essential First Steps

### Create Basic Pages

Create these essential pages:
1. **Home** - Your landing page
2. **About** - About Buffalo Cannabis Network
3. **Contact** - Contact information
4. **Events** - Events archive (use /events/ permalink)
5. **Members** - Community members (use /members/ permalink)

### Set Up Front Page

1. Go to Settings → Reading
2. Choose "A static page"
3. Select your Home page as "Homepage"
4. Select a Blog page as "Posts page" (optional)
5. Save Changes

### Add Widgets

1. Go to Appearance → Widgets
2. Add widgets to:
   - **Sidebar**: Recent Posts, Categories
   - **Footer**: Text widget with contact info
   - **Community**: BCN Community Widget

---

## Using Custom Post Types

### Creating Events

1. Go to Events → Add New in admin
2. Enter event title (e.g., "Monthly Meetup")
3. Add event details in content area
4. Set featured image (800x450px recommended)
5. Select or create Event Category
6. Publish

**Events will appear at**: `yoursite.com/events/`

### Adding Members

1. Go to Members → Add New
2. Enter member name as title
3. Add bio in content area
4. Set profile photo as featured image (400x400px recommended)
5. Publish

**Members will appear at**: `yoursite.com/members/`

---

## Customization Quick Reference

### Change Colors

**Via Customizer:**
- Appearance → Customize → Theme Colors

**Via CSS (Advanced):**
Add to child theme or Customizer Additional CSS:
```css
:root {
  --primary-color: #your-color;
  --secondary-color: #your-color;
  --accent-color: #your-color;
}
```

### Add Your Logo

1. Go to Appearance → Customize → Site Identity
2. Click "Select logo"
3. Upload your logo (350x100px recommended)
4. Click "Publish"

### Change Fonts

Use a plugin like:
- Google Fonts Typography
- Easy Google Fonts
- Or add to Additional CSS in Customizer

---

## Recommended Plugins

While the theme works great standalone, these plugins enhance functionality:

**Essential:**
- **Yoast SEO** - SEO optimization
- **Contact Form 7** - Contact forms
- **Wordfence Security** - Security protection

**Recommended:**
- **WP Super Cache** - Performance
- **Akismet** - Spam protection
- **UpdraftPlus** - Backups

**Optional (Community Features):**
- **BuddyPress** - Social networking
- **bbPress** - Forums
- **The Events Calendar** - Advanced events

---

## Common Tasks

### Adding a Blog Post

1. Go to Posts → Add New
2. Enter title and content
3. Add featured image (1200x675px)
4. Select category
5. Publish

### Creating a Custom Page Template

1. Create a child theme
2. Copy `page.php` to child theme
3. Rename (e.g., `page-custom.php`)
4. Add template name at top:
```php
<?php
/* Template Name: Custom Page */
```
5. Select template when editing page

### Adding Social Media Icons

1. Go to Appearance → Menus
2. Create or edit Footer menu
3. Add Custom Links with social media URLs
4. Save menu

---

## Troubleshooting Quick Fixes

**Problem**: Menus don't show
- **Fix**: Create and assign a menu in Appearance → Menus

**Problem**: Events/Members pages show 404
- **Fix**: Go to Settings → Permalinks, click "Save Changes"

**Problem**: Images too large
- **Fix**: Install "Regenerate Thumbnails" plugin and run it

**Problem**: Sidebar missing
- **Fix**: Add widgets to Sidebar in Appearance → Widgets

**Problem**: Styles not updating
- **Fix**: Clear browser cache (Ctrl+Shift+Delete)

---

## Getting Help

- **Documentation**: See DOCUMENTATION.md for detailed info
- **GitHub Issues**: Report bugs or ask questions
- **WordPress Support**: https://wordpress.org/support/
- **Theme Files**: Check inline comments in PHP files

---

## Next Steps

1. ✅ Theme installed and activated
2. ⬜ Configure basic settings
3. ⬜ Create menu
4. ⬜ Add logo
5. ⬜ Create pages
6. ⬜ Add content
7. ⬜ Install essential plugins
8. ⬜ Test on mobile
9. ⬜ Set up SSL
10. ⬜ Launch!

---

## Pro Tips

- **Use Child Theme**: For custom modifications
- **Test Updates**: Test theme updates in staging
- **Regular Backups**: Backup before making changes
- **Mobile First**: Always test on mobile devices
- **Page Speed**: Use caching and image optimization
- **Accessibility**: Test with keyboard navigation
- **Security**: Keep WordPress and theme updated

---

## Support & Resources

- **Theme Documentation**: DOCUMENTATION.md
- **Contributing**: CONTRIBUTING.md
- **Security**: SECURITY.md
- **Changelog**: CHANGELOG.md
- **License**: MIT License (see LICENSE)

---

**Ready to launch your cannabis community platform!** 🌿

For detailed documentation, see DOCUMENTATION.md
