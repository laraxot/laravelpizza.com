---
title: "🚨 IMPORTANT: GitHub Action Setup Required"
type: concept
tags: [github, action, setup, required]
created: 2026-07-14
updated: 2026-07-14
qmd: "github-action-setup-required 🚨 important: github action setup required"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./discussion-ai-work-summary.md"
  - "./fix-is-ci-context-not-found.md"
  - "./github-actions-fix-report.md"
  - "./issue-multi-agent-collaboration.md"
  - "./issue-subtree-sync-test.md"
  - "./sync-remote-repo-docs-summary.md"
  - "./sync-remote-repo-test-plan.md"
---

# 🚨 IMPORTANT: GitHub Action Setup Required

> **Date**: 2026-03-13  
> **Status**: ⚠️ **REQUIRES MANUAL SETUP**  
> **Priority**: HIGH

---

## ❗ Action Status

**Workflow**: 🔄 Sync Subtrees  
**Status**: ⚠️ **FAILS** - Missing secret configuration  
**Error**: "The ssh-private-key argument is empty"

---

## 🔧 What You Need to Do (Manual Steps)

The GitHub Action is **created and pushed**, but **WILL NOT WORK** until you configure the SSH key secret.

### Step 1: Generate SSH Key

```bash
# Generate new SSH key for GitHub Actions
ssh-keygen -t ed25519 -C "actions@github.com" -f ~/.ssh/subtree_sync

# Press Enter when asked for passphrase (no passphrase for actions)
```

---

### Step 2: Add Public Key to GitHub

1. Go to: **https://github.com/settings/keys**
2. Click **"New SSH key"**
3. Title: "GitHub Actions - Subtree Sync"
4. Key type: **Authentication Key**
5. Paste content of:
   ```bash
   cat ~/.ssh/subtree_sync.pub
   ```
6. Click **"Add SSH key"**

---

### Step 3: Add Private Key to Repo Secrets

1. Go to: **https://github.com/laraxot/base_fixcity_fila5/settings/secrets/actions**
1. Go to: **https://github.com/laraxot/platform/settings/secrets/actions**
2. Click **"New repository secret"**
3. Fill in:
   - **Name**: `SUBTREE_SSH_KEY`
   - **Value**: Content of:
     ```bash
     cat ~/.ssh/subtree_sync
     ```
4. Click **"Add secret"**

---

### Step 4: Test the Workflow

```bash
# Go to project root
cd /var/www/_bases/base_fixcity_fila5
cd /var/www/_bases/base_ptvx_fila5

# Create empty commit to trigger workflow
git commit --allow-empty -m "Test subtree sync workflow"

# Push to dev branch
git push origin dev

# Wait 1-2 minutes, then check:
# https://github.com/laraxot/base_fixcity_fila5/actions
# https://github.com/laraxot/platform/actions
```

---

## ✅ Expected Result

After configuring secrets:

```
🔄 Sync Subtrees workflow
├── ✅ Checkout repository
├── ✅ Setup SSH
├── ✅ Configure Git
├── ✅ Show gitmodules.ini
├── ✅ Sync Subtrees (18+ submodules)
└── ✅ Sync Complete

Status: ✅ Success
```

---

## 📚 Documentation

Full documentation is available at:

- **Workflow Guide**: `bashscripts/docs/github/actions/sync-subtrees.md`
- **Script Guide**: `bashscripts/docs/git/subtrees/sync-remote-repo.md`
- **Final Report**: `bashscripts/docs/github/actions/subtree-sync-final-report.md`

---

## 🐛 Troubleshooting

### If Action Still Fails

1. **Check secret name is exact**: `SUBTREE_SSH_KEY` (case-sensitive)
2. **Verify SSH key format**: Should start with `-----BEGIN OPENSSH PRIVATE KEY-----`
3. **Wait 1-2 minutes**: GitHub may take time to recognize new secret
4. **Check branch name**: Must be exactly `dev` (not `develop` or `main`)

### Check Workflow Logs

```bash
# Using GitHub CLI
gh run list --repo laraxot/base_fixcity_fila5
gh run view <run-id> --log
```

Or visit: **https://github.com/laraxot/base_fixcity_fila5/actions**

---

## 📞 Questions?

If you have questions about the setup:

1. Check documentation in `bashscripts/docs/github/actions/`
2. Review error logs on GitHub Actions
3. Contact: dev @fixcity.example.com
3. Contact: dev @laraxot.example.com

---

**Created By**: AI Agent  
**Date**: 2026-03-13  
**Next Step**: Configure SSH key and test workflow
