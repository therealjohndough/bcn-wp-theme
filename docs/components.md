# Components: Widgets, Templates, Block Patterns

## Widgets

### BCN_Community_Widget
- **Type**: `WP_Widget`
- **ID**: `bcn_community_widget`
- **Purpose**: Displays a short community callout with a customizable title.
- **Register**: `bcn_register_community_widget()` on `widgets_init`.
- **Usage**:
  - Appearance → Widgets → Add “BCN Community Widget” to a sidebar
  - Configure the Title field

## Template Parts

Located in `template-parts/` and used by standard templates:
- `content.php` – default loop item
- `content-single.php` – single post
- `content-page.php` – static pages
- `content-search.php` – search results
- `content-none.php` – no-results state

## Block Patterns

Registered under category `BCN` via `bcn_register_block_patterns()` on `init`.

### Contact – Get in Touch (BCN)
- **Name**: `bcn/contact-get-in-touch`
- **Purpose**: Four-card slick contact section
- **Includes**: Email links for general inquiries, membership, events/education, and mailing address
- **Example insertion**: Block Editor → Patterns → BCN → “Contact – Get in Touch (BCN)”

### Stay Connected (BCN)
- **Name**: `bcn/stay-connected`
- **Purpose**: Social links + newsletter callout in matching style
- **Includes**: Instagram, LinkedIn, newsletter link
- **Example insertion**: Block Editor → Patterns → BCN → “Stay Connected (BCN)”

## Front Page Section

### bcn_community_section()
- **Purpose**: Outputs a section listing the 3 most recent `bcn_event` posts on the front page.
- **Where**: Intended for use in front-page template. Call within templates if needed.
- **Example**:
```php
if ( function_exists('bcn_community_section') ) {
    bcn_community_section();
}
```
