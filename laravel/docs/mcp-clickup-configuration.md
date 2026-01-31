# ClickUp MCP Server Configuration

**Last Updated**: 31 Gennaio 2026
**Status**: ✅ Configured
**MCP Server URL**: `https://mcp.clickup.com/mcp`

---

## 📋 Overview

ClickUp MCP Server provides Model Context Protocol integration for ClickUp Workspace, enabling AI assistants to:
- **Orchestrate task workflows** - Manage tasks with assignees, priorities, and due dates
- **Build executive reports** - Create release notes, status updates, and portfolio summaries
- **Track time** - Log time entries and manage timers
- **Answer work questions** - Search tasks, docs, and comments
- **Collaborate in comments and chat** - Summarize threads, extract action items

### Supported MCP Clients

ClickUp MCP supports all major MCP clients (vetted allowlist):
- **ChatGPT** ✅
- **Civic** ✅
- **Claude Desktop** ✅
- **Claude Code** ✅
- **Code Rabbit** ✅
- **Cursor** ✅
- **Glean** ✅
- **Make** ✅
- **Poke.com** ✅
- **Shortwave** ✅
- **tasklet.ai** ✅
- **VS Code** ✅
- **Windsurf** ✅
- **Antigravity** ✅

---

## 🔧 Configuration Files

### Claude Desktop (.mcp.json)

```json
{
  "mcpServers": {
    "clickup": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://mcp.clickup.com/mcp"]
    }
  }
}
```

**Location**: `/var/www/_bases/base_laravelpizza/laravel/.mcp.json`

### Cursor Editor (.cursor-mcp.json)

```json
{
  "mcpServers": {
    "clickup": {
      "url": "https://mcp.clickup.com/mcp"
    }
  }
}
```

**Location**: `/var/www/_bases/base_laravelpizza/laravel/.cursor-mcp.json`

### Windsurf Editor (.windsurf-mcp.json)

```json
{
  "mcpServers": {
    "clickup": {
      "serverUrl": "https://mcp.clickup.com/mcp"
    }
  }
}
```

**Location**: `/var/www/_bases/base_laravelpizza/laravel/.windsurf-mcp.json`

### Antigravity Editor (.antigravity-mcp.json)

```json
{
  "mcpServers": {
    "clickup": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://mcp.clickup.com/mcp"]
    }
  }
}
```

**Location**: `/var/www/_bases/base_laravelpizza/laravel/.antigravity-mcp.json`

---

## 🔑 Authentication

### OAuth Flow Only

⚠️ **Important**: ClickUp MCP only supports OAuth authentication. API keys and Auth tokens are NOT supported.

1. Configure MCP server URL: `https://mcp.clickup.com/mcp`
2. Launch your MCP client
3. Prompted to authenticate with ClickUp
4. Select your ClickUp Workspace
5. Click "Connect"

### Rate Limits

MCP wraps around ClickUp's existing API and falls under the same limits.

---

## 🛠️ Usage Examples

### Task Management

```bash
# Create task in specific list
"Create a task in 'Development' list: 'Implement PHPStan Level 10 fixes for Seo module'"

# Update task status
"Update task 'Implement PHPStan Level 10 fixes' status to 'In Progress'"

# Search tasks
"Find all tasks assigned to me due this week"

# Build executive report
"Create a status summary of all tasks in 'LaravelPizza' workspace"
```

### Time Tracking

```bash
# Log time
"Log 2 hours on task 'Implement PHPStan Level 10 fixes'"

# Start timer
"Start timer for task 'Refactor Xot base classes'"
```

### Documentation & Collaboration

```bash
# Search docs
"Find all docs mentioning 'Laravel' in the workspace"

# Summarize comments
"Summarize all comments on task 'Implement Filament v5 migration'"

# Extract action items
"Extract action items from the meeting notes in 'Team Sync' doc"
```

---

## 📊 Integration with Modules

### Xot Module
```bash
# Create tasks for Xot improvements
"Create task in 'Xot Development' space: 'Document all Xot base classes'"

# Track Filament v5 migration
"Create task: 'Migrate Xot module to Filament v5'"
```

