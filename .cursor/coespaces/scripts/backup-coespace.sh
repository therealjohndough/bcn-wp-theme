#!/bin/bash

# Backup Coespace Script
# Usage: ./backup-coespace.sh <coespace-name> [options]

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
if [ $# -lt 1 ]; then
    echo "Usage: $0 <coespace-name> [options]"
    echo "Options:"
    echo "  --type <type>        Backup type (full, code, database, files)"
    echo "  --destination <path> Backup destination path"
    echo "  --compress           Compress backup files"
    echo "  --encrypt            Encrypt backup files"
    echo "  --retention <days>   Keep backups for specified days"
    echo "  --dry-run            Show what would be backed up"
    echo "  --restore <file>     Restore from backup file"
    echo "  --list               List available backups"
    echo "  --help               Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0 bcn-buffalo-cannabis-network"
    echo "  $0 client-restaurant-xyz --type full --compress"
    echo "  $0 client-ecommerce-abc --restore backup-20240115.tar.gz"
    exit 1
fi

COESPACE_NAME="$1"
COESPACE_DIR=".cursor/coespaces/$COESPACE_NAME"

# Parse options
BACKUP_TYPE="full"
BACKUP_DESTINATION=""
COMPRESS=false
ENCRYPT=false
RETENTION_DAYS=30
DRY_RUN=false
RESTORE_FILE=""
LIST_BACKUPS=false

while [[ $# -gt 1 ]]; do
    case $2 in
        --type)
            BACKUP_TYPE="$3"
            shift 2
            ;;
        --destination)
            BACKUP_DESTINATION="$3"
            shift 2
            ;;
        --compress)
            COMPRESS=true
            shift
            ;;
        --encrypt)
            ENCRYPT=true
            shift
            ;;
        --retention)
            RETENTION_DAYS="$3"
            shift 2
            ;;
        --dry-run)
            DRY_RUN=true
            shift
            ;;
        --restore)
            RESTORE_FILE="$3"
            shift 2
            ;;
        --list)
            LIST_BACKUPS=true
            shift
            ;;
        --help)
            show_help
            exit 0
            ;;
        *)
            print_error "Unknown option: $2"
            exit 1
            ;;
    esac
done

# Show help
show_help() {
    echo "Backup Coespace Script"
    echo ""
    echo "Usage: $0 <coespace-name> [options]"
    echo ""
    echo "Options:"
    echo "  --type <type>        Backup type (full, code, database, files)"
    echo "  --destination <path> Backup destination path"
    echo "  --compress           Compress backup files"
    echo "  --encrypt            Encrypt backup files"
    echo "  --retention <days>   Keep backups for specified days"
    echo "  --dry-run            Show what would be backed up"
    echo "  --restore <file>     Restore from backup file"
    echo "  --list               List available backups"
    echo "  --help               Show this help message"
    echo ""
    echo "Backup Types:"
    echo "  full       - Complete coespace backup (default)"
    echo "  code       - Source code and configuration only"
    echo "  database   - Database backup only"
    echo "  files      - Uploaded files and media only"
}

# Check if coespace exists
if [ ! -d "$COESPACE_DIR" ]; then
    print_error "Coespace '$COESPACE_NAME' not found!"
    exit 1
fi

# Set default backup destination
if [ -z "$BACKUP_DESTINATION" ]; then
    BACKUP_DESTINATION="$COESPACE_DIR/backups"
fi

# Create backup directory
mkdir -p "$BACKUP_DESTINATION"

# List available backups
if [ "$LIST_BACKUPS" = true ]; then
    list_backups
    exit 0
fi

# Restore from backup
if [ -n "$RESTORE_FILE" ]; then
    restore_backup
    exit 0
fi

# Main backup logic
print_header "Backing up Coespace: $COESPACE_NAME"

# Generate backup filename
BACKUP_TIMESTAMP=$(date +%Y%m%d-%H%M%S)
BACKUP_FILENAME="backup-$COESPACE_NAME-$BACKUP_TYPE-$BACKUP_TIMESTAMP"

if [ "$COMPRESS" = true ]; then
    BACKUP_FILENAME="$BACKUP_FILENAME.tar.gz"
else
    BACKUP_FILENAME="$BACKUP_FILENAME.tar"
