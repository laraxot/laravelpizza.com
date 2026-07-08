# 12. MCP (Model Context Protocol) for Autonomous AI Agents

LaravelPizza project includes complete MCP configuration for autonomous AI agent capabilities across multiple development environments (Claude Desktop, Cursor, Windsurf, Antigravity).

### MCP Server Infrastructure

**Location**: `bashscripts/ai/` and `bashscripts/mcp/`

**Available MCP Servers:**
1. **Filesystem Server** (port 8080) - Read/write files in LaravelPizza project
2. **Git Server** (port 8081) - Version control operations
3. **Memory Server** (port 8082) - Persistent memory for context preservation
4. **Puppeteer Server** (port 8083) - Web browser automation and testing
5. **Sequential Thinking Server** (port 8084) - Complex reasoning and problem solving
6. **Time Server** (port 8085) - Time and date operations
7. **Fetch Server** (port 8086) - HTTP requests and web scraping
8. **MySQL Server** (port 3306) - Database queries and operations
9. **Redis Server** (port 6379) - Cache and queue operations
10. **GitHub Server** (HTTP API) - GitHub integration (issues, PRs, releases)

### Starting MCP Servers

```bash
# Start all MCP servers
bashscripts/mcp/start-all-mcp.sh

# Stop all MCP servers
bashscripts/mcp/stop-all-mcp.sh
```

### AI Agent Configurations

Each AI agent has its own MCP configuration:

- **Claude Desktop**: `bashscripts/ai/.claude/mcp.json`
- **Cursor IDE**: `bashscripts/ai/.cursor/mcp.json`
- **Windsurf IDE**: `bashscripts/ai/.windsurf/mcp.json`
- **Antigravity (Custom)**: `bashscripts/ai/.antigravity/mcp.json`

### MCP Documentation

Complete MCP setup and usage guide:
- **Location**: `docs/mcp-configuration.md`
- **Contents**: Server details, configuration examples, troubleshooting, security considerations

### MCP Usage Examples

```bash
# Check MCP server status
lsof -i :8080  # Filesystem
lsof -i :8081  # Git
lsof -i :8082  # Memory
lsof -i :8083  # Puppeteer

# View MCP logs
tail -f bashscripts/ai/logs/filesystem-mcp.log
tail -f bashscripts/ai/logs/git-mcp.log
tail -f bashscripts/ai/logs/memory-mcp.log
```

### MCP Database Configuration

MySQL MCP server uses:
- Host: `127.0.0.1`
- Port: `3306`
- User: `marco`
- Password: `marco`
- Database: `laravelpizza_data` (production) or `laravelpizza_data_test` (testing)

### MCP Security Rules

1. **NEVER commit MCP configs with credentials** - use environment variables
2. **ALWAYS test database operations** on test database first
3. **USE read-only operations** where possible
4. **MONITOR MCP logs** for unauthorized access
5. **RESTRICT filesystem access** to project directory only
6. **STOP servers gracefully** using stop script

### MCP Autonomous Capabilities

With MCP, AI agents can:
- **Read and write files** autonomously
- **Execute Git operations** (commit, branch, merge, push)
- **Query databases** and retrieve data
- **Run automated browser tests** with Puppeteer
- **Perform complex reasoning** with sequential thinking
- **Preserve context** across sessions using memory server
- **Fetch external data** via HTTP requests
- **Integrate with GitHub** for issue/PR management

---

