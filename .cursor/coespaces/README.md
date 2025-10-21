# Agency Coespace Management System

## What is a Coespace?

A **Coespace** in Cursor is an isolated development environment that allows you to:

- **Separate different projects or clients** - Each coespace has its own codebase, dependencies, and configurations
- **Collaborate with team members** - Share coespaces with specific people for collaborative development
- **Maintain different contexts** - Keep agency work, client projects, and personal projects completely separate
- **Manage resources efficiently** - Each coespace can have its own resource allocation and settings

## Quick Start

### 1. List All Coespaces
```bash
./.cursor/coespaces/scripts/coespace-manager.sh list
```

### 2. Start a Coespace
```bash
./.cursor/coespaces/scripts/coespace-manager.sh start bcn-buffalo-cannabis-network
```

### 3. Create a New Client Coespace
```bash
./.cursor/coespaces/scripts/coespace-manager.sh create "Client Name" "industry" "Project description"
```

## Coespace Structure

### Client Projects
Each client gets their own dedicated coespace:

```
.cursor/coespaces/
├── bcn-buffalo-cannabis-network/          # Current BCN project
├── client-cannabis-dispensary-xyz/        # Future dispensary client
├── client-restaurant-def/                 # Restaurant website
└── client-ecommerce-ghi/                  # E-commerce platform
```

### Agency Operations
Internal coespaces for agency management:

```
.cursor/coespaces/
├── agency-core-templates/                 # Reusable templates
├── agency-plugin-development/             # Custom plugins
├── agency-tools-scripts/                  # Development tools
├── agency-proposals-contracts/            # Business documents
└── agency-marketing/                      # Agency website
```

## Coespace Configuration

Each coespace includes:

- **`coespace-config.json`** - Coespace metadata and settings
- **`README.md`** - Project overview and setup instructions
- **`.env.example`** - Environment variables template
- **`docker-compose.yml`** - Local development environment
- **`package.json`** - Node.js dependencies and scripts
- **`composer.json`** - PHP dependencies
- **`.gitignore`** - Git ignore rules

## Available Commands

### List Coespaces
```bash
./.cursor/coespaces/scripts/coespace-manager.sh list
```

### Show Coespace Details
```bash
./.cursor/coespaces/scripts/coespace-manager.sh show <coespace-name>
```

### Start Development Environment
```bash
./.cursor/coespaces/scripts/coespace-manager.sh start <coespace-name>
```

### Stop Development Environment
```bash
./.cursor/coespaces/scripts/coespace-manager.sh stop <coespace-name>
```

### Deploy Coespace
```bash
./.cursor/coespaces/scripts/coespace-manager.sh deploy <coespace-name> [staging|production]
```

### Create New Coespace
```bash
./.cursor/coespaces/scripts/coespace-manager.sh create "Client Name" "industry" "Project description"
```

## Benefits

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

## Getting Started with Your First Coespace

1. **Create a new client coespace:**
   ```bash
   ./.cursor/coespaces/scripts/coespace-manager.sh create "Green Valley Dispensary" "cannabis" "E-commerce website for cannabis dispensary"
   ```

2. **Navigate to the coespace:**
   ```bash
   cd .cursor/coespaces/client-cannabis-green-valley-dispensary
   ```

3. **Set up the environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your specific settings
   ```

4. **Start development:**
   ```bash
   docker compose up --build
   ```

5. **Access your site:**
   Open http://localhost:8080 in your browser

## Troubleshooting

### Common Issues

1. **Port conflicts**: Change the port in docker-compose.yml if 8080 is in use
2. **Permission issues**: Make sure scripts are executable with `chmod +x`
3. **Docker issues**: Ensure Docker is running and you have sufficient resources
4. **Dependencies**: Run `npm install` and `composer install` in the coespace directory

### Getting Help

- Check the coespace-specific README.md
- Review the coespace-config.json for settings
- Check Docker logs: `docker compose logs -f`
- Verify environment variables in .env file

## Best Practices

1. **Always use the coespace manager scripts** for consistency
2. **Keep coespace configurations up to date** as projects evolve
3. **Use descriptive names** for coespaces
4. **Document project-specific requirements** in README.md
5. **Regularly backup important coespace data**
6. **Clean up unused coespaces** to save resources

## Integration with Cursor

This coespace system is designed to work seamlessly with Cursor's built-in coespace features:

- Each coespace can be opened as a separate Cursor workspace
- Team members can be invited to specific coespaces
- Resources can be allocated per coespace
- Settings and extensions can be coespace-specific

## Support

For issues or questions about the coespace system:

1. Check this documentation first
2. Review the coespace-specific README
3. Check the coespace configuration
4. Contact the development team