fi

if [ "$ENCRYPT" = true ]; then
    BACKUP_FILENAME="$BACKUP_FILENAME.enc"
fi

BACKUP_PATH="$BACKUP_DESTINATION/$BACKUP_FILENAME"

print_status "Backup type: $BACKUP_TYPE"
print_status "Destination: $BACKUP_PATH"
print_status "Compress: $COMPRESS"
print_status "Encrypt: $ENCRYPT"

# Perform backup based on type
case "$BACKUP_TYPE" in
    "full")
        backup_full
        ;;
    "code")
        backup_code
        ;;
    "database")
        backup_database
        ;;
    "files")
        backup_files
        ;;
    *)
        print_error "Invalid backup type: $BACKUP_TYPE"
        exit 1
        ;;
esac

# Clean up old backups
cleanup_old_backups

print_status "Backup completed successfully!"

# Backup full coespace
backup_full() {
    print_status "Creating full backup..."
    
    cd "$COESPACE_DIR"
    
    # Files to exclude
    EXCLUDE_FILES=(
        "node_modules"
        "vendor"
        ".git"
        "backups"
        "*.log"
        ".DS_Store"
        "Thumbs.db"
    )
    
    # Build exclude string
    EXCLUDE_STRING=""
    for file in "${EXCLUDE_FILES[@]}"; do
        EXCLUDE_STRING="$EXCLUDE_STRING --exclude=$file"
    done
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would create backup with excludes: $EXCLUDE_STRING"
        return
    fi
    
    # Create tar archive
    if [ "$COMPRESS" = true ]; then
        tar -czf "$BACKUP_PATH" $EXCLUDE_STRING .
    else
        tar -cf "$BACKUP_PATH" $EXCLUDE_STRING .
    fi
    
    # Encrypt if requested
    if [ "$ENCRYPT" = true ]; then
        print_status "Encrypting backup..."
        gpg --symmetric --cipher-algo AES256 --output "$BACKUP_PATH.enc" "$BACKUP_PATH"
        rm "$BACKUP_PATH"
        BACKUP_PATH="$BACKUP_PATH.enc"
    fi
    
    cd - > /dev/null
}

# Backup code only
backup_code() {
    print_status "Creating code backup..."
    
    cd "$COESPACE_DIR"
    
    # Files to include
    INCLUDE_FILES=(
        "*.php"
        "*.css"
        "*.js"
        "*.json"
        "*.md"
        "*.yml"
        "*.yaml"
        "*.xml"
        "*.txt"
        "assets"
        "includes"
        "template-parts"
        "*.env.example"
        "docker-compose.yml"
        "package.json"
        "composer.json"
        "webpack.config.js"
        "style.css"
        "functions.php"
        "index.php"
        "header.php"
        "footer.php"
        "sidebar.php"
        "single.php"
        "page.php"
        "archive.php"
        "search.php"
        "404.php"
        "comments.php"
        "searchform.php"
    )
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would backup code files"
        return
    fi
    
    # Create tar archive
    if [ "$COMPRESS" = true ]; then
        tar -czf "$BACKUP_PATH" "${INCLUDE_FILES[@]}"
    else
        tar -cf "$BACKUP_PATH" "${INCLUDE_FILES[@]}"
    fi
    
    # Encrypt if requested
    if [ "$ENCRYPT" = true ]; then
        print_status "Encrypting backup..."
        gpg --symmetric --cipher-algo AES256 --output "$BACKUP_PATH.enc" "$BACKUP_PATH"
        rm "$BACKUP_PATH"
        BACKUP_PATH="$BACKUP_PATH.enc"
    fi
    
    cd - > /dev/null
}

