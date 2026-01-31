# MCP Server Configuration - Geo Module

**Last Updated**: 31 Gennaio 2026
**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The Geo module's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Task and project management
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - Direct file access
- **Database** - SQLite queries for data inspection

---

## 🔧 Configuration

### Active MCP Servers

```json
{
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"],
      "description": "Asana Work Graph integration"
    },
    "clickup": {
      "command": "npx",
      "args": ["-y", "mcp-remote", "https://mcp.clickup.com/mcp"],
      "description": "ClickUp workspace integration"
    },
    "filesystem": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "/var/www/_bases/base_laravelpizza/laravel"],
      "description": "Access to Geo module files"
    },
    "database": {
      "command": "npx",
      "args": ["-y", "@bytebase/dbhub"],
      "env": {
        "DATABASE_URL": "sqlite:///var/www/_bases/base_laravelpizza/laravel/database/database.sqlite"
      },
      "description": "SQLite database queries"
    }
  }
}
```

---

## 🚀 Usage Examples

### Asana Integration
```bash
# Create task
"Create task in 'LaravelPizza - Geo Module' project: 'Implement geocoding cache'"

# Update status
"Update task 'Add location model type safety' status to 'In Progress'"

# Log time
"Log 3 hours on task 'Implement geocoding tests'"
```

### ClickUp Integration
```bash
# Create task
"Create task in 'Geo Development' space: 'Implement geocoding cache'"

# Update status
"Update task 'Add location model type safety' status to 'In Progress'"

# Log time
"Log 3 hours on task 'Implement geocoding tests'"
```

### Redmine Integration (Planned)
```bash
# Create issue
"Create issue in project 'Geo Module': task 'Implement geocoding cache' (Priority: Medium)"
```

---

## 📊 MCP Servers Comparison

| Server | Status | Auth | Best For |
|--------|--------|------|----------|
| **Asana** | ✅ Active | OAuth | Established workflows |
| **ClickUp** | ✅ Active | OAuth | Time tracking, reports |
| **Redmine** | 🔄 Planned | API Key | Self-hosted, custom workflows |
| **Filesystem** | ✅ Active | N/A | Direct file access |
| **Database** | ✅ Active | N/A | Schema inspection |

---

## 📝 Best Practices

1. **Task Naming Convention**: Include module prefix `[Geo]`
2. **Tagging**: Use consistent tags across platforms
3. **Use Asana for**: Established workflows, team collaboration
4. **Use ClickUp for**: Time tracking, executive reports
5. **Use Redmine for**: Self-hosted requirements (when implemented)

---

## 📚 Related Documentation

- [Asana MCP Configuration](../../../docs/mcp-asana-configuration.md)
- [ClickUp MCP Configuration](../../../docs/mcp-clickup-configuration.md)
- [Redmine MCP Configuration](../../../docs/mcp-redmine-configuration.md)
- [Geo Module Roadmap](./roadmap-2026-01-31.md)

---

## 🔄 Updates

- **2026-01-31**: Added ClickUp support
- **2026-01-31**: Planned Redmine integration
- **Servers Active**: 4 (Asana, ClickUp, Filesystem, Database)

---

**Module**: Geo (Geographic Services)
**MCP Version**: 2.0.0
**Last Review**: 31 Gennaio 2026