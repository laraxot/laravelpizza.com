# MCP Configuration for LaravelPizza

## Overview

This document describes the MCP (Model Context Protocol) configuration setup for the LaravelPizza project, enabling autonomous AI agent capabilities across multiple development environments.

## Project Structure

```
bashscripts/
├── ai/
│   ├── .claude/mcp.json       # Claude Desktop configuration
│   ├── .cursor/mcp.json       # Cursor IDE configuration
│   ├── .windsurf/mcp.json     # Windsurf IDE configuration
│   ├── .antigravity/mcp.json  # Antigravity custom agent configuration
│   └── logs/                  # MCP server logs
└── mcp/
    ├── start-all-mcp.sh       # Startup script
    └── stop-all-mcp.sh        # Stop script
```

## MCP Servers

### 1. Filesystem Server
- **Port**: 8080
- **Purpose**: Read and write files in the LaravelPizza project
- **Allowed Directories**: `/var/www/_bases/base_laravelpizza`
- **Command**: `npx -y @modelcontextprotocol/server-filesystem`

### 2. Git Server
- **Port**: 8081
- **Purpose**: Version control operations (commit, branch, merge, etc.)
- **Repository**: `/var/www/_bases/base_laravelpizza`
- **Command**: `npx -y mcp-server-git`

### 3. Memory Server
- **Port**: 8082
- **Purpose**: Persistent memory for context preservation
- **Memory Path**: `/var/www/_bases/base_laravelpizza/docs`
- **Command**: `npx -y @modelcontextprotocol/server-memory`

### 4. Puppeteer Server
- **Port**: 8083
- **Purpose**: Web browser automation and testing
- **Command**: `npx -y @modelcontextprotocol/server-puppeteer`

### 5. Sequential Thinking Server
- **Port**: 8084
- **Purpose**: Complex reasoning and step-by-step problem solving
- **Command**: `npx -y @modelcontextprotocol/server-sequential-thinking`

### 6. Time Server
- **Port**: 8085
- **Purpose**: Current time and date operations
- **Command**: `python -m mcp_server_time`

### 7. Fetch Server
- **Port**: 8086
- **Purpose**: HTTP requests and web scraping
- **Command**: `npx -y @modelcontextprotocol/server-fetch`

### 8. MySQL Server
- **Port**: 3306
- **Purpose**: Database queries and operations
- **Database**: `laravelpizza_data`
- **Credentials**: marco/marco
- **Command**: `npx -y @modelcontextprotocol/server-mysql`

### 9. Redis Server
- **Port**: 6379
- **Purpose**: Cache and queue operations
- **Command**: `npx -y @iflow-mcp/redis-mcp-server`

### 10. GitHub Server
- **Type**: HTTP API
- **Purpose**: GitHub integration (issues, PRs, releases)
- **Endpoint**: `https://api.github.com/mcp`
- **Auth**: Bearer token from `GITHUB_TOKEN` environment variable

## AI Agent Configurations

### Claude Desktop
- **Config File**: `bashscripts/ai/.claude/mcp.json`
- **Integration**: Native MCP support
- **Features**: Full MCP server access, memory persistence, autonomous mode

### Cursor IDE
- **Config File**: `bashscripts/ai/.cursor/mcp.json`
- **Integration**: Native MCP support
- **Features**: Code intelligence, git integration, testing support

### Windsurf
- **Config File**: `bashscripts/ai/.windsurf/mcp.json`
- **Integration**: Native MCP support
- **Features**: UI component servers (flowbite, shadcn, daisyui, mui), deepwiki integration

### Antigravity (Custom Agent)
- **Config File**: `bashscripts/ai/.antigravity/mcp.json`
- **Integration**: Custom MCP implementation
- **Features**: Autonomous mode, custom workflows, specialized tools

## Usage

### Starting All MCP Servers

```bash
bashscripts/mcp/start-all-mcp.sh
```