# Backup database
backup_database() {
    print_status "Creating database backup..."
    
    # Load database configuration
    DB_HOST=$(grep "WORDPRESS_DB_HOST" "$COESPACE_DIR/.env" | cut -d'=' -f2)
    DB_NAME=$(grep "WORDPRESS_DB_NAME" "$COESPACE_DIR/.env" | cut -d'=' -f2)
    DB_USER=$(grep "WORDPRESS_DB_USER" "$COESPACE_DIR/.env" | cut -d'=' -f2)
    DB_PASS=$(grep "WORDPRESS_DB_PASSWORD" "$COESPACE_DIR/.env" | cut -d'=' -f2)
    
    if [ -z "$DB_HOST" ] || [ -z "$DB_NAME" ] || [ -z "$DB_USER" ] || [ -z "$DB_PASS" ]; then
        print_error "Database configuration not found in .env file"
        exit 1
    fi
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would backup database: $DB_NAME"
        return
    fi
    
    # Create database dump
    mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_PATH.sql"
    
    # Compress if requested
    if [ "$COMPRESS" = true ]; then
        gzip "$BACKUP_PATH.sql"
        BACKUP_PATH="$BACKUP_PATH.sql.gz"
    fi
    
    # Encrypt if requested
    if [ "$ENCRYPT" = true ]; then
        print_status "Encrypting backup..."
        gpg --symmetric --cipher-algo AES256 --output "$BACKUP_PATH.enc" "$BACKUP_PATH"
        rm "$BACKUP_PATH"
        BACKUP_PATH="$BACKUP_PATH.enc"
    fi
}

# Backup files only
backup_files() {
    print_status "Creating files backup..."
    
    # Look for uploads directory
    UPLOADS_DIR=""
    if [ -d "$COESPACE_DIR/wp-content/uploads" ]; then
        UPLOADS_DIR="$COESPACE_DIR/wp-content/uploads"
    elif [ -d "$COESPACE_DIR/uploads" ]; then
        UPLOADS_DIR="$COESPACE_DIR/uploads"
    else
        print_warning "No uploads directory found"
        return
    fi
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would backup files from: $UPLOADS_DIR"
        return
    fi
    
    # Create tar archive
    if [ "$COMPRESS" = true ]; then
        tar -czf "$BACKUP_PATH" -C "$UPLOADS_DIR" .
    else
        tar -cf "$BACKUP_PATH" -C "$UPLOADS_DIR" .
    fi
    
    # Encrypt if requested
    if [ "$ENCRYPT" = true ]; then
        print_status "Encrypting backup..."
        gpg --symmetric --cipher-algo AES256 --output "$BACKUP_PATH.enc" "$BACKUP_PATH"
        rm "$BACKUP_PATH"
        BACKUP_PATH="$BACKUP_PATH.enc"
    fi
}

# List available backups
list_backups() {
    print_header "Available Backups for $COESPACE_NAME"
    
    if [ ! -d "$BACKUP_DESTINATION" ]; then
        print_warning "No backup directory found"
        return
    fi
    
    echo "Backup files:"
    ls -la "$BACKUP_DESTINATION" | grep "backup-$COESPACE_NAME" | while read line; do
        echo "  $line"
    done
    
    echo ""
    echo "Total backups: $(ls -1 "$BACKUP_DESTINATION" | grep "backup-$COESPACE_NAME" | wc -l)"
}

# Restore from backup
restore_backup() {
    print_header "Restoring from Backup: $RESTORE_FILE"
    
    if [ ! -f "$RESTORE_FILE" ]; then
        print_error "Backup file not found: $RESTORE_FILE"
        exit 1
    fi
    
    if [ "$DRY_RUN" = true ]; then
        print_status "Would restore from: $RESTORE_FILE"
        return
    fi
    
    # Check if backup is encrypted
    if [[ "$RESTORE_FILE" == *.enc ]]; then
        print_status "Decrypting backup..."
        gpg --decrypt --output "${RESTORE_FILE%.enc}" "$RESTORE_FILE"
        RESTORE_FILE="${RESTORE_FILE%.enc}"
    fi
    
    # Extract backup
    print_status "Extracting backup..."
    tar -xf "$RESTORE_FILE" -C "$COESPACE_DIR"
    
    print_status "Restore completed successfully!"
}

# Clean up old backups
cleanup_old_backups() {
    print_status "Cleaning up old backups..."
    
    if [ ! -d "$BACKUP_DESTINATION" ]; then
        return
    fi
    
    # Find and remove backups older than retention period
    find "$BACKUP_DESTINATION" -name "backup-$COESPACE_NAME-*" -type f -mtime +$RETENTION_DAYS -delete
    
    print_status "Old backups cleaned up (retention: $RETENTION_DAYS days)"
}