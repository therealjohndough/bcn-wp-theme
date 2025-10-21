#!/bin/bash

# Deploy Coespace Script
# Usage: ./deploy-coespace.sh <coespace-name> <environment> [options]

set -e

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

# Check if required arguments are provided
if [ $# -lt 2 ]; then
    echo "Usage: $0 <coespace-name> <environment> [options]"
    echo "Environments: staging, production"
    echo "Options:"
    echo "  --dry-run    Show what would be deployed without actually deploying"
    echo "  --force      Force deployment even if there are warnings"
    echo "  --backup     Create backup before deployment"
    echo "  --rollback   Rollback to previous version"
    echo ""
    echo "Examples:"
    echo "  $0 bcn-buffalo-cannabis-network staging"
    echo "  $0 client-restaurant-xyz production --backup"
    echo "  $0 client-ecommerce-abc staging --dry-run"
    exit 1
fi

COESPACE_NAME="$1"
ENVIRONMENT="$2"
COESPACE_DIR=".cursor/coespaces/$COESPACE_NAME"

# Parse options
DRY_RUN=false
FORCE=false
BACKUP=false
ROLLBACK=false

while [[ $# -gt 2 ]]; do
    case $3 in
        --dry-run)
            DRY_RUN=true
            shift
            ;;
        --force)
            FORCE=true
            shift
            ;;
        --backup)
            BACKUP=true
            shift
            ;;
        --rollback)
            ROLLBACK=true
            shift
            ;;
        *)
            print_error "Unknown option: $3"
            exit 1
            ;;
    esac
done

# Validate environment
if [[ "$ENVIRONMENT" != "staging" && "$ENVIRONMENT" != "production" ]]; then
    print_error "Invalid environment. Use 'staging' or 'production'"
    exit 1
fi

# Check if coespace exists
if [ ! -d "$COESPACE_DIR" ]; then
    print_error "Coespace '$COESPACE_NAME' not found!"
    exit 1
fi

# Load coespace configuration
if [ ! -f "$COESPACE_DIR/coespace-config.json" ]; then
    print_error "Coespace configuration not found!"
    exit 1
fi

# Extract configuration values
DEPLOYMENT_PROVIDER=$(jq -r '.deployment.provider' "$COESPACE_DIR/coespace-config.json")
DEPLOYMENT_METHOD=$(jq -r '.deployment.method' "$COESPACE_DIR/coespace-config.json")
AUTO_DEPLOY=$(jq -r '.deployment.auto_deploy' "$COESPACE_DIR/coespace-config.json")

# Set environment-specific variables
if [ "$ENVIRONMENT" = "staging" ]; then
    DEPLOY_URL=$(jq -r '.development.staging_url' "$COESPACE_DIR/coespace-config.json")
    DEPLOY_PATH="/staging"
elif [ "$ENVIRONMENT" = "production" ]; then
    DEPLOY_URL=$(jq -r '.development.production_url' "$COESPACE_DIR/coespace-config.json")
    DEPLOY_PATH="/production"
fi

print_header "Deploying Coespace: $COESPACE_NAME to $ENVIRONMENT"

# Change to coespace directory
cd "$COESPACE_DIR"

# Check if this is a rollback
if [ "$ROLLBACK" = true ]; then
    print_header "Rolling Back Deployment"
    
    if [ ! -f "deployment/backup/latest.tar.gz" ]; then
        print_error "No backup found for rollback!"
        exit 1
    fi
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would restore from backup: deployment/backup/latest.tar.gz"
        exit 0
    fi
    
    print_status "Restoring from backup..."
    tar -xzf deployment/backup/latest.tar.gz -C ../
    print_status "Rollback completed!"
    exit 0
fi

# Create backup if requested
if [ "$BACKUP" = true ]; then
    print_header "Creating Backup"
    
    mkdir -p deployment/backup
    BACKUP_FILE="deployment/backup/backup-$(date +%Y%m%d-%H%M%S).tar.gz"
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would create backup: $BACKUP_FILE"
    else
        print_status "Creating backup..."
        tar -czf "$BACKUP_FILE" --exclude='node_modules' --exclude='vendor' --exclude='.git' .
        ln -sf "$BACKUP_FILE" deployment/backup/latest.tar.gz
        print_status "Backup created: $BACKUP_FILE"
    fi
fi

# Build assets
print_header "Building Assets"

if [ -f "package.json" ]; then
    print_status "Installing Node.js dependencies..."
    if [ "$DRY_RUN" = true ]; then
        print_status "Would run: npm ci"
    else
        npm ci
    fi
    
    print_status "Building assets..."
    if [ "$DRY_RUN" = true ]; then
        print_status "Would run: npm run build"
    else
        npm run build
    fi
fi

if [ -f "composer.json" ]; then
    print_status "Installing PHP dependencies..."
    if [ "$DRY_RUN" = true ]; then
        print_status "Would run: composer install --no-dev --optimize-autoloader"
    else
        composer install --no-dev --optimize-autoloader
    fi
fi

# Run pre-deployment tests
print_header "Running Pre-deployment Tests"

if [ -f "package.json" ] && grep -q '"test"' package.json; then
    print_status "Running tests..."
    if [ "$DRY_RUN" = true ]; then
        print_status "Would run: npm test"
    else
        if ! npm test; then
            if [ "$FORCE" = false ]; then
                print_error "Tests failed! Use --force to deploy anyway."
                exit 1
            else
                print_warning "Tests failed, but deploying anyway due to --force flag"
            fi
        fi
    fi