This will:
1. Check which servers are already running
2. Start any servers that aren't running
3. Display status of all servers
4. Show configuration file locations
5. Show log file locations

### Stopping All MCP Servers

```bash
bashscripts/mcp/stop-all-mcp.sh
```

This will:
1. Gracefully stop all MCP servers
2. Force kill if graceful shutdown fails
3. Display status of each server

### Viewing MCP Logs

```bash
# View specific server log
tail -f bashscripts/ai/logs/mysql-mcp.log

# View all logs
ls -la bashscripts/ai/logs/
```

## Database Configuration

The MySQL MCP server is configured with:

```json
{
  "MYSQL_HOST": "127.0.0.1",
  "MYSQL_PORT": "3306",
  "MYSQL_USER": "marco",
  "MYSQL_PASSWORD": "marco",
  "MYSQL_DATABASE": "laravelpizza_data"
}
```

For testing, use `laravelpizza_data_test` database.

## Critical Rules for MCP Usage

1. **Always check if servers are running** before attempting operations
2. **Use the startup script** to ensure proper initialization
3. **Monitor logs** for errors and warnings
4. **Stop servers gracefully** using the stop script
5. **Never hardcode credentials** in MCP configs (use environment variables)
6. **Test database operations** on test database first
7. **Use memory server** for context preservation across sessions

## Troubleshooting

### Server Won't Start
1. Check if port is already in use: `lsof -i :8080`
2. Check logs: `bashscripts/ai/logs/*-mcp.log`
3. Verify Node.js is installed: `node --version`
4. Clear NPM cache: `npm cache clean --force`

### Connection Refused
1. Verify server is running: `lsof -i :<port>`
2. Check firewall settings
3. Verify configuration file syntax
4. Restart all MCP servers

### Database Connection Issues
1. Verify MySQL is running: `systemctl status mysql`
2. Check credentials in `.env` file
3. Test connection: `mysql -u marco -p -h 127.0.0.1`
4. Use test database for MCP operations

## Autonomous Agent Features

The MCP configuration enables:

1. **File Operations**: Read, write, search files autonomously
2. **Git Operations**: Commit, branch, merge, push automatically
3. **Database Queries**: Execute SQL, retrieve data, update records
4. **Web Testing**: Puppeteer for automated browser testing
5. **Complex Reasoning**: Sequential thinking for multi-step problems
6. **Context Preservation**: Memory server for long-term knowledge
7. **API Integration**: Fetch server for external data sources
8. **Version Control**: Git server for code management
9. **Testing Automation**: Run Pest tests, verify functionality
10. **Documentation**: Auto-generate and update docs

## Security Considerations

1. **Never commit MCP configs with credentials**
2. **Use environment variables** for sensitive data
3. **Restrict filesystem access** to project directory
4. **Monitor MCP logs** for unauthorized access
5. **Use read-only operations** where possible
6. **Test operations** on non-production environments first

## Future Enhancements

1. **Add more MCP servers**: Elasticsearch, MongoDB, PostgreSQL
2. **Implement MCP-based testing**: Automated test generation
3. **Add MCP monitoring**: Real-time server health checks
4. **Create MCP workflows**: Pre-defined agent task sequences
5. **Implement MCP caching**: Reduce redundant operations
6. **Add MCP logging**: Detailed operation audit trail

## Related Documentation

- `laravel/Modules/Xot/docs/mcp-integration.md` - Module-specific MCP usage
- `laravel/Themes/Meetup/docs/mcp-frontend.md` - Frontend MCP automation
- `docs/mcp-architecture.md` - MCP system architecture
- `docs/ai-agent-guidelines.md` - AI agent development guidelines

## Support

For issues or questions about MCP configuration:
1. Check this documentation
2. Review MCP logs in `bashscripts/ai/logs/`
3. Verify configuration files are valid JSON
4. Test with manual MCP server startup
5. Contact the MCP server maintainers

---

**
**Maintained By**: iFlow CLI  
**Project**: LaravelPizza - Modular Laravel Framework