# MCP Server Configuration - Meetup Theme

**Last Updated**: 31 Gennaio 2026
**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The Meetup theme's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Frontend development task tracking
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - Theme assets, components, and page access
- **Database** - Theme configuration and settings inspection

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
      "description": "Access to Meetup theme files"
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
"Create task in 'LaravelPizza - Meetup Theme' project: 'Implement about page with Tailwind'"

# Track component development
"Create task: 'Create reusable card component for events'"

# Monitor styling improvements
"Create task: 'Align homepage hero section with laravelpizza.com design'"
```

### ClickUp Integration
```bash
# Create task
"Create task in 'Meetup Theme Development' space: 'Implement about page with Tailwind'"

# Update status
"Update task 'Create reusable card component' status to 'In Progress'"

# Log time
"Log 3 hours on task 'Align homepage hero section'"
```

### Redmine Integration (Planned)
```bash
# Create issue
"Create issue in project 'Meetup Theme': task 'Implement about page with Tailwind' (Priority: High)"
```

### Filesystem Access

```bash
# Read layout components
"Read file: Themes/Meetup/resources/views/layouts/app.blade.php"

# Analyze Volt components
"List files in Themes/Meetup/resources/views/livewire/"

# Check Tailwind configuration
"Read file: Themes/Meetup/tailwind.config.js"
```

### Database Queries

```bash
# Check theme settings
"Query: SELECT * FROM theme_settings WHERE theme = 'meetup'"

# Analyze metatag configuration
"Query: SELECT * FROM metatags WHERE page IN ('home', 'events', 'about')"

# Check navigation items
"Query: SELECT * FROM navigation WHERE theme = 'meetup' ORDER BY sort_order"
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

Map Meetup theme roadmap tasks to Asana:

| Roadmap Task | Asana Project | Priority |
|--------------|---------------|----------|
| Component library | LaravelPizza - Meetup Theme | High |
| About page completion | LaravelPizza - Meetup Theme | High |
| Interactive forms | LaravelPizza - Meetup Theme | Medium |
| Visual parity with laravelpizza.com | LaravelPizza - Meetup Theme | High |

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

## 📝 Best Practices for Meetup Theme

1. **Task Naming Convention**:
   ```
   "[Theme] Implement {component} with Tailwind"
   "[Theme] Create Folio page for {page}"
   "[Theme] Fix styling issue in {component}"
   ```

2. **Project Organization**:
   - Create dedicated Asana project: "LaravelPizza - Meetup Theme"
   - Use sections: "Components", "Pages", "Styling", "Testing", "Documentation"

3. **Tagging System**:
   - `theme-components` - Component related tasks
   - `theme-folio` - Folio page tasks
   - `theme-tailwind` - Styling tasks
   - `theme-phpstan` - PHPStan compliance tasks

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

- [Asana MCP Configuration](../../docs/mcp-asana-configuration.md)
- [ClickUp MCP Configuration](../../docs/mcp-clickup-configuration.md)
- [Redmine MCP Configuration](../../docs/mcp-redmine-configuration.md)
- [Meetup Theme Roadmap](./roadmap-2026-01-31.md)

---

## 🔄 Updates

- **2026-01-31**: Added ClickUp support
- **2026-01-31**: Planned Redmine integration
- **Servers Active**: 4 (Asana, ClickUp, Filesystem, Database)

---

**Theme**: Meetup (Frontend)
**MCP Version**: 2.0.0
**Last Review**: 31 Gennaio 2026