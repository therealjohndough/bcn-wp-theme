# Buffalo Cannabis Network - Setup Guide

## 🎉 Development Complete!

All theme files, templates, patterns, and functionality have been implemented. The following manual steps need to be completed in WordPress admin to go live.

---

## ✅ COMPLETED

### Theme Development
- ✅ Modern professional styling with micro animations
- ✅ Enhanced membership page with FAQ (schema markup included)
- ✅ Page templates (Contact, Events Archive, Single Event)
- ✅ Event gallery pattern with lightbox effects
- ✅ Contact form pattern
- ✅ Custom admin dashboard (BCN Dashboard)
- ✅ Event meta boxes (date, time, location, registration link)
- ✅ Full SEO optimization (meta tags, Open Graph, Twitter Cards)
- ✅ Schema markup (Organization, FAQ, Event, LocalBusiness)
- ✅ XML sitemap (accessible at `/?bcn_sitemap=1`)
- ✅ Performance optimizations (lazy loading, WebP, DNS prefetch)
- ✅ Deployment scripts

---

## 📋 REMAINING MANUAL STEPS

### Step 1: Create WordPress Pages

Log into WordPress admin and create the following pages:

#### **Contact Page**
1. Go to: Pages → Add New
2. Title: "Contact"
3. Template: Select "Contact Page" from the Template dropdown
4. Add the `bcn/contact-form` pattern
5. Publish

#### **Membership Page** (if not exists)
1. Go to: Pages → Add New  
2. Title: "Membership"
3. Add `bcn/membership-tiers` pattern
4. Add `bcn/faq-schema` pattern below it
5. Publish

#### **Events Page** (if not exists)
1. Go to: Pages → Add New
2. Title: "Events"  
3. Will automatically use Events Archive template
4. Publish

### Step 2: Configure Navigation Menus

#### **Primary Navigation Menu**
1. Go to: Appearance → Menus (or Navigation in new editor)
2. Create menu named "Primary Menu"
3. Add pages in this order:
   - Home
   - About
   - Events
   - Membership
   - News/Blog
   - Contact
4. Assign to "Primary Menu" location
5. Save

#### **Footer Menus**
The footer has 4 columns. You can either:
- **Option A**: Leave footer as-is (it has static links)
- **Option B**: Create footer menus:
  1. Quick Links menu
  2. Resources menu
  3. Connect menu
  4. Assign each to footer positions

### Step 3: Create Event Posts

Create 3-5 event posts to showcase BCN events:

#### **Example: BCN Brand Showcase June 2025**
1. Go to: BCN Dashboard → Add New Event (or Events → Add New)
2. Title: "BCN Brand Showcase - June 2025"
3. Content: Write event description
4. **Event Details Meta Box:**
   - Event Date: 2025-06-15
   - Event Time: 18:00
   - Location: 505 Ellicott St, Buffalo, NY 14203
   - Registration Link: (if applicable)
5. **Featured Image**: Upload event poster/banner
6. **Event Gallery**: 
   - Add content → Add `bcn/event-gallery` pattern
   - Insert gallery block
   - Select event photos from Media Library
   - Upload WebP images from `/wp-content/uploads/2025/09/`
7. Publish

#### Repeat for other events:
- Buffalo Cannabis Network Brand Showcase 2025
- Dispensary Showcase Event
- Add 2-3 more upcoming events

### Step 4: Verify SEO Settings

1. **Check Meta Tags** (view page source):
   - Description tags present
   - Open Graph tags
   - Schema markup in `<script type="application/ld+json">`

2. **Test Rich Results**:
   - Visit: https://search.google.com/test/rich-results
   - Enter: https://buffalocannabisnetwork.com/membership
   - Verify FAQ schema is detected
   - Test event pages for Event schema

3. **Submit Sitemap**:
   - Go to Google Search Console
   - Add property: buffalocannabisnetwork.com
   - Submit sitemap: `https://buffalocannabisnetwork.com/?bcn_sitemap=1`

### Step 5: Pre-Launch Checklist

Test the following before going live:

#### **Functionality**
- [ ] All navigation links work
- [ ] Membership pricing displays correctly ($49, $250, $695)
- [ ] FAQ accordion expands/collapses smoothly
- [ ] Contact form submits (test with real email)
- [ ] Event galleries load and zoom works
- [ ] Social sharing buttons work

#### **Design & UX**
- [ ] Animations work smoothly (buttons, cards, hover effects)
- [ ] Text is readable (good contrast)
- [ ] No overlapping text or broken layouts
- [ ] Footer displays correctly with all 4 columns

