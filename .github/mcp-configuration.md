# MCP Configuration for LaravelPizza

This file documents how to configure Model Context Protocol (MCP) servers for enhanced Copilot integration with this Laravel project.

## Available MCP Servers

### 1. Filesystem Navigation (Built-in)
Enables Copilot to explore project structure and read files efficiently.

**Recommended configuration:**
```json
{
  "filesystem": {
    "allow_read": ["/**"],
    "allow_write": [],
    "exclude_patterns": [
      "**/vendor/**",
      "**/node_modules/**",
      "**/.git/**",
      "**/storage/**",
      "**/.env*",
      "**/*.log"
    ],
    "include_patterns": [
      "**/*.php",
      "**/*.blade.php",
      "**/*.js",
      "**/*.css",
      "**/*.json",
      "**/*.md",
      "**/composer.json",
      "**/package.json"
    ]
  }
}
```

### 2. Git Integration (Optional)
Provides context about commits, branches, and history.

**Setup:**
```bash
# Install git MCP server (if not already available)
npm install -g @modelcontextprotocol/server-git
```

**Configuration:**
```json
{
  "git": {
    "enable_branch_context": true,
    "enable_commit_history": true,
    "max_commits_to_analyze": 10,
    "exclude_branches": ["archive/**"]
  }
}
```

### 3. Laravel-Specific Tools (Recommended)
For analyzing Laravel-specific patterns and generating code.

**What it helps with:**
- Analyzing module structure and dependencies
- Understanding Eloquent relationships and scopes
- Validating Filament resource patterns
- Checking migration consistency

**Setup (manual for now):**
- Use `AGENTS.md` and `.agents/docs/` as primary reference
- Use bash commands: `php artisan module:list`, `php artisan tinker`
- Reference test patterns in existing modules

## Setup Instructions

### For Cursor IDE
Add to `.cursor/rules/mcp-config.md` or `.cursorrules`:
```
MCP Servers: filesystem (read-only), git (optional)
PHP Path: /usr/bin/php
Artisan Path: ./laravel/artisan
PHPStan Config: ./laravel/phpstan.neon
Test Command: php artisan test
```

### For VS Code with Copilot Extension
Add to `.vscode/settings.json`:
```json
{
  "github.copilot.enable": {
    "markdown": true,
    "plaintext": true
  },
  "[php]": {
    "editor.defaultFormatter": "Laravel Pint"
  }
}
```

### For Claude/OpenAI Claude
The filesystem MCP is sufficient. Reference:
- `CLAUDE.md` for architectural overview
- `AGENTS.md` for detailed rules
- `.agents/docs/agents-guide/` for specific patterns

## MCP Usage Examples

### Analyzing Module Structure
```bash
# Using Copilot with filesystem MCP
"@copilot Show me the structure of the Meetup module"
# MCP will include: Modules/Meetup/app/, Modules/Meetup/docs/, Modules/Meetup/tests/
```

### Understanding a Feature
```bash
"@copilot How does event registration work in the Meetup module?"
# MCP will traverse: Models/Event.php, Actions/Event/*, Filament/Resources/EventResource.php
```

### Generating Code from Patterns
```bash
"@copilot Generate a new Filament resource for events following XotBase patterns"
# MCP will reference existing resources as patterns
```

## Performance Optimization

- **Exclude vendor & node_modules:** Prevents MCP from analyzing dependencies (already in main config)
- **Limit commit history:** Set `max_commits_to_analyze: 10` to avoid context overload
- **Use filesystem patterns:** Include only relevant file types (PHP, Blade, JSON, MD)

## Troubleshooting

**Q: MCP server not responding**
- Ensure Node.js is installed: `node --version`
- Check MCP server is running: Look at Copilot logs
- Restart Copilot session and try again

**Q: Slow file exploration**
- Check `.exclude_patterns` is blocking `vendor/` and `node_modules/`
- Reduce `include_patterns` if searching too many file types

**Q: Git history not available**
- Ensure git MCP server is installed and running
- Check repository has commit history (not a fresh clone)

## Notes

- MCP is **optional** but recommended for large codebases like this
- Filesystem MCP alone is sufficient for most tasks
- Git MCP is helpful for understanding recent changes and branch context
- Laravel-specific analysis is available through bash commands and documentation references
