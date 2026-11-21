---
title: "Sync Remote Repo - Test Plan"
type: concept
tags: [sync, remote, repo, test]
created: 2026-07-14
updated: 2026-07-14
qmd: "sync-remote-repo-test-plan sync remote repo - test plan"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./discussion-ai-work-summary.md"
  - "./fix-is-ci-context-not-found.md"
  - "./github-action-setup-required.md"
  - "./github-actions-fix-report.md"
  - "./issue-multi-agent-collaboration.md"
  - "./issue-subtree-sync-test.md"
  - "./sync-remote-repo-docs-summary.md"
---

# Sync Remote Repo - Test Plan

> **Purpose**: Verify that sync_remote_repo.sh and GitHub Actions workflow work correctly  
> **Script**: `bashscripts/git/subtrees/sync_remote_repo.sh`  
> **Workflow**: `.github/workflows/sync-remote-repo.yml`  
> **Date**: 2026-03-13

---

## 🎯 Test Objectives

### Primary Goal
Verify that git subtrees sync works **BIDIRECTIONALLY**:

1. **Main Repo → Subtree Repo**: Files added in main repo modules appear in remote repository
2. **Subtree Repo → Main Repo**: Files added in remote repository appear in main repo modules

### Secondary Goals
- ✅ Script syntax is valid
- ✅ Script runs in CLI mode
- ✅ Script runs in CI mode (GitHub Actions)
- ✅ No errors during execution
- ✅ Files are properly synced

---

## 📋 Test Scenarios

### Test 1: Script Syntax Validation

**Command**:
```bash
bash -n bashscripts/git/subtrees/sync_remote_repo.sh
```

**Expected**: Exit code 0 (no output)

**Status**: ✅ PASSED

---

### Test 2: CLI Mode - Dry Run

**Command**:
```bash
CI=true bashscripts/git/subtrees/sync_remote_repo.sh laraxot
```

**Expected**:
- Script executes without errors
- All subtrees are synced
- No backup is performed (CI mode)

**Status**: ⏳ PENDING

---

### Test 3: GitHub Actions Workflow

**Trigger**: Push to `dev` branch OR manual workflow dispatch

**Expected**:
- Workflow starts successfully
- All steps complete without errors
- Subtrees are synced
- Changes are committed and pushed back to main repo

**Status**: ⏳ PENDING

---

### Test 4: Bidirectional Sync Test

#### 4a: Main Repo → Subtree Repo

**Steps**:
1. Create a test file in a module directory:
   ```bash
   echo "Test content" > laravel/Modules/Xot/test_sync_file.txt
   ```

2. Commit and push:
   ```bash
   git add laravel/Modules/Xot/test_sync_file.txt
   git commit -m "test: Add sync test file"
   git push origin dev
   ```

3. Trigger GitHub Actions workflow

4. Check remote repository (e.g., laraxot/xot_fila5) for the file

**Expected**: File appears in remote repository

**Status**: ⏳ PENDING

#### 4b: Subtree Repo → Main Repo

**Steps**:
1. In remote repository (e.g., laraxot/xot_fila5), create a test file:
   ```bash
   echo "Remote test content" > test_from_remote.txt
   git add test_from_remote.txt
   git commit -m "test: Add file from remote"
   git push origin dev
   ```

2. Trigger GitHub Actions workflow

3. Check main repo for the file:
   ```bash
   ls -la laravel/Modules/Xot/test_from_remote.txt
   ```

**Expected**: File appears in main repo module directory

**Status**: ⏳ PENDING

---

## 🔧 Test Setup

### Prerequisites

1. **Git Configuration**:
   ```bash
   git config --global user.name "Test User"
   git config --global user.email "test@example.com"
   ```

2. **GitHub Secrets**:
   - `BASHSCRIPTS_TOKEN`: GitHub PAT with `repo` scope
   - Must be set in repository settings

3. **gitmodules.ini Configuration**:
   ```ini
   [submodule "xot"]
       path = laravel/Modules/Xot
       url = git@github.com:laraxot/xot_fila5.git
       branch = dev
   ```

### Test Files

Create these test files during testing:

**File 1** (Main → Remote):
```bash
# Content: test_sync_file.txt
This file was created in the main repository.
If you can read this, the sync is working!
Timestamp: $(date)
```

**File 2** (Remote → Main):
```bash
# Content: test_from_remote.txt
This file was created in the remote repository.
If you can read this, the bidirectional sync is working!
Timestamp: $(date)
```

---

## 📊 Test Checklist

### Pre-Test Verification

- [ ] Script syntax is valid: `bash -n script.sh`
- [ ] Script is executable: `chmod +x script.sh`
- [ ] Libraries exist: `ls bashscripts/lib/`
- [ ] gitmodules.ini exists and is valid
- [ ] GitHub secrets are configured
- [ ] Remote repositories are accessible

### CLI Mode Tests

