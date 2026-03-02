# MCP Server Configuration - Xot Module


**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The Xot module's MCP configuration enables AI assistants to interact with:
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
# Create task
"Create task in 'LaravelPizza - Xot Module' project: 'Implement Filament v5 migration'"

# Track PHPStan compliance
"Create task: 'Verify PHPStan Level 10 compliance for all base classes'"

# Monitor documentation updates
"Create task: 'Update Xot module documentation with new patterns'"
```

### ClickUp Integration
```bash
# Create task
"Create task in 'Xot Development' space: 'Implement Filament v5 migration'"

# Update status
"Update task 'Verify PHPStan Level 10 compliance' status to 'In Progress'"

# Log time
"Log 2 hours on task 'Implement new base trait'"
```

### Redmine Integration (Planned)
```bash
# Create issue
"Create issue in project 'Xot Foundation': task 'Implement Filament v5 migration' (Priority: High)"
```

### Filesystem Access

```bash
# Read Xot base classes
"Read file: Modules/Xot/app/Models/XotBaseModel.php"

# Analyze traits
"List files in Modules/Xot/app/Traits/"

# Check PHPStan configuration
"Read file: laravel/phpstan.neon"
```

### Database Queries

```bash
# Check migration status
"Query: SELECT * FROM migrations WHERE migration LIKE '%xot%'"

# Analyze Xot-related tables
"List all tables in database"

# Inspect schema
"Show schema for xot_base_models table"
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

## 📊 Integration with Roadmap

### Roadmap Tasks → Asana

Map Xot module roadmap tasks to Asana:

| Roadmap Task | Asana Project | Priority |
|--------------|---------------|----------|
| Filament v5 migration | LaravelPizza - Xot Module | High |
| Documentation consolidation | LaravelPizza - Xot Module | Medium |
| Test coverage improvement | LaravelPizza - Xot Module | High |
| Performance optimization | LaravelPizza - Xot Module | Medium |

---

## 🔌 Editor-Specific Configurations

### Claude Desktop
- **Config File**: `~/.config/claude/claude_desktop_config.json`
- **Server URL**: `https://mcp.asana.com/sse`

### Cursor
- **Config File**: `/var/www/_bases/base_laravelpizza/laravel/.cursor-mcp.json`
- **Command**: `npx mcp-remote https://mcp.asana.com/sse`

### Windsurf
- **Config File**: `/var/www/_bases/base_laravelpizza/laravel/.windsurf-mcp.json`
- **Command**: `npx mcp-remote https://mcp.asana.com/sse`

---

## 📝 Best Practices for Xot Module

1. **Task Naming Convention**:
   ```
   "[Xot] Implement {feature} in {class}"
   "[Xot] Fix PHPStan error in {file}:{line}"
   "[Xot] Update documentation for {component}"
   ```

2. **Project Organization**:
   - Create dedicated Asana project: "LaravelPizza - Xot Module"
   - Use sections: "Features", "Fixes", "Refactoring", "Testing", "Documentation"

3. **Tagging System**:
   - `xot-base-classes` - Base class related tasks
   - `xot-traits` - Trait related tasks
   - `xot-phpstan` - PHPStan compliance tasks
   - `xot-filament` - Filament integration tasks

4. **Use Asana for**: Established workflows, team collaboration
5. **Use ClickUp for**: Time tracking, executive reports
6. **Use Redmine for**: Self-hosted requirements (when implemented)

---

## 🐛 Troubleshooting

### Common Issues

**MCP Server Not Connecting**:
```bash
# Check MCP server status
# Verify authentication tokens
# Restart MCP client
```

**Filesystem Access Denied**:
```bash
# Verify file permissions
# Check path configuration
# Ensure .mcp.json has correct paths
```

**Database Query Fails**:
```bash
# Verify DATABASE_URL
# Check SQLite file exists
# Validate database schema
```

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