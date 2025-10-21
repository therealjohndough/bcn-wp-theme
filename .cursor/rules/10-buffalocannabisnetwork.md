---
description: BCN Media Network (events, members, news)
globs: "**/*.php"
---

## Content System
- CPTs: `events`, `news`, `members`; heavy ACF repeaters for schedules and metadata.
- Member dashboard at `/my-account`; gate member-only content via capabilities/roles.
- Avoid N+1 queries in archives; prefetch meta where possible.

## Brand & Design
- Colors: Buffalo Blue `#4A90E2`, White `#FFFFFF`, Network Magenta `#D31C95`, Charcoal `#1A1A1A` (body only).
- **No pure black backgrounds.** Maintain AA+ contrast.
- Typography: Roboto; visible focus states; clear hover styles.

## Events
- Use ACF fields: `start_datetime`, `end_datetime`, `location_name`, `location_address`, `price`, `cta_url`.
- Render `Event` JSON-LD with start/end, location, organizer when present.
- List pages must support: upcoming/past filters, search, and tag/category filters.
- Calendar exports (optional): add `.ics` link with correct timezone.

## News
- Use `NewsArticle` JSON-LD (headline, datePublished, author, image).
- Social share meta (OG/Twitter) sourced from featured image + excerpt.

## Members
- Member CPT or user roles; expose profile fields via ACF (`company`, `role`, `website`, `social[]`).
- Protect dashboards and downloads; never index private member pages.

## Performance
- Define image sizes: `bcn-card` (~900×600), `bcn-hero` (~1600×900).
- Always set `loading="lazy"` + `decoding="async"` and explicit width/height or aspect-ratio.
- Defer non-critical JS; one small entry file; no global namespace leaks.

## Dev Conventions
- Function prefix: `bcn_`.
- Template parts in `template-parts/` and accept data arrays (no queries inside partials).
- Escape output: `esc_html`, `esc_url`, `wp_kses_post`. Sanitize on save.
- Menu locations: `primary`, `footer`. Register in `after_setup_theme`.

## Nice to have (if time allows)
- RSS feeds for News; Newsletter signup integration.
- Event schema "offers" mapping for paid events.