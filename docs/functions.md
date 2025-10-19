# PHP Functions and Hooks

All functions are prefixed with `bcn_` to avoid collisions. Hook registrations are included for quick reference.

## Theme Setup

### bcn_theme_setup()
- **Purpose**: Registers theme supports, image sizes, and navigation menus.
- **Hooked**: `after_setup_theme`
- **Side effects**: Enables `title-tag`, `post-thumbnails`, HTML5 features, editor styles; registers menus: `primary`, `footer`, `community`; registers image sizes `bcn-featured`, `bcn-thumbnail`.
- **Usage**: Runs automatically via hook. Do not call directly.

### bcn_content_width()
- **Purpose**: Sets global content width.
- **Hooked**: `after_setup_theme` (priority 0)
- **Returns**: void
- **Filters**: `bcn_content_width` (int)
- **Example**:
```php
add_filter('bcn_content_width', fn($w) => 1400);
```

### bcn_widgets_init()
- **Purpose**: Registers widget areas (`sidebar-1`, `footer-1`, `community-1`).
- **Hooked**: `widgets_init`
- **Usage**: Automatic.

### bcn_scripts()
- **Purpose**: Enqueues styles and scripts; injects `bcnTheme` globals.
- **Hooked**: `wp_enqueue_scripts`
- **Enqueues**: `bcn-style`, `bcn-navigation`, `bcn-main`, `comment-reply` (conditional), `bcn-patterns`.
- **Globals**: `bcnTheme = { ajaxUrl, nonce }`.

### bcn_body_classes( array $classes ) : array
- **Purpose**: Adds `has-sidebar` and `singular` classes.
- **Hooked**: `body_class`
- **Returns**: array

### bcn_excerpt_length( int $length ) : int
- **Purpose**: Sets excerpt length to 30 words.
- **Hooked**: `excerpt_length`

### bcn_excerpt_more( string $more ) : string
- **Purpose**: Sets excerpt more to `…`.
- **Hooked**: `excerpt_more`

---

## Template Functions (`includes/template-functions.php`)

### bcn_body_classes_extra( array $classes ) : array
- **Purpose**: Adds `hfeed` to non-singular pages; `no-sidebar` when sidebar is inactive.
- **Hooked**: `body_class`

### bcn_pingback_header() : void
- **Purpose**: Outputs pingback link in `<head>` on singular content with pings open.
- **Hooked**: `wp_head`

---

## Template Tags (`includes/template-tags.php`)

### bcn_posted_on() : void
- **Purpose**: Prints date/time meta markup for current post.
- **Output**: Echoes HTML.

### bcn_posted_by() : void
- **Purpose**: Prints author meta markup.
- **Output**: Echoes HTML.

### bcn_entry_footer() : void
- **Purpose**: Prints categories, tags, comments link, and edit link.
- **Output**: Echoes HTML.

---

## Customizer (`includes/customizer.php`)

### bcn_customize_register( WP_Customize_Manager $wp_customize )
- **Purpose**: Enables live preview transports; registers Theme Colors section and two color controls.
- **Hooked**: `customize_register`
- **Settings**: `bcn_primary_color`, `bcn_secondary_color`

### bcn_customize_partial_blogname() : void
### bcn_customize_partial_blogdescription() : void
- **Purpose**: Render callbacks for selective refresh.

### bcn_customize_preview_js() : void
- **Purpose**: Enqueues `assets/js/customizer.js` for live preview.
- **Hooked**: `customize_preview_init`

---

## Content Types (`includes/post-types.php`)

### bcn_register_post_types() : void
- **Purpose**: Registers `bcn_event` and `bcn_member` post types.
- **Hooked**: `init`
- **Notes**: Both are public, have archives, REST enabled; slugs `events`, `members`.

### bcn_register_taxonomies() : void
- **Purpose**: Registers `event_category` taxonomy for events.
- **Hooked**: `init`

---

## Member Directory (`includes/member-directory.php`)

### bcn_register_member_post_type() : void
- **Purpose**: Registers `bcn_member` post type (duplicates high-level CPT for modularity). If used alongside `bcn_register_post_types()`, ensure no conflict or remove one.
- **Hooked**: `init`

### bcn_register_membership_level_taxonomy() : void
- **Purpose**: Registers `bcn_membership_level` taxonomy.
- **Hooked**: `init` (prio 0)

### bcn_seed_membership_levels() : void
- **Purpose**: Seeds default levels (`premier-member`, `pro-member`, `community-partner`).
- **Hooked**: `init` (prio 15)

