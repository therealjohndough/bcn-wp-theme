#!/usr/bin/env bash
set -euo pipefail

# deploy-local.sh
# Usage:
#   DRY_RUN=1 PUSH_GIT=0 ./scripts/deploy-local.sh   # build, show rsync dry-run
#   DRY_RUN=0 PUSH_GIT=1 ./scripts/deploy-local.sh   # push git and perform deploy

ROOT_DIR=$(git rev-parse --show-toplevel)
cd "$ROOT_DIR"

SRC=${SOURCE:-./build}
KEY=${KEY:-$HOME/.ssh/siteground_id}
HOST=${HOST:-staging19.casestudy-labs.com}
USER=${USER:-u2037-2lvglkrliykq}
PORT=${PORT:-18765}
REMOTE_PATH=${REMOTE_PATH:-/home/u2037-2lvglkrliykq/staging19.casestudy-labs.com/public_html/wp-content/themes/bcn-wp-theme}
DRY_RUN=${DRY_RUN:-1}
PUSH_GIT=${PUSH_GIT:-0}

echo "Source: $SRC"
echo "Remote: $USER@$HOST:$REMOTE_PATH"
echo "SSH key: $KEY"
echo "Dry run: $DRY_RUN"
echo "Push git before deploy: $PUSH_GIT"

# Build assets if package.json exists
if [ -f package.json ]; then
  echo "Installing/building frontend assets..."
  if [ -f package-lock.json ] || [ -f npm-shrinkwrap.json ]; then
    npm ci
  else
    npm install
  fi
  if npm run | grep -q " build"; then
    npm run build
  fi
fi

# If the source directory doesn't exist or is empty, export the tracked repo files
# into a temporary directory using git archive. This ensures deploy contains the
# theme files present in the repository even if no prebuilt `build/` exists.
TMP_SRC=''
if [ ! -d "$SRC" ] || [ -z "$(ls -A "$SRC" 2>/dev/null || true)" ]; then
  echo "Source directory '$SRC' missing or empty — exporting tracked repo files to temporary directory for deploy"
  TMP_SRC=$(mktemp -d /tmp/bcn-deploy-XXXX)
  # export current HEAD (tracked files only)
  git archive --format=tar HEAD | tar -x -C "$TMP_SRC"
  SRC="$TMP_SRC"
  # ensure we clean up tempdir on exit
  cleanup() {
    if [ -n "$TMP_SRC" ] && [ -d "$TMP_SRC" ]; then
      rm -rf "$TMP_SRC"
    fi
  }
  trap cleanup EXIT
fi

if [ "$PUSH_GIT" = "1" ]; then
  echo "Pushing current branch to origin..."
  git add -A
  git commit -m "Deploy: $(date -u +'%Y-%m-%dT%H:%M:%SZ')" || true
  git push
fi

RSYNC_OPTS=( -az --delete --exclude .git --exclude node_modules --exclude .env )
SSH_CMD=( ssh -i "$KEY" -p "$PORT" -o IdentitiesOnly=yes -o StrictHostKeyChecking=no )

if [ "$DRY_RUN" = "1" ]; then
  echo "Running rsync dry-run..."
  rsync "${RSYNC_OPTS[@]}" -n -e "${SSH_CMD[*]}" "${SRC%/}/" "$USER@$HOST:$REMOTE_PATH/"
  echo "Dry-run complete. If the output looks right, re-run with DRY_RUN=0 to actually deploy."
else
  echo "Running rsync deploy..."
  rsync "${RSYNC_OPTS[@]}" -e "${SSH_CMD[*]}" "${SRC%/}/" "$USER@$HOST:$REMOTE_PATH/"
  echo "Deploy complete."
fi

exit 0
