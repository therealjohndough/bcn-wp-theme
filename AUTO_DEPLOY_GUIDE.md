# BCN Theme Auto-Deploy and Test Process

## 🚀 Overview

This guide covers the complete automated deployment and testing process for the BCN WordPress theme, including enhanced member cards and user experience features.

## 📋 Prerequisites

### Required Tools
- **Git** - Version control
- **PHP 8.1+** - Theme development
- **Composer** - PHP dependency management
- **cURL** - HTTP requests and testing
- **jq** - JSON processing (optional but recommended)
- **SSH** - Server access
- **rsync** - File synchronization

### Required Access
- **GitHub Repository** - Push/pull access
- **Staging Server** - SSH access to staging6.buffalocannabisnetwork.com
- **Production Server** - SSH access to buffalocannabisnetwork.com
- **GitHub Actions** - CI/CD pipeline access

## 🔧 Setup Instructions

### 1. Environment Configuration

```bash
# Copy environment template
cp .env.example .env

# Edit with your actual values
nano .env
```

### 2. SSH Key Setup

```bash
# Generate SSH key for deployment (if not exists)
ssh-keygen -t rsa -b 4096 -C "bcn-theme-deploy"

# Add public key to staging server
ssh-copy-id -p 22 deploy@staging6.buffalocannabisnetwork.com

# Add public key to production server
ssh-copy-id -p 22 deploy@buffalocannabisnetwork.com
```

### 3. GitHub Secrets Configuration

Set the following secrets in your GitHub repository:

```
SG_DEPLOY_KEY=your_staging_ssh_private_key
PROD_DEPLOY_KEY=your_production_ssh_private_key
SG_HOST=staging6.buffalocannabisnetwork.com
SG_USER=deploy
SG_PORT=22
SG_REMOTE_PATH=/public_html/wp-content/themes/bcn-wp-theme
PROD_HOST=buffalocannabisnetwork.com
PROD_USER=deploy
PROD_PORT=22
PROD_REMOTE_PATH=/public_html/wp-content/themes/bcn-wp-theme
```

## 🚀 Deployment Process

### Automated Deployment (Recommended)

#### Option 1: GitHub Actions (Fully Automated)
```bash
# Push to main branch triggers staging deployment
git add .
git commit -m "feat: Enhanced member features"
git push origin main

# For production deployment, use workflow dispatch
# Go to GitHub Actions → Deploy BCN Theme with Tests → Run workflow
```

#### Option 2: Local Script (Semi-Automated)
```bash
# Deploy to staging with tests
./scripts/deploy-with-tests.sh staging

# Deploy to production with tests
./scripts/deploy-with-tests.sh production

# Deploy without tests (not recommended)
./scripts/deploy-with-tests.sh staging true
```

### Manual Deployment Steps

#### 1. Run Tests
```bash
# Run comprehensive theme tests
./scripts/test-theme.sh

# Check test results
cat test-results/test-report.md
```

#### 2. Build Theme
```bash
# Build optimized theme assets
./scripts/setup-enhanced-features.sh

# Verify build
ls -la build/
```

#### 3. Deploy to Staging
```bash
# Deploy to staging
./scripts/deploy-local.sh staging

# Verify deployment
curl -I https://staging6.buffalocannabisnetwork.com
```

#### 4. Test Staging
```bash
# Run performance monitoring
./scripts/monitor-performance.sh

# Check member directory
curl -I https://staging6.buffalocannabisnetwork.com/members/
```

#### 5. Deploy to Production
```bash
# Deploy to production (after staging tests pass)
./scripts/deploy-local.sh production

# Verify production
curl -I https://buffalocannabisnetwork.com
```

## 🧪 Testing Process

### Automated Tests

The testing process includes:

1. **File Structure Validation**
   - Required files present
   - Proper WordPress theme structure
   - Correct file permissions

2. **Code Quality Checks**
   - PHP syntax validation
   - CSS syntax validation
   - JavaScript syntax validation
   - Security checks

3. **Functionality Tests**
   - Required functions defined
   - Template files valid
   - Asset loading correct

4. **Performance Tests**
   - Page load times
   - Asset optimization
   - Mobile responsiveness

5. **Accessibility Tests**
   - ARIA labels present
   - Alt attributes on images
   - Semantic HTML usage

### Running Tests

```bash
# Run all tests
./scripts/test-theme.sh

# Check specific test results
cat test-results/test-report.md

# Run performance monitoring
./scripts/monitor-performance.sh
```

## 📊 Monitoring and Maintenance

### Performance Monitoring

```bash
# Monitor staging performance
./scripts/monitor-performance.sh

# Check specific metrics
curl -w "@-" -o /dev/null -s https://staging6.buffalocannabisnetwork.com << 'EOF'
{
    "time_total": %{time_total},
    "http_code": %{http_code},
    "size_download": %{size_download}
}
EOF
```

