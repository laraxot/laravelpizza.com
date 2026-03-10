# MCP Server Configuration - User Module


**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, Redmine (Planned)

---

## 📋 Overview

The User module's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Authentication and authorization task tracking
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - User model and policy file access
- **Database** - User, Role, Permission, Team data inspection

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
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "/var/www/_bases/base_<nome progetto>/laravel"],
      "description": "Access to User module files"
    },
    "database": {
      "command": "npx",
      "args": ["-y", "@bytebase/dbhub"],
      "env": {
        "DATABASE_URL": "sqlite:///var/www/_bases/base_<nome progetto>/laravel/database/database.sqlite"
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
"Create task in '<nome progetto> - User Module' project: 'Implement two-factor authentication'"

# Track security improvements
"Create task: 'Add device fingerprinting for security alerts'"

# Monitor permission system
"Create task: 'Audit and optimize RBAC policies'"
```

### ClickUp Integration
```bash
# Create task
"Create task in 'User Development' space: 'Implement two-factor authentication'"

# Update status
"Update task 'Add device fingerprinting' status to 'In Progress'"

# Log time
"Log 3 hours on task 'Audit RBAC policies'"
```

### Redmine Integration (Planned)
```bash
# Create issue
"Create issue in project 'User Module': task 'Implement two-factor authentication' (Priority: High)"
```

### Filesystem Access

```bash
# Read User model
"Read file: Modules/User/app/Models/User.php"

# Analyze policies
"List files in Modules/User/app/Policies/"

# Check Filament resources
"Read file: Modules/User/app/Filament/Resources/UserResource.php"
```

### Database Queries

```bash
# Check user roles
"Query: SELECT u.name, r.name as role FROM users u JOIN roles r ON u.role_id = r.id"

# Analyze permissions
"Query: SELECT COUNT(*) as permission_count FROM permissions"

# Check authentication logs
"Query: SELECT * FROM authentication_logs ORDER BY created_at DESC LIMIT 10"
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

Map User module roadmap tasks to Asana:

| Roadmap Task | Asana Project | Priority |
|--------------|---------------|----------|
| Two-factor authentication | <nome progetto> - User Module | High |
| Security alerts | <nome progetto> - User Module | High |
| Device management | <nome progetto> - User Module | Medium |
| Test coverage 90%+ | <nome progetto> - User Module | High |

---

## 🔌 Editor-Specific Configurations

### Claude Desktop
- **Config File**: `~/.config/claude/claude_desktop_config.json`
- **Server URL**: `https://mcp.asana.com/sse`

### Cursor
- **Config File**: `/var/www/_bases/base_<nome progetto>/laravel/.cursor-mcp.json`
- **Command**: `npx mcp-remote https://mcp.asana.com/sse`

### Windsurf
- **Config File**: `/var/www/_bases/base_<nome progetto>/laravel/.windsurf-mcp.json`
- **Command**: `npx mcp-remote https://mcp.asana.com/sse`

---

## 📝 Best Practices for User Module

1. **Task Naming Convention**:
   ```
   "[User] Implement {feature} in authentication"
   "[User] Fix security vulnerability in {component}"
   "[User] Optimize RBAC for {scenario}"
   ```

2. **Project Organization**:
   - Create dedicated Asana project: "<nome progetto> - User Module"
   - Use sections: "Authentication", "Authorization", "Security", "Testing", "Documentation"

3. **Tagging System**:
   - `user-auth` - Authentication related tasks
   - `user-rbac` - Role-based access control tasks
   - `user-security` - Security tasks
   - `user-phpstan` - PHPStan compliance tasks

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
- [User Module Roadmap](./roadmap-[date].md)

---

## 🔄 Updates

- **[DATE]**: Added ClickUp support
- **[DATE]**: Planned Redmine integration
- **Servers Active**: 4 (Asana, ClickUp, Filesystem, Database)

---

**Module**: User (Authentication & Authorization)
**MCP Version**: 2.0.0
**Last Review**: 31 Gennaio 2026