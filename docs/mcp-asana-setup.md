# Asana MCP Server - Complete Setup Guide

**Versione**: 1.0.0
**Data**: 2026-01-31
**Status**: ✅ Configurato

---

## 📋 Indice

1. [What is MCP?](#what-is-mcp)
2. [Asana MCP Overview](#asana-mcp-overview)
3. [Configuration in LaravelPizza](#configuration-in-laravelpizza)
4. [Setup for Different Environments](#setup-for-different-environments)
5. [Available Tools](#available-tools)
6. [Usage Examples](#usage-examples)
7. [Troubleshooting](#troubleshooting)

---

## What is MCP?

**MCP (Model Context Protocol)** is a protocol that allows AI assistants to interact with external systems and data sources. It enables:

- **Seamless Integration**: Connect AI tools with external platforms
- **Context Awareness**: AI assistants can access real-time data
- **Action Capabilities**: Perform actions through natural language
- **Standardized Interface**: Consistent API across different systems

**Key Benefits**:
- No need for custom API integrations
- Real-time data access
- Natural language interactions
- Secure authentication via OAuth

---

## Asana MCP Overview

Asana's MCP Server provides access to the **Asana Work Graph** from external AI applications. It enables:

- ✅ **Task Management**: Create, update, and search tasks
- ✅ **Project Tracking**: Monitor project status and progress
- ✅ **Team Collaboration**: Access team information and assignments
- ✅ **Goal Management**: Track goals and objectives
- ✅ **Analytics**: Generate reports and insights
- ✅ **Natural Language**: Interact using plain English/Italian

**Beta Feature**: Asana MCP is currently in beta, provided "as is" basis.

---

## Configuration in LaravelPizza

### Current Configuration

The LaravelPizza project has Asana MCP configured in `/var/www/_bases/base_laravelpizza/laravel/.mcp.json`:

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

### Server Details

- **Server URL**: `https://mcp.asana.com/sse`
- **Type**: SSE (Server-Sent Events)
- **Authentication**: OAuth
- **Status**: ✅ Configured

---

## Setup for Different Environments

### 1. iFlow CLI (Current Environment)

✅ **Already Configured**

The Asana MCP server is already configured and ready to use in the iFlow CLI environment.

**Usage**:
- AI agents can access Asana tasks, projects, and teams
- Natural language commands supported
- OAuth authentication handled automatically

### 2. Cursor Editor

**Setup Steps**:

1. **Open Cursor Settings**
   - Go to "Settings" > "Cursor Settings"
   - Navigate to "MCP" section

2. **Add Asana MCP Server**
   - Click "+ Add new global MCP server"
   - OR go to "Tools & Integrations" > "New MCP Server"

3. **Configure mcp.json**
   ```json
   {
     "asana": {
       "command": "npx",
       "args": ["mcp-remote", "https://mcp.asana.com/sse"]
     }
   }
   ```

4. **Save and Authenticate**
   - Save your `mcp.json` file
   - You'll be prompted to authenticate with Asana
   - Complete OAuth flow

**Troubleshooting**:
- If you encounter "Internal Server Error", delete `~/.mcp-auth`:
  ```bash
  rm -rf ~/.mcp-auth
  ```
- Re-authenticate after clearing auth cache

### 3. Windsurf Editor

**Setup Steps**:

1. **Open Windsurf Settings**
   - Go to Settings > MCP
   - Click "Add Server"

2. **Configure Asana MCP**
   ```json
   {
     "name": "asana",
     "url": "https://mcp.asana.com/sse",
     "type": "sse"
   }
   ```

3. **Authenticate**
   - Complete OAuth flow when prompted
   - Select which Asana tools to enable

### 4. Claude.ai

**Note**: Requires Claude Enterprise or Teams

**For Admins** (Workspace Owner/Primary Owner only):

1. **Go to Claude.ai Settings**
   - Navigate to "Integrations" section
   - Click "Add server"

2. **Configure Server**
   - Name: "Asana"
   - Server URL: `https://mcp.asana.com/sse`
   - Click "Add server"

3. **Authenticate**
   - Complete OAuth flow
   - Select Asana tools to enable
   - Click "Save"

**For Users**:
- Navigate to claude.ai
- Click tools menu (next to search icon)
- Select "Asana" from integrations
- Authenticate if first time
- Start using Claude with Asana

### 5. Other AI Agents

**Generic MCP Client Setup**:

1. **Configure Connection**
   - Server URL: `https://mcp.asana.com/sse`
   - Protocol: SSE (Server-Sent Events)
   - Authentication: OAuth

2. **Requirements**
   - Client must support SSE-based servers
   - Client must handle OAuth authentication flows
   - Client must implement `tools/list` MCP command

3. **Authentication Flow**
   - Redirect to Asana OAuth
   - Authorize application access
   - Receive access token
   - Store token securely

---

## Available Tools

Asana's MCP server includes **30+ tools** for:

### Task Management
- ✅ Create tasks
- ✅ Update tasks
- ✅ Search tasks
- ✅ Delete tasks
- ✅ Assign tasks
- ✅ Complete tasks

### Project Management
- ✅ Create projects
- ✅ List projects
- ✅ Get project status
- ✅ Update project details
- ✅ Archive projects

### Team Management
- ✅ List teams
- ✅ Get team members
- ✅ Add team members
- ✅ Create teams

### Goal Management
- ✅ Get goals
- ✅ Create goals
- ✅ Update goals
- ✅ Track goal progress

### Search & Discovery
- ✅ Quick search via typeahead
- ✅ Find by type (tasks, projects, teams)
- ✅ Filter by criteria

### Analytics & Reporting
- ✅ Generate reports
- ✅ Summarize project data
- ✅ Analyze task completion
- ✅ Track team performance

**Dynamic Tool Discovery**: Use `tools/list` MCP command to get the most up-to-date list of available tools.

---

## Usage Examples

### Task Management

**Example 1: Find Tasks**
```
"Find all my incomplete tasks due this week"
```

**Example 2: Create Task**
```
"Create a new task in the Marketing project assigned to me"
```

**Example 3: Update Task**
```
"Mark task #123456789 as complete"
```

### Project Management

**Example 1: List Sections**
```
"List all sections in the Product Launch project"
```

**Example 2: Get Status**
```
"Show me the status of the Q2 Planning project"
```

### Team Collaboration

**Example 1: Team Members**
```
"Show me all members of the Engineering team"
```

**Example 2: Assign Task**
```
"Assign the bug fix task to John Doe"
```

### Reporting

**Example 1: Generate Report**
```
"Generate a summary report of all completed tasks this month"
```

**Example 2: Project Summary**
```
"Create a project summary for the Website Redesign project"
```

---

## Troubleshooting

### Authentication Issues

**Problem**: Authentication fails or "Client not found" error

**Solution**:
1. Log out of Asana account and log back in
2. Remove Asana MCP integration in client
3. Add integration back
4. Re-authenticate

**Problem**: "invalid_redirect_uri" error

**Solution**:
- Contact Asana Support
- Register redirect URI with Asana
- Enterprise+ tier: Use App Management
- Other tiers: Contact support via request

### Connection Issues

**Problem**: SSE connection fails

**Solution**:
- Ensure client supports SSE-based servers (not Streamable HTTP)
- Check network connectivity
- Verify server URL: `https://mcp.asana.com/sse`

**Problem**: "Internal Server Error" in Cursor

**Solution**:
```bash
# Clear MCP auth cache
rm -rf ~/.mcp-auth

# Re-authenticate with Asana
```

⚠️ **WARNING**: This will clear auth for all MCP clients using `mcp-remote`

### OAuth Flow Issues

**Problem**: OAuth redirect blocked

**Solution**:
- Ensure Asana MCP app is not blocked
- Enterprise+: Check App Management settings
- Other tiers: Contact Asana Support to unblock

**Problem**: Insufficient permissions

**Solution**:
- Verify user has necessary permissions in Asana workspace
- Contact workspace admin if needed

### Tool Issues

**Problem**: Tools not available after connection

**Solution**:
- Use `tools/list` MCP command to verify available tools
- Check that Asana MCP app is not blocked
- Re-authenticate if necessary

**Problem**: Tool execution fails

**Solution**:
- Check tool permissions in Asana
- Verify user has access to requested resources
- Check network connectivity

---

## Security Considerations

### Authentication

- ✅ OAuth 2.0 authentication
- ✅ Token-based access
- ✅ Secure token storage
- ✅ Session management

### Data Privacy

- ✅ Encrypted connections (HTTPS)
- ✅ OAuth scope limitations
- ✅ User consent required
- ✅ Data access logging

### Access Control

- ✅ Workspace-level permissions
- ✅ App management (Enterprise+)
- ✅ Allowlist/blocklist support
- ✅ Admin control over integrations

### Best Practices

1. **Use OAuth**: Always use OAuth authentication
2. **Limit Scope**: Only enable necessary tools
3. **Monitor Access**: Review active integrations regularly
4. **Secure Tokens**: Store tokens securely
5. **Revoke Unused**: Revoke access when no longer needed

---

## Integration with LaravelPizza Modules

### Xot Module

**Potential Use Cases**:
- Track module development tasks in Asana
- Create tasks for new features
- Update task status from code changes

**Example Workflow**:
1. AI agent reads roadmap
2. Creates Asana tasks for each roadmap item
3. Updates task status as features are completed

### User Module

**Potential Use Cases**:
- Track feature requests
- Manage bug reports
- Coordinate team assignments

**Example Workflow**:
1. User submits bug report
2. AI agent creates task in Asana
3. Assigns to appropriate team member
4. Tracks resolution progress

### Activity Module

**Potential Use Cases**:
- Sync Asana activity logs
- Track task completions
- Generate activity reports

**Example Workflow**:
1. Asana task completed
2. AI agent logs activity
3. Generates completion report
4. Updates project metrics

### Project Management

**Use Cases Across Modules**:
- **Cms Module**: Content creation tasks
- **Geo Module**: Feature development tracking
- **Job Module**: Queue job monitoring
- **Media Module**: Asset management tasks
- **Notify Module**: Notification tasks
- **Tenant Module**: Tenant onboarding tasks
- **Meetup Module**: Event coordination
- **Gdpr Module**: Compliance tasks
- **Seo Module**: SEO optimization tasks

---

## Advanced Usage

### Automated Task Creation

**Workflow**:
1. AI agent reads module roadmaps
2. Creates hierarchical tasks in Asana
3. Sets dependencies between tasks
4. Assigns team members
5. Sets due dates based on roadmap timeline

### Progress Tracking

**Workflow**:
1. AI agent monitors code changes
2. Updates Asana task status
3. Completes subtasks
4. Notifies team members
5. Generates progress reports

### Team Coordination

**Workflow**:
1. AI agent identifies cross-module dependencies
2. Creates coordination tasks
3. Assigns to appropriate teams
4. Tracks completion
5. Resolves conflicts

---

## Documentation Updates

### Module-Specific Documentation

Each module should include:

1. **Asana Integration** section in README
2. **Task Templates** for common actions
3. **Workflow Documentation** for module-specific processes
4. **Best Practices** for using Asana with the module

### Example Documentation Structure

```markdown
## Asana Integration

### Setup
- Configure Asana MCP server
- Authenticate with Asana
- Enable necessary tools

### Common Tasks
- Create feature task: "Create a new task for [feature]"
- Update status: "Mark task #[id] as [status]"
- Search tasks: "Find all [type] tasks in [project]"

### Workflows
1. Feature Development Workflow
2. Bug Fix Workflow
3. Documentation Workflow

### Best Practices
- Use descriptive task names
- Set appropriate due dates
- Assign correct team members
- Track dependencies
```

---

## Future Enhancements

### Planned Features

1. **Automated Task Sync**
   - Sync GitHub PRs with Asana tasks
   - Update task status from CI/CD
   - Link commits to tasks

2. **Smart Task Creation**
   - Auto-generate tasks from code comments
   - Create tasks from TODO comments
   - Generate tasks from roadmap items

3. **Advanced Reporting**
   - Generate sprint reports
   - Create burndown charts
   - Track velocity metrics

4. **Integration Enhancements**
   - Slack notifications for task updates
   - Email alerts for due tasks
   - Calendar integration for deadlines

---

## Support & Resources

### Documentation

- **Asana MCP Docs**: https://developers.asana.com/docs/using-asanas-mcp-server
- **MCP Protocol**: https://modelcontextprotocol.io/
- **Asana API**: https://developers.asana.com/

### Support Channels

- **Asana Support**: Contact for MCP-specific issues
- **Community Forums**: Asana Developer Community
- **GitHub Issues**: Report bugs and feature requests

### Training

- **Asana Academy**: Learn Asana best practices
- **MCP Tutorials**: Learn MCP integration patterns
- **AI Agent Training**: Train agents on Asana workflows

---

**Status**: ✅ Configured and Ready
**Last Updated**: 2026-01-31
**Next Review**: 2026-02-28
**Maintained By**: Dev Team
