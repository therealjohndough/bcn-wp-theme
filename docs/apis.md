# Shortcodes and Front-End APIs

## Shortcodes

### [member_logo_grid]
- **Purpose**: Display a responsive grid of member logos with optional filtering.
- **Signature**: `[member_logo_grid level="" limit="12" columns="4" featured="false"]`
- **Attributes**:
  - `level` (string, optional): membership level slug (e.g., `premier-member`).
  - `limit` (int, optional): max items; `-1` for all. Default `12`.
  - `columns` (int, optional): 2–6. Default `4`.
  - `featured` (bool, optional): `true` to show only featured members.
- **Returns**: HTML string (logo grid).
- **Example**:
```shortcode
[member_logo_grid level="premier-member" limit="-1" columns="5" featured="true"]
```

### [member_submission_form]
- **Purpose**: Secure member content submission (story or photo) using a private key.
- **Signature**: `[member_submission_form key="" redirect=""]`
- **Attributes**:
  - `key` (string, optional): fallback submission key; typically use `?submission_key=...` in URL.
  - `redirect` (string, optional): URL to redirect after successful submission.
- **Behavior**:
  - Validates nonce and inputs; creates a pending `post` with metadata linking back to the `bcn_member`.
  - `type` radio field supports `blog` (rich text) or `photo` (image upload + caption).
  - Sends admin notification via email.
- **Example**:
```shortcode
[member_submission_form redirect="/thank-you/"]
```
- **Sharable link**:
  - Construct a URL like `/member-submissions/?submission_key=PRIVATE_KEY`

## WordPress REST API

The theme enables REST support for custom post types and taxonomies. Use standard WordPress auth (cookies + nonce in wp-admin, Application Passwords, OAuth/JWT plugins) for write operations.

- Base: `/wp-json/wp/v2`

### Members (CPT: `bcn_member`)
- **List** (GET): `/wp-json/wp/v2/bcn_member?per_page=10&page=1`
- **Get** (GET): `/wp-json/wp/v2/bcn_member/{id}`
- **Create** (POST, auth required): `/wp-json/wp/v2/bcn_member`
  - Body (JSON minimal):
```json
{
  "title": "Acme Labs",
  "status": "publish",
  "content": "Member bio...",
  "meta": {
    "bcn_member_website": "https://acme.example",
    "bcn_member_email": "hello@acme.example",
    "bcn_member_phone": "(555) 555-5555",
    "bcn_member_address": "123 Main St"
  }
}
```
- Note: Private meta is not exposed (e.g., `bcn_member_submission_key`).

### Events (CPT: `bcn_event`)
- **List** (GET): `/wp-json/wp/v2/bcn_event?per_page=10&page=1`
- **Get** (GET): `/wp-json/wp/v2/bcn_event/{id}`
- **Create** (POST, auth required): `/wp-json/wp/v2/bcn_event`

### Taxonomies
- **Event Categories**: `/wp-json/wp/v2/event_category`
- **Membership Levels**: `/wp-json/wp/v2/bcn_membership_level`

Notes:
- Core WP REST does not provide taxonomy filtering on CPT endpoints by default. To filter by taxonomy via REST, add custom endpoints or use a REST filter plugin. Server-side templates can filter archives via query args; see `docs/content-types.md`.

## Front-End JavaScript

### assets/js/navigation.js
- **APIs**:
  - Initializes a mobile menu button `.menu-toggle` and toggles submenu visibility.
  - Adds smooth scrolling for anchor links.
- **Usage**: Automatically enqueued by theme. Requires HTML structure with `.main-navigation`.

### assets/js/main.js
- **Behavior**:
  - Adds `scrolled` class on body past 100px scroll.
  - Improves skip link focus handling.
  - Adds `focus` class on keyboard navigation in menus.
  - Forces external links to open in new tab with `rel="noopener noreferrer"`.
- **Usage**: Loaded on front-end; no global API exposed.

### assets/js/customizer.js
- **Behavior**:
  - Live-updates `.site-title a`, `.site-description`, and header text color.
- **Usage**: Enqueued in Customizer preview only.

## AJAX and Nonces
- The theme exposes `bcnTheme = { ajaxUrl, nonce }` as an inline global before `bcn-main`. This is a placeholder for future AJAX endpoints. No public AJAX handlers are defined in the theme.
