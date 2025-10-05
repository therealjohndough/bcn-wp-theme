# Contributing to Buffalo Cannabis Network WordPress Theme

Thank you for your interest in contributing to the BCN WordPress theme! This document provides guidelines and instructions for contributing.

## Code of Conduct

By participating in this project, you agree to maintain a respectful and inclusive environment for all contributors.

## How to Contribute

### Reporting Bugs

If you find a bug, please create an issue on GitHub with:
- A clear, descriptive title
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- WordPress version
- PHP version
- Browser (if applicable)
- Screenshots (if applicable)

### Suggesting Enhancements

Enhancement suggestions are welcome! Please create an issue with:
- A clear, descriptive title
- Detailed description of the proposed feature
- Use cases and benefits
- Any relevant mockups or examples

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Follow WordPress Coding Standards**
   - PHP: [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
   - CSS: [WordPress CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/)
   - JavaScript: [WordPress JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/)
3. **Write clear commit messages**
   - Use present tense ("Add feature" not "Added feature")
   - Use imperative mood ("Move cursor to..." not "Moves cursor to...")
   - Limit first line to 72 characters
   - Reference issues and pull requests liberally
4. **Test your changes**
   - Test in latest versions of major browsers
   - Test with different WordPress versions (5.0+)
   - Ensure no PHP errors
   - Verify responsive design
5. **Update documentation** as needed
6. **Submit your pull request**

## Development Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/therealjohndough/bcn-wp-theme.git
   ```

2. Install the theme in your WordPress installation:
   ```bash
   cd wp-content/themes
   cp -r /path/to/bcn-wp-theme .
   ```

3. Activate the theme in WordPress admin

4. Install development dependencies (optional):
   ```bash
   npm install
   ```

## Coding Standards

### PHP

- Follow WordPress PHP Coding Standards
- Use proper escaping functions (`esc_html()`, `esc_attr()`, `esc_url()`)
- Validate and sanitize all input
- Use WordPress core functions where available
- Add inline documentation for all functions
- Use meaningful variable and function names

### CSS

- Use CSS custom properties (CSS variables) for theme colors
- Follow BEM or similar methodology for class naming
- Write mobile-first responsive CSS
- Group related properties together
- Add comments for complex sections

### JavaScript

- Use vanilla JavaScript or jQuery (already included in WordPress)
- Avoid using external JavaScript libraries unless necessary
- Write modular, reusable code
- Add comments for complex logic
- Use strict mode

### File Organization

- **Template files**: Root directory
- **Template parts**: `/template-parts/`
- **PHP includes**: `/includes/`
- **CSS**: `/assets/css/`
- **JavaScript**: `/assets/js/`
- **Images**: `/assets/images/`

## Testing Checklist

Before submitting a pull request, ensure:

- [ ] Code follows WordPress coding standards
- [ ] All PHP files have no syntax errors
- [ ] Changes work in latest WordPress version
- [ ] Theme passes Theme Check plugin
- [ ] Tested in multiple browsers (Chrome, Firefox, Safari, Edge)
- [ ] Responsive design works on mobile, tablet, and desktop
- [ ] No JavaScript console errors
- [ ] No PHP errors or warnings
- [ ] Accessibility standards maintained
- [ ] Documentation updated

## Theme Structure

```
bcn-wp-theme/
├── assets/              # Static assets
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   └── images/         # Images
├── includes/           # PHP includes
│   ├── community-features.php
│   ├── customizer.php
│   ├── post-types.php
│   ├── template-functions.php
│   └── template-tags.php
├── template-parts/     # Reusable template parts
│   ├── content.php
│   ├── content-single.php
│   ├── content-page.php
│   ├── content-search.php
│   └── content-none.php
├── *.php               # Main template files
├── style.css           # Main stylesheet with theme header
├── functions.php       # Theme functions
└── README.md           # Documentation
```

## Version Control

- Use meaningful branch names (feature/*, bugfix/*, hotfix/*)
- Keep commits focused and atomic
- Write clear commit messages
- Rebase on main before submitting PR

## Documentation

- Update README.md for user-facing changes
- Add inline code comments for complex logic
- Update function documentation (PHPDoc)
- Include examples where helpful

## Questions?

If you have questions about contributing, please open an issue with the "question" label.

## Recognition

Contributors will be recognized in the project's documentation. Thank you for helping make this theme better!

## License

By contributing, you agree that your contributions will be licensed under the same MIT License that covers the project.