### User Module
```bash
# Track authentication features
"Create task: 'Implement two-factor authentication in User module'"

# Monitor security tasks
"Create task: 'Audit RBAC policies for security vulnerabilities'"
```

### Meetup Module
```bash
# Event management
"Create task in 'Events' list: 'Set up Laravel February meetup'"

# RSVP tracking
"Create task: 'Implement waitlist for sold-out events'"
```

---

## 🌟 Available Tools (Dynamic)

Use `tools/list` command to discover available tools:

- **Task Operations**: Create, update, search, move tasks
- **List Management**: Manage lists and folders
- **Time Tracking**: Log time, start/stop timers
- **Doc Operations**: Read, search, update docs
- **Comments**: Read, create, summarize comments
- **Space Operations**: Navigate workspace hierarchy

---

## 🔌 Editor-Specific Setup

### Claude Desktop

**Pro, Team, Enterprise**:
1. Navigate to Settings
2. Scroll to Connectors
3. Click Add
4. Name: ClickUp
5. Remote MCP Server URL: `https://mcp.clickup.com/mcp`

**Free**:
1. Go to Claude desktop settings
2. Click Developer section
3. Edit `claude_desktop_config.json`
4. Add ClickUp configuration
5. Restart Claude desktop

### Cursor

1. Go to Settings > MCP
2. Click Add Server
3. Add to `mcp.json`:
```json
"clickup": {
  "url": "https://mcp.clickup.com/mcp"
}
```

### Windsurf

1. Press Ctrl+, (Windows) or Cmd+, (Mac)
2. Scroll to Cascade
3. Click MCP servers
4. Add custom server
5. Paste JSON configuration

### Antigravity

1. Open Settings
2. Navigate to MCP Servers
3. Add ClickUp server
4. Configure OAuth authentication

---

## 🚫 Limitations

### No Deletion Tools

For safety reasons, deletion tools are NOT currently available through ClickUp MCP.

### Connected Search Not Supported

Cannot search connected apps through ClickUp MCP.

---

## 📝 Best Practices

1. **Task Naming**:
   ```
   "[Module] Implement {feature}"
   "[Module] Fix {issue}"
   "[Module] Document {component}"
   ```

2. **Space Organization**:
   - Create dedicated spaces for each module
   - Use folders for categorization
   - Maintain consistent naming conventions

3. **Tags**:
   - `high-priority`
   - `phpstan-compliance`
   - `testing`
   - `documentation`

4. **Custom Fields**:
   - Module name
   - Priority level
   - PHPStan status
   - Test coverage

---

## 🐛 Troubleshooting

### Common Issues

**OAuth Fails**:
```bash
# Clear authentication cache
# Re-authenticate with ClickUp
# Check workspace permissions
```

**Server Not Responding**:
- Verify MCP server URL
- Check network connectivity
- Ensure client is on vetted list

**Tools Not Listed**:
- Use `tools/list` command
- Verify workspace permissions
- Check MCP client version

### Getting Help

- **ClickUp Support**: Contact for MCP-specific issues
- **Community Forum**: https://community.clickup.com
- **Documentation**: https://developer.clickup.com/docs/mcp-server

---

## 📚 Related Documentation

- [ClickUp MCP Official Docs](https://developer.clickup.com/docs/connect-an-ai-assistant-to-clickups-mcp-server)
- [MCP Protocol Specification](https://modelcontextprotocol.io)
- [Asana MCP Configuration](./mcp-asana-configuration.md)
- [Redmine MCP Configuration](./mcp-redmine-configuration.md)

---

## 🔄 Updates

- **2026-01-31**: Initial configuration for base_laravelpizza project
- **Supported Editors**: Claude, Cursor, Windsurf, Antigravity
- **MCP Server**: ClickUp Workspace (Public Beta)
- **Features**: Task management, time tracking, doc collaboration

---

**Maintained by**: Laraxot Team
**Documentation Version**: 1.0.0
**Last Review**: 31 Gennaio 2026