# Buffalo Cannabis Network WordPress Theme

A custom WordPress theme for Buffalo Cannabis Network - a marketing and community platform designed for the cannabis industry.

## Overview

This theme provides a robust, maintainable foundation for building a community-driven marketing platform. It includes modern WordPress best practices, responsive design, and custom post types specifically designed for community engagement.

## Features

### Core Features
- ✅ Fully responsive design
- ✅ Custom color scheme optimized for cannabis branding
- ✅ Modern WordPress theme structure
- ✅ HTML5 semantic markup
- ✅ Accessibility-ready
- ✅ SEO-friendly
- ✅ Translation-ready

### Community Features
- ✅ Custom post types (Events, Members)
- ✅ Custom taxonomies (Event Categories)
- ✅ Community widget areas
- ✅ Event management system
- ✅ Member profiles

### Design Features
- ✅ CSS custom properties for easy theming
- ✅ Flexible layout system
- ✅ Custom logo support
- ✅ Custom background support
- ✅ Multiple widget areas (Sidebar, Footer, Community)
- ✅ Three navigation menu locations

### Developer Features
- ✅ Clean, well-documented code
- ✅ WordPress Coding Standards compliant
- ✅ Theme Customizer integration
- ✅ Custom template tags
- ✅ Modular file structure
- ✅ Editor styles support

## Installation

1. Download or clone this repository
2. Upload the theme folder to `/wp-content/themes/`
3. Activate the theme through the WordPress admin panel
4. Go to Appearance → Customize to configure theme options

## Theme Structure

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
│   ├── community-features.php
│   ├── customizer.php
│   ├── post-types.php
│   ├── template-functions.php
│   └── template-tags.php
├── template-parts/
│   ├── content.php
│   ├── content-none.php
│   ├── content-page.php
│   └── content-single.php
├── archive.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── sidebar.php
├── single.php
└── style.css
```

## Customization

### Theme Colors

The theme uses CSS custom properties for easy color customization. Default colors:

- Primary Color: `#2d5016` (Dark Green)
- Secondary Color: `#7cb342` (Light Green)
- Accent Color: `#ff6f00` (Orange)

You can customize these colors in:
1. WordPress Customizer (Appearance → Customize → Theme Colors)
2. Or directly in `style.css` under `:root` variables

### BCN Block Patterns
Two ready-made patterns are available under **Patterns → BCN** in the block editor:
- **Contact – Get in Touch (BCN)**
- **Stay Connected (BCN)**

If you don’t see them, ensure `includes/patterns.php` is loaded and `assets/css/patterns.css` is enqueued in `functions.php`.

### Navigation Menus

The theme supports three menu locations:
- **Primary Menu**: Main site navigation in the header
- **Footer Menu**: Links in the footer area
- **Community Menu**: Special menu for community features

Configure menus at: Appearance → Menus

### Widget Areas

Three widget areas are available:
- **Sidebar**: Main sidebar for posts and pages
- **Footer Widget Area**: Footer content area
- **Community Widget Area**: Special area for community features

Configure widgets at: Appearance → Widgets

### Custom Post Types

#### Events (`bcn_event`)
Perfect for community events, meetups, and activities.

**Features:**
- Title, content, featured image
- Excerpt and comments support
- Event categories taxonomy
- Archive page at `/events/`

#### Members (`bcn_member`)
Showcase community members and profiles.

**Features:**
- Title, content, featured image
- Member profiles with bio
- Archive page at `/members/`

## Development

### Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher

### Development Setup

1. Clone the repository
2. Install development dependencies (optional):
   ```bash
   npm install
   ```
3. Start developing!

### Building Assets

The theme includes basic npm scripts for future asset compilation:

```bash
npm run build      # Build all assets
npm run dev        # Watch and build during development
```

Note: Currently, assets are vanilla JS/CSS. Build scripts are placeholders for future enhancements.

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Accessibility

This theme follows WCAG 2.0 Level AA guidelines:
- Semantic HTML5 elements
- ARIA landmarks
- Keyboard navigation support
- Screen reader text for icon-only elements
- Skip links for navigation

## Performance

- Minimal CSS and JavaScript
- Optimized asset loading
- No external dependencies
- Efficient WordPress queries
- Proper use of WordPress transients

## Contributing

Contributions are welcome! Please follow these guidelines:
1. Fork the repository
2. Create a feature branch
3. Follow WordPress Coding Standards
4. Test thoroughly
5. Submit a pull request

## Support

For issues, questions, or contributions:
- Open an issue on GitHub
- Follow WordPress theme development best practices
- Check WordPress Codex for theme development guidelines

## GitHub Actions: Deploy to SiteGround

There's a workflow at `.github/workflows/deploy-siteground.yml` that will run on push to `main` and deploy a directory (by default `./build`) to SiteGround via `rsync` over SSH.

Required repository secrets:
- `SG_DEPLOY_KEY` - the private SSH key (PEM) used to authenticate to SiteGround. Paste the private key contents (NOT the public key).
- `SG_HOST` - SSH hostname for SiteGround (for example `ssh.buffalocannabisnetwork.com`).
- `SG_USER` - SSH username (for example `u2037-...`).
- `SG_PORT` - SSH port (for example `18765`). Optional; the workflow defaults to `18765` when unset.
- `SG_REMOTE_PATH` - remote path to deploy into (for example `/home/u2037-.../public_html/wp-content/themes/bcn-wp-theme`).
- `SG_SOURCE` - optional: local path to deploy. Defaults to `./build` if not set.

Optional secret:
- `DRY_RUN` - set to `1` to only print the rsync command during workflow runs (useful for testing).

How it works:
- On push to `main`, the workflow checks out the repo, prepares the SSH key from `SG_DEPLOY_KEY`, attempts an `npm ci`/`npm install` and `npm run build` if `package.json` exists, then runs `rsync` to copy the `SG_SOURCE` directory to the remote path.

Security note: keep `SG_DEPLOY_KEY` secret and never commit private keys into the repository. Use the GitHub repository settings to add secrets.

## Credits

- Theme Author: John Dough
- Built with WordPress
- Icons: WordPress Dashicons
- Follows WordPress Theme Review Guidelines

## License

This theme is licensed under the MIT License. See LICENSE file for details.

## Changelog

### Version 1.0.0
- Initial release
- Core theme structure
- Custom post types (Events, Members)
- Community features
- Responsive design
- Theme Customizer integration
- Widget areas
- Navigation menus

## Future Enhancements

Potential features for future versions:
- Advanced event management with dates/times
- Member registration system
- Community forums integration
- Social media integration
- Advanced search functionality
- Page builder compatibility
- Additional custom blocks for Gutenberg
- Dark mode support