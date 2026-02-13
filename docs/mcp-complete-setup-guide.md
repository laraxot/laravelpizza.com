# MCP Complete Setup Guide - LaravelPizza Project

**Versione**:
**Data**:
**Status**: ✅ Configurato

---

## 📋 Indice

1. [Overview](#overview)
2. [MCP Servers Configured](#mcp-servers-configured)
3. [Environment-Specific Setup](#environment-specific-setup)
4. [Available MCP Integrations](#available-mcp-integrations)
5. [Usage Examples](#usage-examples)
6. [Troubleshooting](#troubleshooting)

---

## Overview

LaravelPizza project has comprehensive MCP (Model Context Protocol) configuration for multiple project management platforms:

### Configured Platforms

- ✅ **Asana** - Task management, project tracking, team collaboration
- ✅ **ClickUp** - Task orchestration, time tracking, work management
- ✅ **GitHub** - PR reviews, issue management, code automation
- ✅ **Filesystem** - Project file access
- ✅ **Database** - SQLite database queries

### Target Environments

- ✅ **iFlow CLI** - Primary AI assistant (current environment)
- ✅ **Cursor** - AI-powered code editor
- ✅ **Windsurf** - AI IDE
- ✅ **Antigravity** - Custom AI agent
- ✅ **Claude** - Anthropic's AI assistant
- ✅ **ChatGPT** - OpenAI's AI assistant

---

## MCP Servers Configured

### 1. Asana MCP Server

**Purpose**: Task management, project tracking, team collaboration

**Server URL**: `https://mcp.asana.com/sse`

**Features**:
- ✅ Task creation and management
- ✅ Project tracking and status updates
- ✅ Team collaboration
- ✅ Goal management
- ✅ Search and discovery
- ✅ Analytics and reporting

**Beta Status**: Asana MCP is in beta (experimental)

### 2. ClickUp MCP Server

**Purpose**: Task orchestration, time tracking, work management

**Server URL**: `https://mcp.clickup.com/mcp`

**Features**:
- ✅ Task orchestration with assignees, priorities, due dates
- ✅ Executive reports (release notes, status updates, portfolio summaries)
- ✅ Time tracking and timer management
- ✅ Work questions (search tasks, docs, comments)
- ✅ Comments and chat collaboration
- ✅ Natural language interactions

**Beta Status**: ClickUp MCP is in public beta

**Plan Availability**: Available on all plans

**Deletion**: No deletion tools available (safety measure)

### 3. GitHub MCP Server

**Purpose**: PR reviews, issue management, code automation

**Server URL**: `https://api.githubcopilot.com/mcp/`

**Features**:
- ✅ Pull request reviews
- ✅ Issue management
- ✅ Code automation
- ✅ Repository analytics
- ✅ Collaboration features

### 4. Filesystem MCP Server

**Purpose**: Access to project files

**Command**: `npx -y @modelcontextprotocol/server-filesystem`

**Features**:
- ✅ File read/write operations
- ✅ Directory listing
- ✅ Project file access
- ✅ Config file management

**Path**: `/var/www/_bases/base_laravelpizza/laravel`

### 5. Database MCP Server

**Purpose**: Direct database queries

**Command**: `npx -y @bytebase/dbhub`

**Database**: SQLite (`/var/www/_bases/base_laravelpizza/laravel/database/database.sqlite`)

**Features**:
- ✅ Schema inspection
- ✅ Analytics queries
- ✅ Debugging support
- ✅ Direct SQL execution

---

## Environment-Specific Setup

### 1. iFlow CLI (Current Environment)

✅ **Already Configured**

**Configuration File**: `/var/www/_bases/base_laravelpizza/laravel/.mcp.json`

```json
{
  "mcpServers": {
    "filesystem": {...},
    "database": {...},
    "github": {...},
    "asana": {...},
    "clickup": {...}
  }
}
```

### 2. Cursor Editor

✅ **Configuration File**: `/var/www/_bases/base_laravelpizza/laravel/.cursor-mcp.json`

```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"]
    },
    "clickup": {
      "url": "https://mcp.clickup.com/mcp"
    }
  }
}
```

**Setup Instructions**:

1. Open Cursor settings ("Settings" > "Cursor Settings")
2. Navigate to "MCP" section
3. Import the `.cursor-mcp.json` file
4. Authenticate with Asana and ClickUp

**Troubleshooting**:
```bash
# Clear MCP auth cache if needed
rm -rf ~/.mcp-auth
```

### 3. Windsurf Editor

✅ **Configuration File**: `/var/www/_bases/base_laravelpizza/laravel/.windsurf-mcp.json`

```json
{
  "mcpServers": {
    "asana": {
      "serverUrl": "https://mcp.asana.com/sse"
    },
    "clickup": {
      "serverUrl": "https://mcp.clickup.com/mcp"
    }
  }
}
```

**Setup Instructions**:

1. Press `Ctrl + ,` (Windows) or `Cmd + ,` (Mac)
2. Scroll to "Cascade" section
3. Click "MCP servers"
4. Click "Add Server" → "Add custom server"
5. Import the `.windsurf-mcp.json` file
6. Authenticate when prompted

### 4. Antigravity AI Agent

✅ **Configuration File**: `/var/www/_bases/base_laravelpizza/laravel/.antigravity-mcp.json`

```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"]
    },
    "clickup": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.clickup.com/mcp"]
    }
  }
}
```

**Setup Instructions**:

1. Configure Antigravity to use `.antigravity-mcp.json`
2. Ensure NPM is available in environment
3. Configure OAuth flow for Asana and ClickUp
4. Test connection

### 5. Claude Desktop

**Pro/Team/Enterprise**:

1. Navigate to Settings
2. Scroll to "Connectors" at bottom
3. Click "Add"
4. Enter:
   - Name: Asana
   - Remote MCP Server URL: `https://mcp.asana.com/sse`
5. Repeat for ClickUp:
   - Name: ClickUp
   - Remote MCP Server URL: `https://mcp.clickup.com/mcp`

**Free Plan**:

1. Go to Claude desktop settings
2. Click "Developer" section
3. Click "edit config"
4. Open `claude_desktop_config.json`
5. Add:
```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://mcp.asana.com/sse"]
    },
    "clickup": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://mcp.clickup.com/mcp"]
    }
  }
}
```
6. Restart Claude desktop app

**Claude Code**:

```bash
claude mcp add --transport http asana https://mcp.asana.com/sse
claude mcp add --transport http clickup https://mcp.clickup.com/mcp
```

### 6. ChatGPT

**Team/Enterprise/Edu**:

1. Navigate to **Settings** → **Connectors**
2. Add custom connector with URL: `https://mcp.clickup.com/mcp`
3. Use with **Deep Research** tool
4. Add as source in Deep Research

**Developer Mode (Custom Connector)**:

1. Navigate to Settings → **Apps and Connectors**
2. Scroll to bottom, enable **Developer Mode**
3. Return to Apps and Connectors
4. Click **Create** → select **ClickUp**
5. Set MCP Server URL: `https://mcp.clickup.com/mcp`
6. Set Authentication to **OAuth**
7. Check "I understand and want to continue"
8. Complete authentication (select workspace, click Connect)
9. Click **Plus** button → **More** → select custom connector

---

## Available MCP Integrations

### Redmine Integration

**Note**: Redmine does not have native MCP server support yet.

**Alternative**: Use Redmine REST API for integration

**REST API Features**:
- ✅ Multiple projects support
- ✅ Flexible issue tracking system
- ✅ Role-based access control
- ✅ Gantt chart and calendar
- ✅ News, documents & files management
- ✅ Wiki and forums
- ✅ Time tracking
- ✅ Custom fields
- ✅ SCM integration (SVN, CVS, Git, Mercurial, Bazaar)
- ✅ Multiple databases support

**Integration Approach**:
1. Use Filesystem MCP to read Redmine configuration
2. Use Database MCP to query Redmine database
3. Create custom integration scripts
4. Use GitHub MCP to sync with repositories

**Future**: Monitor for Redmine MCP server availability

---

## Usage Examples

### Asana MCP Examples

```
# Task Management
"Find all my incomplete tasks due this week in the Xot project"
"Create a new task 'Complete Safe Functions' in the Development project assigned to me"
"List all sections in the User module project"
"Show me the status of the Q1 planning project"

# Project Management
"Generate a summary report of all completed tasks this month"
"Create a project summary for the Xot core framework"
"List all teams and their members"
```

### ClickUp MCP Examples

```
# Task Orchestration
"Find all tasks assigned to me due this week"
"Create a new task in the Development list with high priority"
"Update task status to 'In Progress' and add comment"

# Executive Reports
"Generate release notes for v1.2.0"
"Create a status update for the Q1 roadmap"
"Summarize portfolio performance across all projects"

# Time Tracking
"Log 2 hours for task 'Fix PHPStan errors'"
"Show me all time entries this week"
"Start a timer for current task"

# Work Questions
"Search for tasks related to 'Safe Functions'"
"Find all docs mentioning 'PHPStan Level 10'"
"Summarize the discussion in task #123"

# Collaboration
"Extract action items from the comments"
"Summarize the thread in task #456"
"Post an update to the team in task #789"
```

### GitHub MCP Examples

```
# PR Reviews
"Review pull request #123"
"Check if PR #456 has conflicts"
"Generate PR description from commits"

# Issue Management
"List all open issues in the User module"
"Create issue for bug found in Job module"
"Update issue #789 status"

# Code Automation
"Generate changelog from recent commits"
"Analyze commit history for this month"
"Create release notes from PRs"
```

### Filesystem MCP Examples

```
# File Operations
"Read the Xot module README"
"List all files in the Activity module docs"
"Update the configuration file"

# Config Management
"Check .env configuration"
"Verify composer.json dependencies"
"List all configuration files"
```

### Database MCP Examples

```
# Schema Inspection
"Show the structure of the users table"
"List all tables in the database"
"Check foreign key constraints"

# Analytics Queries
"Count total number of tasks in the database"
"Find all overdue tasks"
"Generate usage statistics"
```

---

## Troubleshooting

### Authentication Issues

**Asana MCP**:
```bash
# Clear MCP auth cache
rm -rf ~/.mcp-auth

# Re-authenticate with Asana
```

**ClickUp MCP**:
- Ensure OAuth is configured
- Check workspace permissions
- Verify redirect URI is allowlisted

### Connection Issues

**General**:
- Check internet connectivity
- Verify server URLs are correct
- Ensure MCP server is accessible
- Check firewall settings

**Cursor Specific**:
```bash
# Clear auth cache
rm -rf ~/.mcp-auth

# Restart Cursor
```

**Windsurf Specific**:
- Verify MCP server is started
- Check configuration file format
- Restart Windsurf if needed

### Rate Limits

**Asana MCP**:
- Falls under existing API limits
- Implement request throttling
- Cache responses when possible

**ClickUp MCP**:
- Wraps around existing API
- Same limits as API
- Be mindful of LLM call patterns

### Common Errors

**"Internal Server Error"**:
- Clear auth cache
- Re-authenticate
- Check network connectivity

**"invalid_redirect_uri"**:
- Contact platform support
- Register redirect URI
- Check allowlist status

**"Client not found"**:
- Remove and re-add integration
- Re-authenticate
- Check OAuth configuration

---

## Security Considerations

### OAuth Authentication

- ✅ OAuth 2.0 for Asana
- ✅ OAuth 2.1 with PKCE for ClickUp
- ✅ Token-based access
- ✅ Secure token storage
- ✅ Short-lived tokens where applicable

### Data Privacy

- ✅ Encrypted connections (HTTPS)
- ✅ OAuth scope limitations
- ✅ User consent required
- ✅ Data access logging
- ✅ Workspace-level permissions

### Access Control

- ✅ Workspace-level permissions
- ✅ Role-based access control (Redmine)
- ✅ App management (Asana Enterprise+)
- ✅ Allowlist/blocklist support (ClickUp)
- ✅ Admin control over integrations

### Best Practices

1. **Use OAuth**: Always use OAuth authentication
2. **Limit Scope**: Only enable necessary tools
3. **Monitor Access**: Review active integrations regularly
4. **Secure Tokens**: Store tokens securely
5. **Revoke Unused**: Revoke access when no longer needed
6. **Rate Limiting**: Implement request throttling
7. **Caching**: Cache responses when appropriate
8. **Logging**: Monitor and log MCP interactions

---

## Best Practices for AI Agents

### Task Creation

**Asana**:
```
✅ Good:
"Create task 'Implement SafeIntCastAction' in Xot Development project
with high priority, assigned to TBD, due in 3-4 days"

❌ Bad:
"Create task"
```

**ClickUp**:
```
✅ Good:
"Create task in Development list with:
- Name: Implement SafeIntCastAction
- Priority: High
- Assignee: TBD
- Due date: 2026-02-03
- Description: Implement safe integer casting with full type safety"

❌ Bad:
"New task"
```

### Progress Tracking

```
# Update task status
"Mark task 'SafeIntCastAction' as complete in Asana"
"Update ClickUp task #123 status to 'Done'"

# Add comments
"Add comment to task: 'Implementation completed, 
PHPStan Level 10 compliant, 95% test coverage'"
```

### Reporting

```
# Generate reports
"Generate weekly progress report from Asana tasks"
"Create monthly velocity report from ClickUp"
"Summarize all completed tasks this quarter"
```

### Multi-Platform Sync

```
# Sync across platforms
"Create task in Asana and ClickUp for same feature"
"Update task status in both platforms"
"Generate consolidated report from Asana and ClickUp"
```

---

## Integration with LaravelPizza Modules

### Module-Specific Usage

**Xot Module**:
- Track core framework development tasks
- Monitor PHPStan Level 10 compliance
- Manage test coverage goals

**User Module**:
- Track authentication/authorization features
- Manage 2FA implementation tasks
- Monitor session management improvements

**Lang Module**:
- Track translation tasks
- Manage language coverage goals
- Monitor translation quality

**Activity Module**:
- Track event logging features
- Monitor security violation detection
- Manage export system development

**Cms Module**:
- Track content management features
- Monitor Folio + Volt implementation
- Manage block system development

**Geo Module**:
- Track geocoding features
- Monitor routing algorithm improvements
- Manage offline caching implementation

**Job Module**:
- Track queue system improvements
- Monitor job analytics features
- Manage dependency graph implementation

**Media Module**:
- Track file management features
- Monitor video transcoding development
- Manage bulk operations

**Notify Module**:
- Track notification channel features
- Monitor WhatsApp integration
- Manage throttling implementation

**Tenant Module**:
- Track multi-tenancy features
- Monitor onboarding automation
- Manage resource quotas

**Meetup Module**:
- Track event management features
- Monitor calendar widget restoration
- Manage registration system

**Gdpr Module**:
- Track compliance features
- Monitor data export functionality
- Manage consent management

**Seo Module**:
- Track optimization features
- Monitor AI integration
- Manage keyword tracking

**Meetup Theme**:
- Track frontend development tasks
- Monitor Blade template conversion
- Manage API integration

---

## Configuration Files Summary

### File Locations

```
/var/www/_bases/base_laravelpizza/laravel/
├── .mcp.json                  # iFlow CLI (primary)
├── .cursor-mcp.json           # Cursor Editor
├── .windsurf-mcp.json         # Windsurf IDE
└── .antigravity-mcp.json     # Antigravity AI Agent
```

### Documentation Locations

```
/var/www/_bases/base_laravelpizza/docs/
├── mcp-complete-setup-guide.md  # This file
├── mcp-asana-setup.md           # Asana specific guide
└── module-roadmaps-summary.md   # Module roadmaps

/var/www/_bases/base_laravelpizza/laravel/Modules/
├── Xot/docs/mcp-asana-integration.md  # Xot Asana guide
└── [Other modules]/docs/            # Module-specific docs
```

---

## Future Enhancements

### Planned Integrations

1. **Redmine MCP Server** (when available)
   - Wait for Redmine MCP release
   - Integrate REST API in meantime
   - Configure for legacy projects

2. **Automated Task Sync**
   - Sync between Asana and ClickUp
   - Bidirectional task updates
   - Conflict resolution

3. **Smart Task Creation**
   - Auto-generate from roadmap items
   - Create from code comments (TODO, FIXME)
   - Generate from commit messages

4. **Advanced Reporting**
   - Cross-platform consolidated reports
   - Sprint burndown charts
   - Velocity metrics across platforms
   - Portfolio summaries

5. **CI/CD Integration**
   - Update tasks from pipeline status
   - Create tasks from failed builds
   - Complete tasks on successful deployment

---

## Support & Resources

### Documentation

- **Asana MCP**: https://developers.asana.com/docs/using-asanas-mcp-server
- **ClickUp MCP**: https://developer.clickup.com/docs/connect-an-ai-assistant-to-clickups-mcp-server
- **Redmine**: https://www.redmine.org/
- **MCP Protocol**: https://modelcontextprotocol.io/

### Support Channels

- **Asana Support**: Contact for MCP-specific issues
- **ClickUp Support**: Submit feedback for beta
- **Redmine Forums**: Community support
- **Community Forums**: General MCP discussions

### Training

- **Asana Academy**: Learn Asana best practices
- **ClickUp University**: Learn ClickUp features
- **Redmine Books**: Mastering Redmine, Redmine Cookbook
- **MCP Tutorials**: Learn MCP integration patterns

---

**Status**: ✅ Fully Configured
**Last Updated**: 2026-01-31
**Next Review**: 2026-02-28
**Maintained By**: Dev Team
