# MCP Server Configuration - Xot Module (Updated)


**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The Xot module's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Task and project management
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - Direct file access
- **Database** - SQLite queries for schema inspection

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
      "description": "Access to Xot module files"
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
# Create task for Xot improvements
"Create task in 'LaravelPizza - Xot Module' project: 'Implement Filament v5 migration'"

# Track PHPStan compliance
"Create task: 'Verify PHPStan Level 10 compliance for all base classes'"
```

### ClickUp Integration

```bash
# Create task in ClickUp
"Create task in 'Xot Development' space: 'Document all Xot base classes'"

# Update task status
"Update task 'Implement Filament v5 migration' status to 'In Progress'"

# Log time
"Log 2 hours on task 'Document Xot base classes'"
```

### Redmine Integration (Planned)

```bash
# Create issue
"Create issue in project 'Xot Module': task 'Document all base classes' (Priority: High)"

# Update issue
"Update issue #12345 status to 'In Progress'"
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

## 🔌 Editor-Specific Configurations

### Claude Desktop
- **Config File**: `~/.config/claude/claude_desktop_config.json`
- **Servers**: Asana, ClickUp, Filesystem, Database

### Cursor
- **Config File**: `/var/www/_bases/base_laravelpizza/laravel/.cursor-mcp.json`
- **Servers**: Asana, ClickUp, Filesystem, Database

### Windsurf
- **Config File**: `/var/www/_bases/base_laravelpizza/laravel/.windsurf-mcp.json`
- **Servers**: Asana, ClickUp, Filesystem, Database

### Antigravity
- **Config File**: `/var/www/_bases/base_laravelpizza/laravel/.antigravity-mcp.json`
- **Servers**: Asana, ClickUp, Filesystem, Database

---

## 📝 Best Practices

1. **Use Asana for**: Established workflows, team collaboration
2. **Use ClickUp for**: Time tracking, executive reports, detailed task management
3. **Use Redmine for**: Self-hosted requirements, custom workflows (when implemented)
4. **Task Naming**: Include module prefix `[Xot]`
5. **Tagging**: Use consistent tags across platforms

---

## 📚 Related Documentation

- [Asana MCP Configuration](../../../../../../docs/mcp-asana-configuration.md)
- [ClickUp MCP Configuration](../../../../../../docs/mcp-clickup-configuration.md)
- [Redmine MCP Configuration](../../../../../../docs/mcp-redmine-configuration.md)
- [Xot Module Roadmap](./roadmap-[date].md)

---

## 🔄 Updates

- **[DATE]**: Added ClickUp support
- **[DATE]**: Planned Redmine integration
- **Servers Active**: 4 (Asana, ClickUp, Filesystem, Database)

---

**Module**: Xot (Foundation)
**MCP Version**: 2.0.0
**Last Review**: 31 Gennaio 2026