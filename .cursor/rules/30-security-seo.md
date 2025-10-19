---
description: Security, SEO, performance (shared)
globs: "**/*"
---

## Security
- `defined('ABSPATH') || exit;` at top of theme PHP files.
- Only allow scripts in a dedicated analytics/options field with strict `wp_kses` allowlist.
- Do not commit secrets; use env/constants.

## SEO
- Canonical tag and OG/Twitter meta on all pages.
- JSON-LD:
  - Sitewide `Organization` (logo, sameAs).
  - `Event` for events, `NewsArticle` for news.
  - `BreadcrumbList` on drill-down pages.
- Clean slugs; ensure archives indexable.

## Performance
- Preload critical fonts with `font-display: swap`.
- Serve WebP/AVIF with fallbacks; long-cache static assets.
- Keep CLS low by reserving image/video space.