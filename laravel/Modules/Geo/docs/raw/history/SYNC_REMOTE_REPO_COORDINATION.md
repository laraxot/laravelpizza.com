# Sync Remote Repo - AI Agent Coordination Hub

> **Status:** ✅ ACTIVE - Seeking AI Agents
> 
> **Mission:** `sync_remote_repo.sh` works in BOTH CLI and GitHub Actions
> 
> **Created:** 2026-03-13
> **Issue:** #109
> **Team:** sync-subtrees-team

---

## 🚀 Quick Start for AI Agents

Sei un agente AI? Ecco cosa devi sapere:

### 1. Read These Docs First

```bash
# Main documentation
cat bashscripts/git/subtrees/README.md

# Workflow configuration
cat .github/workflows/sync-remote-repo.yml

# Skill guide
cat .qwen/skills/sync-remote-repo.md

# Team coordination
cat docs/ai-agent-teams/sync-remote-repo-team.md
```

### 2. Verify Current State

```bash
# Check script exists
ls -la bashscripts/git/subtrees/sync_remote_repo.sh

# Check workflow exists
ls -la .github/workflows/sync-remote-repo.yml

# Check gitmodules config
cat gitmodules.ini
```

### 3. Test CLI

```bash
# Make executable
chmod +x bashscripts/git/subtrees/sync_remote_repo.sh

# Dry run test
./bashscripts/git/subtrees/sync_remote_repo.sh --dry-run

# Full run
./bashscripts/git/subtrees/sync_remote_repo.sh
```

### 4. Test GitHub Actions

```bash
# From GitHub UI
# Go to: Actions → Sync Remote Repos → Run workflow

# From CLI with gh
gh workflow run sync-remote-repo.yml

# Check results
gh run list --workflow=sync-remote-repo.yml
```

---

## 📊 Current Status

### ✅ What's Done

| Component | Status | Location | Verified |
|-----------|--------|----------|----------|
| **Script** | ✅ Exists | `bashscripts/git/subtrees/sync_remote_repo.sh` | ✅ Gemini CLI |
| **Workflow** | ✅ Created | `.github/workflows/sync-remote-repo.yml` | ⏳ Pending |
| **Documentation** | ✅ Complete | `bashscripts/git/subtrees/README.md` | ✅ Gemini CLI |
| **AI Agent Team** | ✅ Created | `docs/ai-agent-teams/` | ✅ Gemini CLI |
| **GitHub Issue** | ✅ Created | Issue #109 | ✅ Gemini CLI |
| **Skill** | ✅ Created | `.qwen/skills/sync-remote-repo.md` | ✅ Gemini CLI |
| **Lib Support** | ✅ Optimized | `bashscripts/lib/custom.sh` (CI support) | ✅ Gemini CLI |

### 🟡 What Needs Testing

- [ ] CLI execution test
- [ ] GitHub Actions manual trigger test
- [ ] Scheduled run verification
- [ ] Error handling test
- [ ] Log upload verification
- [ ] Notification test

---

## 🎯 Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│         bashscripts/git/subtrees/sync_remote_repo.sh     │
│                                                          │
│  Detects environment automatically:                      │
│  - If [ -n "$CI" ] → GitHub Actions mode                 │
│  - Else → CLI mode                                       │
└─────────────────────────────────────────────────────────┘
                         │
        ┌────────────────┴────────────────┐
        │                                 │
        ▼                                 ▼
┌───────────────┐              ┌──────────────────┐
│  CLI Mode     │              │ GitHub Actions   │
│               │              │                  │
│ • Interactive │              │ • Automated      │
│ • Manual      │              │ • Scheduled      │
│ • Full logs   │              │ • CI logs        │
│ • Backup ON   │              │ • Backup OFF     │
│ • SSH/PAT     │              │ • GH_PAT only    │
└───────────────┘              └──────────────────┘
```

---

## 🔧 Configuration

### Required Secrets

```yaml
# GitHub Actions Secrets
# Settings → Secrets → Actions

GH_PAT: <your-personal-access-token>
```

### Create GH_PAT

1. GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token
3. Scopes: `repo`, `workflow`
4. Copy token
5. Add to repository secrets

### Workflow Triggers

```yaml
on:
  schedule:
    - cron: '0 2 * * *'     # Daily at 2 AM UTC
  
  workflow_dispatch:         # Manual trigger
    inputs:
      org:
        description: 'Organization override'
        required: false
  
  push:
    branches:
      - main
      - dev
    paths:
      - 'gitmodules.ini'
      - 'bashscripts/git/subtrees/**'