fi

# Run code quality checks
if [ -f "package.json" ] && grep -q '"quality"' package.json; then
    print_status "Running code quality checks..."
    if [ "$DRY_RUN" = true ]; then
        print_status "Would run: npm run quality"
    else
        if ! npm run quality; then
            if [ "$FORCE" = false ]; then
                print_error "Code quality checks failed! Use --force to deploy anyway."
                exit 1
            else
                print_warning "Code quality checks failed, but deploying anyway due to --force flag"
            fi
        fi
    fi
fi

# Deploy based on method
print_header "Deploying to $ENVIRONMENT"

case "$DEPLOYMENT_METHOD" in
    "rsync")
        deploy_with_rsync
        ;;
    "git")
        deploy_with_git
        ;;
    "ftp")
        deploy_with_ftp
        ;;
    "sftp")
        deploy_with_sftp
        ;;
    *)
        print_error "Unknown deployment method: $DEPLOYMENT_METHOD"
        exit 1
        ;;
esac

# Post-deployment tasks
print_header "Post-deployment Tasks"

if [ "$DRY_RUN" = true ]; then
    print_status "Would run post-deployment tasks"
else
    # Clear caches
    print_status "Clearing caches..."
    # Add cache clearing commands here
    
    # Run database migrations
    if [ -f "deployment/migrations" ]; then
        print_status "Running database migrations..."
        # Add migration commands here
    fi
    
    # Send deployment notification
    print_status "Sending deployment notification..."
    # Add notification logic here
    
    print_status "Deployment completed successfully!"
fi

# Deploy with rsync
deploy_with_rsync() {
    print_status "Deploying with rsync..."
    
    # Load rsync configuration
    RSYNC_HOST=$(jq -r '.deployment.rsync.host' "$COESPACE_DIR/coespace-config.json")
    RSYNC_USER=$(jq -r '.deployment.rsync.user' "$COESPACE_DIR/coespace-config.json")
    RSYNC_PATH=$(jq -r '.deployment.rsync.path' "$COESPACE_DIR/coespace-config.json")
    RSYNC_PORT=$(jq -r '.deployment.rsync.port // 22' "$COESPACE_DIR/coespace-config.json")
    
    RSYNC_CMD="rsync -avz --delete --exclude='.git' --exclude='node_modules' --exclude='vendor' --exclude='.env'"
    
    if [ "$ENVIRONMENT" = "staging" ]; then
        RSYNC_CMD="$RSYNC_CMD --exclude='deployment/production'"
    elif [ "$ENVIRONMENT" = "production" ]; then
        RSYNC_CMD="$RSYNC_CMD --exclude='deployment/staging'"
    fi
    
    RSYNC_CMD="$RSYNC_CMD -e 'ssh -p $RSYNC_PORT' ./ $RSYNC_USER@$RSYNC_HOST:$RSYNC_PATH$DEPLOY_PATH/"
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would run: $RSYNC_CMD"
    else
        print_status "Running rsync deployment..."
        eval $RSYNC_CMD
    fi
}

# Deploy with git
deploy_with_git() {
    print_status "Deploying with git..."
    
    GIT_REMOTE=$(jq -r '.deployment.git.remote' "$COESPACE_DIR/coespace-config.json")
    GIT_BRANCH=$(jq -r '.deployment.git.branch' "$COESPACE_DIR/coespace-config.json")
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would push to: $GIT_REMOTE $GIT_BRANCH"
    else
        print_status "Pushing to git repository..."
        git add .
        git commit -m "Deploy to $ENVIRONMENT - $(date)"
        git push $GIT_REMOTE $GIT_BRANCH
    fi
}

# Deploy with FTP
deploy_with_ftp() {
    print_status "Deploying with FTP..."
    
    FTP_HOST=$(jq -r '.deployment.ftp.host' "$COESPACE_DIR/coespace-config.json")
    FTP_USER=$(jq -r '.deployment.ftp.user' "$COESPACE_DIR/coespace-config.json")
    FTP_PASS=$(jq -r '.deployment.ftp.password' "$COESPACE_DIR/coespace-config.json")
    FTP_PATH=$(jq -r '.deployment.ftp.path' "$COESPACE_DIR/coespace-config.json")
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would upload to: ftp://$FTP_HOST$FTP_PATH$DEPLOY_PATH/"
    else
        print_status "Uploading via FTP..."
        # Add FTP upload logic here
    fi
}

# Deploy with SFTP
deploy_with_sftp() {
    print_status "Deploying with SFTP..."
    
    SFTP_HOST=$(jq -r '.deployment.sftp.host' "$COESPACE_DIR/coespace-config.json")
    SFTP_USER=$(jq -r '.deployment.sftp.user' "$COESPACE_DIR/coespace-config.json")
    SFTP_PATH=$(jq -r '.deployment.sftp.path' "$COESPACE_DIR/coespace-config.json")
    SFTP_PORT=$(jq -r '.deployment.sftp.port // 22' "$COESPACE_DIR/coespace-config.json")
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would upload to: sftp://$SFTP_USER@$SFTP_HOST:$SFTP_PORT$SFTP_PATH$DEPLOY_PATH/"
    else
        print_status "Uploading via SFTP..."
        # Add SFTP upload logic here
    fi
}