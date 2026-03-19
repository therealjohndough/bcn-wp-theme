# Buffalo Cannabis Network - Deployment Guide

## Production Deployment Instructions

### Prerequisites

1. **Git Configuration**
   ```bash
   # Add production remote (replace with actual server details)
   cd /Users/dough/public_html
   git remote add production ssh://bcn@buffalocannabisnetwork.com/home/customer/www/buffalocannabisnetwork.com/public_html/
   ```

2. **SSH Access**
   - Ensure you have SSH access to the production server
   - Test connection: `ssh bcn@buffalocannabisnetwork.com`

### Quick Deployment

```bash
# Run the deployment script
cd /Users/dough/public_html/wp-content/themes/buffalo-cannabis-network
./scripts/deploy-production.sh
```

### Manual Deployment Steps

If you prefer manual deployment:

1. **Create Backup**
   ```bash
   # Backup theme files
   tar -czf bcn-backup-$(date +%Y%m%d).tar.gz wp-content/themes/buffalo-cannabis-network/
   ```

2. **Commit Changes**
   ```bash
   git add .
   git commit -m "Production deployment - $(date +%Y-%m-%d)"
   ```

3. **Push to Production**
   ```bash
   git push production master
   ```

4. **Clear Caches**
   - Log into WordPress admin
   - Navigate to SiteGround Optimizer → Caching
   - Click "Purge Cache"
   - Or via SSH:
     ```bash
     rm -rf wp-content/cache/sgo-cache/*
     ```

### Post-Deployment Checklist

After deployment, verify:

- [ ] Homepage loads correctly
- [ ] All navigation links work
- [ ] About page displays properly
- [ ] Membership page shows correct pricing ($49, $250, $695)
- [ ] FAQ accordion works
- [ ] Contact form functional
- [ ] Events archive displays
- [ ] Mobile responsiveness (test on phone/tablet)
- [ ] Schema markup (test at: https://search.google.com/test/rich-results)
- [ ] Sitemap accessible: `https://buffalocannabisnetwork.com/?bcn_sitemap=1`

### SEO Setup

1. **Google Search Console**
   - Submit sitemap: `https://buffalocannabisnetwork.com/?bcn_sitemap=1`
   - Verify ownership
   - Monitor indexing status

2. **Google Analytics**
   - Add tracking code to header (if not already done)
   - Verify tracking is working

3. **Meta Tags Verification**
   - View page source and check for:
     - Title tags
     - Meta descriptions
     - Open Graph tags
     - Schema markup

### Performance Optimization

The theme includes:
- ✅ Lazy loading for images
- ✅ WebP support
- ✅ Minified assets
- ✅ DNS prefetching
- ✅ Database optimization

**Additional Optimizations (via SiteGround):**
- Enable SG Optimizer caching
- Enable compression
- Enable browser caching
- Enable lazy loading (if not already)

### Troubleshooting

**Issue: White screen after deployment**
- Enable WP_DEBUG in wp-config.php
- Check error logs: `/wp-content/debug.log`
- Clear all caches

**Issue: Styles not loading**
- Hard refresh browser: Cmd+Shift+R (Mac) or Ctrl+Shift+R (Windows)
- Clear SiteGround cache
- Check file permissions

**Issue: Images not displaying**
- Check uploads directory permissions (should be 755)
- Verify WebP images are uploading correctly
- Check SiteGround image optimization settings

### Rollback Procedure

If you need to rollback:

```bash
# List backups
ls -lh ~/bcn-backups/

# Restore from backup
cd /Users/dough/public_html/wp-content/themes/
tar -xzf ~/bcn-backups/bcn_backup_YYYYMMDD_HHMMSS.tar.gz
```

### Support Contacts

- **Development Support**: Your agency contact
- **Hosting Support**: SiteGround (https://my.siteground.com)
- **BCN Admin**: info@buffalocannabisnetwork.com | 716-507-3501

### Important URLs

- **Live Site**: https://buffalocannabisnetwork.com
- **Staging**: https://staging6.buffalocannabisnetwork.com
- **WordPress Admin**: https://buffalocannabisnetwork.com/wp-admin
- **Sitemap**: https://buffalocannabisnetwork.com/?bcn_sitemap=1
- **BCN Dashboard**: Admin → BCN Dashboard

## Files Modified/Created

### New Templates
- `templates/page-contact.html` - Contact page template
- `templates/archive-bcn_event.html` - Events archive
- `templates/single-bcn_event.html` - Single event view

### New Patterns
- `patterns/faq-schema.php` - FAQ with schema markup
- `patterns/event-gallery.php` - Event photo gallery
- `patterns/contact-form.php` - Contact form

### New Admin Files
- `includes/admin-dashboard.php` - Custom BCN dashboard
- `includes/event-meta-boxes.php` - Event management UI

### Enhanced Files
- `functions.php` - Added SEO, schema, performance optimizations
- `style.css` - Added modern animations and styling

### Scripts
- `scripts/deploy-production.sh` - Production deployment script

## Features Implemented

### SEO & Schema
- ✅ Organization schema
- ✅ FAQ schema
- ✅ Event schema
- ✅ LocalBusiness schema
- ✅ Meta tags (Open Graph, Twitter Cards)
- ✅ XML sitemap
- ✅ Canonical URLs
- ✅ Geographic metadata

### Performance
- ✅ Lazy loading
- ✅ WebP support
- ✅ DNS prefetching
- ✅ Optimized assets
- ✅ Database optimization
- ✅ Heartbeat API optimization

### User Experience
- ✅ Modern micro animations
- ✅ Improved readability
- ✅ Mobile-responsive design
- ✅ Accessible (WCAG AA compliant)
- ✅ Fast page loads

### Admin Experience
- ✅ Custom BCN dashboard
- ✅ Event meta boxes
- ✅ Simplified UI for client
- ✅ Quick actions
- ✅ Analytics widgets

---

**Last Updated**: $(date +"%B %d, %Y")  
**Version**: 1.0.0  
**Powered by**: Buffalo Cannabis Network