### Health Checks

```bash
# Check staging health
curl -I https://staging6.buffalocannabisnetwork.com

# Check member directory
curl -I https://staging6.buffalocannabisnetwork.com/members/

# Check enhanced assets
curl -I https://staging6.buffalocannabisnetwork.com/wp-content/themes/bcn-wp-theme/assets/css/member-cards-enhanced.css
```

## 🔄 Rollback Process

### Automated Rollback

```bash
# Rollback staging
./scripts/rollback-deployment.sh staging

# Rollback production
./scripts/rollback-deployment.sh production

# Rollback to specific commit
./scripts/rollback-deployment.sh commit abc123 staging

# List available backups
./scripts/rollback-deployment.sh list

# Verify rollback
./scripts/rollback-deployment.sh verify staging
```

### Manual Rollback

```bash
# Checkout previous commit
git log --oneline -10
git checkout <previous-commit-hash>

# Deploy previous version
./scripts/deploy-local.sh staging

# Verify rollback
curl -I https://staging6.buffalocannabisnetwork.com
```

## 🚨 Troubleshooting

### Common Issues

#### 1. Deployment Fails
```bash
# Check SSH connection
ssh -p 22 deploy@staging6.buffalocannabisnetwork.com

# Check file permissions
ls -la scripts/

# Check environment variables
cat .env
```

#### 2. Tests Fail
```bash
# Check test logs
cat test-results/*.log

# Run individual tests
php -l functions.php
php -l includes/member-experience.php
```

#### 3. Performance Issues
```bash
# Check page load times
curl -w "@-" -o /dev/null -s https://staging6.buffalocannabisnetwork.com

# Check asset loading
curl -I https://staging6.buffalocannabisnetwork.com/wp-content/themes/bcn-wp-theme/style.css
```

#### 4. Member Directory Issues
```bash
# Check member directory
curl -I https://staging6.buffalocannabisnetwork.com/members/

# Check for enhanced features
curl -s https://staging6.buffalocannabisnetwork.com/members/ | grep -i "member-card-enhanced"
```

### Debug Mode

```bash
# Enable debug mode for deployment
DEBUG=true ./scripts/deploy-with-tests.sh staging

# Enable verbose output
VERBOSE=true ./scripts/test-theme.sh
```

## 📈 Performance Optimization

### Asset Optimization

```bash
# Minify CSS
find assets/css -name "*.css" -exec minify {} \;

# Minify JavaScript
find assets/js -name "*.js" -exec minify {} \;

# Optimize images
find assets/images -name "*.png" -exec optipng -o7 {} \;
find assets/images -name "*.jpg" -exec jpegoptim --max=85 {} \;
```

### Caching

```bash
# Enable WordPress caching
# Add to wp-config.php:
# define('WP_CACHE', true);

# Clear cache after deployment
curl -X POST https://staging6.buffalocannabisnetwork.com/wp-admin/admin-ajax.php \
  -d "action=clear_cache"
```

## 🔐 Security Considerations

### SSH Security

```bash
# Use SSH key authentication only
# Disable password authentication on servers

# Rotate SSH keys regularly
ssh-keygen -t rsa -b 4096 -C "new-deploy-key"
```

### File Permissions

```bash
# Set correct permissions
find . -type f -name "*.php" -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
find . -name "*.sh" -exec chmod +x {} \;
```

## 📚 Additional Resources

### Documentation
- [DEPLOYMENT_PLAN.md](DEPLOYMENT_PLAN.md) - Detailed deployment plan
- [README.md](README.md) - Theme documentation
- [CHANGELOG.md](CHANGELOG.md) - Version history

### Scripts
- `scripts/deploy-with-tests.sh` - Main deployment script
- `scripts/test-theme.sh` - Theme testing
- `scripts/monitor-performance.sh` - Performance monitoring
- `scripts/rollback-deployment.sh` - Rollback functionality

### GitHub Actions
- `.github/workflows/deploy-with-tests.yml` - CI/CD pipeline
- `.github/workflows/phpcs.yml` - Code quality checks

## 🆘 Support

### Getting Help

1. **Check Logs**: Review test results and deployment logs
2. **Run Diagnostics**: Use monitoring scripts to identify issues
3. **Check Documentation**: Review this guide and related docs
4. **GitHub Issues**: Create an issue in the repository

### Contact Information

- **Developer**: John Dough
- **Email**: casestudylabs@gmail.com
- **GitHub**: @therealjohndough
- **Repository**: https://github.com/therealjohndough/bcn-wp-theme

---

*This auto-deploy and test process ensures reliable, professional deployment of the BCN WordPress theme with enhanced member features.*