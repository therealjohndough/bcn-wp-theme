#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(git rev-parse --show-toplevel)"
cd "$ROOT_DIR"

echo "Building theme assets before starting (if package.json present)..."
if [ -f package.json ]; then
  if [ -f package-lock.json ] || [ -f npm-shrinkwrap.json ]; then
    npm ci
  else
    npm install
  fi
  if npm run | grep -q " build"; then
    npm run build
  fi
fi

echo "Starting WordPress preview on http://localhost:${WP_PORT:-8080}"
docker compose up -d
echo "Waiting for containers to settle..."
sleep 5
docker compose ps
echo "Open http://localhost:${WP_PORT:-8080} to view the site. Admin: /wp-admin (use the installer to create admin user)."
