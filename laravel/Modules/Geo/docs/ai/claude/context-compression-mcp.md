# Context Compression MCP Setup

## Purpose

This project hit a real context-limit failure:

- endpoint max context: `262144` tokens
- attempted request: about `422920` tokens

The fix is to add a local MCP-based context compression layer so Claude Code can offload and compress bulky tool output instead of pushing everything into the live prompt.

## Installed Component

Installed package:

- `@ooples/token-optimizer-mcp` version `5.0.1`

Installed in:

- [bashscripts/mcp/package.json](/var/www/_bases/base_ptvx_fila5/bashscripts/mcp/package.json)

## Configuration

Shared Claude Code project config:

- [.mcp.json](/var/www/_bases/base_ptvx_fila5/.mcp.json)

Compatibility config already used in this repository:

- [.claude/mcp_servers.json](/var/www/_bases/base_ptvx_fila5/.claude/mcp_servers.json)

Configured servers:

- `qmd`
- `token-optimizer`

The token optimizer uses a local cache directory:

- [.claude/token-optimizer-cache](/var/www/_bases/base_ptvx_fila5/.claude/token-optimizer-cache)

## Why This Layout

- local binary path is deterministic and does not depend on live `npx` downloads
- project-scoped `.mcp.json` matches Anthropic's current shared-project MCP pattern
- `.claude/mcp_servers.json` is kept in sync for repository compatibility with existing local tooling

## Verification

Recommended checks:

```bash
node -v
npm view @ooples/token-optimizer-mcp version
```

Claude Code checks:

```bash
claude mcp list
claude mcp get token-optimizer
```

If Claude Code is already open, restart it after changing MCP config.

## Usage

The optimizer is most useful when:

- raw docs are huge
- the same file or tool result is fetched multiple times
- prompt growth comes from tool output rather than user instructions

Use it together with the project second-brain workflow:

1. query `docs/wiki/` first
2. use QMD for targeted retrieval
3. let the MCP optimizer reduce repeated or bulky tool context
4. persist durable findings back into wiki pages

## Troubleshooting

If the server is listed but not usable:

- verify the binary exists at `bashscripts/mcp/node_modules/.bin/token-optimizer-mcp`
- verify Node is available
- restart Claude Code
- check whether the client is reading `.mcp.json` or `.claude/mcp_servers.json`

If token pressure remains high:

- reduce raw file reads
- favor QMD snippet retrieval over full-document loads
- split work into shorter sub-tasks
- clean or compress oversized context files such as `CLAUDE.md`

## References

- Anthropic Claude Code MCP docs: https://docs.anthropic.com/en/docs/claude-code/mcp
- Token Optimizer MCP repository: https://github.com/ooples/token-optimizer-mcp
- Token Optimizer MCP npm package: https://www.npmjs.com/package/@ooples/token-optimizer-mcp
