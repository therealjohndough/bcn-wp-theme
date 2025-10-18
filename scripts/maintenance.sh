#!/usr/bin/env bash
set -euo pipefail
echo "🔧 Maintenance start: $(date -u +"%Y-%m-%dT%H:%M:%SZ")"

if [ -f package.json ]; then
  if command -v pnpm >/dev/null 2>&1; then
    pnpm run -s build || true
    pnpm run -s lint || true
  else
    npm run -s build || true
    npm run -s lint || true
  fi
fi

if [ -f composer.json ]; then
  composer audit || true
fi

# Quick WP checks (non-fatal)
grep -R --line-number "wp_enqueue_" ./ || true
grep -R --line-number "add_theme_support" ./ || true

echo "✅ Maintenance complete."
