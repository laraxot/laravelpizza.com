# Asana MCP Server Configuration

**Last Updated**: 31 Gennaio 2026
**Status**: ✅ Configured
**MCP Server URL**: `https://mcp.asana.com/sse`

---

## 📋 Overview

Asana MCP Server provides Model Context Protocol integration for Asana Work Graph, enabling AI assistants to:
- Access Asana data from compatible AI applications
- Create and manage tasks and projects through natural language
- Generate reports and summaries based on Asana data
- Analyze project data and get AI-powered suggestions

### Available Capabilities

Asana's MCP server includes 30+ tools for:
- **Project tracking** and status updates
- **Task creation** and management
- **User information** lookup
- **Goals updates**
- **Team organization**
- **Quick Asana object searching** via typeahead

---

## 🔧 Configuration Files

### Claude Desktop / iFlow CLI (.mcp.json)

```json
{
  "$schema": "https://modelcontextprotocol.io/schema/mcp.json",
  "mcpServers": {
    "asana": {
      "type": "stdio",
      "command": "npx",
      "args": [
        "-y",
        "mcp-remote",
        "https://mcp.asana.com/sse"
      ],
      "description": "Asana Work Graph integration for task management, project tracking, and team collaboration"
    }
  }
}
```

**Location**: `/var/www/_bases/base_laravelpizza/laravel/.mcp.json`

### Cursor Editor (.cursor-mcp.json)

```json
{
  "$schema": "https://modelcontextprotocol.io/schema/mcp.json",
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"]
    }
  }
}
```

**Location**: `/var/www/_bases/base_laravelpizza/laravel/.cursor-mcp.json`

### Windsurf Editor (.windsurf-mcp.json)

```json
{
  "$schema": "https://modelcontextprotocol.io/schema/mcp.json",
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"]
    }
  }
}
```

**Location**: `/var/www/_bases/base_laravelpizza/laravel/.windsurf-mcp.json`

---

## 🔑 Authentication

### OAuth Flow

When connecting for the first time:
1. Configure MCP server URL: `https://mcp.asana.com/sse`
2. Launch your MCP client (Claude, Cursor, Windsurf)
3. Prompted to authenticate with Asana
4. Authorize the "Asana MCP" app
5. Select which Asana tools to enable

### Troubleshooting Authentication

**Internal Server Error**:
```bash
rm -rf ~/.mcp-auth
```
⚠️ **WARNING**: This will delete authentication for ALL applications using MCP-remote

**Client not found error**:
1. Remove Asana MCP integration in your client
2. Add it back
3. Re-authenticate

**invalid_redirect_uri error**:
- Contact app maintainer or Asana Support
- Some applications require redirect URI allowlist registration

---

## 🛠️ Usage Examples

### Task Management

```bash
# Find incomplete tasks due this week
"Find all my incomplete tasks due this week"

# Create new task
"Create a new task in the Marketing project assigned to me"

# List sections
"List all sections in the Product Launch project"

# Check project status
"Show me the status of the Q2 Planning project"
```

### Integration with Modules

#### Meetup Module
```bash
# Create tasks for meetup events
"Create task for Laravel meetup preparation in Meetup module"
```

#### User Module
```bash
# Track authentication tasks
"Create task for OAuth integration completion in User module"
```

#### SEO Module
```bash
# Monitor SEO improvements
"Create task for sitemap generation in SEO module"
```

---

## 📊 Available Tools (Dynamic)

Asana MCP follows Model Context Protocol best practices. To discover available tools:

```bash
tools/list
```

This returns 30+ tools including:
- Project management
- Task operations
- User lookup
- Goals tracking
- Team organization
- Typeahead search

---

## 🔌 MCP Server Compatibility

### Supported Clients

| Client | Status | Notes |
|--------|--------|-------|
| **Claude.ai** | ✅ Supported | Requires Claude Enterprise/Teams. Admin setup required |
| **Cursor** | ✅ Supported | Full OAuth support |
| **Windsurf** | ✅ Supported | Full OAuth support |
| **ChatGPT** | 🔄 Exploring | Additional tools needed |

### SSE-Based Servers Required

⚠️ **Important**: Ensure your MCP client supports SSE-based servers (not Streamable HTTP)

---

## 🚀 Setup Instructions

### For Claude.ai Users

**Admin Setup (Workspace Owner only)**:
1. Go to Claude.ai Settings
2. Navigate to "Integrations"
3. Click "Add server"
4. Name: "Asana"
5. Server URL: `https://mcp.asana.com/sse`
6. Authenticate via OAuth
7. Select tools to enable
8. Save

**User Usage**:
1. Navigate to claude.ai
2. Click tools menu (next to search icon)
3. Select "Asana"
4. Authenticate if first time
5. Start using Claude with Asana

### For Cursor Users

1. Go to Settings > Cursor Settings
2. Navigate to "MCP" or "Tools & Integrations"
3. Click "Add new global MCP server"
4. Add to `mcp.json`:
```json
"asana": {
  "command": "npx",
  "args": ["mcp-remote", "https://mcp.asana.com/sse"]
}
```
5. Save `mcp.json`
6. Authenticate when prompted

### For Windsurf Users

1. Go to Settings > MCP Servers
2. Add new server configuration
3. Use the same configuration as Cursor
4. Save and authenticate

---

## 🔒 Security & Permissions

### Allowlist Management

**Enterprise+ Customers**: Use Asana App Management to allow/block "Asana MCP" app

**Other Tiers**: Contact Asana Support to block the app

### Permissions Required

- Read access to workspace data
- Task creation permissions
- Project update permissions
- Team access for collaborative features

---

## 📝 Best Practices

1. **Task Naming**: Use descriptive task names linked to modules/features
   ```
   "Complete PHPStan Level 10 fixes for Seo module"
   ```

2. **Project Organization**: Create dedicated projects for each module
   ```
   Project: "LaravelPizza - Xot Module"
   ```

3. **Assignments**: Assign tasks to team members responsible for specific modules

4. **Due Dates**: Set realistic due dates based on module roadmaps

5. **Tracking**: Use Asana tags to organize tasks by priority:
   ```
   Tag: "high-priority"
   Tag: "phpstan-compliance"
   Tag: "testing"
   ```

---

## 🐛 Troubleshooting

### Common Issues

**Authentication Fails**:
```bash
# Try logging out and back in to Asana
# Remove integration and add it back
```

**Server Not Responding**:
- Verify SSE support in client
- Check network connectivity
- Ensure Asana MCP app is not blocked

**Tools Not Listed**:
- Use `tools/list` command
- Verify tool permissions in Asana
- Check client MCP version

### Getting Help

- **Asana Support**: Contact for MCP-specific issues
- **App Maintainer**: For redirect URI problems
- **Documentation**: [Asana MCP Docs](https://developers.asana.com/docs/using-asanas-mcp-server)

---

## 📚 Related Documentation

- [Asana MCP Official Documentation](https://developers.asana.com/docs/using-asanas-mcp-server)
- [MCP Protocol Specification](https://modelcontextprotocol.io)
- [Project Roadmaps](../../docs/project-overview.md)
- [Module Documentation](../../Modules/*/docs/README.md)

---

## 🔄 Updates

- **2026-01-31**: Initial configuration for base_laravelpizza project
- **Supported Editors**: Claude, Cursor, Windsurf
- **MCP Server**: Asana Work Graph (Beta)
- **Tools Available**: 30+ dynamic tools

---

**Maintained by**: Laraxot Team
**Documentation Version**: 1.0.0
**Last Review**: 31 Gennaio 2026