---
title: "GitHub Issues - CORRECT WORKFLOW"
type: concept
tags: [github, issues, workflow]
created: 2026-07-14
updated: 2026-07-14
qmd: "github-issues-workflow github issues - correct workflow"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./01-gsd-workflow.md"
  - "./02-bmad-workflow.md"
  - "./03-architecture-zen.md"
  - "./04-filament-philosophy.md"
  - "./05-front-office-audit.md"
  - "./06-cinematic-effects.md"
  - "./07-mcp-tailwind-ui.md"
---

# GitHub Issues - CORRECT WORKFLOW

**CRITICAL RULE**: GitHub Issues e Discussions si creano **ONLINE** su GitHub, NON come file locali!

---

## Repository

- **URL**: https://github.com/laraxot/base_predict_fila5
- **Remote**: `origin` (git@github.com:laraxot/base_predict_fila5.git)
- **URL**: https://github.com/laraxot/base_ptvx_fila5
- **Remote**: `origin` (git@github.com:laraxot/base_ptvx_fila5.git)

---

## ✅ CORRECT: Create Issues Online

### Method 1: GitHub Web Interface

```
1. Vai su: https://github.com/laraxot/base_predict_fila5/issues
1. Vai su: https://github.com/laraxot/base_ptvx_fila5/issues
2. Clicca "New issue"
3. Scegli template
4. Compili e invii
```

### Method 2: GitHub CLI

```bash
# Login (prima volta)
gh auth login

# Crea issue
gh issue create --title "Bug: ..." --body "..."

# Crea discussion
gh discussion create --title "..." --body "..."
```

---

## ❌ WRONG: NEVER Do This

```bash
# NO creare file markdown locali
echo "# Bug" > .github/ISSUES/001-bug.md  ← SBAGLIATO!

# NO pensare che file locali = issue GitHub
git add .github/ISSUES/  ← INUTILE!
```

---

## Why Online?

1. ✅ **Tracciabilità** - Link diretti, notifiche, menzioni
2. ✅ **Collaborazione** - Commenti, reaction, assignee
3. ✅ **Integration** - Si collega a PR, commit, project board
4. ✅ **Search** - Ricerca full-text, filtri, label
5. ✅ **Automation** - GitHub Actions, bots, auto-close

---

## Local .github/ Folder - ONLY For

- ✅ `ISSUE_TEMPLATE/*.yml` - Template configuration
- ✅ `PULL_REQUEST_TEMPLATE.md` - PR template
- ✅ `workflows/` - GitHub Actions
- ✅ `config.yml` - GitHub configuration
- ✅ `CODEOWNERS` - Code owners

**MAI**:
- ❌ `.github/ISSUES/*.md` (issue locali)
- ❌ `.github/DISCUSSIONS/*.md` (discussion locali)

---

## Quick Commands

```bash
# List issues
gh issue list

# Create issue
gh issue create --title "Fix: ..." --body "..."

# View issue
gh issue view 123

# Comment issue
gh issue comment 123 --body "Fixed!"

# Create PR
gh pr create --title "Fix: ..." --body "Fixes #123"
```

---

## Missing Features - Create Issues

1. ⚡ **Dark Mode Toggle** - HIGH priority
2. 📈 **Advanced Charts (TradingView)** - HIGH priority
3. 💬 **Comments Section** - HIGH priority
4. 📤 **Share Buttons** - MEDIUM priority

**Create issues on GitHub**: https://github.com/laraxot/base_predict_fila5/issues
**Create issues on GitHub**: https://github.com/laraxot/base_ptvx_fila5/issues

---

**Last Updated**: 2026-03-20  
**Docs**: `docs/project/GITHUB_ISSUES_ONLINE_RULE.md`