- [ ] Script runs without errors in CI mode
- [ ] Script runs without errors in CLI mode (interactive)
- [ ] Backup is skipped in CI mode
- [ ] Backup is performed in CLI mode (if interactive)
- [ ] All subtrees are processed
- [ ] No "command not found" errors
- [ ] No syntax errors during execution

### GitHub Actions Tests

- [ ] Workflow triggers on push to dev
- [ ] Workflow can be manually dispatched
- [ ] All steps complete successfully
- [ ] No authentication errors
- [ ] Subtrees are synced
- [ ] Changes are committed
- [ ] Changes are pushed to dev branch

### Bidirectional Sync Tests

- [ ] File created in main repo appears in remote
- [ ] File created in remote appears in main repo
- [ ] File content is preserved
- [ ] Git history is preserved
- [ ] No merge conflicts
- [ ] Sync is idempotent (running twice doesn't duplicate)

---

## 🐛 Known Issues to Watch For

### Issue 1: Function Not Found

**Error**: `git_safe_directory_add: command not found`

**Cause**: Function not defined in script or sourced libraries

**Fix**: Ensure function is defined in script or `custom.sh`

**Status**: ✅ FIXED - Function exported in script

### Issue 2: Syntax Error with Token `(`

**Error**: `syntax error near unexpected token '('`

**Cause**: Duplicate function definitions or bash/sh incompatibility

**Fix**: Remove duplicate definitions, ensure bash is used

**Status**: ✅ FIXED - Consolidated function definitions

### Issue 3: Authentication Failed

**Error**: `fatal: Authentication failed`

**Cause**: Missing or invalid GitHub token

**Fix**: Set `BASHSCRIPTS_TOKEN` secret in repository settings

**Status**: ⏳ TO VERIFY

### Issue 4: Branch Not Found

**Error**: `fatal: couldn't find remote ref refs/heads/dev`

**Cause**: Remote branch doesn't exist

**Fix**: Create branch in remote or update gitmodules.ini

**Status**: ⏳ TO VERIFY

---

## 📝 Test Execution Log

### Test Run 1: Syntax Validation

**Date**: 2026-03-13  
**Command**: `bash -n bashscripts/git/subtrees/sync_remote_repo.sh`  
**Result**: ✅ PASSED - No syntax errors  
**Notes**: Script syntax is valid after fixes

### Test Run 2: CLI Mode

**Date**: PENDING  
**Command**: `CI=true bashscripts/git/subtrees/sync_remote_repo.sh laraxot`  
**Result**: ⏳ PENDING  
**Notes**: Awaiting execution

### Test Run 3: GitHub Actions

**Date**: PENDING  
**Workflow**: Manual dispatch  
**Result**: ⏳ PENDING  
**Notes**: Awaiting workflow run

### Test Run 4: Bidirectional Sync

**Date**: PENDING  
**Result**: ⏳ PENDING  
**Notes**: Awaiting workflow test

---

## 🎯 Success Criteria

The test is successful if:

1. ✅ Script runs without syntax errors
2. ✅ Script runs without runtime errors in both CLI and CI modes
3. ✅ GitHub Actions workflow completes successfully
4. ✅ Files created in main repo appear in remote repos
5. ✅ Files created in remote repos appear in main repo
6. ✅ No data loss during sync
7. ✅ Git history is preserved
8. ✅ No merge conflicts (or they are resolved automatically)

---

## 📞 Next Steps

1. **Execute CLI mode test**:
   ```bash
   CI=true bashscripts/git/subtrees/sync_remote_repo.sh laraxot
   ```

2. **Trigger GitHub Actions workflow**:
   - Go to Actions tab
   - Select "Sync Remote Repo"
   - Click "Run workflow"
   - Select `dev` branch
   - Click "Run workflow"

3. **Create test file in main repo**:
   ```bash
   echo "Test $(date)" > laravel/Modules/Xot/test_sync.txt
   git add .
   git commit -m "test: Sync test file"
   git push origin dev
   ```

4. **Verify file appears in remote repo**:
   - Check GitHub: laraxot/xot_fila5
   - Look for `test_sync.txt`

5. **Create test file in remote repo**:
   - Go to GitHub: laraxot/xot_fila5
   - Create file: `test_from_remote.txt`
   - Commit to `dev` branch

6. **Trigger workflow and verify**:
   - Run workflow
   - Check main repo for `test_from_remote.txt`

---

## 📊 Test Results Summary

| Test | Status | Date | Notes |
|------|--------|------|-------|
| Syntax Validation | ✅ PASSED | 2026-03-13 | No errors |
| CLI Mode | ⏳ PENDING | - | Awaiting execution |
| GitHub Actions | ⏳ PENDING | - | Awaiting workflow run |
| Main → Remote Sync | ⏳ PENDING | - | Awaiting test |
| Remote → Main Sync | ⏳ PENDING | - | Awaiting test |

---

**Test Plan Created**: 2026-03-13  
**Test Plan Updated**: 2026-03-13  
**Script Fixed**: ✅ YES  
**Ready for Testing**: ✅ YES  
**Test Executor**: AI Agent Teams
