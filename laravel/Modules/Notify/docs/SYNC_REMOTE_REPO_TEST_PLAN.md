# Sync Remote Repo - Test Plan

**Date**: 2026-03-13  
**Status**: Ready for Testing  
**Script**: `bashscripts/git/subtrees/sync_remote_repo.sh`  
**Workflow**: `.github/workflows/sync-remote-repo.yml`

---

## 🎯 Test Objective

Verify that `sync_remote_repo.sh` works correctly for **bidirectional sync**:

1. **Local → Remote**: Files added locally appear in remote repository after sync
2. **Remote → Local**: Files added to remote repository appear locally after sync

---

## 📋 Test Scenarios

### Test 1: Local → Remote Sync

**Steps**:
1. Create test file in local module (e.g., `laravel/Modules/Blog/SYNC_TEST.md`)
2. Run sync script: `./bashscripts/git/subtrees/sync_remote_repo.sh laraxot`
3. Check remote repository (module_blog_fila5.git) on GitHub
4. Verify file appears in remote repository

**Expected Result**:
- ✅ File appears in remote repository
- ✅ Commit message shows sync operation
- ✅ No errors during sync

**Verification**:
```bash
# Check remote repository via GitHub web UI
https://github.com/laraxot/module_blog_fila5.git

# Or via git command
git ls-remote git@github.com:laraxot/module_blog_fila5.git
```

---

### Test 2: Remote → Local Sync

**Steps**:
1. Add file to remote repository (via GitHub web UI or git push)
2. Run sync script locally
3. Check if file appears in local module directory
4. Verify file content matches

**Expected Result**:
- ✅ File appears in local directory
- ✅ File content matches remote
- ✅ No conflicts during sync

**Verification**:
```bash
# Check local directory
ls -la laravel/Modules/Blog/
cat laravel/Modules/Blog/REMOTE_TEST.md
```

---

### Test 3: GitHub Action Automatic Sync

**Steps**:
1. Push commit to `dev` branch
2. GitHub Action triggers automatically
3. Monitor action logs
4. Verify sync completed successfully
5. Check both local and remote repositories

**Expected Result**:
- ✅ Action completes successfully
- ✅ All submodules synced
- ✅ Changes committed and pushed
- ✅ No SSH permission errors

**Verification**:
```bash
# Check action status
gh run list --workflow "Sync Remote Repo" --limit 1

# View action logs
gh run view <run-id> --log
```

---

## 🔧 Prerequisites

### Local Environment
- ✅ Bash 5.0+
- ✅ Git 2.30+
- ✅ Access to remote repositories (SSH or HTTPS)
- ✅ `BASHSCRIPTS_TOKEN` environment variable (for CI)

### GitHub Actions
- ✅ `BASHSCRIPTS_TOKEN` secret configured
- ✅ Workflow file: `.github/workflows/sync-remote-repo.yml`
- ✅ Script: `bashscripts/git/subtrees/sync_remote_repo.sh`

---

## 📊 Test Checklist

### Pre-Test Checks
- [ ] Script syntax valid (`bash -n script.sh`)
- [ ] gitmodules.ini exists and is valid
- [ ] Remote repositories accessible
- [ ] Test files created

### During Test
- [ ] No syntax errors
- [ ] No permission errors
- [ ] All submodules processed
- [ ] Conflicts handled correctly

### Post-Test Verification
- [ ] Files synced correctly
- [ ] Remote repositories updated
- [ ] Local repositories updated
- [ ] No data loss

---

## 🐛 Common Issues & Solutions

### Issue 1: Permission Denied (publickey)

**Symptoms**:
```
git@github.com: Permission denied (publickey).
fatal: Could not read from remote repository.
```

**Solution**:
- Ensure `BASHSCRIPTS_TOKEN` is set in CI
- Script converts SSH to HTTPS in CI mode
- Check token has correct permissions

### Issue 2: Unbound Variable

**Symptoms**:
```
line 36: CI: unbound variable
```

**Solution**:
- Use `${CI:-}` for safe variable access
- Script handles both CI and non-CI environments

### Issue 3: Command Not Found

**Symptoms**:
```
is_ci_context: command not found
git_safe_directory_add: command not found
```

**Solution**:
- Ensure functions are defined before use
- Source libraries with absolute paths
- Check library files exist

### Issue 4: Merge Conflicts

**Symptoms**:
```
CONFLICT (content): Merge conflict in file.md
```

**Solution**:
- Script auto-resolves by accepting upstream changes
- Check conflict resolution logic
- Manual intervention if needed

---

## 📝 Test Results Template

### Test Run #1 - [DATE]

**Tester**: [AI Agent Name]  
**Environment**: Local / GitHub Actions  
**Script Version**: [Commit SHA]

#### Test 1: Local → Remote

- **Status**: ✅ Pass / ❌ Fail
- **File**: SYNC_TEST.md
- **Remote Repo**: module_blog_fila5.git
- **Result**: [Description]

#### Test 2: Remote → Local

- **Status**: ✅ Pass / ❌ Fail
- **File**: REMOTE_TEST.md
- **Local Path**: laravel/Modules/Blog/
- **Result**: [Description]

#### Test 3: GitHub Action

- **Status**: ✅ Pass / ❌ Fail
- **Run ID**: [GitHub Actions Run ID]
- **Duration**: [Time]
- **Result**: [Description]

#### Issues Found

- [List any issues]

#### Actions Taken

- [List fixes applied]

---

## 🎯 Success Criteria

Test is considered successful when:

1. ✅ Script runs without errors (exit code 0)
2. ✅ Files sync bidirectionally correctly
3. ✅ No permission errors
4. ✅ GitHub Action completes successfully
5. ✅ All submodules processed
6. ✅ Conflicts handled automatically

---

## 🔗 Related Documentation

- [Script Documentation](../../../bashscripts/docs/git/subtrees/sync-remote-repo-guide.md)
- [Workflow Configuration](../../../.github/workflows/sync-remote-repo.yml)
- [GitHub Issue #11](https://github.com/laraxot/base_fixcity_fila5/issues/11)
- [GitHub Issue #12](https://github.com/laraxot/base_fixcity_fila5/issues/12)

---

**Created**: 2026-03-13  
**Last Updated**: 2026-03-13  
**Next Test**: When GitHub Action runs
