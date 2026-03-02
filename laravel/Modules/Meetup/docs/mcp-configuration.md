# MCP Server Configuration - Meetup Module


**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The Meetup module's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Event management and task tracking
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - Event model and Filament resource access
- **Database** - Event, registration, and attendee data inspection

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
      "description": "Access to Meetup module files"
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
"Create task in 'LaravelPizza - Meetup Module' project: 'Implement recurring events feature'"

# Track Folio page completion
"Create task: 'Complete event detail page with Volt components'"

# Monitor RSVP system
"Create task: 'Implement waitlist for sold-out events'"
```

### ClickUp Integration
```bash
# Create task
"Create task in 'Meetup Development' space: 'Implement recurring events feature'"

# Update status
"Update task 'Complete event detail page' status to 'In Progress'"

# Log time
"Log 4 hours on task 'Implement waitlist for sold-out events'"
```

### Redmine Integration (Planned)
```bash
# Create issue
"Create issue in project 'Meetup Module': task 'Implement recurring events feature' (Priority: Medium)"
```

### Filesystem Access

```bash
# Read Event model
"Read file: Modules/Meetup/app/Models/Event.php"

# Analyze Filament resources
"List files in Modules/Meetup/app/Filament/Resources/"

# Check Volt components
"Read file: Themes/Meetup/resources/views/livewire/event-list.blade.php"
```

### Database Queries

```bash
# Check upcoming events
"Query: SELECT * FROM events WHERE event_date >= NOW() ORDER BY event_date ASC"

# Analyze registrations
"Query: SELECT event_id, COUNT(*) as attendees FROM event_registrations GROUP BY event_id"

# Check RSVP status
"Query: SELECT * FROM event_registrations WHERE status = 'confirmed' ORDER BY created_at DESC"
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

Map Meetup module roadmap tasks to Asana:

| Roadmap Task | Asana Project | Priority |
|--------------|---------------|----------|
| Folio pages completion | LaravelPizza - Meetup Module | High |
| Recurring events | LaravelPizza - Meetup Module | Medium |
| Attendee registration | LaravelPizza - Meetup Module | High |
| Event calendar integration | LaravelPizza - Meetup Module | Medium |

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

## 📝 Best Practices for Meetup Module

1. **Task Naming Convention**:
   ```
   "[Meetup] Implement {feature} for event management"
   "[Meetup] Create Folio page for {page}"
   "[Meetup] Fix issue in {component}"
   ```

2. **Project Organization**:
   - Create dedicated Asana project: "LaravelPizza - Meetup Module"
   - Use sections: "Events", "Registration", "Folio Pages", "Testing", "Documentation"

3. **Tagging System**:
   - `meetup-events` - Event related tasks
   - `meetup-rsvp` - Registration tasks
   - `meetup-folio` - Folio/Volt tasks
   - `meetup-phpstan` - PHPStan compliance tasks

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

- [Asana MCP Configuration](../../../../docs/mcp-asana-configuration.md)
- [ClickUp MCP Configuration](../../../../docs/mcp-clickup-configuration.md)
- [Redmine MCP Configuration](../../../../docs/mcp-redmine-configuration.md)
- [Meetup Module Roadmap](./roadmap-[date].md)

---

## 🔄 Updates

- **[DATE]**: Added ClickUp support
- **[DATE]**: Planned Redmine integration
- **Servers Active**: 4 (Asana, ClickUp, Filesystem, Database)

---

**Module**: Meetup (Business Logic)
**MCP Version**: 2.0.0
**Last Review**: 31 Gennaio 2026