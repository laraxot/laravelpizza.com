# MCP Servers - Complete Configuration Guide

**Project**: Laravel Pizza Meetups
**Last Updated**:
**Status**: ✅ Production Ready

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Currently Configured Servers](#currently-configured-servers)
3. [Module-Specific Recommendations](#module-specific-recommendations)
4. [Additional Recommended Servers](#additional-recommended-servers)
5. [Configuration Files](#configuration-files)
6. [Usage Examples](#usage-examples)
7. [Troubleshooting](#troubleshooting)
8. [Security](#security)

---

## Overview

Model Context Protocol (MCP) servers extend Claude Code's capabilities with specialized tools for Laravel/Filament development. This guide consolidates all MCP configuration across the project.

**Key Benefits:**
- 🔓 Access `.env` and protected files (bypasses gitignore)
- 🗄️ Direct database queries without phpMyAdmin
- 🔧 Git operations beyond bash commands
- 🌐 HTTP requests to Laravel/Filament documentation
- 🎭 Browser automation for UI testing
- 🧠 Persistent memory across sessions

---

## Currently Configured Servers

### ✅ Active Servers (8/9)

| Server | Status | Purpose | Use Cases |
|--------|--------|---------|-----------|
| **filesystem** | ✅ Active | File operations | `.env`, `auth.json`, protected configs, JSON content files |
| **memory** | ✅ Active | Persistent context | Remember preferences, patterns, project decisions |
| **fetch** | ✅ Active | HTTP requests | Laravel docs, Filament docs, Packagist, external APIs |
| **sequential-thinking** | ✅ Active | Extended reasoning | Complex architectural decisions, SEO strategy |
| **puppeteer** | ✅ Active | Browser automation | UI testing, screenshots, SERP scraping |
| **sqlite** | ✅ Active | Database queries | Analytics, schema inspection, data exploration |
| **git** | ✅ Active | Version control | History, blame, diff, branch analysis |
| **screenshot-server** | ✅ Active | Screenshot tool | Visual regression testing |
| **everart** | ⚠️ Needs API key | AI image generation | (Optional) |

### Configuration Location

```bash
/var/www/_bases/base_laravelpizza/.claude/mcp.json
```

### Example Configuration

```json
{
  "mcpServers": {
    "filesystem": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-filesystem",
        "/var/www/_bases/base_laravelpizza"
      ]
    },
    "sqlite": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-sqlite",
        "--db-path",
        "/var/www/_bases/base_laravelpizza/laravel/database/database.sqlite"
      ]
    },
    "git": {
      "command": "npx",
      "args": [
        "-y",
        "@modelcontextprotocol/server-git",
        "--repository",
        "/var/www/_bases/base_laravelpizza"
      ]
    }
  }
}
```

---

## Module-Specific Recommendations

### Cms Module

**Recommended Servers:**
- `filesystem` - Asset management (images, files, media)
- `fetch` - External API integration (import/export content)
- `memory` - Temporary content caching during editing

**Rationale:** CMS handles dynamic content, media assets, and integrations.

**Documentation:** `Modules/Cms/docs/mcp-server-recommended.md`

### Geo Module

**Recommended Servers:**
- `fetch` - Retrieve geographic data from external APIs
- `memory` - Cache geospatial data temporarily
- `filesystem` - Manage GeoJSON, Shapefile, KML files

**Rationale:** Geo module requires external data sources and file-based geographic datasets.

**Documentation:** `Modules/Geo/docs/mcp-server-recommended.md`

### Seo Module

**Recommended Servers:**
- `sequential-thinking` - Orchestrate SEO workflow, brainstorming strategies
- `memory` - Maintain keyword knowledge base, analysis results, campaign history
- `filesystem` - Export SEO reports, import keyword lists
- `puppeteer` - Automate web crawling, SERP scraping, screenshot generation
- `postgres` (optional) - If using PostgreSQL for SEO data storage

**Rationale:** SEO requires complex decision-making, web scraping, and data persistence.

**Documentation:** `Modules/Seo/docs/mcp-server-recommended.md`

### Meetup Module (Core Business Logic)

**Recommended Servers:**
- `filesystem` - Access JSON content files (`config/local/laravelpizza/database/content/pages/`)
- `sqlite` - Query events, registrations, users
- `fetch` - External integrations (Meetup.com API, social media)
- `memory` - Remember event patterns, user preferences

**Rationale:** Meetup is the core module - requires all-around capabilities.

---

## Additional Recommended Servers

### For Production (Not Yet Configured)

#### 1. **PostgreSQL Server** (Alternative to SQLite)

```json
{
  "postgres": {
    "command": "npx",
    "args": [
      "-y",
      "@modelcontextprotocol/server-postgres"
    ],
    "env": {
      "DATABASE_URL": "postgresql://user:password@host:5432/laravelpizza"
    }
  }
}
```

**Use Case:** Production database queries, analytics on PostgreSQL.

#### 2. **MySQL Server** (Alternative to SQLite)

```json
{
  "mysql": {
    "command": "npx",
    "args": [
      "-y",
      "@modelcontextprotocol/server-mysql"
    ],
    "env": {
      "MYSQL_CONNECTION_STRING": "mysql://user:password@host:3306/laravelpizza"
    }
  }
}
```

**Use Case:** Production database queries on MySQL.

#### 3. **Docker Server** (For Container Management)

```json
{
  "docker": {
    "command": "npx",
    "args": [
      "-y",
      "@modelcontextprotocol/server-docker"
    ]
  }
}
```

**Use Case:** Manage Laravel Sail containers, inspect logs, restart services.

#### 4. **GitHub Server** (Enhanced Git Integration)

```json
{
  "github": {
    "command": "npx",
    "args": [
      "-y",
      "@modelcontextprotocol/server-github"
    ],
    "env": {
      "GITHUB_PERSONAL_ACCESS_TOKEN": "ghp_your_token_here"
    }
  }
}
```

**Use Case:** Create issues, review PRs, automate workflows.

**Setup:**
1. Generate token: https://github.com/settings/tokens
2. Scopes required: `repo`, `read:org`, `read:user`
3. Add to `.claude/mcp.json` (NOT committed to git)

---

## Configuration Files

### Project-Level Config

**File:** `.claude/mcp.json`
**Scope:** Entire project
**Committed to Git:** ✅ Yes (no sensitive data)

### User-Level Config (Optional)

**File:** `~/.config/claude/mcp.json`
**Scope:** User-specific (all projects)
**Committed to Git:** ❌ No

### Module-Level Documentation

Each module can document recommended MCP servers:

```
Modules/{Module}/docs/mcp-server-recommended.md
```

**Current Modules with MCP Docs:**
- ✅ Cms
- ✅ Geo
- ✅ Seo
- ✅ Meetup

---

## Usage Examples

### Filesystem Server (Protected Files)

```bash
# Access .env (in gitignore)
"Show me the DATABASE_URL from .env"

# Read Composer auth.json
"Check if auth.json has valid credentials for nova.laravel.com"

# Access JSON content files
"Show me the content blocks for the events page JSON"

# List all JSON pages
"List all page definitions in config/local/laravelpizza/database/content/pages/"
```

### SQLite Server (Database Queries)

```bash
# Analytics
"How many events are scheduled this month?"
"Which event has the most registrations?"

# Schema inspection
"Show me the structure of the events table"
"List all indexes in the database"

# Data exploration
"Show the last 10 user registrations"
"Find all events with status 'published'"
```

### Git Server (Version Control)

```bash
# History
"Who modified the UserResource.php file?"
"Show commits from the last week"

# Analysis
"Which files changed most frequently?"
"Show me the diff between develop and main"

# Blame
"Who wrote the CreateEventAction?"
```

### Fetch Server (Documentation)

```bash
# Laravel docs
"Search Laravel 11 documentation for queue workers"

# Filament docs
"Find examples of custom Filament widgets in the documentation"

# Packagist
"Show me the latest version of spatie/laravel-permission on Packagist"
```

### Puppeteer Server (Browser Automation)

```bash
# UI testing
"Navigate to /it/events and take a screenshot"

# Form testing
"Fill the contact form and submit it"

# Visual regression
"Compare the homepage screenshot with the reference"
```

### Memory Server (Persistent Context)

```bash
# Project decisions
"Remember that we prefer Actions over Services for business logic"

# Patterns
"Remember that all public pages must be JSON-driven, no Blade files"

# Preferences
"Remember that I prefer PHPStan Level 10 and complexity < 10"
```

---

## Troubleshooting

### Server Not Starting

**Symptom:** MCP server fails to initialize

**Solution:**
```bash
# Verify Node.js and npx
node --version  # Should be >= 18.x
npx --version

# Test server manually
npx -y @modelcontextprotocol/server-filesystem /path/to/project

# Clear npx cache
npx clear-npx-cache
```

### Database Connection Error

**Symptom:** SQLite server can't connect

**Solution:**
```bash
# Verify database exists
ls -lh /var/www/_bases/base_laravelpizza/laravel/database/database.sqlite

# Create if missing
cd /var/www/_bases/base_laravelpizza/laravel
php artisan migrate
```

### Permission Denied (Filesystem)

**Symptom:** Can't read protected files

**Solution:**
```bash
# Verify path in mcp.json is correct
cat .claude/mcp.json | grep filesystem -A 5

# Should point to project root:
# "/var/www/_bases/base_laravelpizza"
```

### GitHub Token Invalid

**Symptom:** GitHub server authentication fails

**Solution:**
1. Regenerate token: https://github.com/settings/tokens
2. Verify scopes: `repo`, `read:org`, `read:user`
3. Update `.claude/mcp.json` (use local config, not committed)
4. Restart Claude Code

---

## Security

### Credential Protection

**✅ Safe to Commit:**
- Server configuration (command, args)
- Project paths
- Database paths (SQLite)

**❌ NEVER Commit:**
- API keys (`EVERART_API_KEY`)
- Database passwords
- GitHub tokens (`GITHUB_PERSONAL_ACCESS_TOKEN`)
- OAuth tokens

**Best Practice:**
```json
{
  "mcpServers": {
    "github": {
      "command": "npx",
      "args": ["-y", "@modelcontextprotocol/server-github"],
      "env": {
        "GITHUB_PERSONAL_ACCESS_TOKEN": "${GITHUB_TOKEN}"
      }
    }
  }
}
```

Store `GITHUB_TOKEN` in:
- `.env` (gitignored)
- `~/.config/claude/settings.json` (user-specific)

### Access Control

**Filesystem Server:**
- Restricted to project directory only
- Cannot access `/etc/`, `/var/`, or user home outside project

**Database Server:**
- Read-only for SQLite (recommended)
- Write access requires explicit configuration

**Git Server:**
- Read-only by default
- Push/commit operations require authentication

---

## Maintenance

### Update MCP Servers

```bash
# Servers auto-update with npx -y flag
# To force update, clear cache:
npx clear-npx-cache

# Verify versions
npx @modelcontextprotocol/server-filesystem --version
npx @modelcontextprotocol/server-sqlite --version
```

### Remove Unused Server

```bash
# Edit .claude/mcp.json and remove server entry
# Or disable with "enabled": false

{
  "everart": {
    "enabled": false,
    "command": "npx",
    "args": ["-y", "@modelcontextprotocol/server-everart"]
  }
}
```

### Verify Configuration

```bash
# Run verification script
./bashscripts/mcp/verify-mcp-setup.sh

# Expected output:
# ✅ filesystem - Active
# ✅ sqlite - Active
# ✅ git - Active
# ⚠️ everart - API key missing
```

---

## Resources

### Official Documentation
- [MCP Protocol Specification](https://modelcontextprotocol.io/)
- [MCP Server Registry](https://github.com/modelcontextprotocol/servers)
- [Claude Code MCP Guide](https://code.claude.com/docs/en/mcp)

### Project Documentation
- `Modules/Meetup/docs/mcp-servers-setup.md` - Initial setup guide
- `Modules/Cms/docs/mcp-server-recommended.md` - CMS-specific servers
- `Modules/Geo/docs/mcp-server-recommended.md` - Geo-specific servers
- `Modules/Seo/docs/mcp-server-recommended.md` - SEO-specific servers
- `.cursor/MCP_SETUP.md` - Quick setup reference

### MCP Server Packages (npm)
- `@modelcontextprotocol/server-filesystem`
- `@modelcontextprotocol/server-sqlite`
- `@modelcontextprotocol/server-postgres`
- `@modelcontextprotocol/server-mysql`
- `@modelcontextprotocol/server-git`
- `@modelcontextprotocol/server-fetch`
- `@modelcontextprotocol/server-memory`
- `@modelcontextprotocol/server-sequential-thinking`
- `@modelcontextprotocol/server-puppeteer`
- `@modelcontextprotocol/server-docker`
- `@modelcontextprotocol/server-github`
- `@modelcontextprotocol/server-everart`

---

## Version History

- **v{VERSION}** ({DATE}) - Initial setup (filesystem, sqlite, git)
- **v{VERSION}** ({DATE}) - Added memory, fetch, sequential-thinking
- **v{VERSION}** ({DATE}) - Added puppeteer, screenshot-server
- **v{VERSION}** ({DATE}) - Complete consolidation guide with module-specific recommendations

---

**Status**: ✅ Production Ready
**Maintained by**: Development Team
**Last Updated**:
