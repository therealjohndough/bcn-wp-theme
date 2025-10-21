#!/bin/bash

# Create Client Coespace Script
# Usage: ./create-client-coespace.sh "Client Name" "Industry" "Project Description"

set -e

# Check if required arguments are provided
if [ $# -lt 3 ]; then
    echo "Usage: $0 \"Client Name\" \"Industry\" \"Project Description\""
    echo "Example: $0 \"Green Valley Dispensary\" \"cannabis\" \"E-commerce website for cannabis dispensary\""
    exit 1
fi

CLIENT_NAME="$1"
INDUSTRY="$2"
PROJECT_DESCRIPTION="$3"

# Convert client name to coespace format
COESPACE_NAME=$(echo "$CLIENT_NAME" | tr '[:upper:]' '[:lower:]' | sed 's/ /-/g')
COESPACE_DIR="client-${INDUSTRY}-${COESPACE_NAME}"

echo "Creating coespace: $COESPACE_DIR"

# Create coespace directory
mkdir -p ".cursor/coespaces/$COESPACE_DIR"

# Copy template files
cp -r ".cursor/coespaces/client-template/"* ".cursor/coespaces/$COESPACE_DIR/"

# Generate coespace configuration
cat > ".cursor/coespaces/$COESPACE_DIR/coespace-config.json" << EOF
{
  "coespace": {
    "name": "$CLIENT_NAME",
    "type": "client-project",
    "industry": "$INDUSTRY",
    "client": "$CLIENT_NAME",
    "description": "$PROJECT_DESCRIPTION",
    "status": "planning",
    "priority": "medium"
  },
  "team": {
    "owner": "agency-admin",
    "collaborators": [],
    "access_level": "full"
  },
  "technology": {
    "platform": "wordpress",
    "php_version": "8.1",
    "wordpress_version": "6.4+",
    "theme_framework": "custom",
    "plugins": [],
    "build_tools": ["webpack", "sass", "babel"]
  },
  "development": {
    "local_url": "http://localhost:8080",
    "staging_url": "",
    "production_url": "",
    "database": "mysql",
    "cache": "redis"
  },
  "deployment": {
    "provider": "siteground",
    "method": "rsync",
    "branch": "main",
    "auto_deploy": false,
    "backup_strategy": "daily"
  },
  "budget": {
    "estimated_hours": 0,
    "hourly_rate": 150,
    "total_budget": 0,
    "spent_hours": 0,
    "remaining_budget": 0
  },
  "timeline": {
    "start_date": "$(date +%Y-%m-%d)",
    "launch_date": "",
    "maintenance_start": "",
    "maintenance_end": ""
  }
}
EOF

# Create project README
cat > ".cursor/coespaces/$COESPACE_DIR/README.md" << EOF
# $CLIENT_NAME Project

## Project Overview
**Industry:** $INDUSTRY  
**Description:** $PROJECT_DESCRIPTION  
**Status:** Planning  
**Created:** $(date)

## Technology Stack
- WordPress 6.4+
- PHP 8.1
- Custom Theme Framework
- Webpack, Sass, Babel

## Development Setup

### Prerequisites
- Docker and Docker Compose
- Node.js 16+
- PHP 8.1+

### Local Development
1. Copy environment template:
   \`\`\`bash
   cp .env.example .env
   \`\`\`

2. Start development environment:
   \`\`\`bash
   docker compose up --build
   \`\`\`

3. Access the site at http://localhost:8080

### Project Structure
\`\`\`
$COESPACE_DIR/
├── assets/
├── includes/
├── template-parts/
├── .env.example
├── docker-compose.yml
├── package.json
├── composer.json
└── README.md
\`\`\`

## Deployment
- **Staging:** TBD
- **Production:** TBD
- **Provider:** SiteGround
- **Method:** rsync

## Team
- **Owner:** agency-admin
- **Collaborators:** TBD

## Budget & Timeline
- **Estimated Hours:** TBD
- **Hourly Rate:** \$150
- **Total Budget:** TBD
- **Start Date:** $(date +%Y-%m-%d)
- **Launch Date:** TBD

## Notes
- Add project-specific notes here
- Track important decisions and changes
- Document any special requirements
EOF

# Create .env.example
cat > ".cursor/coespaces/$COESPACE_DIR/.env.example" << EOF
# WordPress Database
WORDPRESS_DB_HOST=db
WORDPRESS_DB_NAME=wordpress
WORDPRESS_DB_USER=wordpress
WORDPRESS_DB_PASSWORD=wordpress

# MySQL Database
MYSQL_ROOT_PASSWORD=ChangeMe
MYSQL_DATABASE=wordpress
MYSQL_USER=wordpress
MYSQL_PASSWORD=wordpress

# WordPress Configuration
WORDPRESS_DEBUG=1
WORDPRESS_CONFIG_EXTRA=define('WP_DEBUG_LOG', true);

# Project Specific
PROJECT_NAME=$CLIENT_NAME
PROJECT_INDUSTRY=$INDUSTRY
EOF

# Create docker-compose.yml
cat > ".cursor/coespaces/$COESPACE_DIR/docker-compose.yml" << EOF
version: '3.8'

services:
  db:
    image: mysql:8.0
    container_name: ${COESPACE_NAME}_db
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: \${MYSQL_ROOT_PASSWORD}
      MYSQL_DATABASE: \${MYSQL_DATABASE}
      MYSQL_USER: \${MYSQL_USER}
      MYSQL_PASSWORD: \${MYSQL_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"

  wordpress:
    image: wordpress:6.4-php8.1-apache
    container_name: ${COESPACE_NAME}_wordpress
    restart: unless-stopped
    ports:
      - "8080:80"
    environment:
      WORDPRESS_DB_HOST: db:3306
      WORDPRESS_DB_USER: \${WORDPRESS_DB_USER}
      WORDPRESS_DB_PASSWORD: \${WORDPRESS_DB_PASSWORD}
      WORDPRESS_DB_NAME: \${WORDPRESS_DB_NAME}
      WORDPRESS_DEBUG: \${WORDPRESS_DEBUG}
    volumes:
      - ./:/var/www/html/wp-content/themes/$COESPACE_NAME
      - wp_data:/var/www/html
    depends_on:
      - db

volumes:
  db_data:
  wp_data:
EOF

# Create package.json
cat > ".cursor/coespaces/$COESPACE_DIR/package.json" << EOF
{
  "name": "$COESPACE_NAME",
  "version": "1.0.0",
  "description": "$PROJECT_DESCRIPTION",
  "main": "index.js",
  "scripts": {
    "dev": "webpack --mode development --watch",
    "build": "webpack --mode production",
    "test": "jest",
    "lint": "eslint assets/js/ --ext .js",
    "lint:fix": "eslint assets/js/ --ext .js --fix",
    "format": "prettier --write .",
    "phpcs": "phpcs --standard=WordPress .",
    "phpcbf": "phpcbf --standard=WordPress .",
    "quality": "npm run lint && npm run phpcs",
    "quality:fix": "npm run lint:fix && npm run phpcbf"
  },
  "keywords": [
    "wordpress",
    "theme",
    "$INDUSTRY",
    "$COESPACE_NAME"
  ],
  "author": "Agency Name",
  "license": "GPL-2.0-or-later",
  "devDependencies": {
    "@babel/core": "^7.23.0",
    "@babel/preset-env": "^7.23.0",
    "babel-loader": "^9.1.3",
    "clean-webpack-plugin": "^4.0.0",
    "copy-webpack-plugin": "^11.0.0",
    "css-loader": "^6.8.1",
    "css-minimizer-webpack-plugin": "^5.0.1",
    "eslint": "^8.52.0",
    "jest": "^29.7.0",
    "mini-css-extract-plugin": "^2.7.6",
    "postcss": "^8.4.31",
    "postcss-loader": "^7.3.3",
    "prettier": "^3.0.3",
    "sass": "^1.69.5",
    "sass-loader": "^13.3.2",
    "terser-webpack-plugin": "^5.3.9",
    "webpack": "^5.89.0",
    "webpack-cli": "^5.1.4"
  },
  "dependencies": {
    "jquery": "^3.7.1"
  },
  "browserslist": [
    "> 1%",
    "last 2 versions",
    "not dead"
  ],
  "engines": {
    "node": ">=16.0.0",
    "npm": ">=8.0.0"
  }
}
EOF

# Create composer.json
cat > ".cursor/coespaces/$COESPACE_DIR/composer.json" << EOF
{
  "name": "agency/$COESPACE_NAME",
  "description": "$PROJECT_DESCRIPTION",
  "type": "wordpress-theme",
  "license": "GPL-2.0-or-later",
  "authors": [
    {
      "name": "Agency Name",
      "email": "dev@agency.com"
    }
  ],
  "require": {
    "php": ">=8.1"
  },
  "require-dev": {
    "phpunit/phpunit": "^10.0",
    "squizlabs/php_codesniffer": "^3.7",
    "wp-coding-standards/wpcs": "^3.0",
    "phpstan/phpstan": "^1.10"
  },
  "autoload": {
    "psr-4": {
      "Agency\\\\$COESPACE_NAME\\\\": "includes/"
    }
  },
  "scripts": {
    "test": "phpunit",
    "phpcs": "phpcs --standard=WordPress .",
    "phpcbf": "phpcbf --standard=WordPress .",
    "phpstan": "phpstan analyse"
  }
}
EOF

# Create .gitignore
cat > ".cursor/coespaces/$COESPACE_DIR/.gitignore" << EOF
# WordPress
wp-config.php
wp-content/uploads/
wp-content/cache/
wp-content/backup-db/
wp-content/advanced-cache.php
wp-content/wp-cache-config.php

# Environment
.env
.env.local
.env.production

# Dependencies
node_modules/
vendor/

# Build
dist/
build/

# IDE
.vscode/
.idea/
*.swp
*.swo

# OS
.DS_Store
Thumbs.db

# Logs
*.log
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Runtime data
pids
*.pid
*.seed
*.pid.lock

# Coverage directory used by tools like istanbul
coverage/

# Dependency directories
jspm_packages/

# Optional npm cache directory
.npm

# Optional REPL history
.node_repl_history

# Output of 'npm pack'
*.tgz

# Yarn Integrity file
.yarn-integrity

# dotenv environment variables file
.env

# next.js build output
.next

# Nuxt.js build output
.nuxt

# vuepress build output
.vuepress/dist

# Serverless directories
.serverless

# FuseBox cache
.fusebox/

# DynamoDB Local files
.dynamodb/

# TernJS port file
.tern-port
EOF

echo "✅ Coespace created successfully!"
echo "📁 Location: .cursor/coespaces/$COESPACE_DIR"
echo "🚀 Next steps:"
echo "   1. cd .cursor/coespaces/$COESPACE_DIR"
echo "   2. cp .env.example .env"
echo "   3. docker compose up --build"
echo "   4. Start developing!"