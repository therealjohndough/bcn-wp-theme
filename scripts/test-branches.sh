#!/usr/bin/env bash
set -euo pipefail

# Test all remote branches in isolated git worktrees.
# Usage: BUILD_CMD="..." ./scripts/test-branches.sh

REMOTE=${REMOTE:-origin}
RESULTS_DIR=${RESULTS_DIR:-/tmp/bcn-branch-test-results}
mkdir -p "$RESULTS_DIR"
RESULTS_FILE="$RESULTS_DIR/branch-build-results-$(date +%Y%m%dT%H%M%S).txt"

cd "$(git rev-parse --show-toplevel)"

echo "Detecting build command..."
if [ -n "${BUILD_CMD:-}" ]; then
  DETECTED_BUILD_CMD="$BUILD_CMD"
else
  if [ -f package.json ]; then
    # prefer npm ci when lockfile present
    if [ -f package-lock.json ] || [ -f npm-shrinkwrap.json ]; then
      INSTALL_CMD='npm ci'
    else
      INSTALL_CMD='npm install'
    fi
    # choose build script if present
    if npm run | grep -q " build"; then
      BUILD_SCRIPT='npm run build'
    elif npm run | grep -q " production"; then
      BUILD_SCRIPT='npm run production'
    else
      BUILD_SCRIPT=':'
    fi
    DETECTED_BUILD_CMD="$INSTALL_CMD && $BUILD_SCRIPT"
  elif [ -f composer.json ]; then
    DETECTED_BUILD_CMD='composer install --no-interaction --prefer-dist --no-progress'
  else
    DETECTED_BUILD_CMD=':'
  fi
fi

echo "Using BUILD_CMD: $DETECTED_BUILD_CMD"
echo "Results will be written to $RESULTS_FILE"

git fetch "$REMOTE" --prune

# list remote branches (skip HEAD and the remote name itself)
branches=$(git for-each-ref --format='%(refname:short)' refs/remotes/"$REMOTE" | sed "s#^$REMOTE/##" | grep -vE '^HEAD$|^$REMOTE$' | sort -u)

echo "Found branches:" >&2
echo "$branches" >&2

CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)

for br in $branches; do
  echo "\n=== Testing branch: $br ===" | tee -a "$RESULTS_FILE"
  # If this is the current branch (checked out in the main worktree), run in-place
  if [ "$br" = "$CURRENT_BRANCH" ]; then
    workdir="$(git rev-parse --show-toplevel)"
    echo "Branch is current branch ($CURRENT_BRANCH) — running in-place at $workdir" | tee -a "$RESULTS_FILE"
    pushd "$workdir" >/dev/null
    # detect build command per-worktree
    if [ -f package.json ]; then
      if [ -f package-lock.json ] || [ -f npm-shrinkwrap.json ]; then
        INSTALL_CMD='npm ci'
      else
        INSTALL_CMD='npm install'
      fi
      if npm run | grep -q " build"; then
        BUILD_SCRIPT='npm run build'
      elif npm run | grep -q " production"; then
        BUILD_SCRIPT='npm run production'
      else
        BUILD_SCRIPT=':'
      fi
      RUN_CMD="$INSTALL_CMD && $BUILD_SCRIPT"
    elif [ -f composer.json ]; then
      RUN_CMD='composer install --no-interaction --prefer-dist --no-progress'
    else
      RUN_CMD=':'
    fi

    echo "Command: $RUN_CMD" | tee -a "$RESULTS_FILE"
    if bash -lc "$RUN_CMD" >build-output.log 2>&1; then
      echo "$br: SUCCESS" | tee -a "$RESULTS_FILE"
      rm -f build-output.log || true
    else
      echo "$br: FAILURE (logs at $workdir/build-output.log)" | tee -a "$RESULTS_FILE"
      echo "---- tail of build output for $br ----" | tee -a "$RESULTS_FILE"
      tail -n 200 build-output.log | tee -a "$RESULTS_FILE"
      echo "Logs kept at $workdir/build-output.log" | tee -a "$RESULTS_FILE"
    fi
    popd >/dev/null
    continue
  fi

  tmpdir=$(mktemp -d /tmp/bcn-branch-XXXX)

  # try to create a local worktree for the remote branch
  if git show-ref --verify --quiet refs/heads/"$br"; then
    git worktree add "$tmpdir" "$br"
  else
    # create local branch tracking remote
    git worktree add -b "$br" "$tmpdir" "$REMOTE/$br" || git worktree add "$tmpdir" "$REMOTE/$br"
  fi

  pushd "$tmpdir" >/dev/null
  echo "Running build in $tmpdir" | tee -a "$RESULTS_FILE"

  # detect build command per-worktree (prefer local lockfile)
  if [ -f package.json ]; then
    if [ -f package-lock.json ] || [ -f npm-shrinkwrap.json ]; then
      INSTALL_CMD='npm ci'
    else
      INSTALL_CMD='npm install'
    fi
    if npm run | grep -q " build"; then
      BUILD_SCRIPT='npm run build'
    elif npm run | grep -q " production"; then
      BUILD_SCRIPT='npm run production'
    else
      BUILD_SCRIPT=':'
    fi
    RUN_CMD="$INSTALL_CMD && $BUILD_SCRIPT"
  elif [ -f composer.json ]; then
    RUN_CMD='composer install --no-interaction --prefer-dist --no-progress'
  else
    RUN_CMD=':'
  fi

  echo "Command: $RUN_CMD" | tee -a "$RESULTS_FILE"

  # Run build and capture exit code & output
  if bash -lc "$RUN_CMD" >build-output.log 2>&1; then
    echo "$br: SUCCESS" | tee -a "$RESULTS_FILE"
    # on success, remove worktree
    popd >/dev/null
    git worktree remove "$tmpdir" --force >/dev/null 2>&1 || rm -rf "$tmpdir"
  else
    echo "$br: FAILURE (logs at $tmpdir/build-output.log)" | tee -a "$RESULTS_FILE"
    echo "---- tail of build output for $br ----" | tee -a "$RESULTS_FILE"
    tail -n 200 build-output.log | tee -a "$RESULTS_FILE"
    popd >/dev/null
    echo "Keeping failed worktree at $tmpdir for inspection." | tee -a "$RESULTS_FILE"
  fi
done

echo "\nAll done. Results: $RESULTS_FILE"
echo "Failed worktrees (if any) are left under /tmp with prefix bcn-branch-" 

exit 0
