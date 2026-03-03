# Cursor MCP Configuration Guide

**
**Status**: ✅ Configured
**Editor**: Cursor AI

---

## 📋 Overview

Model Context Protocol (MCP) connects Cursor to external systems and data. Instead of explaining your project structure repeatedly, you can integrate directly with your tools and data sources.

### What MCP Does in Cursor

- **Read files from external systems** - Access project files, databases, APIs
- **Execute code in external systems** - Run scripts, queries, commands
- **Integrate with project management tools** - Asana, ClickUp, Jira, etc.
- **Access databases** - SQLite, PostgreSQL, MySQL queries
- **Automate workflows** - Task creation, time tracking, status updates

---

## 🔧 Configuration Files

### Primary Configuration File

**Location**: `{PROJECT_ROOT}/laravel/.cursor-mcp.json`

```json
{
  "$schema": "https://modelcontextprotocol.io/schema/mcp.json",
  "mcpServers": {
    "asana": {
      "command": "npx",
      "args": ["mcp-remote", "https://mcp.asana.com/sse"]
    },
    "clickup": {
      "url": "https://mcp.clickup.com/mcp"
    },
    "filesystem": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-filesystem", "{PROJECT_ROOT}/laravel"]
    },    "database": {
      "command": "npx",
      "args": ["-y", "@bytebase/dbhub"],
      "env": {
        "DATABASE_URL": "sqlite:///var/www/_bases/base_laravelpizza/laravel/database/database.sqlite"
      }
    }
  }
}
```

---

## 🚀 How to Configure MCP in Cursor

### Method 1: Cursor Settings (GUI)

1. Open Cursor
2. Go to **Settings** > **MCP** (or press `Cmd+,` / `Ctrl+,`)
3. Scroll to **Model Context Protocol** section
4. Click **"+ Add Server"**
5. Add server configuration:
   ```json
   {
     "asana": {
       "command": "npx",
       "args": ["mcp-remote", "https://mcp.asana.com/sse"]
     }
   }
   ```
6. Click **Save**

### Method 2: Manual Configuration File

1. Create or edit `.cursor-mcp.json` in project root
2. Add MCP server configurations
3. Restart Cursor
4. Servers will be automatically detected

### Method 3: Cursor CLI

Cursor CLI automatically detects and respects your `.cursor-mcp.json` configuration file.

```bash
# Use MCP in CLI
cursor ask "Show me all tasks in Asana due this week"
```

---

## 📊 Configured MCP Servers

### 1. Asana Work Graph

**Purpose**: Task and project management

**Configuration**:
```json
"asana": {
  "command": "npx",
  "args": ["mcp-remote", "https://mcp.asana.com/sse"]
}
```

**Usage Examples**:
```bash
# Ask Cursor AI
"Create task in Asana: Implement PHPStan Level 10 fixes for Seo module"
"Show all my incomplete tasks due this week"
"List all sections in the Product Launch project"
```

**Authentication**: OAuth (first-time setup required)

### 2. ClickUp Workspace

**Purpose**: Advanced task workflows and time tracking

**Configuration**:
```json
"clickup": {
  "url": "https://mcp.clickup.com/mcp"
}
```

**Usage Examples**:
```bash
"Create task in ClickUp: Document all Xot base classes"
"Update task status to In Progress"
"Log 2 hours on current task"
```

**Authentication**: OAuth (first-time setup required)

### 3. Filesystem

**Purpose**: Direct file access to project

**Configuration**:
```json
"filesystem": {
  "command": "npx",
  "args": ["-y", "@modelcontextprotocol/server-filesystem", "/var/www/_bases/base_laravelpizza/laravel"]
}
```

**Usage Examples**:
```bash
"Read the User model file"
"List all PHP files in the Xot module"
"Show me the structure of the Meetup module"
```

**Authentication**: None (local filesystem access)

### 4. Database

**Purpose**: SQLite database queries

**Configuration**:
```json
"database": {
  "command": "npx",
  "args": ["-y", "@bytebase/dbhub"],
  "env": {
    "DATABASE_URL": "sqlite:///{PROJECT_ROOT}/laravel/database/database.sqlite"
  }
}
```

**Usage Examples**:
```bash
"Show all users in the database"
"Query: SELECT * FROM migrations WHERE migration LIKE '%xot%'"
"List all tables in the database"
```

**Authentication**: None (local database access)

---

## 🔌 MCP Server Types

### stdio (Standard Input/Output)

Used for command-line based MCP servers.

**Example**: Asana, Filesystem, Database

```json
"server_name": {
  "command": "npx",
  "args": ["-y", "package-name", "additional-args"]
}
```

