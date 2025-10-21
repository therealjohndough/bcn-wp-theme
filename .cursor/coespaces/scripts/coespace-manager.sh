#!/bin/bash

# Coespace Manager Script
# Usage: ./coespace-manager.sh [command] [options]

set -e

COESPACES_DIR=".cursor/coespaces"
SCRIPTS_DIR=".cursor/coespaces/scripts"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_header() {
    echo -e "${BLUE}=== $1 ===${NC}"
}

# List all coespaces
list_coespaces() {
    print_header "Available Coespaces"
    
    if [ ! -d "$COESPACES_DIR" ]; then
        print_error "Coespaces directory not found!"
        exit 1
    fi
    
    for coespace in "$COESPACES_DIR"/*; do
        if [ -d "$coespace" ] && [ -f "$coespace/coespace-config.json" ]; then
            coespace_name=$(basename "$coespace")
            if command -v jq >/dev/null 2>&1; then
                coespace_type=$(jq -r '.coespace.type // "unknown"' "$coespace/coespace-config.json" 2>/dev/null || echo "unknown")
                coespace_status=$(jq -r '.coespace.status // "unknown"' "$coespace/coespace-config.json" 2>/dev/null || echo "unknown")
                coespace_client=$(jq -r '.coespace.client // .coespace.name // "unknown"' "$coespace/coespace-config.json" 2>/dev/null || echo "unknown")
            else
                coespace_type="config"
                coespace_status="active"
                coespace_client=$(basename "$coespace")
            fi
            
            echo "📁 $coespace_name"
            echo "   Type: $coespace_type"
            echo "   Status: $coespace_status"
            echo "   Client: $coespace_client"
            echo ""
        fi
    done
}

# Show coespace details
show_coespace() {
    local coespace_name="$1"
    local coespace_dir="$COESPACES_DIR/$coespace_name"
    
    if [ ! -d "$coespace_dir" ]; then
        print_error "Coespace '$coespace_name' not found!"
        exit 1
    fi
    
    if [ ! -f "$coespace_dir/coespace-config.json" ]; then
        print_error "Coespace configuration not found!"
        exit 1
    fi
    
    print_header "Coespace Details: $coespace_name"
    
    # Display configuration
    echo "📋 Configuration:"
    jq '.' "$coespace_dir/coespace-config.json"
    
    echo ""
    echo "📁 Files:"
    ls -la "$coespace_dir"
}

# Start coespace development environment
start_coespace() {
    local coespace_name="$1"
    local coespace_dir="$COESPACES_DIR/$coespace_name"
    
    if [ ! -d "$coespace_dir" ]; then
        print_error "Coespace '$coespace_name' not found!"
        exit 1
    fi
    
    print_header "Starting Coespace: $coespace_name"
    
    cd "$coespace_dir"
    
    # Check if .env exists
    if [ ! -f ".env" ]; then
        if [ -f ".env.example" ]; then
            print_warning "Creating .env from .env.example"
            cp .env.example .env
        else
            print_error ".env file not found and no .env.example available!"
            exit 1
        fi
    fi
    
    # Start Docker environment
    if [ -f "docker-compose.yml" ]; then
        print_status "Starting Docker environment..."
        docker compose up --build -d
        print_status "Environment started! Check the logs with: docker compose logs -f"
    else
        print_warning "No docker-compose.yml found in coespace"
    fi
    
    # Install dependencies
    if [ -f "package.json" ]; then
        print_status "Installing Node.js dependencies..."
        npm install
    fi
    
    if [ -f "composer.json" ]; then
        print_status "Installing PHP dependencies..."
        composer install
    fi
    
    print_status "Coespace '$coespace_name' is ready for development!"
}

# Stop coespace development environment
stop_coespace() {
    local coespace_name="$1"
    local coespace_dir="$COESPACES_DIR/$coespace_name"
    
    if [ ! -d "$coespace_dir" ]; then
        print_error "Coespace '$coespace_name' not found!"
        exit 1
    fi
    
    print_header "Stopping Coespace: $coespace_name"
    
    cd "$coespace_dir"
    
    if [ -f "docker-compose.yml" ]; then
        print_status "Stopping Docker environment..."
        docker compose down
        print_status "Environment stopped!"
    else
        print_warning "No docker-compose.yml found in coespace"
    fi
}

# Deploy coespace
deploy_coespace() {
    local coespace_name="$1"
    local environment="${2:-staging}"
    local coespace_dir="$COESPACES_DIR/$coespace_name"
    
    if [ ! -d "$coespace_dir" ]; then
        print_error "Coespace '$coespace_name' not found!"
        exit 1
    fi
    
    print_header "Deploying Coespace: $coespace_name to $environment"
    
    cd "$coespace_dir"
    
    # Build assets
    if [ -f "package.json" ]; then
        print_status "Building assets..."
        npm run build
    fi
    
    # Run deployment script
    if [ -f "scripts/deploy-$environment.sh" ]; then
        print_status "Running deployment script..."
        ./scripts/deploy-$environment.sh
    else
        print_warning "No deployment script found for $environment"
        print_status "Manual deployment required"
    fi
}

# Create new coespace
create_coespace() {
    local coespace_name="$1"
    local industry="$2"
    local description="$3"
    
    if [ -z "$coespace_name" ] || [ -z "$industry" ] || [ -z "$description" ]; then
        print_error "Usage: create <coespace-name> <industry> <description>"
        exit 1
    fi
    
    print_header "Creating New Coespace: $coespace_name"
    
    if [ -f "$SCRIPTS_DIR/create-client-coespace.sh" ]; then
        "$SCRIPTS_DIR/create-client-coespace.sh" "$coespace_name" "$industry" "$description"
    else
        print_error "Create script not found!"
        exit 1
    fi
}

# Show help
show_help() {
    echo "Coespace Manager - Manage your agency coespaces"
    echo ""
    echo "Usage: $0 [command] [options]"
    echo ""
    echo "Commands:"
    echo "  list                           List all available coespaces"
    echo "  show <coespace-name>           Show detailed information about a coespace"
    echo "  start <coespace-name>          Start development environment for a coespace"
    echo "  stop <coespace-name>           Stop development environment for a coespace"
    echo "  deploy <coespace-name> [env]   Deploy coespace to staging/production"
    echo "  create <name> <industry> <desc> Create a new client coespace"
    echo "  help                           Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0 list"
    echo "  $0 show bcn-buffalo-cannabis-network"
    echo "  $0 start bcn-buffalo-cannabis-network"
    echo "  $0 deploy bcn-buffalo-cannabis-network production"
    echo "  $0 create \"Green Valley Dispensary\" cannabis \"E-commerce website\""
}

# Main script logic
case "${1:-help}" in
    "list")
        list_coespaces
        ;;
    "show")
        if [ -z "$2" ]; then
            print_error "Please provide a coespace name"
            exit 1
        fi
        show_coespace "$2"
        ;;
    "start")
        if [ -z "$2" ]; then
            print_error "Please provide a coespace name"
            exit 1
        fi
        start_coespace "$2"
        ;;
    "stop")
        if [ -z "$2" ]; then
            print_error "Please provide a coespace name"
            exit 1
        fi
        stop_coespace "$2"
        ;;
    "deploy")
        if [ -z "$2" ]; then
            print_error "Please provide a coespace name"
            exit 1
        fi
        deploy_coespace "$2" "$3"
        ;;
    "create")
        create_coespace "$2" "$3" "$4"
        ;;
    "help"|*)
        show_help
        ;;
esac