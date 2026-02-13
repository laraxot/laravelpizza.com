# MCP Servers Setup Guide

## Overview

This document describes the Model Context Protocol (MCP) servers configured for the Laravel Pizza Meetups project. MCP allows Claude Code to access protected resources like `.env` files, database queries, and GitHub integration.

## Configured Servers

### 1. Filesystem Server

**Purpose**: Access to project files including `.env`, `auth.json`, and protected configs.

**Configuration**:
```json
{
  "type": "stdio",
  "command": "npx",
  "args": ["-y", "@modelcontextprotocol/server-filesystem", "/var/www/_bases/base_laravelpizza/laravel"]
}
```

**Capabilities**:
- Read/write `.env` files without exposing them in git
- Access `auth.json` for Composer credentials
- Consult protected documentation (`CLAUDE.md`, `IFLOW.md`)
- Manage configuration files in `.gitignore`

**Security**: Limited to project directory only.

### 2. Database Server

**Purpose**: Direct SQLite database queries for analytics, schema inspection, and debugging.

**Configuration**:
```json
{
  "type": "stdio",
  "command": "npx",
  "args": ["-y", "@bytebase/dbhub"],
  "env": {
    "DATABASE_URL": "sqlite:///var/www/_bases/base_laravelpizza/laravel/database/database.sqlite"
  }
}
```

**Capabilities**:
- Analytics queries: "How many events are scheduled this month?"
- Schema inspection: "Show me the structure of the events table"
- Performance analysis: "Which queries are slowest?"
- Data exploration without phpMyAdmin/Adminer

**Database**: SQLite at `/var/www/_bases/base_laravelpizza/laravel/database/database.sqlite`

### 3. GitHub Server

**Purpose**: GitHub integration for PR reviews, issue management, and code automation.

**Configuration**:
```json
{
  "type": "http",
  "url": "https://api.githubcopilot.com/mcp/"
}
```

**Capabilities**:
- Create issues: "Create an issue for this bug"
- Review PRs: "Review PR #123 and suggest improvements"
- List pull requests: "Show all open PRs"
- Automate workflows: "Create a PR for the dark mode feature"

**Authentication**: OAuth flow via `/mcp` command in Claude Code.

## Activation Instructions

### Step 1: Verify Configuration

The `.mcp.json` file is already committed to the repository. Verify it exists:

```bash
cat /var/www/_bases/base_laravelpizza/laravel/.mcp.json
```

### Step 2: List Configured Servers

```bash
claude mcp list
```

Expected output:
```
filesystem - stdio - Access to project files
database   - stdio - Direct SQLite database queries
github     - http  - GitHub integration
```

### Step 3: Authenticate GitHub (Optional)

If using GitHub integration:

1. Launch Claude Code: `claude`
2. Type: `/mcp`
3. Select "Authenticate" for GitHub
4. Follow OAuth flow in browser

### Step 4: Test Servers

**Test Filesystem:**
```
> "Show me the DATABASE_URL from .env"
```

**Test Database:**
```
> "How many tables are in the database?"
```

**Test GitHub:**
```
> "List all open pull requests"
```

## Usage Examples

### Filesystem Server

```
> "Read the .env file and list all configured services"
> "Check if auth.json has valid Composer credentials"
> "Show me the APP_KEY from .env"
```

### Database Server

```
> "How many users are registered?"
> "Show me the last 10 event registrations"
> "What is the structure of the events table?"
> "Which events have the most attendees?"
```

### GitHub Server

```
> "Create an issue for implementing dark mode"
> "Review the latest PR and suggest improvements"
> "List all issues with label 'bug'"
> "Show commits from the last week"
```

## Architecture Compliance

This MCP setup adheres to the Laravel Pizza Meetups architecture rules defined in `CLAUDE.md`:

✅ **DRY**: Database server prevents repetitive SQL queries
✅ **KISS**: Simple configuration, minimal complexity
✅ **Secure**: No credentials exposed in git
✅ **Laraxot Patterns**: Compatible with modular architecture

### CMS-Driven Pages Compatibility

The filesystem server provides access to:
- `config/local/laravelpizza/database/content/pages/*.json` - Page content
- `Themes/Meetup/resources/views/components/blocks/` - Block components
- Protected configuration files

This enables Claude Code to:
- Create/edit JSON page definitions
- Modify block components
- Maintain content structure without exposing secrets

## Troubleshooting

### MCP Server Not Found

```bash
# Reinstall server
cd /var/www/_bases/base_laravelpizza/laravel
claude mcp add --transport stdio filesystem -- npx -y @modelcontextprotocol/server-filesystem /var/www/_bases/base_laravelpizza/laravel
```

### Database Connection Error

Verify database file exists:
```bash
ls -lh /var/www/_bases/base_laravelpizza/laravel/database/database.sqlite
```

If missing, run migrations:
```bash
php artisan migrate
```

### GitHub Authentication Failed

Reset authentication:
```bash
claude mcp remove github
claude mcp add --transport http github https://api.githubcopilot.com/mcp/
```

Then re-authenticate via `/mcp` command.

### Permission Denied

Ensure npx is installed:
```bash
which npx
node --version  # Should be >= 18.x
```

Install Node.js if missing:
```bash
# Ubuntu/Debian
sudo apt install nodejs npm

# Verify
npx --version
```

## Security Considerations

### Credential Protection

- **Database URL**: Hardcoded path to SQLite (no password needed)
- **GitHub Token**: Managed by OAuth, not stored in config
- **Filesystem Access**: Limited to project directory

### Team Sharing

The `.mcp.json` file is committed to git and shared with the team because:
- ✅ No sensitive credentials are stored
- ✅ Environment variables are used for secrets
- ✅ Team members need consistent MCP setup

### Production Environment

For production databases (MySQL/PostgreSQL):

1. Use local scope instead of project scope:
```bash
claude mcp add --transport stdio db \
  --env DATABASE_URL="mysql://user:pass@host/db" \
  --scope local \
  -- npx -y @bytebase/dbhub
```

2. Store credentials in `.env`:
```env
DATABASE_URL=mysql://user:pass@host/db
```

3. Reference in `.mcp.json`:
```json
{
  "env": {
    "DATABASE_URL": "${DATABASE_URL}"
  }
}
```

## Maintenance

### Update MCP Servers

```bash
# Update all npm-based servers
npx -y @modelcontextprotocol/server-filesystem@latest
npx -y @bytebase/dbhub@latest
```

### Remove Unused Servers

```bash
claude mcp remove <server-name>
```

### Reset Project Choices

If Claude keeps asking to approve servers:
```bash
claude mcp reset-project-choices
```

## Resources

- **MCP Registry**: https://api.anthropic.com/mcp-registry/docs
- **GitHub MCP Servers**: https://github.com/modelcontextprotocol/servers
- **Claude Code Docs**: https://code.claude.com/docs/en/mcp.md
- **Bytebase DBHub**: https://github.com/bytebase/dbhub

## Version History

- **v1.0** (2025-12-09): Initial setup with filesystem, database (SQLite), and GitHub servers

---

**Status**: ✅ Active
**Maintained by**: Development Team

