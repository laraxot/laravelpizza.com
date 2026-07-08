# Git Commit & Push Workflow - AI Agent Rules

**Status**: ✅ Active  
**Priority**: CRITICAL  
**Applies to**: All AI agents working on this repository

---

## 🎯 CRITICAL RULE

### **When You Are Sure Everything Works → COMMIT AND PUSH!**

**Rule**: 
> Quando sei sicuro che tutto funzioni, devi fare **git commit** e **git push** immediatamente!

**Why**:
- Changes not pushed are lost work
- GitHub Actions need committed code to run
- Other AI agents need to see your changes
- Verification requires code to be in repository
- Working code in working tree ≠ saved work

---

## 📋 When to Commit & Push

### ✅ **DO Commit & Push When**:

1. **GitHub Action Tested & Working**
   - Action completed with success ✅
   - All steps passed
   - Logs show expected behavior
   - → **COMMIT & PUSH IMMEDIATELY**

2. **Script Tested Locally**
   - Script runs without errors
   - Output is correct
   - Syntax is valid (`bash -n script.sh`)
   - → **COMMIT & PUSH**

3. **Documentation Created**
   - New docs files created
   - Existing docs updated
   - Content is accurate
   - → **COMMIT & PUSH**

4. **Configuration Changed**
   - Workflow files updated
   - Config files modified
   - Settings changed
   - → **COMMIT & PUSH**

5. **Bug Fixed**
   - Issue identified and resolved
   - Fix verified
   - → **COMMIT & PUSH**

### ❌ **DON'T Commit & Push When**:

1. **Work In Progress**
   - Code is incomplete
   - Testing still ongoing
   - Known issues not fixed
   - → Wait until complete

2. **Unverified Changes**
   - Haven't tested yet
   - Not sure if it works
   - Need to verify first
   - → Test first, then commit

3. **Breaking Changes**
   - Changes that break existing functionality
   - Need coordination with other agents
   - → Coordinate first

---

## 🔧 How to Commit & Push

### Standard Workflow

```bash
# 1. Check what changed
git status

# 2. Add relevant files
git add <files>

# 3. Verify changes
git diff --cached

# 4. Commit with clear message
git commit -m "type: description"

# 5. Push immediately
git push origin <branch>
```

### Commit Message Format

**Pattern**: `type: description`

**Types**:
- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation changes
- `ci:` - CI/CD changes
- `refactor:` - Code refactoring
- `test:` - Test additions/changes
- `chore:` - Maintenance tasks

**Examples**:
```bash
git commit -m "ci: Add sync remote repo GitHub Action"
git commit -m "docs: Add bashscripts documentation"
git commit -m "fix: Resolve symlink issues in CI"
git commit -m "feat: Implement auto-sync for submodules"
```

### After GitHub Action Success

```bash
# Action completed successfully
# Verify in GitHub Actions tab

# Then immediately:
git add .github/workflows/sync-remote-repo.yml
git commit -m "ci: Add sync remote repo GitHub Action with manual trigger"
git push origin dev

# ✅ Work is now saved and visible to all agents
```

---

## 🚨 Common Mistakes

### ❌ WRONG: Not Pushing After Success

**Scenario**:
- GitHub Action runs successfully ✅
- Agent verifies logs show success
- Agent creates documentation
- **BUT** doesn't commit/push
- Next agent starts from old state
- Work is duplicated or lost

**CORRECT**:
```bash
# After verifying action success:
git add .
git commit -m "docs: Document successful sync action"
git push origin dev
```

### ❌ WRONG: Committing Without Testing

**Scenario**:
- Create workflow file
- Commit immediately
- Push to remote
- Action fails due to syntax error
- Wastes CI/CD minutes

**CORRECT**:
```bash
# Before committing:
bash -n .github/workflows/sync-remote-repo.yml
# Verify syntax is OK

# Then commit:
git add .
git commit -m "ci: Add workflow (tested locally)"
git push
```

### ❌ WRONG: Vague Commit Messages

**WRONG**:
```bash
git commit -m "fix stuff"
git commit -m "update"
git commit -m "changes"
```

