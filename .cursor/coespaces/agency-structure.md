# Agency Coespace Structure

## Overview
This document outlines the coespace structure for managing multiple client projects and agency operations efficiently.

## Coespace Categories

### 1. Client Projects
Each client gets their own dedicated coespace for complete project isolation.

#### Cannabis Industry Clients
- **bcn-buffalo-cannabis-network** - Current BCN WordPress theme project
- **client-cannabis-dispensary-xyz** - Future dispensary client
- **client-cannabis-brands-abc** - Cannabis brand marketing site

#### Other Industry Clients
- **client-restaurant-def** - Restaurant website project
- **client-ecommerce-ghi** - E-commerce platform
- **client-corporate-jkl** - Corporate website

### 2. Agency Operations
Internal coespaces for agency management and development.

#### Development & Infrastructure
- **agency-core-templates** - Reusable WordPress theme templates
- **agency-plugin-development** - Custom plugin development
- **agency-tools-scripts** - Development tools and automation scripts

#### Business Operations
- **agency-proposals-contracts** - Client proposals and contracts
- **agency-marketing** - Agency website and marketing materials
- **agency-finance** - Financial tracking and invoicing

### 3. Learning & Development
- **agency-training** - Team training materials and resources
- **agency-experiments** - Testing new technologies and approaches
- **agency-documentation** - Internal documentation and processes

## Coespace Configuration

Each coespace should include:
- `.cursor/coespace-config.json` - Coespace-specific settings
- `README.md` - Project overview and setup instructions
- `.env.example` - Environment variables template
- `docker-compose.yml` - Local development environment
- `package.json` - Node.js dependencies and scripts
- `composer.json` - PHP dependencies
- `.gitignore` - Git ignore rules
- `deployment/` - Deployment configurations

## Benefits of This Structure

1. **Complete Isolation** - Each client project is completely separate
2. **Resource Management** - Allocate resources per coespace
3. **Team Collaboration** - Share specific coespaces with team members
4. **Version Control** - Independent git repositories per project
5. **Deployment Control** - Separate deployment pipelines
6. **Security** - Client data and code isolation
7. **Scalability** - Easy to add new clients and projects

## Naming Convention

- **Client Projects**: `client-{industry}-{client-name}`
- **Agency Operations**: `agency-{department}-{purpose}`
- **Learning**: `agency-{type}-{subject}`

## Access Control

- **Public Coespaces**: Agency templates and open-source projects
- **Private Coespaces**: Client projects and internal operations
- **Team Coespaces**: Shared with specific team members
- **Admin Coespaces**: Agency management and sensitive operations