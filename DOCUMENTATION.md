# BCN WordPress Theme Documentation

## Table of Contents

1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Customization](#customization)
4. [Custom Post Types](#custom-post-types)
5. [Widgets](#widgets)
6. [Menus](#menus)
7. [Template Hierarchy](#template-hierarchy)
8. [Hooks and Filters](#hooks-and-filters)
9. [Development](#development)
10. [Troubleshooting](#troubleshooting)

---

## Installation

### Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher (or MariaDB 10.0+)

### Steps

1. **Download the theme**
   - Clone from GitHub or download as ZIP
   ```bash
   git clone https://github.com/therealjohndough/bcn-wp-theme.git
   ```

2. **Install in WordPress**
   - Upload to `/wp-content/themes/bcn-wp-theme/`
   - Or use Appearance → Themes → Add New → Upload Theme

3. **Activate the theme**
   - Go to Appearance → Themes
   - Click "Activate" on Buffalo Cannabis Network theme

4. **Configure basic settings**
   - Set Site Title and Tagline (Settings → General)
   - Configure permalinks (Settings → Permalinks - recommended: Post name)
   - Create menu (Appearance → Menus)

---

## Configuration

### Initial Setup

1. **Site Identity**
   - Go to Appearance → Customize → Site Identity
   - Upload a logo (recommended: 350x100px)
   - Set site title and tagline

2. **Colors**
   - Go to Appearance → Customize → Theme Colors
   - Customize primary and secondary colors
   - Changes reflect immediately in preview

3. **Menus**
   - Create at least a Primary Menu
   - Optionally create Footer and Community menus
   - See [Menus](#menus) section for details

4. **Widgets**
   - Add widgets to Sidebar, Footer, or Community areas
   - See [Widgets](#widgets) section for details

---

## Customization

### Theme Colors

The theme uses CSS custom properties for easy color customization:

```css
:root {
  --primary-color: #2d5016;      /* Dark Green */
  --secondary-color: #7cb342;    /* Light Green */
  --accent-color: #ff6f00;       /* Orange */
  --text-color: #333333;         /* Dark Gray */
  --light-bg: #f5f5f5;          /* Light Gray */
  --white: #ffffff;              /* White */
}
```

**Method 1: WordPress Customizer**
- Appearance → Customize → Theme Colors
- Change Primary and Secondary colors
- Live preview before publishing

**Method 2: Child Theme**
Create a child theme and override in `style.css`:

```css
:root {
  --primary-color: #your-color;
  --secondary-color: #your-color;
}
```

### Fonts

Default fonts:
- Body: System font stack (optimized for performance)
- Headings: Georgia, serif

To change fonts, create a child theme or use a plugin like:
- Google Fonts Typography
- Easy Google Fonts
- Custom Font Uploader

### Layout

The theme uses a flexible container system:
- Maximum content width: 1200px
- Responsive breakpoints: 768px (mobile)

---

## Custom Post Types

### Events (`bcn_event`)

**Purpose**: Community events, meetups, workshops

**Features**:
- Title, content, featured image
- Excerpt support
- Comments enabled
- Archive page: `/events/`
- Event categories taxonomy

**Usage**:
1. Go to Events → Add New
2. Enter event title and details
3. Add featured image (recommended: 800x450px)
4. Assign event category
5. Publish

**Display Events**:
- Archive: `yoursite.com/events/`
- Single: `yoursite.com/events/event-name/`
- Category: `yoursite.com/event-category/category-name/`

### Members (`bcn_member`)

**Purpose**: Showcase community members

**Features**:
- Title, rich content, and featured logo support
- Membership levels taxonomy with default Premier, Pro, and Community Partner tiers
- Dedicated onboarding workflow that creates the profile, uploads the logo, and applies the correct membership tier from a single form
- Custom fields for website, email, phone, and address information
- Archive page: `/members/`
- `[member_logo_grid]` shortcode for automated logo walls on landing pages (supports filtering by level, featured flag, and column count)
- Optional secure submission links so trusted members can send stories or photos that land in the pending posts queue for editorial review

**Usage**:
1. Go to Members → Onboard Member to launch the guided workflow.
2. Complete the onboarding form with the member’s details, select the correct membership level, and upload their logo.
3. Submit the form to automatically create the member’s profile page, assign taxonomy terms, and add their logo to the media library.
4. Review the generated profile and add any supplementary media or formatting as needed.
5. To allow a member to submit stories or images, open their profile in the editor and enable the **Member Contributions** meta box. A private key and shareable URL will be generated automatically.
6. Optionally, manage the member later via Members → All Members.

**Logo Grid Shortcode**:
```
[member_logo_grid level="premier-member" limit="12" columns="4" featured="false"]
```
- `level` (optional): Filter logos to a specific membership level slug.
- `limit` (optional): Maximum number of members to display (`-1` for all).
- `columns` (optional): Number of columns in the grid (2-6, default 4).
- `featured` (optional): Set to `true` to only surface members marked as featured.

**Member Submission Shortcode**:
```
[member_submission_form]
```
- Add this shortcode to a dedicated page (for example `/member-submissions/`).
- Share the generated link (page URL + `?submission_key=...`) with members who have the **Allow this member to submit stories or media** checkbox enabled.
- The form supports blog-style story submissions or photo uploads; everything is created as a pending post so admins can edit and publish when ready.
- Optional: pass `redirect="/thank-you/"` to send contributors to a confirmation page after the form is submitted.

**Display Members**:
- Archive: `yoursite.com/members/`
- Single: `yoursite.com/members/member-name/`
- Submission form: `yoursite.com/member-submissions/?submission_key=YOUR-PRIVATE-KEY`

---

## Widgets

### Available Widget Areas

**1. Sidebar**
- Location: Right side of posts and pages
- Use for: Recent posts, categories, tags, custom content

**2. Footer Widget Area**
- Location: Footer section
- Use for: Contact info, links, social media

**3. Community Widget Area**
- Location: Special community pages
- Use for: Community-specific content

### BCN Community Widget

Custom widget included with the theme:
- Displays community information
- Customizable title
- Perfect for engagement

**To use**:
1. Appearance → Widgets
2. Drag "BCN Community Widget" to desired area
3. Configure title and save

---

## Menus

### Menu Locations

**Primary Menu**
- Location: Header, below site title
- Use for: Main site navigation
- Supports: Multi-level menus (dropdowns)

**Footer Menu**
- Location: Footer area
- Use for: Secondary links, legal pages
- Supports: Single level (recommended)

**Community Menu**
- Location: Community pages
- Use for: Community-specific navigation

### Creating Menus

1. Go to Appearance → Menus
2. Click "Create a new menu"
3. Name your menu
4. Check desired location(s)
5. Add pages/posts/custom links
6. Arrange order by dragging
7. Save menu

---

## Template Hierarchy

The theme follows WordPress template hierarchy:

```
Single Post:
single.php → index.php

Page:
page.php → index.php

Archive:
archive.php → index.php

Search:
search.php → index.php

404:
404.php → index.php

Custom Post Types:
single-{post-type}.php → single.php → index.php
archive-{post-type}.php → archive.php → index.php
```

### Template Parts

Located in `/template-parts/`:
- `content.php` - Default post display
- `content-single.php` - Single post
- `content-page.php` - Page content
- `content-search.php` - Search results
- `content-none.php` - No content found

---

## Hooks and Filters

### Available Filters

**Content Width**
```php
add_filter('bcn_content_width', function($width) {
    return 1400; // Change from default 1200px
});
```

**Excerpt Length**
```php
add_filter('excerpt_length', function($length) {
    return 50; // Change from default 30 words
});
```

**Body Classes**
```php
add_filter('body_class', function($classes) {
    $classes[] = 'custom-class';
    return $classes;
});
```

### Custom Functions

All theme functions are prefixed with `bcn_` to avoid conflicts:
- `bcn_theme_setup()` - Theme setup
- `bcn_widgets_init()` - Register widgets
- `bcn_scripts()` - Enqueue scripts/styles
- `bcn_posted_on()` - Display post date
- `bcn_posted_by()` - Display post author
- `bcn_entry_footer()` - Display post meta

---

## Development

### File Structure

```
bcn-wp-theme/
├── assets/
│   ├── css/
│   │   └── editor-style.css
│   ├── js/
│   │   ├── customizer.js
│   │   ├── main.js
│   │   └── navigation.js
│   └── images/
├── includes/
│   ├── community-features.php    # Community functionality
│   ├── customizer.php            # Customizer settings
│   ├── post-types.php            # Custom post types
│   ├── template-functions.php    # Helper functions
│   └── template-tags.php         # Template tags
├── template-parts/
│   └── *.php                     # Template part files
├── functions.php                 # Main functions file
├── style.css                     # Main stylesheet
└── [template-files].php          # WordPress template files
```

### Creating a Child Theme

1. Create directory: `/wp-content/themes/bcn-wp-theme-child/`

2. Create `style.css`:
```css
/*
Theme Name: BCN Child Theme
Template: bcn-wp-theme
*/
```

3. Create `functions.php`:
```php
<?php
function bcn_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'bcn_child_enqueue_styles');
```

4. Activate child theme

### Extending Functionality

**Add custom post type**:
Edit `includes/post-types.php` or add in child theme

**Add custom widget area**:
Edit `functions.php` `bcn_widgets_init()` function

**Customize templates**:
Copy template file to child theme and modify

---

## Troubleshooting

### Common Issues

**Issue**: Menu doesn't display
- Solution: Create and assign menu in Appearance → Menus

**Issue**: Sidebar not showing
- Solution: Add widgets to Sidebar widget area

**Issue**: Custom post types not visible
- Solution: Go to Settings → Permalinks and click "Save Changes"

**Issue**: Images too large
- Solution: Install "Regenerate Thumbnails" plugin and run

**Issue**: Style changes don't appear
- Solution: Clear browser cache and WordPress cache

### Getting Help

1. Check WordPress Codex
2. Review theme documentation
3. Check browser console for JavaScript errors
4. Enable WordPress debug mode
5. Create issue on GitHub

### Debug Mode

Enable in `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Check `/wp-content/debug.log` for errors

---

## Support

- GitHub Issues: https://github.com/therealjohndough/bcn-wp-theme/issues
- WordPress Support: https://wordpress.org/support/
- Theme Documentation: This file

## License

MIT License - See LICENSE file for details
