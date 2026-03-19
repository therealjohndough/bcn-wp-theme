# 🎛️ ACF Pro Setup Guide

## ✅ You Made the Right Choice!

**PHP + ACF = Much Easier for Clients**

Block themes are great for some sites, but for a **custom admin experience**, ACF Pro is the way to go.

---

## 📦 **Plugins to Install**

Upload these 3 plugins (you said you have them):

1. **Advanced Custom Fields PRO** - Custom fields
2. **ACF Extended** - Enhanced ACF features  
3. **Frontend Admin** (optional) - Edit from frontend

---

## 🚀 **After Installing ACF Pro**

### Step 1: Import Field Groups (Auto-Imported!)

The theme is already configured to auto-load ACF fields from `/acf-json/` folder.

**What you'll see in WordPress Admin:**
- ✅ BCN Settings (options page for site-wide settings)
- ✅ Homepage Content fields (when editing homepage)
- ✅ Contact Information fields (in BCN Settings)

### Step 2: Edit Homepage

1. **Go to**: Pages → Find "Home" → Edit
2. **You'll see ACF fields**:
   - Hero Title
   - Hero Tagline  
   - Hero Description
   - Mission Heading
   - Mission Text
   - Members Heading
   - Members Subheading
   - CTA Heading
   - CTA Text

3. **Fill them in** or leave defaults
4. **Publish**

### Step 3: Set Contact Info

1. **Go to**: BCN Settings → Contact Info
2. **Fill in**:
   - Phone: 716-507-3501
   - Email: info@buffalocannabisnetwork.com
   - Address: 505 Ellicott St
   - City: Buffalo
   - State: NY
   - ZIP: 14203

3. **Save**

---

## 📝 **How It Works Now**

### Homepage (`front-page.php`)
- ✅ PHP template (easy to customize)
- ✅ Uses ACF fields for all text
- ✅ Falls back to defaults if no ACF
- ✅ Client can edit via simple forms
- ✅ Members auto-populate from database

### Pages
- ✅ Regular WordPress pages
- ✅ ACF fields where needed
- ✅ No block editor complexity

### Members
- ✅ Simple admin interface
- ✅ Upload logo, add details
- ✅ Auto-appears on homepage

### Events  
- ✅ Date/time/location fields
- ✅ Gallery upload
- ✅ Simple and clean

---

## 🎨 **Frontend Admin (Optional)**

If you install Frontend Admin, clients can edit from the actual website!

### Setup:
1. Install Frontend Admin plugin
2. Create frontend forms for:
   - Homepage editing
   - Member management
   - Event management
3. Hide WordPress admin from clients

**Result**: Client edits directly on the site, no WordPress backend confusion!

---

## 🔧 **Customization**

### Adding More Homepage Fields

1. **Custom Fields** → **Field Groups** → **Homepage Content**
2. Click **Add Field**
3. Configure field (text, image, wysiwyg, etc.)
4. **Update**
5. Use in `front-page.php`:
   ```php
   <?php echo get_field('your_field_name'); ?>
   ```

### Adding Options Page Fields

1. **Custom Fields** → **Field Groups** → **Contact Information**
2. Add fields
3. Use anywhere:
   ```php
   <?php echo get_field('field_name', 'option'); ?>
   ```

---

## 📋 **What Files Changed**

### New PHP Files:
- `front-page.php` - Homepage template (uses ACF)
- `template-parts/membership-tiers.php` - Pricing cards
- `template-parts/values-grid.php` - Values section
- `template-parts/faq-list.php` - FAQ list

### ACF JSON:
- `acf-json/homepage-fields.json` - Homepage ACF fields
- `acf-json/contact-fields.json` - Contact info ACF fields

### Enhanced:
- `functions.php` - ACF options pages, JSON save/load

---

## ⚡ **Why This is Better**

### Before (Block Theme):
- ❌ Confusing site editor
- ❌ Can't edit patterns
- ❌ No customizer
- ❌ Client gets lost

### Now (PHP + ACF):
- ✅ Simple text fields
- ✅ Clear labels ("Hero Title", "Phone Number")
- ✅ Familiar WordPress interface
- ✅ Client can't break design
- ✅ Easy to train client
- ✅ Frontend editing (with Frontend Admin)

---

## 🎯 **Client Training (5 minutes)**

Show client:

1. **Edit Homepage**:
   - Pages → Home → Edit
   - Scroll down to "Homepage Content" box
   - Change any text field
   - Click Update

2. **Add Member**:
   - BCN Members → Add New
   - Fill in company name
   - Upload logo
   - Click Publish

3. **Add Event**:
   - BCN Dashboard → Add New Event
   - Fill in date, time, location
   - Upload photos
   - Click Publish

**That's it!** Client is trained.

---

## 🚀 **Next Steps**

1. **Upload ACF Pro** ✅ (you're doing this)
2. **Upload ACF Extended** ✅ (you're doing this)
3. **Upload Frontend Admin** ✅ (optional)
4. **Activate plugins**
5. **Go to**: Settings → Reading
   - Your homepage displays: **A static page**
   - Homepage: Create "Home" page if needed
   - **Save**
6. **Edit homepage**: Pages → Home → Edit
7. **See ACF fields appear!**
8. **Test it** - change a field, view homepage

---

## 💡 **Pro Tips**

### Homepage Not Showing?
```
Settings → Reading
Your homepage displays: A static page
Homepage: Select "Home"
Save Changes
```

### Fields Not Showing?
- Make sure ACF Pro is activated
- Check that `acf-json` folder exists
- Go to Custom Fields → Sync (click Sync if you see it)

### Want Different Layout?
- Edit `front-page.php` directly
- It's just PHP and HTML!
- Much easier than block templates

---

## 📞 **This is What You Wanted**

> "the backend should feel like custom php ui for the client"

✅ **You got it!**

- Simple forms (ACF)
- No confusing blocks
- Clear labels
- Easy to train
- Professional backend
- Can't break design

---

**After ACF is installed**, the homepage will be **100% editable** via simple text fields!

Much better than block editor confusion! 🎯

