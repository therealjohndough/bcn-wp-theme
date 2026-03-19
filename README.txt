# Buffalo Cannabis Network WordPress Block Theme

A modern, professional WordPress block theme designed for the Buffalo Cannabis Network. Built using WordPress Full Site Editing (FSE) with clean, custom PHP feel and easy visual editing capabilities.

## 🎯 Theme Features

- **Full Site Editing (FSE)** - Edit everything visually using WordPress blocks
- **Custom Block Patterns** - Pre-built, reusable content layouts
- **Clean Design System** - Consistent colors, typography, and spacing via theme.json
- **Custom Post Type** - Events with taxonomy support
- **Responsive & Accessible** - Mobile-friendly, WCAG 2.1 AA compliant
- **Performance Optimized** - Minimal dependencies, clean code
- **SEO-Friendly** - Semantic HTML5 markup

## 📁 Theme Structure

```
buffalo-cannabis-network/
├── theme.json                 # Design system configuration
├── style.css                  # Theme header & custom styles
├── functions.php              # PHP functionality
├── README.md                  # This file
├── screenshot.png             # Theme screenshot (create this)
├── templates/
│   ├── index.html            # Default template
│   ├── front-page.html       # Homepage template
│   ├── page.html             # Page template
│   ├── single.html           # Single post template
│   ├── archive.html          # Archive template
│   ├── page-about.html       # About page template
│   ├── page-contact.html     # Contact page template
│   ├── page-membership.html  # Membership page template
│   └── page-events.html      # Events page template
├── parts/
│   ├── header.html           # Site header
│   └── footer.html           # Site footer
├── patterns/
│   ├── values-grid.php       # Values/benefits grid
│   ├── membership-tiers.php  # Membership pricing cards
│   ├── hero-section.php      # Hero sections
│   ├── team-grid.php         # Team member cards
│   ├── event-cards.php       # Event card layouts
│   └── cta-section.php       # Call-to-action sections
└── assets/
    ├── css/
    ├── js/
    └── images/
```

## 🚀 Installation

1. **Upload Theme:**
   - Compress the theme folder into a .zip file
   - Go to WordPress Admin → Appearance → Themes → Add New
   - Click "Upload Theme" and select your .zip file
   - Click "Install Now"

2. **Activate Theme:**
   - Click "Activate" after installation completes

3. **Set Up Navigation:**
   - Go to Appearance → Editor → Navigation
   - Create your primary navigation menu

4. **Customize Settings:**
   - Go to Appearance → Editor
   - Click the ⚙️ (Settings) icon to access global styles
   - Customize colors, typography, and spacing as needed

## 🎨 Design System

### Colors

The theme uses a carefully selected color palette:

- **Primary Green:** `#7CB342` - Main brand color
- **Secondary Blue:** `#4A90E2` - Page headers, featured elements
- **Accent Purple:** `#9C27B0` - Tertiary accents
- **Highlight Yellow:** `#FFC107` - Call-to-action highlights
- **Black:** `#000000` - Navigation, footer, headings
- **Gray:** `#757575` - Body text, secondary content
- **Light Gray:** `#f5f5f5` - Section backgrounds

### Typography

- **Font Family:** Roboto Flex (variable font)
- **Headings:** Font weights 300-700
- **Body Text:** 1rem (16px), line-height 1.6
- **Large Text:** 1.25rem - 4.5rem scale

### Spacing

Consistent spacing scale: 0.5rem, 1rem, 1.5rem, 2rem, 3rem, 4rem, 5rem

## 📝 Using Block Patterns

Block patterns are pre-designed content layouts you can insert and customize:

1. **In the Block Editor:**
   - Click the `+` (Add Block) button
   - Select the "Patterns" tab
   - Browse patterns by category:
     - BCN Hero Sections
     - BCN Card Layouts
     - BCN Membership
     - BCN Team & People
     - BCN Call to Action

2. **Available Patterns:**
   - **Values Grid** - 6-card grid for core values/benefits
   - **Membership Tiers** - 3-tier pricing cards
   - **Hero Section** - Large header with CTA buttons
   - **Team Grid** - Team member cards with bios
   - **Event Cards** - Event listing cards
   - **CTA Section** - Call-to-action banners

## 🎯 Creating Pages

### Homepage

1. Create a new page called "Home"
2. Set as static front page: Settings → Reading → Homepage
3. The theme will automatically use `templates/front-page.html`
4. Edit page content using the block editor

