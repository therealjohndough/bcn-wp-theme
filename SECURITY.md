# Security Policy

## Supported Versions

The following versions of the BCN WordPress Theme are currently supported with security updates:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |

## Reporting a Vulnerability

We take the security of the Buffalo Cannabis Network WordPress theme seriously. If you discover a security vulnerability, please follow these steps:

### How to Report

1. **DO NOT** create a public GitHub issue for security vulnerabilities
2. Email the maintainer directly at: [Create a security advisory on GitHub]
3. Or use GitHub's Security Advisory feature:
   - Go to the repository's Security tab
   - Click "Report a vulnerability"
   - Fill out the form with details

### What to Include

Please include the following information in your report:

- **Description**: Clear description of the vulnerability
- **Impact**: What could an attacker accomplish?
- **Steps to Reproduce**: Detailed steps to reproduce the issue
- **Affected Versions**: Which versions are affected?
- **Suggested Fix**: If you have ideas on how to fix it
- **Your Contact Info**: How we can reach you for follow-up

### Response Timeline

- **Acknowledgment**: Within 48 hours
- **Initial Assessment**: Within 1 week
- **Status Update**: Every 2 weeks until resolved
- **Fix Release**: Depends on severity
  - Critical: ASAP (within days)
  - High: Within 2 weeks
  - Medium: Within 1 month
  - Low: Next release cycle

## Security Best Practices

When using this theme, follow these security best practices:

### For Theme Users

1. **Keep WordPress Updated**
   - Always use the latest WordPress version
   - Enable automatic updates when possible

2. **Keep Theme Updated**
   - Watch for theme updates
   - Test updates in staging before production

3. **Use Strong Passwords**
   - Use complex passwords for WordPress admin
   - Enable two-factor authentication

4. **Limit User Permissions**
   - Only give users necessary permissions
   - Regularly audit user accounts

5. **Use Security Plugins**
   - Consider plugins like Wordfence or Sucuri
   - Enable login attempt limiting
   - Enable file integrity monitoring

6. **Regular Backups**
   - Backup your site regularly
   - Test restore procedures

7. **SSL Certificate**
   - Use HTTPS for your site
   - Force SSL in WordPress settings

### For Theme Developers

1. **Input Validation**
   - Always validate user input
   - Never trust client-side data

2. **Output Escaping**
   - Use proper escaping functions:
     - `esc_html()` for HTML output
     - `esc_attr()` for attributes
     - `esc_url()` for URLs
     - `wp_kses()` for allowed HTML

3. **SQL Queries**
   - Use `$wpdb->prepare()` for all queries
   - Never concatenate user input into queries
   - Use WordPress query functions when possible

4. **Nonces**
   - Use nonces for all form submissions
   - Verify nonces before processing

5. **Capability Checks**
   - Check user capabilities before sensitive operations
   - Use `current_user_can()` appropriately

6. **File Operations**
   - Validate file uploads
   - Use WordPress file system API
   - Never trust file extensions

7. **AJAX Security**
   - Verify nonces in AJAX requests
   - Check user capabilities
   - Sanitize and validate all data

## Security Features in This Theme

The BCN WordPress Theme includes several security features:

### Built-in Security

1. **Escaping Functions**
   - All output is properly escaped
   - HTML, attributes, and URLs sanitized

2. **Sanitization**
   - All input is sanitized
   - Form data validated

3. **No External Dependencies**
   - No external JavaScript libraries (except WordPress core)
   - All assets served locally

4. **Secure Headers**
   - Proper HTTP headers
   - No inline scripts (except WordPress core)

5. **WordPress Standards**
   - Follows WordPress Coding Standards
   - Uses WordPress APIs exclusively

### What This Theme Does NOT Do

For security, this theme does NOT:

- Store sensitive data in cookies
- Use `eval()` or similar dangerous functions
- Execute arbitrary code
- Make external HTTP requests (except WordPress core)
- Modify WordPress core files
- Create security exceptions

## Known Security Considerations

### Theme Customizer

- Customizer settings use proper sanitization
- Color values validated as hex colors
- All settings saved through WordPress API

### Custom Post Types

- Standard WordPress post types
- Use built-in capabilities
- No custom permissions added

### JavaScript

- Minimal JavaScript usage
- No user input processed in JavaScript
- All AJAX uses WordPress nonces (if implemented)

### Widgets

- Custom widget properly sanitizes input
- Uses WordPress widget API
- No file uploads or dangerous operations

## Disclosure Policy

When a security vulnerability is reported and confirmed:

1. **Private Fix**: We'll work on a fix privately
2. **Security Advisory**: Create GitHub security advisory
3. **Update Release**: Release patched version
4. **Public Disclosure**: Announce after fix is available
5. **Credit**: Credit reporter (if desired)

## Third-Party Dependencies

This theme has minimal dependencies:

- **WordPress Core**: Required (5.0+)
- **PHP**: Required (7.4+)
- **jQuery**: Included with WordPress core

Always keep WordPress and PHP updated to latest stable versions.

## Security Checklist for Deployment

Before deploying to production:

- [ ] WordPress is updated to latest version
- [ ] PHP is version 7.4 or higher
- [ ] SSL certificate installed and configured
- [ ] File permissions set correctly (644 for files, 755 for directories)
- [ ] wp-config.php has strong security keys
- [ ] Database credentials are secure
- [ ] WordPress debugging is disabled in production
- [ ] Unused plugins and themes removed
- [ ] Security plugin installed and configured
- [ ] Backup solution in place
- [ ] User accounts reviewed and limited
- [ ] Strong passwords enforced

## Updates and Notifications

To stay informed about security updates:

1. **Watch the GitHub Repository**
   - Click "Watch" → "Releases only"
   - Receive notifications for new versions

2. **Check WordPress Dashboard**
   - WordPress will notify of available updates
   - Review update notes before applying

3. **Subscribe to WordPress Security Blog**
   - Stay informed about WordPress security

## Questions?

If you have questions about security:
- For general questions: Open a GitHub issue
- For security vulnerabilities: Use private reporting methods above

## Compliance

This theme aims to comply with:
- WordPress.org Theme Review Guidelines
- OWASP Web Security Standards
- PHP Security Best Practices
- GDPR (no personal data collected by theme)

## Acknowledgments

We appreciate security researchers who responsibly disclose vulnerabilities. Thank you for helping keep this theme secure!

---

Last Updated: January 2025