**CORRECT**:
```bash
git commit -m "fix: Resolve gitmodules.ini path in sync script"
git commit -m "ci: Add manual trigger to sync workflow"
git commit -m "docs: Add sync remote repo documentation"
```

---

## 📊 Verification Checklist

Before committing:

- [ ] Changes tested locally (if applicable)
- [ ] GitHub Action completed successfully (if applicable)
- [ ] Syntax is valid (`bash -n`, `yaml-lint`, etc.)
- [ ] No breaking changes (or coordinated)
- [ ] Commit message is clear and descriptive
- [ ] Only relevant files staged

After pushing:

- [ ] Verify on GitHub (commits tab)
- [ ] Check Actions tab (if workflow triggered)
- [ ] Confirm branch is up to date
- [ ] Document in relevant issues

---

## 🎯 AI Agent Collaboration

### Why This Matters for Multi-Agent

1. **Shared State**
   - All agents work from same codebase
   - Unpushed changes are invisible to others
   - Pushed changes are immediately available

2. **Avoid Duplication**
   - Agent A creates feature (doesn't push)
   - Agent B doesn't see it, creates duplicate
   - Wasted effort, potential conflicts

3. **Continuous Verification**
   - Agent A pushes working code
   - Agent B can verify and build on it
   - Progress is incremental and visible

4. **GitHub Actions**
   - Actions only run on committed code
   - Can't verify uncommitted changes
   - Push triggers automated testing

---

## 📝 Examples from This Project

### ✅ GOOD: Sync Remote Repo Action

**What Happened**:
1. Created workflow file
2. Tested on GitHub (triggered manually)
3. Verified success in logs
4. **Immediately committed and pushed**:
   ```bash
   git add .github/workflows/sync-remote-repo.yml
   git commit -m "ci: Add sync remote repo GitHub Action"
   git push origin dev
   ```
5. Next agent could see and verify

### ❌ BAD: Documentation Not Pushed

**What Happened**:
1. Agent created documentation files
2. Verified content is correct
3. **Did NOT commit/push** (bashscripts/ is in .gitignore)
4. Next agent couldn't see docs
5. Had to recreate

**Lesson**: Even if in .gitignore, document what you did in issues/PRs

---

## 🔐 Special Cases

### Files in .gitignore

Some important files are in `.gitignore`:
- `bashscripts/` folder
- `laravel/Modules/*/docs/`
- `laravel/Themes/*/docs/`

**How to Handle**:
1. Document changes in GitHub issues
2. Create summary in main `docs/` folder
3. Reference ignored files in commit messages
4. Use GitHub Discussions for major changes

**Example**:
```bash
# Can't commit bashscripts/docs/, but can document it:
git add docs/BASHSCRIPTS_SYNC_SUMMARY.md
git commit -m "docs: Document bashscripts sync system
- Created docs in bashscripts/docs/git/subtrees/ (ignored)
- See issue #9 for testing details"
git push
```

### Workflow-Only Changes

When only changing workflows:
```bash
git add .github/workflows/
git commit -m "ci: Update sync workflow
- Added manual trigger
- Fixed path handling
- Tested successfully (run #23047488623)"
git push
```

---

## 📚 Related Documentation

- [Git Workflow](git-workflow.md)
- [Commit Message Guidelines](commit-messages.md)
- [GitHub Actions Guide](github-actions.md)
- [AI Agent Collaboration](ai-collaboration.md)

---

## 🎯 Summary

**CRITICAL RULE**:
> Quando sei sicuro che tutto funzioni → **git commit && git push**

**Remember**:
- ✅ Tested + Working = Commit & Push
- ✅ Action Success = Commit & Push
- ✅ Docs Created = Commit & Push (or document in issues)
- ❌ Unverified = Don't Commit
- ❌ WIP = Don't Commit

**For AI Agents**:
- Your work isn't done until it's pushed
- Other agents can't see uncommitted changes
- GitHub Actions need committed code
- Progress = Committed + Pushed + Verified

---

**Status**: ✅ Active  
**Enforced**: Yes  
**Priority**: CRITICAL  
**Last Updated**: 2026-03-13