#### **Mobile Testing**
- [ ] Test on iPhone/Android phone
- [ ] Test on iPad/tablet
- [ ] Navigation menu works on mobile
- [ ] Images load properly
- [ ] Touch targets are large enough
- [ ] No horizontal scrolling

#### **Cross-Browser Testing**
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

#### **Performance**
- [ ] Page load time < 3 seconds
- [ ] Test at: https://pagespeed.web.dev/
- [ ] Images use WebP format
- [ ] No console errors (F12 → Console)

### Step 6: Production Deployment

When everything is tested and ready:

```bash
# Option 1: Use deployment script
cd /Users/dough/public_html/wp-content/themes/buffalo-cannabis-network
./scripts/deploy-production.sh

# Option 2: Manual deployment
cd /Users/dough/public_html
git add .
git commit -m "Production launch - Buffalo Cannabis Network"
git push production master
```

### Step 7: Post-Launch Tasks

Immediately after going live:

1. **Clear All Caches**:
   - WordPress admin → SG Optimizer → Purge Cache
   - Browser cache (Cmd+Shift+R)
   - CloudFlare cache (if using)

2. **Monitor for 24 Hours**:
   - Check error logs
   - Monitor Google Analytics
   - Test all forms
   - Verify email notifications work

3. **Submit to Search Engines**:
   - Google Search Console
   - Bing Webmaster Tools

4. **Social Media**:
   - Share launch announcement
   - Test social sharing previews

---

## 🎨 Admin Features

### BCN Custom Dashboard

Access at: **WordPress Admin → BCN Dashboard**

Features:
- Quick stats (events, posts, pages)
- Upcoming events widget
- Recent posts overview
- Quick actions (add event, upload media, etc.)

### Event Management

When editing events, you'll see:
- **Event Details** meta box with:
  - Date picker
  - Time selector  
  - Location field
  - Registration link
- Admin columns show date and location
- Events are sortable by date

### Available Block Patterns

Insert these patterns when editing pages:

- **bcn/membership-tiers** - Three-tier pricing cards
- **bcn/faq-schema** - FAQ accordion with SEO schema
- **bcn/event-gallery** - Photo gallery for events
- **bcn/contact-form** - Contact form layout
- **bcn/values-grid** - Company values cards
- Plus all other existing patterns

---

## 🔧 Customization

### Changing Membership Prices

Edit file: `patterns/membership-tiers.php`
- Line 35: Student price (currently $49)
- Line 86: Professional price (currently $250)
- Line 137: Premier price (currently $695)

### Modifying Colors

Edit file: `theme.json`
- Line 14: Primary color (#7CB342 - green)
- Line 19: Secondary color (#4A90E2 - blue)
- Line 24: Accent color (#9C27B0 - purple)

### Adding Custom CSS

Add to: `style.css` at the end of the file

---

## 📞 Support

### Agency Support
Contact your development agency for:
- Code customizations
- Bug fixes
- Feature additions
- Technical issues

### Hosting Support
SiteGround: https://my.siteground.com
- Server issues
- Cache problems
- Email setup
- SSL certificates

### WordPress Help
- WordPress Codex: https://codex.wordpress.org/
- Block Editor Guide: https://wordpress.org/support/article/wordpress-editor/

---

## 🚀 Regional SEO Keywords

The site is optimized for:
- Buffalo cannabis network
- Western New York cannabis
- NY cannabis networking
- Buffalo cannabis events
- Cannabis industry Buffalo
- New York cannabis community

**Tip**: Write blog posts using these keywords to improve SEO rankings!

---

## 📊 Analytics

### Google Analytics Setup
1. Get tracking ID from Google Analytics
2. Add to header via plugin or theme
3. Verify tracking works

### Monitor These Metrics
- Page views
- Bounce rate
- Time on site
- Conversion rate (membership signups)
- Top pages
- Traffic sources

---

## ✨ Next Steps for Growth

### Content Strategy
1. **Blog Posts** - Write 2-4 posts/month about:
   - Buffalo cannabis industry news
   - Event recaps
   - Member spotlights
   - Educational content

2. **Event Photos** - After each event:
   - Upload photos to Media Library
   - Create event post
   - Add photos using event gallery pattern

3. **Member Testimonials** - Add to About page

### Marketing
1. Email newsletter (integrate with MailChimp/Constant Contact)
2. Social media integration
3. Member directory (coming soon)
4. Online payments for membership

---

**Theme Version**: 1.0.0  
**Last Updated**: November 6, 2025  
**Built for**: Buffalo Cannabis Network  
**Powered by**: Your Agency Name

---

Need help? Email: info@buffalocannabisnetwork.com | Call: 716-507-3501

