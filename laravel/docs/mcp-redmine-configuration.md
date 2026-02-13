# Redmine MCP Server Configuration


**Status**: 🔄 Planned (Requires Self-Hosted Redmine)
**MCP Server**: Community/Custom Implementation Required

---

## 📋 Overview

Redmine is a flexible project management web application built on Ruby on Rails. It's open source (GPL v2) and supports multiple projects, issue tracking, Gantt charts, wikis, and more.

### Key Features

- **Multiple projects support** - Manage multiple projects in one instance
- **Flexible role based access control** - Granular permissions system
- **Issue tracking system** - Custom workflows, priorities, categories
- **Gantt chart and calendar** - Visual project planning
- **Time tracking** - Built-in time entry management
- **Wiki and forums** - Per-project documentation and discussions
- **SCM integration** - Support for Git, SVN, CVS, Mercurial, Bazaar
- **Custom fields** - Extensible data model for issues, projects, users
- **Multilanguage support** - 40+ languages available
- **Multiple databases** - MySQL, PostgreSQL, SQLite

---

## 🔧 MCP Server Status

### Current Status: Community Implementation Required

⚠️ **Important**: Redmine does NOT have an official MCP server. This requires:

1. **Self-hosted Redmine instance**
2. **Custom MCP server implementation** using Redmine REST API
3. **OAuth 2.0 authentication** setup
4. **JSON-RPC 2.0 protocol** implementation over HTTP

### Architecture Required

```
Redmine Instance (Self-Hosted)
    ↓ REST API
Custom MCP Server (Node.js/Python)
    ↓ JSON-RPC 2.0 over HTTP
MCP Clients (Claude, Cursor, Windsurf, Antigravity)
```

---

## 🔧 Configuration (Planned)

### MCP Server Implementation

```json
{
  "mcpServers": {
    "redmine": {
      "type": "stdio",
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://redmine.example.com/mcp"],
      "env": {
        "REDMINE_URL": "https://redmine.example.com",
        "REDMINE_API_KEY": "your-api-key-here"
      },
      "description": "Redmine project management integration"
    }
  }
}
```

### Required Components

1. **MCP Server Wrapper**
   - Implements JSON-RPC 2.0 protocol
   - Translates MCP tools to Redmine REST API calls
   - Handles authentication and rate limiting

2. **Redmine REST API Endpoints**
   - Issues: `/issues.json`
   - Projects: `/projects.json`
   - Time entries: `/time_entries.json`
   - Wiki pages: `/wiki/*.json`
   - Users: `/users.json`

3. **Authentication**
   - API Key authentication (Redmine native)
   - OAuth 2.0 (if implementing custom auth)

---

## 🛠️ Planned MCP Tools

### Issue Management

```bash
# Create issue
"Create issue in project 'LaravelPizza': task 'Implement PHPStan Level 10 fixes'"

# Update issue
"Update issue #12345 status to 'In Progress'"

# Search issues
"Find all open issues assigned to me in LaravelPizza project"

# Add comment
"Add comment to issue #12345: 'Started working on base classes'"
```

### Project Management

```bash
# List projects
"List all Redmine projects"

# Get project details
"Show details for LaravelPizza project"

# Track time
"Log 4 hours on issue #12345"

# Generate Gantt chart data
"Get Gantt chart data for LaravelPizza project"
```

### Wiki & Documentation

```bash
# Read wiki page
"Read wiki page 'Architecture' from LaravelPizza project"

# Update wiki page
"Update wiki page 'Roadmap' with new tasks"

# Search wiki
"Search wiki for 'PHPStan' in LaravelPizza project"
```

---

## 🚀 Implementation Roadmap

### Phase 1: Setup Redmine (Week 1)
- [ ] Install Redmine instance
- [ ] Configure database (PostgreSQL/MySQL)
- [ ] Set up SSL/HTTPS
- [ ] Configure API access
- [ ] Create user accounts for MCP

### Phase 2: Develop MCP Server (Week 2-3)
- [ ] Design MCP tool architecture
- [ ] Implement JSON-RPC 2.0 server
- [ ] Map Redmine REST API to MCP tools
- [ ] Add authentication layer
- [ ] Implement rate limiting

### Phase 3: Testing (Week 4)
- [ ] Unit tests for MCP tools
- [ ] Integration tests with Redmine
- [ ] Test with MCP clients (Claude, Cursor, Windsurf)
- [ ] Performance testing
- [ ] Security audit

### Phase 4: Deployment (Week 5)
- [ ] Deploy MCP server
- [ ] Configure MCP clients
- [ ] Document setup process
- [ ] Train team
- [ ] Monitor and iterate

---

## 🔌 Editor-Specific Configuration

### Claude Desktop

```json
{
  "mcpServers": {
    "redmine": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://redmine.example.com/mcp"],
      "env": {
        "REDMINE_URL": "https://redmine.example.com",
        "REDMINE_API_KEY": "your-api-key-here"
      }
    }
  }
}
```

### Cursor

```json
{
  "mcpServers": {
    "redmine": {
      "url": "https://redmine.example.com/mcp",
      "headers": {
        "X-Redmine-API-Key": "your-api-key-here"
      }
    }
  }
}
```

### Windsurf

