# WordPress Theme Template

This is a reusable WordPress theme template for agency client projects.

## Features

- Modern WordPress theme structure
- Responsive design
- Custom post types support
- ACF integration ready
- Webpack build system
- Docker development environment
- WordPress Coding Standards compliant

## Quick Start

1. **Copy this template to your client coespace:**
   ```bash
   cp -r .cursor/coespaces/templates/wordpress-theme-template/* .cursor/coespaces/client-{industry}-{client-name}/
   ```

2. **Update the theme information:**
   - Edit `style.css` header
   - Update `package.json`
   - Modify `composer.json`
   - Customize `coespace-config.json`

3. **Set up development environment:**
   ```bash
   cp .env.example .env
   docker compose up --build
   ```

4. **Install dependencies:**
   ```bash
   npm install
   composer install
   ```

## Project Structure

```
wordpress-theme-template/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── includes/
│   ├── customizer.php
│   ├── post-types.php
│   ├── template-functions.php
│   └── template-tags.php
├── template-parts/
├── .env.example
├── docker-compose.yml
├── package.json
├── composer.json
├── webpack.config.js
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
└── README.md
```

## Customization

### Theme Information
Update the theme header in `style.css`:

```css
/*
Theme Name: Client Theme Name
Description: Custom theme for Client Name
Author: Your Agency Name
Version: 1.0.0
*/
```

### Color Scheme
Modify CSS custom properties in `style.css`:

```css
:root {
  --primary-color: #2d5016;
  --secondary-color: #7cb342;
  --accent-color: #ff6f00;
}
```

### Custom Post Types
Add your custom post types in `includes/post-types.php`:

```php
function register_custom_post_types() {
    // Your custom post types here
}
```

## Development

### Build Assets
```bash
npm run dev      # Development build with watch
npm run build    # Production build
```

### Code Quality
```bash
npm run lint     # Check JavaScript
npm run phpcs    # Check PHP code
npm run quality  # Run all quality checks
```

### Testing
```bash
npm test         # Run tests
```

## Deployment

### Staging
```bash
npm run deploy:staging
```

### Production
```bash
npm run deploy:production
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## License

GPL-2.0-or-later