### bcn_register_member_meta() : void
- **Purpose**: Registers member meta fields and post meta for submissions.
- **Hooked**: `init`
- **Meta (member)**: website, email, phone, address, featured, can_submit_content, submission_key.
- **Meta (post)**: submission_member_id, submission_type, submission_contact_name/email.

### bcn_member_add_meta_boxes() : void
- **Purpose**: Adds meta boxes for member details, featured options, and contributions.
- **Hooked**: `add_meta_boxes`

### bcn_member_details_meta_box( WP_Post $post ) : void
### bcn_member_featured_meta_box( WP_Post $post ) : void
### bcn_member_contributions_meta_box( WP_Post $post ) : void
- **Purpose**: Renders admin UI.

### bcn_save_member_meta( int $post_id ) : void
- **Purpose**: Saves member meta on `save_post_bcn_member`.
- **Validations**: nonce, autosave, capabilities, sanitization.

### bcn_filter_member_archive( WP_Query $query ) : void
- **Purpose**: Supports filtering members archive by `membership_level` and `featured_only` query args.
- **Hooked**: `pre_get_posts`
- **Example**: `/members/?membership_level=premier-member&featured_only=1`

### bcn_register_member_onboarding_page() : void
- **Purpose**: Adds admin submenu “Onboard Member” under Members.
- **Hooked**: `admin_menu`

### bcn_render_member_onboarding_page() : void
- **Purpose**: Renders onboarding form and processes submission.
- **Flow**: Validates, creates `bcn_member`, sets terms/meta, handles logo upload.

### bcn_handle_member_onboarding_form() : int|false
- **Purpose**: Handles POST processing; returns new member post ID or false.

### bcn_member_logo_grid_shortcode( array $atts ) : string
- **Purpose**: Renders a responsive grid of member logos.
- **Shortcode**: `[member_logo_grid level="premier-member" limit="12" columns="4" featured="false"]`
- **Attributes**:
  - `level` (slug), `limit` (int|-1), `columns` (2-6), `featured` (bool)

### bcn_get_member_by_submission_key( string $key ) : ?WP_Post
- **Purpose**: Finds a member allowed to submit content with a private key.

### bcn_notify_member_submission( int $post_id, WP_Post $member, string $type, array $fields ) : void
- **Purpose**: Emails admin with submission details.

### bcn_member_submission_form_shortcode( array $atts ) : string
- **Purpose**: Outputs secure member submission form (blog/photo) and handles uploads.
- **Shortcode**: `[member_submission_form key="ABC123" redirect="/thank-you/"]`

### bcn_get_member_profile_fields( int $post_id ) : array
- **Purpose**: Helper to retrieve structured profile fields for templates.

### bcn_validate_uploaded_image( array|null $file ) : true|WP_Error
- **Purpose**: Validates uploaded image (type/size/errors). Max 5MB; must be image/*.

---

## Community Features (`includes/community-features.php`)

### bcn_community_section() : void
- **Purpose**: Outputs front-page section showing 3 latest `bcn_event` posts.
- **Display**: Only on front page.

### Class BCN_Community_Widget extends WP_Widget
- **Purpose**: Simple community callout widget with configurable title.
- **Register**: `bcn_register_community_widget()` on `widgets_init`.
- **Usage**: Appearance → Widgets → Add “BCN Community Widget”.

---

## Hooks Summary
- `after_setup_theme`: `bcn_theme_setup`, `bcn_content_width`
- `widgets_init`: `bcn_widgets_init`, `bcn_register_community_widget`
- `wp_enqueue_scripts`: `bcn_scripts`
- `body_class`: `bcn_body_classes`, `bcn_body_classes_extra`
- `excerpt_length`: `bcn_excerpt_length`
- `excerpt_more`: `bcn_excerpt_more`
- `wp_head`: `bcn_pingback_header`
- `customize_register`: `bcn_customize_register`
- `customize_preview_init`: `bcn_customize_preview_js`
- `init`: `bcn_register_post_types`, `bcn_register_taxonomies`, `bcn_register_member_post_type`, `bcn_register_membership_level_taxonomy`, `bcn_seed_membership_levels`, `bcn_register_member_meta`, `bcn_register_block_patterns`
- `add_meta_boxes`: `bcn_member_add_meta_boxes`
- `save_post_bcn_member`: `bcn_save_member_meta`
- `pre_get_posts`: `bcn_filter_member_archive`
- `admin_menu`: `bcn_register_member_onboarding_page`