```json
{
  "mcpServers": {
    "redmine": {
      "serverUrl": "https://redmine.example.com/mcp",
      "env": {
        "REDMINE_API_KEY": "your-api-key-here"
      }
    }
  }
}
```

### Antigravity

```json
{
  "mcpServers": {
    "redmine": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://redmine.example.com/mcp"],
      "env": {
        "REDMINE_API_KEY": "your-api-key-here"
      }
    }
  }
}
```

---

## 📊 Integration with Modules

### Xot Module

```bash
# Create issues for Xot improvements
"Create issue in project 'Xot Module': task 'Document all base classes' (Priority: High)"

# Track PHPStan compliance
"Create issue: 'Achieve PHPStan Level 10 compliance' (Tracker: Bug)"
```

### User Module

```bash
# Authentication features
"Create issue: 'Implement two-factor authentication' (Category: Security)"

# Monitor security
"Create issue: 'Audit RBAC policies' (Priority: Urgent)"
```

### Meetup Module

```bash
# Event management
"Create issue: 'Set up Laravel February meetup' (Tracker: Feature)"

# RSVP tracking
"Create issue: 'Implement waitlist for sold-out events' (Priority: Normal)"
```

---

## 📝 Best Practices

1. **Issue Naming Convention**:
   ```
   [Module] Feature: Implement {feature}
   [Module] Bug: Fix {issue}
   [Module] Task: {task description}
   ```

2. **Project Structure**:
   - Create dedicated Redmine project for each module
   - Use trackers: Feature, Bug, Task, Support
   - Use categories: Backend, Frontend, Testing, Documentation

3. **Custom Fields**:
   - Module name (dropdown)
   - PHPStan status (dropdown: Compliant, In Progress, Non-Compliant)
   - Test coverage (number)
   - Estimated hours (number)

4. **Workflow**:
   - New → In Progress → Resolved → Closed
   - Add "Ready for Testing" status
   - Add "Blocked" status for dependencies

---

## 🐛 Troubleshooting

### Common Issues

**MCP Server Not Starting**:
```bash
# Check Node.js version
# Verify MCP server dependencies
# Check Redmine API accessibility
# Review logs for errors
```

**Authentication Fails**:
```bash
# Verify API key
# Check Redmine user permissions
# Ensure API key is enabled
# Test API endpoint directly
```

**Rate Limiting**:
```bash
# Implement request throttling
# Cache frequently accessed data
# Use pagination for large datasets
```

---

## 📚 Resources

### Redmine Documentation
- [Redmine Official Site](https://www.redmine.org/)
- [Redmine REST API](https://www.redmine.org/projects/redmine/wiki/Rest_api)
- [Redmine Plugins](https://www.redmine.org/plugins)
- [Redmine Guide](https://www.redmine.org/guide/)

### MCP Resources
- [MCP Protocol Specification](https://modelcontextprotocol.io)
- [MCP Server Implementation Guide](https://modelcontextprotocol.io/docs/concepts/servers/)

### Community
- [Redmine Forums](https://www.redmine.org/projects/redmine/boards)
- [Redmine Chatroom](https://libera.chat/)
- [Redmine Slack](https://join.slack.com/t/redmine/shared_invite/zt-o1t4z0l5-3~6y5~_qW6Q~5vGx8Y2A)

---

## 🔄 Alternatives

If Redmine MCP implementation is too complex, consider:

1. **ClickUp MCP** - Official MCP support (already configured)
2. **Asana MCP** - Official MCP support (already configured)
3. **Linear MCP** - Third-party implementation available
4. **Jira MCP** - Third-party implementation available

---

## 📊 Comparison: Redmine vs ClickUp vs Asana

| Feature | Redmine | ClickUp | Asana |
|---------|---------|---------|-------|
| **Official MCP** | ❌ No | ✅ Yes | ✅ Yes |
| **Self-Hosted** | ✅ Yes | ❌ No | ❌ No |
| **Open Source** | ✅ GPL v2 | ❌ Proprietary | ❌ Proprietary |
| **Free Tier** | ✅ Yes | ✅ Limited | ✅ Limited |
| **API Access** | ✅ REST API | ✅ REST API | ✅ REST API |
| **Custom Fields** | ✅ Extensive | ✅ Limited | ✅ Limited |
| **Gantt Charts** | ✅ Native | ✅ Native | ✅ Limited |
| **Time Tracking** | ✅ Native | ✅ Native | ❌ Limited |
| **Wiki** | ✅ Native | ❌ No | ✅ Native |
| **SCM Integration** | ✅ Native | ❌ No | ❌ No |

---

## 🎯 Recommendation

For base_laravelpizza project, **recommended approach**:

1. **Primary**: Use ClickUp MCP (official support, easy setup)
2. **Secondary**: Use Asana MCP (official support, established workflows)
3. **Tertiary**: Consider Redmine MCP only if self-hosting is required for data privacy/security

---

## 🔄 Updates

- **2026-01-31**: Initial planning document created
- **Status**: Planned (requires self-hosted Redmine)
- **Effort**: 4-5 weeks for full implementation
- **Priority**: Low (ClickUp and Asana already configured)

---

**Maintained by**: Laraxot Team
**Documentation Version**: 1.0.0 (Planning Phase)
**Last Review**: 31 Gennaio 2026
**Next Review**: After Redmine implementation