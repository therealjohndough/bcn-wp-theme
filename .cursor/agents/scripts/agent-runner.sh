#!/bin/bash
# Background Agent Runner for BCN Development

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Configuration
AGENTS_DIR=".cursor/agents"
CONFIG_FILE="$AGENTS_DIR/config.json"
LOG_DIR="$AGENTS_DIR/logs"
STATUS_DIR="$AGENTS_DIR/status"
REPORTS_DIR="$AGENTS_DIR/reports"

# Create directories
mkdir -p "$LOG_DIR" "$STATUS_DIR" "$REPORTS_DIR"

# Logging function
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_DIR/agent-runner.log"
}

# Run agent command
run_agent() {
    local agent_name="$1"
    local command="$2"
    local output_file="$3"
    
    log "Running $agent_name: $command"
    
    if eval "$command" > "$output_file" 2>&1; then
        log "✅ $agent_name completed successfully"
        echo "success" > "$STATUS_DIR/${agent_name}.status"
        return 0
    else
        log "❌ $agent_name failed"
        echo "failed" > "$STATUS_DIR/${agent_name}.status"
        return 1
    fi
}

# Check if agent is enabled
is_agent_enabled() {
    local agent_name="$1"
    jq -r ".agents.${agent_name}.enabled" "$CONFIG_FILE" 2>/dev/null | grep -q "true"
}

# Get agent commands
get_agent_commands() {
    local agent_name="$1"
    jq -r ".agents.${agent_name}.commands[]" "$CONFIG_FILE" 2>/dev/null
}

# Run all enabled agents
run_all_agents() {
    log "🚀 Starting BCN Background Agents"
    
    # Code Quality Agent
    if is_agent_enabled "code-quality"; then
        run_agent "code-quality" "phpcs --standard=WordPress ." "$LOG_DIR/code-quality.log"
    fi
    
    # Performance Agent
    if is_agent_enabled "performance"; then
        run_agent "performance" "lighthouse https://staging6.buffalocannabisnetwork.com --output=json --output-path=$REPORTS_DIR/lighthouse.json" "$LOG_DIR/performance.log"
    fi
    
    # Security Agent
    if is_agent_enabled "security"; then
        run_agent "security" "composer audit" "$LOG_DIR/security.log"
    fi
    
    # Content Agent
    if is_agent_enabled "content"; then
        run_agent "content" "wp acf sync" "$LOG_DIR/content.log"
    fi
    
    log "🎉 All agents completed"
}

# Watch for file changes
watch_files() {
    local watch_patterns=("**/*.php" "**/*.js" "**/*.css")
    
    log "👀 Starting file watcher"
    
    # Use fswatch if available, otherwise use inotifywait
    if command -v fswatch >/dev/null 2>&1; then
        fswatch -o "${watch_patterns[@]}" | while read; do
            log "📁 File change detected, running agents..."
            run_all_agents
        done
    elif command -v inotifywait >/dev/null 2>&1; then
        inotifywait -m -r -e modify "${watch_patterns[@]}" | while read; do
            log "📁 File change detected, running agents..."
            run_all_agents
        done
    else
        log "⚠️  No file watcher available, running agents once"
        run_all_agents
    fi
}

# Main execution
case "${1:-run}" in
    "run")
        run_all_agents
        ;;
    "watch")
        watch_files
        ;;
    "status")
        echo "Agent Status:"
        for status_file in "$STATUS_DIR"/*.status; do
            if [ -f "$status_file" ]; then
                agent_name=$(basename "$status_file" .status)
                status=$(cat "$status_file")
                echo "  $agent_name: $status"
            fi
        done
        ;;
    "logs")
        echo "Recent logs:"
        tail -n 20 "$LOG_DIR/agent-runner.log"
        ;;
    *)
        echo "Usage: $0 {run|watch|status|logs}"
        exit 1
        ;;
esac