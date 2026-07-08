# MCP (Model Context Protocol) Configuration

> **Last Updated**: 2026-03-13  
> **Status**: 🔄 In Progress  
> **Repository**: FixCity Platform

---

## 📋 Overview

MCP (Model Context Protocol) è un protocollo standard per connettere modelli AI a sistemi esterni come GitHub, database, API, ecc.

---

## 🔧 MCP Servers Available

### GitHub MCP Server

**Status**: ⚠️ Deprecated (npm package no longer supported)

**Alternative**: Usare GitHub CLI (`gh`) direttamente

**Installazione**:
```bash
# Install GitHub CLI (già installato)
sudo apt install gh

# Verifica autenticazione
gh auth status

# Autenticati se necessario
gh auth login
```

**Comandi Utili**:
```bash
# Creare Issue
gh issue create --title "Titolo" --body "Descrizione"

# Creare Pull Request
gh pr create --title "Titolo" --body "Descrizione"

# Vedere Issues
gh issue list

# Vedere PR
gh pr list

# Checkout PR
gh pr checkout <number>
```

---

## 📁 MCP Configuration Files

### VS Code Settings

File: `.vscode/settings.json`

```json
{
  "mcp.servers": {
    "github": {
      "command": "gh",
      "args": ["api", "graphql"],
      "env": {
        "GH_TOKEN": "${env:GITHUB_TOKEN}"
      }
    },
    "filesystem": {
      "command": "node",
      "args": ["/path/to/mcp-filesystem-server/dist/index.js"],
      "env": {
        "ROOT": "${workspaceFolder}"
      }
    }
  }
}
```

### Qwen Code Configuration

File: `.qwen/mcp-config.json`

```json
{
  "mcpServers": {
    "github": {
      "type": "cli",
      "command": "gh",
      "authRequired": true
    },
    "git": {
      "type": "cli",
      "command": "git"
    },
    "filesystem": {
      "type": "builtin"
    }
  }
}
```

---

## 🚀 Setup Instructions

### Step 1: Install GitHub CLI

```bash
# Ubuntu/Debian
sudo apt update
sudo apt install gh

# macOS
brew install gh

# Verifica installazione
gh --version
```

### Step 2: Authenticate with GitHub

```bash
# Login
gh auth login

# Scegli:
# - GitHub.com
# - HTTPS
# - Login with browser
# - Authorize git
```

### Step 3: Verify Authentication

```bash
gh auth status
```

Output atteso:
```
github.com
  ✓ Logged in to github.com account yourusername
  - Active account: true
  - Git operations protocol: ssh
  - Token: gho_************************************
  - Token scopes: 'repo', 'read:org'
```

### Step 4: Test GitHub Commands

```bash
# View current repo
gh repo view

# List issues
gh issue list

# List PRs
gh pr list
```

---

## 📝 Common MCP Operations

### Create GitHub Issue

```bash
gh issue create \
  --title "🐛 Fix Database Naming Convention" \
  --body "Description of the issue" \
  --label "documentation,good first issue" \
  --assignee "@me"
```

### Create GitHub Pull Request

```bash
# After making changes
git checkout -b feature/fix-database-naming

git add .
git commit -m "📁 Fix database directory naming convention"

git push -u origin feature/fix-database-naming

# Create PR
gh pr create \
  --title "📁 Fix database directory naming" \
  --body "This PR fixes the database directory naming convention" \
  --base main \
  --reviewer "@me"
```

### Comment on Issue

```bash
gh issue comment <number> --body "Working on this!"
```

### Close Issue

```bash
gh issue close <number>
```

---

## 🔐 Security Best Practices

### Token Management

1. **Never commit tokens** to git
2. **Use environment variables**:
   ```bash
   export GITHUB_TOKEN="gho_..."
   ```

3. **Use gh auth token** for scripts:
   ```bash
   TOKEN=$(gh auth token)
   ```

4. **Rotate tokens regularly**

### Repository Permissions

Minimum required scopes:
- `repo` - Full control of private repositories
- `read:org` - Read organization membership
- `gist` - Create gists

---

## 🛠️ Troubleshooting

### Issue: "Command not found: gh"

**Solution**:
```bash
# Install gh
sudo apt install gh

# Or download from: https://github.com/cli/cli/releases
```

### Issue: "Authentication required"

**Solution**:
```bash
# Re-authenticate
gh auth logout
gh auth login
```

### Issue: "Token expired"

**Solution**:
```bash
# Refresh token
gh auth refresh
```

### Issue: "Rate limit exceeded"

**Solution**:
```bash
# Check rate limit
gh api rate_limit

# Wait or use authenticated requests (higher limit)
```

---

## 📚 Resources

### Official Documentation
- [GitHub CLI](https://cli.github.com/)
- [GitHub CLI Manual](https://cli.github.com/manual/)
- [MCP Specification](https://modelcontextprotocol.io/)

### Tutorials
- [Getting Started with gh](https://docs.github.com/en/github-cli/github-cli/getting-started-with-gh)
- [GitHub CLI Best Practices](https://github.blog/2021-03-11-scripting-with-github-cli/)

### Tools
- [gh Extensions](https://github.com/topics/gh-extension)
- [MCP Servers](https://github.com/modelcontextprotocol/servers)

---

## 🤝 Contributing

To contribute to MCP configuration:

1. Test configuration on your system
2. Document any issues encountered
3. Submit PR with fixes
4. Update this document

---

**Maintainer**: @marco76tv  
**Contact**: dev @fixcity.example.com  
**Last Tested**: 2026-03-13