### http (HTTP-based)

Used for HTTP-based MCP servers.

**Example**: ClickUp

```json
"server_name": {
  "url": "https://server-url.com/mcp"
}
```

---

## 🎯 Best Practices for Cursor MCP

### 1. Server Organization

Organize servers by purpose:
- **Project Management**: Asana, ClickUp
- **Data Access**: Filesystem, Database
- **External APIs**: Custom servers

### 2. Authentication Management

- Use OAuth for cloud services (Asana, ClickUp)
- Use environment variables for API keys
- Never commit secrets to version control

```json
"custom_api": {
  "command": "npx",
  "args": ["mcp-remote", "https://api.example.com/mcp"],
  "env": {
    "API_KEY": "${API_KEY}"  // Use environment variable
  }
}
```

### 3. Performance Optimization

- Limit number of active servers
- Use filesystem server for local files
- Cache frequently accessed data
- Use database queries instead of multiple API calls

### 4. Error Handling

- Configure timeouts for HTTP servers
- Implement retry logic for unreliable connections
- Provide clear error messages

---

## 🐛 Troubleshooting

### Server Not Showing in Cursor

**Symptoms**: MCP server not listed in Cursor UI

**Solutions**:
```bash
# 1. Verify configuration file exists
ls -la .cursor-mcp.json

# 2. Check JSON syntax
cat .cursor-mcp.json | jq .

# 3. Restart Cursor
# Completely close and reopen Cursor

# 4. Clear Cursor cache
rm -rf ~/.cursor/cache
```

### Authentication Failed

**Symptoms**: OAuth prompt appears but authentication fails

**Solutions**:
```bash
# 1. Clear MCP authentication cache
rm -rf ~/.mcp-auth

# 2. Remove and re-add server
# - Delete server from .cursor-mcp.json
# - Add it back
# - Re-authenticate

# 3. Check OAuth redirect URI
# - Verify redirect URI is in allowlist
# - Contact service support if needed
```

### Filesystem Access Denied

**Symptoms**: Cannot read files through filesystem server

**Solutions**:
```bash
# 1. Verify file permissions
ls -la /var/www/_bases/base_laravelpizza/laravel

# 2. Check path in configuration
# - Ensure absolute path is correct
# - No typos in path

# 3. Verify server path argument
# - Should be: "{PROJECT_ROOT}/laravel"
# - Not: "./laravel" or relative paths
```

### Database Query Failed

**Symptoms**: Database queries return errors

**Solutions**:
```bash
# 1. Verify database file exists
ls -la {PROJECT_ROOT}/laravel/database/database.sqlite

# 2. Check DATABASE_URL format
# - SQLite: sqlite:///absolute/path/to/database.sqlite
# - PostgreSQL: postgresql://user:pass@host:port/dbname
# - MySQL: mysql://user:pass@host:port/dbname

# 3. Test database connection directly
sqlite3 {PROJECT_ROOT}/laravel/database/database.sqlite ".tables"
```

---

## 🚀 Advanced Configuration

### Custom MCP Server

Create a custom MCP server for specific needs:

```json
"custom_server": {
  "command": "node",
  "args": ["/path/to/custom-mcp-server.js"],
  "env": {
    "CUSTOM_ENV": "value"
  },
  "timeout": 30000
}
```

### Multiple Database Connections

Configure multiple database servers:

```json
"databases": {
  "main_db": {
    "command": "npx",
    "args": ["-y", "@bytebase/dbhub"],
    "env": {
      "DATABASE_URL": "sqlite:///var/www/_bases/base_laravelpizza/laravel/database/database.sqlite"
    }
  },
  "analytics_db": {
    "command": "npx",
    "args": ["-y", "@bytebase/dbhub"],
    "env": {
      "DATABASE_URL": "postgresql://user:pass@localhost/analytics"
    }
  }
}
```

---

## 📚 Related Documentation

- [Asana MCP Configuration](./mcp-asana-configuration.md)
- [ClickUp MCP Configuration](./mcp-clickup-configuration.md)
- [Redmine MCP Configuration](./mcp-redmine-configuration.md)
- [Module MCP Configurations](../laravel/Modules/*/docs/mcp-configuration.md)
- [Cursor Official Docs](https://cursor.com/docs)

---

## 🔄 Updates

- **Initial Configuration**: Complete MCP configuration for Cursor
- **Servers Configured**: 4 (Asana, ClickUp, Filesystem, Database)
- **Status**: Production Ready

---

**Editor**: Cursor AI
**MCP Version**: 2.0.0
**Last Review**: