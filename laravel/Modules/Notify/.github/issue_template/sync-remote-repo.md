---
name: 🔄 Sync Remote Repo Script Issue
about: Report a bug or request a feature for the sync_remote_repo.sh script
title: '[SYNC] '
labels: ['sync-script', 'bug', 'enhancement']
assignees: ''
---

## 🎯 Issue Type

- [ ] Bug Report (script fails, unexpected behavior)
- [ ] Feature Request (new functionality)
- [ ] Documentation Issue (missing or unclear docs)
- [ ] Performance Issue (slow execution, timeouts)
- [ ] CI/CD Issue (GitHub Actions workflow problem)

## 📋 Description

<!-- Provide a clear and concise description of the issue -->

## 🔍 Environment

### For CLI Issues
```bash
# OS and version
uname -a

# Git version
git --version

# Bash version
bash --version

# Script path
ls -la bashscripts/git/subtrees/sync_remote_repo.sh
```

### For GitHub Actions Issues
```yaml
# Workflow file
.github/workflows/sync-remote-repo.yml

# Recent workflow run URL
https://github.com/laraxot/bashscripts_fila5/actions/runs/XXX
```

## 🐛 Reproduction Steps (for bugs)

1. 
2. 
3. 

## ✅ Expected Behavior

<!-- What should happen -->

## ❌ Actual Behavior

<!-- What actually happens -->

## 📝 Logs

### CLI Mode Logs

```bash
# Run with verbose output
bash -x bashscripts/git/subtrees/sync_remote_repo.sh laraxot

# Paste output below
```

### GitHub Actions Logs

```yaml
# Paste relevant log lines from workflow run
```

## 🔍 Diagnostics

### Git Configuration

```bash
# Check gitmodules.ini
cat gitmodules.ini | head -20

# Check remote configuration
git remote -v

# Check branch configuration
git branch -a
```

### Script Validation

```bash
# Syntax check
bash -n bashscripts/git/subtrees/sync_remote_repo.sh

# File permissions
ls -la bashscripts/git/subtrees/sync_remote_repo.sh
```

## 💡 Proposed Solution (optional)

<!-- If you have ideas on how to fix this -->

## 🚨 Impact

- [ ] Blocks development
- [ ] Blocks CI/CD pipeline
- [ ] Minor inconvenience
- [ ] Documentation only

## 📚 Related Documentation

- [ ] I've read `bashscripts/docs/git/sync-remote-repo-guide.md`
- [ ] I've checked `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md`
- [ ] I've searched existing issues

## 🔗 Related Issues/PRs

<!-- Link to any related GitHub issues or PRs -->

## 📷 Screenshots (optional)

<!-- If applicable, add screenshots to help explain the issue -->

## 🤝 Agent Coordination

**Agent ID**: <!-- Your agent identifier -->
**Date**: <!-- YYYY-MM-DD -->
**Already Contacted**: <!-- List other agents you've coordinated with -->

---

## ✅ Checklist

Before submitting this issue, please verify:

- [ ] I've tested in both CLI and CI modes (if applicable)
- [ ] I've checked the coordination log for conflicting work
- [ ] I've included all relevant logs
- [ ] I've provided environment details
- [ ] I've searched for duplicate issues
