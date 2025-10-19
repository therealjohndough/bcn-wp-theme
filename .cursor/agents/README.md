# 🤖 BCN Background Agents

This directory contains background agents for automated development workflows, code quality monitoring, and content management.

## 🚀 Quick Start

```bash
# Run all agents
./.cursor/agents/scripts/agent-runner.sh

# Watch for file changes and run agents automatically
./.cursor/agents/scripts/agent-runner.sh watch

# Check agent status
./.cursor/agents/scripts/agent-runner.sh status

# View recent logs
./.cursor/agents/scripts/agent-runner.sh logs
```

## 🤖 Available Agents

### 1. **Code Quality Agent**
- **Triggers**: File changes, pre-commit
- **Tasks**: PHPCS, ESLint, Prettier
- **Output**: `.cursor/agents/logs/code-quality.log`

### 2. **Performance Agent**
- **Triggers**: Post-deploy, scheduled (daily)
- **Tasks**: Lighthouse audits, page speed checks
- **Output**: `.cursor/agents/reports/lighthouse-*.json`

### 3. **Security Agent**
- **Triggers**: File changes, daily
- **Tasks**: Composer audit, npm audit, WP-CLI checks
- **Output**: `.cursor/agents/logs/security.log`

### 4. **Deployment Agent**
- **Triggers**: Manual, GitHub webhook
- **Tasks**: Automated deployments, rollbacks, health checks
- **Environments**: Staging, Production

### 5. **Content Agent**
- **Triggers**: ACF changes, content updates
- **Tasks**: ACF sync, SEO audit, content migration
- **Output**: `.cursor/agents/logs/content.log`

## 📊 Monitoring & Reports

### Performance Monitoring
```bash
# Run performance audit
./.cursor/agents/scripts/performance-monitor.sh

# Check specific environment
./.cursor/agents/scripts/performance-monitor.sh staging
```

### Deployment Management
```bash
# Deploy to staging
./.cursor/agents/scripts/deployment-agent.sh deploy staging

# Check deployment status
./.cursor/agents/scripts/deployment-agent.sh status staging

# Rollback if needed
./.cursor/agents/scripts/deployment-agent.sh rollback staging
```

### Content Management
```bash
# Sync ACF fields
./.cursor/agents/scripts/content-agent.sh sync-acf

# Run SEO audit
./.cursor/agents/scripts/content-agent.sh seo-audit

# Optimize images
./.cursor/agents/scripts/content-agent.sh optimize-images

# Run all content tasks
./.cursor/agents/scripts/content-agent.sh all
```

## ⚙️ Configuration

Edit `.cursor/agents/config.json` to customize:
- Agent triggers and schedules
- Environment settings
- Notification preferences
- Logging levels

## 📁 Directory Structure

```
.cursor/agents/
├── config.json              # Agent configuration
├── scripts/                 # Agent scripts
│   ├── agent-runner.sh      # Main agent runner
│   ├── performance-monitor.sh
│   ├── deployment-agent.sh
│   └── content-agent.sh
├── logs/                    # Agent logs
├── status/                  # Agent status files
├── reports/                 # Generated reports
└── README.md               # This file
```

## 🔧 Dependencies

### Required Tools
- **PHPCS**: `composer global require squizlabs/php_codesniffer`
- **ESLint**: `npm install -g eslint`
- **Prettier**: `npm install -g prettier`
- **Lighthouse**: `npm install -g lighthouse`
- **jq**: `brew install jq` (for JSON processing)

### Optional Tools
- **fswatch**: `brew install fswatch` (for file watching)
- **inotifywait**: `sudo apt-get install inotify-tools` (Linux file watching)

## 🚨 Troubleshooting

### Agent Not Running
1. Check if dependencies are installed
2. Verify file permissions: `chmod +x .cursor/agents/scripts/*.sh`
3. Check logs: `tail -f .cursor/agents/logs/agent-runner.log`

### Performance Issues
1. Check Lighthouse scores in reports
2. Review page load times
3. Verify Core Web Vitals

### Deployment Failures
1. Check SSH keys and credentials
2. Verify environment configurations
3. Review deployment logs

## 📈 Benefits

- **Automated Quality**: Continuous code quality monitoring
- **Performance Tracking**: Regular Lighthouse audits and optimization
- **Security Monitoring**: Automated vulnerability scanning
- **Content Management**: ACF sync and SEO optimization
- **Deployment Automation**: One-click staging and production deployments

## 🔄 Integration

These agents integrate with:
- **GitHub Actions**: CI/CD pipeline
- **WordPress**: ACF, WP-CLI, custom post types
- **SiteGround**: SSH deployment
- **Monitoring**: Performance and health checks

---

**Ready to automate your BCN development workflow!** 🎉