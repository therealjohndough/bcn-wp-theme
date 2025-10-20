# ACF Pro Setup Guide for BCN Theme

## Prerequisites
1. **Install ACF Pro** - Purchase and install Advanced Custom Fields Pro plugin
2. **Activate the theme** - The BCN theme should be active

## Automatic Setup (Recommended)

The theme will automatically import ACF field groups when activated. If you need to manually import:

## Manual Import Steps

### 1. Access ACF Tools
1. Go to **Custom Fields > Tools** in your WordPress admin
2. Click on the **Import** tab

### 2. Import Field Groups
1. Copy the contents of `acf-json/bcn_member_fields.json`
2. Paste into the "Import Field Groups" textarea
3. Click **Import**

### 3. Verify Import
1. Go to **Custom Fields > Field Groups**
2. You should see these field groups:
   - **Member Details** - Basic contact information
   - **Social Media & Links** - Social profiles
   - **Member Status & Features** - Status and permissions
   - **Business Information** - Business-specific data

### 4. Check Member Settings
1. Go to **BCN Settings > Member Settings**
2. Configure default settings:
   - Marquee Speed: Medium
   - Members Per Page: 12
   - Show Featured First: Yes
   - Enable Member Registration: Yes
   - Require Admin Approval: Yes

## Field Groups Overview

### Member Details
- Company Name (required)
- Contact Person (required)
- Email Address (required)
- Phone Number
- Website URL
- Business Address

### Social Media & Links
- Instagram
- Facebook
- Twitter
- LinkedIn
- YouTube
- TikTok

### Member Status & Features
- Featured Member (checkbox)
- Can Submit Content (checkbox)
- Member Status (dropdown: Active, Pending, Suspended, Inactive)
- Registration Date
- Last Activity

### Business Information
- Business Type (dropdown)
- License Number
- Services Offered
- Areas Served

## Default Membership Levels

The theme automatically creates these membership levels:
- **Premier Member** - Highest tier
- **Pro Member** - Professional tier
- **Basic Member** - Entry level

## Testing the Setup

1. **Create a test member:**
   - Go to **Members > Add New**
   - Fill in the ACF fields
   - Set featured status
   - Assign membership level

2. **Test the member archive:**
   - Visit `/members/` on your site
   - Verify the member appears
   - Test filtering and search

3. **Test member registration:**
   - Use the `[member_registration_form]` shortcode
   - Submit a test registration
   - Check admin for pending approval

## Troubleshooting

### Field Groups Not Appearing
- Ensure ACF Pro is active
- Check file permissions on `acf-json/` directory
- Try manual import from ACF Tools

### Member Archive 404
- Go to **Settings > Permalinks**
- Click **Save Changes** to flush rewrite rules

### Registration Form Not Working
- Check that the form action URL is correct
- Verify nonce security is working
- Check for JavaScript errors in browser console

## Support

If you encounter issues:
1. Check the WordPress error logs
2. Verify ACF Pro is properly licensed
3. Ensure all theme files are uploaded correctly
4. Test with a default WordPress theme to isolate issues