```

---

## 📋 Testing Checklist

### CLI Testing

```bash
# 1. Verify script
[ -x bashscripts/git/subtrees/sync_remote_repo.sh ] && echo "✅ Script exists and executable"

# 2. Verify gitmodules
[ -f gitmodules.ini ] && echo "✅ gitmodules.ini exists"

# 3. Dry run
./bashscripts/git/subtrees/sync_remote_repo.sh --dry-run

# 4. Full run
./bashscripts/git/subtrees/sync_remote_repo.sh

# 5. Verify results
git status
git log --oneline -5
```

### GitHub Actions Testing

```bash
# 1. Manual trigger
gh workflow run sync-remote-repo.yml

# 2. Monitor run
gh run watch

# 3. View logs
gh run view <run-id> --log

# 4. Check artifacts
gh run view <run-id> --dir ./logs
```

---

## 🤖 AI Agent Roles

### Team Members

| Role | Responsibilities | Assigned To | Status |
|------|------------------|------------|--------|
| **Team Lead** | Overall coordination, CLI testing | _Open_ | ⏳ |
| **GitHub Actions Specialist** | Workflow testing, CI/CD | **Gemini CLI** | ✅ ACTIVE |
| **Script Analyst** | Code review, improvements | **Gemini CLI** | ✅ ACTIVE |
| **Documentation Lead** | Docs, examples, guides | _Open_ | ⏳ |
| **Testing Coordinator** | Test scenarios, validation | _Open_ | ⏳ |

### How to Claim a Role

1. **Comment on Issue #109** with your chosen role
2. **Update this document** with your agent name
3. **Start working** on the role responsibilities
4. **Report progress** daily

---

## 📝 Coordination Rules

### Before You Start

```bash
# 1. Check coordination hub
cat docs/ai-agent-coordination.md

# 2. Check existing work
git log --oneline --grep="sync" -20

# 3. Check open issues
gh issue list --state open | grep sync
```

### While Working

```bash
# 1. Use feature branch
git checkout -b ai-agent/sync-task-name

# 2. Commit frequently
git add -A
git commit -m "[ai] Progress on sync task"

# 3. Push regularly
git push origin ai-agent/sync-task-name
```

### After Completion

```bash
# 1. Test your changes
# 2. Update documentation
# 3. Comment on Issue #109
# 4. Update coordination doc
```

---

## 🔍 Monitoring

### Check Script Status

```bash
# Last sync run
ls -la sync-report-*.json 2>/dev/null | tail -1

# Check logs
cat *.log 2>/dev/null | tail -50

# Git status
git status
```

### Check Workflow Status

```bash
# Recent runs
gh run list --workflow=sync-remote-repo.yml --limit 5

# Latest run status
gh run list --workflow=sync-remote-repo.yml --json status --jq '.[0].status'

# Check for failures
gh run list --workflow=sync-remote-repo.yml --json conclusion --jq '.[] | select(.conclusion=="failure")'
```

---

## 📚 Resources

### Key Files

| File | Purpose |
|------|---------|
| `bashscripts/git/subtrees/sync_remote_repo.sh` | Main sync script |
| `.github/workflows/sync-remote-repo.yml` | GitHub Actions workflow |
| `gitmodules.ini` | Subtree configuration |
| `bashscripts/git/subtrees/README.md` | Usage documentation |
| `.qwen/skills/sync-remote-repo.md` | AI skill guide |

### Related Issues

- **Issue #109:** Sync Remote Repo Coordination
- **Issue #108:** AI Agent Coordination Hub
- **Issue #107:** Module Folder Structure

### External Resources

- [GitHub Actions Docs](https://docs.github.com/en/actions)
- [Git Subtree Documentation](https://github.com/git/git/blob/master/contrib/subtree/git-subtree.txt)
- [gh CLI Documentation](https://cli.github.com/)

---

## 🎯 Success Criteria

- ✅ Script works from CLI without interactive prompts
- ✅ GitHub Actions workflow executes successfully using GH_PAT
- ✅ Daily sync runs automatically via cron
- ✅ Manual trigger works with org override
- ✅ Error handling and notifications are robust
- ✅ Documentation is clear for both humans and AI agents
