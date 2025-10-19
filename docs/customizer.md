# Customizer: Sections, Settings, Controls

All settings and controls are registered in `includes/customizer.php` via `bcn_customize_register()`.

## Sections

### bcn_colors
- **Title**: Theme Colors
- **Priority**: 30
- **Purpose**: Manage primary and secondary brand colors

## Settings

### bcn_primary_color
- **Default**: `#2d5016`
- **Sanitize**: `sanitize_hex_color`
- **Transport**: `refresh`
- **Control**: `WP_Customize_Color_Control`

### bcn_secondary_color
- **Default**: `#7cb342`
- **Sanitize**: `sanitize_hex_color`
- **Transport**: `refresh`
- **Control**: `WP_Customize_Color_Control`

## Live Preview (Selective Refresh)

- `blogname` partial
  - `selector`: `.site-title a`
  - `render_callback`: `bcn_customize_partial_blogname`

- `blogdescription` partial
  - `selector`: `.site-description`
  - `render_callback`: `bcn_customize_partial_blogdescription`

## Preview Script

### bcn_customize_preview_js()
- **Hook**: `customize_preview_init`
- **Script**: `assets/js/customizer.js`
- **Behavior**: Dynamically updates site title, description, and header text color in Customizer preview.