### Other Pages

1. **About Page:**
   - Create page with "About" template
   - Add team grid pattern
   - Add values grid pattern

2. **Membership Page:**
   - Create page with "Membership" template
   - Use membership tiers pattern
   - Add testimonials

3. **Events Page:**
   - Create page with "Events" template
   - Use event cards pattern
   - Filter by event type taxonomy

4. **Contact Page:**
   - Create page with "Contact" template
   - Add contact form (use Contact Form 7 or similar)
   - Add contact info blocks

## 📅 Events Custom Post Type

The theme includes a custom "Events" post type:

### Adding Events

1. Go to **Events → Add New**
2. Add event title and description
3. Add custom fields:
   - `event_date` - Event date (YYYY-MM-DD format)
   - `event_time` - Event time
   - `event_location` - Venue/location
   - `event_type` - Taxonomy term
4. Set featured image
5. Publish event

### Event Types

Categorize events using the Event Type taxonomy:
- Networking
- Workshop
- Speaker Series
- Showcase
- Happy Hour

## 🔧 Customization

### Editing Global Styles

1. Go to **Appearance → Editor**
2. Click the ⚙️ icon (top right)
3. Select "Styles"
4. Modify:
   - Colors
   - Typography
   - Layout widths
   - Spacing

### Editing Templates

1. Go to **Appearance → Editor**
2. Click "Templates"
3. Select template to edit
4. Use block editor to modify layout
5. Save changes

### Creating Custom Block Patterns

```php
<?php
// In patterns/your-pattern.php
/**
 * Title: Your Pattern Name
 * Slug: bcn/your-pattern-slug
 * Categories: bcn-cards
 */
?>

<!-- Add your block markup here -->
```

## 🎨 CSS Utility Classes

The theme includes helpful CSS utility classes:

### Containers
- `.bcn-container` - Max-width 1400px
- `.bcn-container-narrow` - Max-width 1200px

### Card Effects
- `.bcn-card-hover` - Hover lift effect

### Backgrounds
- `.bcn-bg-subtle` - Light gray background
- `.bcn-bg-dark` - Black background
- `.bcn-bg-blue` - Blue background

### Border Accents
- `.bcn-border-left-primary` - Left border (green)
- `.bcn-border-left-secondary` - Left border (blue)
- `.bcn-border-left-accent` - Left border (purple)

### Grids
- `.bcn-grid-2` - 2-column responsive grid
- `.bcn-grid-3` - 3-column responsive grid
- `.bcn-grid-4` - 4-column responsive grid

## 🔒 Security Features

- Input sanitization and validation
- SVG upload sanitization
- Security headers
- No WordPress version in source
- Cleaned up wp_head

## ⚡ Performance Features

- Deferred script loading
- No WordPress emojis
- Minimal CSS/JS dependencies
- Google Fonts preconnect
- Optimized image sizes

## 📱 Responsive Breakpoints

- **Desktop:** 1400px+
- **Tablet:** 768px - 968px
- **Mobile:** < 768px

## 🆘 Support & Troubleshooting

### Common Issues

**Navigation not showing:**
- Go to Appearance → Editor → Navigation
- Create a navigation menu with your links

**Patterns not appearing:**
- Make sure pattern files are in `/patterns/` folder
- Check that pattern categories are registered in functions.php

**Colors not matching:**
- Go to Appearance → Editor → Styles
- Check color palette settings

**Events not showing:**
- Flush permalinks: Settings → Permalinks → Save Changes

## 📋 Recommended Plugins

- **Contact Form 7** - Contact forms
- **Yoast SEO** - SEO optimization
- **WP Super Cache** - Performance caching
- **Wordfence Security** - Security hardening
- **UpdraftPlus** - Backup solution

## 🔄 Updates & Maintenance

### Updating Content
- All content is editable through the WordPress block editor
- No need to touch code for content updates

### Child Theme (Optional)
For extensive customizations, create a child theme:

```php
// child-theme/style.css
/*
Theme Name: BCN Child Theme
Template: buffalo-cannabis-network
*/
```

## 📞 Getting Help

For theme customization help:
1. Check WordPress Block Editor documentation
2. Review theme.json specification
3. Explore WordPress block patterns
4. Contact theme developer

## 📄 License

This theme is licensed under GPL v2 or later.

---

**Version:** 1.0.0  
**Last Updated:** 2025  
**Author:** Buffalo Cannabis Network