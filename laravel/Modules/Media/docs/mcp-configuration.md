# MCP Server Configuration - Media Module

**Last Updated**: 31 Gennaio 2026
**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The Media module's MCP configuration enables AI assistants to interact with:
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
      "description": "Access to Media module files"
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
"Create task in 'LaravelPizza - Media Module' project: 'Increase test coverage to 90%'"

# Update status
"Update task 'Reduce PHPStan suppressions' status to 'In Progress'"

# Log time
"Log 3 hours on task 'Consolidate documentation'"
```

### ClickUp Integration
```bash
# Create task
"Create task in 'Media Development' space: 'Increase test coverage to 90%'"

# Update status
"Update task 'Reduce PHPStan suppressions' status to 'In Progress'"

# Log time
"Log 3 hours on task 'Consolidate documentation'"
```

### Redmine Integration (Planned)
```bash
# Create issue
"Create issue in project 'Media Module': task 'Increase test coverage to 90%' (Priority: Medium)"
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

1. **Task Naming Convention**: Include module prefix `[Media]`
2. **Tagging**: Use consistent tags across platforms
3. **Use Asana for**: Established workflows, team collaboration
4. **Use ClickUp for**: Time tracking, executive reports
5. **Use Redmine for**: Self-hosted requirements (when implemented)

---

## 📚 Related Documentation

- [Asana MCP Configuration](../../../docs/mcp-asana-configuration.md)
- [ClickUp MCP Configuration](../../../docs/mcp-clickup-configuration.md)
- [Redmine MCP Configuration](../../../docs/mcp-redmine-configuration.md)
- [Media Module Roadmap](./roadmap-2026-01-31.md)

---

## 🔄 Updates

- **2026-01-31**: Added ClickUp support
- **2026-01-31**: Planned Redmine integration
- **Servers Active**: 4 (Asana, ClickUp, Filesystem, Database)

---

**Module**: Media (File & Asset Management)
**MCP Version**: 2.0.0
**Last Review**: 31 Gennaio 2026