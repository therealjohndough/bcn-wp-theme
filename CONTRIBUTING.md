# BCN Theme — Version Control & Workflow

## Branches

| Branch | Purpose |
|--------|---------|
| `main` | Production — what's live on buffalocannabisnetwork.com |
| `staging` | Testing — matches staging6.buffalocannabisnetwork.com |
| `dev` | Active development — create from here |

**Never commit directly to `main`.** All changes go through a branch and get merged.

## Day-to-Day Workflow

### Starting a change

```bash
git checkout dev
git pull origin dev
git checkout -b feature/your-change-name
```

### After making changes

```bash
git add -p                          # review what you're staging
git commit -m "Short description"
git push origin feature/your-change-name
```

### Getting it to staging

```bash
git checkout staging
git merge feature/your-change-name
git push origin staging
# deploy to staging server and test
```

### Getting it to production

```bash
git checkout main
git merge staging
git push origin main
# deploy to production
```

## Commit Message Format

```
type: short description (50 chars max)

Optional longer explanation if needed.
```

**Types:**
- `fix:` — bug fix
- `feat:` — new feature or section
- `style:` — CSS/visual changes only
- `content:` — copy, text, images
- `chore:` — cleanup, config, docs

**Examples:**
```
fix: mobile nav overflow on small screens
feat: add Croptober 2026 event section
style: update homepage hero spacing
content: add April networking event
chore: remove unused import scripts
```

## What Goes in Git

**Always version:**
- All `.php` template and include files
- `style.css`, `theme.json`, `functions.php`
- `assets/` — CSS and JS
- `acf-json/` — ACF field group configs (canonical files only)
- `patterns/`, `parts/`, `template-parts/`
- Documentation `.md` files

**Never version:**
- SSH keys, credentials, `.pem` files
- One-time import/migration scripts (after they've been run)
- ACF export backup files (`acf-export-*.json`)
- `.DS_Store`, editor config files

## ACF JSON Rules

ACF Extended auto-saves field group changes to `acf-json/`. **Always commit these changes** — they are the source of truth for your data structure.

When adding a new field group in the WordPress admin:
1. Save the field group
2. ACF auto-writes to `acf-json/`
3. `git add acf-json/` and commit immediately

**Do not manually edit** JSON files unless you know exactly what you're doing.

## Deployment

See `DEPLOYMENT.md` for full server details.

### Quick deploy to production
```bash
rsync -avz --exclude='.git' \
  wp-content/themes/buffalo-cannabis-network/ \
  user@server:~/public_html/wp-content/themes/buffalo-cannabis-network/
```

After any deploy: **clear all caches** (SiteGround cache + any caching plugin).

## File Structure Reference

```
buffalo-cannabis-network/
├── functions.php          Main theme functions (2,300+ lines)
├── style.css              Theme stylesheet + metadata
├── theme.json             Block editor design system
├── front-page.php         Homepage template
├── page-*.php             Custom page templates
├── single-*.php           Custom post type singles
├── archive-*.php          Archive/listing templates
├── header.php / footer.php
├── acf-json/              ACF field configs — commit these
├── assets/css/            Stylesheets
├── assets/js/             JavaScript
├── patterns/              Block patterns (18 files)
├── template-parts/        Reusable PHP partials
├── includes/              Admin includes
└── scripts/               Utility scripts (mostly one-time use)
```
