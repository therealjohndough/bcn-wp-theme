# 🏠 Homepage Setup Instructions

## Why You Can't Edit the Homepage

**Block themes don't use the Customizer!** They use the **Site Editor** instead.

Your homepage needs to be set up one of two ways:

---

## ✅ **OPTION 1: Use Site Editor** (Recommended - Easier)

### Step 1: Set Homepage to Use Template

1. **Go to**: WordPress Admin → **Settings** → **Reading**

2. **Find**: "Your homepage displays"

3. **Select**: "A static page"

4. **Homepage dropdown**: Select "Home" or create a new page called "Home"
   - If no Home page exists, go to **Pages** → **Add New**
   - Title: "Home"
   - **Template**: Select "Front Page" (right sidebar)
   - Click **Publish**

5. **Posts page**: Select your blog page (or leave blank)

6. Click **Save Changes**

### Step 2: Edit Your Homepage

**Two ways to edit:**

#### **Method A: Edit via Site Editor**
1. **Appearance** → **Editor**
2. Click on the page preview (or **Templates** → **Front Page**)
3. ✏️ Click and edit any text, buttons, sections
4. **Save**

#### **Method B: Edit the Page Directly**
1. **Pages** → **All Pages**
2. Find "Home" page
3. Click **Edit**
4. Edit content blocks
5. **Publish**

---

## ✅ **OPTION 2: Simple Homepage (Fastest)**

If the above is confusing, just do this:

### Create a Simple Editable Homepage

1. **Pages** → **Add New**
2. Title: **Home**
3. In the editor, add these blocks in order:

**Add each section:**

1. **Click "+" → Search "Cover"**
   - Add hero image/color
   - Type your heading: "Building Buffalo's Cannabis Future, Together"
   - Add tagline: "Connect. Support. Elevate."
   - Add buttons

2. **Click "+" → Search "Group"**
   - Add mission text

3. **Click "+" → Search "Shortcode"**
   - Type: `[bcn_members]`
   - This shows your members automatically!

4. **Click "+" → Search "Pattern"**
   - Select "Membership Tiers"

5. **Click "+" → Search "Pattern"**
   - Select "FAQ with Schema"

6. Add final CTA section

7. **Template** (right sidebar): Select "Front Page"

8. **Publish**

9. **Go to**: **Settings** → **Reading**
   - Your homepage displays: **A static page**
   - Homepage: **Select "Home"**
   - Save

✅ **Done!** Now your homepage is fully editable!

---

## 📝 **Where is the Customizer?**

Block themes (modern WordPress) don't use the Customizer anymore. Instead:

| Old Way (Classic Themes) | New Way (Block Themes) |
|--------------------------|------------------------|
| Appearance → Customize | Appearance → Editor |
| Customizer panels | Site Editor |
| Limited editing | Full control |
| PHP templates | HTML templates |

**You have MORE control now, not less!**

---

## 🎨 **What You Can Edit in Site Editor**

### **Appearance → Editor** gives you:

1. **Templates** - Edit page layouts
   - Front Page
   - Single Post
   - Archive
   - Events
   - Members
   - Contact

2. **Template Parts** - Edit reusable sections
   - Header
   - Footer

3. **Patterns** - Reusable designs
   - Membership tiers
   - FAQ
   - Contact form
   - Event gallery
   - Members showcase

4. **Styles** - Colors, fonts, spacing
   - Change colors site-wide
   - Adjust fonts
   - Modify spacing

---

## 🚀 **Quick Fix (Do This Now)**

1. **Create Home Page**:
   ```
   Pages → Add New
   Title: Home
   Template: Front Page (right sidebar)
   Publish
   ```

2. **Set as Homepage**:
   ```
   Settings → Reading
   Your homepage displays: A static page
   Homepage: Home
   Save Changes
   ```

3. **Edit It**:
   ```
   Pages → Home → Edit
   Click any text to change it
   Save
   ```

✅ **Done!**

---

## 💡 **Pro Tip: Copy from Template**

If you want to start with our design:

1. **Appearance** → **Editor** → **Templates** → **Front Page**
2. Click **⋮** (three dots) top right → **Copy all blocks**
3. **Pages** → **Home** → **Edit**
4. Click **⋮** (three dots) → **Paste**
5. **Publish**

Now you have our design, but it's editable!

---

## 📞 **Still Confused?**

The homepage content is in:
- **File**: `wp-content/themes/buffalo-cannabis-network/templates/frontpage.html`
- **Edit via**: Appearance → Editor → Templates → Front Page

OR create a Page called "Home" and set it as static homepage (Settings → Reading)

---

## 🎯 **Members Section**

The members section works like this:

1. **Add members**: BCN Members → Add New
2. **They auto-appear**: Homepage updates automatically
3. **Edit heading**: Click "We Are Stronger, Together" in editor
4. **Members grid**: Updates from database (no manual editing needed!)

This is BETTER than manual because:
- ✅ Add a member once, appears everywhere
- ✅ Update a logo, changes everywhere
- ✅ Remove a member, disappears from all pages
- ✅ No duplicate work!

---

**Need help?** Let me know what you see when you go to Appearance → Editor

