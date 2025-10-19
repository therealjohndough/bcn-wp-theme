---
description: Background Agents and async workflows for BCN development
globs: "**/*"
---

## Background Agents Setup

### Agent Types
- **Code Quality Agent**: Runs PHPCS, ESLint, Prettier on file changes
- **Performance Agent**: Monitors Lighthouse scores, bundle sizes, Core Web Vitals
- **Security Agent**: Scans for vulnerabilities, checks dependencies, validates inputs
- **Deployment Agent**: Handles staging/prod deployments, rollbacks, health checks
- **Content Agent**: Manages ACF field updates, content migrations, SEO optimization

### Agent Triggers
- File changes (watch mode)
- Git commits/pushes
- Scheduled intervals (daily/weekly)
- Manual triggers via Cursor commands
- Webhook events from external services

### Agent Communication
- Use `.cursor/agents/` directory for agent configs
- Agents communicate via JSON files in `.cursor/agents/status/`
- Log all agent activities to `.cursor/agents/logs/`
- Use GitHub Issues for agent-generated tasks

## Async Code Operations

### File Watching
- Watch `assets/` for CSS/JS changes → auto-compile/minify
- Watch `template-parts/` for PHP changes → run syntax checks
- Watch `includes/` for function changes → update documentation
- Watch `acf-json/` for field changes → sync to database

### Background Tasks
- Image optimization on upload
- Database query optimization
- Cache warming after deployments
- SEO audit and recommendations
- Performance monitoring and alerts

### Integration Points
- GitHub Actions for CI/CD
- Slack/Discord for notifications
- WordPress REST API for content updates
- External APIs for third-party services