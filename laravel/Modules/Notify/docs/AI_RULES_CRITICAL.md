# 🤖 AI Agent Rules - CRITICAL UPDATE

> **Last Updated**: 2026-03-13  
> **Status**: ✅ Active  
> **Version**: 4.0

---

## 🚨 CRITICAL RULE #1: GIT COMMIT & PUSH

### Rule Statement

**QUANDO SEI SICURO CHE TUTTO FUNZIONA → DEVI FARE GIT COMMIT E GIT PUSH**

### Why

- ✅ Il lavoro non è completo finché non è su GitHub
- ✅ L'utente deve poter verificare
- ✅ GitHub Actions non parte senza push
- ✅ La documentazione deve essere accessibile

### How

```bash
# After creating/modifying files
cd /var/www/_bases/base_fixcity_fila5

# 1. Add all changes
git add .

# 2. Check what will be committed
git status

# 3. Commit with descriptive message
git commit -m "Add feature X with documentation

- file1.md: Description
- file2.yml: Description
- Updated rules and memory"

# 4. Push to remote
git push origin dev

# 5. Verify on GitHub
gh run list --repo laraxot/base_fixcity_fila5
```

---

## 🚨 CRITICAL RULE #2: TEST ON GITHUB

### Rule Statement

**MAI dichiarare task completato senza verificare su GitHub**

### Why

- ✅ GitHub environment è diverso dal locale
- ✅ Secrets devono essere configurati
- ✅ Workflow possono fallire
- ✅ L'utente si fida di te

### How

```bash
# After push, wait 1-2 minutes
sleep 120

# Check workflow status
gh run list --repo laraxot/base_fixcity_fila5

# View logs
gh run view <run-id> --log

# If fails:
# 1. Check error
# 2. Fix or document
# 3. Push fix
# 4. Re-test
```

---

## 🚨 CRITICAL RULE #3: DOCUMENT MANUAL STEPS

### Rule Statement

**Se serve setup manuale, documentalo CHIARAMENTE**

### Why

- ✅ GitHub secrets non sono automatici
- ✅ L'utente deve sapere cosa fare
- ✅ Evita confusione
- ✅ Risparmia tempo

### How

```markdown
## ⚠️ Manual Setup Required

**Status**: Action created, requires manual secret setup

**Steps**:
1. Generate SSH key
2. Add to GitHub Settings
3. Add to repo secrets
4. Test workflow

**Files**:
- `SETUP_GUIDE.md`: Step-by-step instructions
- `.qwen/AI_MEMORY.md`: Updated with requirements
```

---

## 📝 Complete Workflow

### Before Task

```
1. Understand requirement
2. Plan implementation
3. Check existing docs
```

### During Task

```
1. Create code/docs
2. Test locally (if possible)
3. Add to git
4. Commit with clear message
5. Push to remote
```

### After Task

```
1. Verify on GitHub
2. Check workflow runs
3. View logs
4. Fix errors OR document
5. Update status
```

---

## ✅ Task Completion Checklist

Before saying "task complete":

- [ ] Code created
- [ ] Documentation written
- [ ] **Git add executed**
- [ ] **Git commit executed**
- [ ] **Git push executed**
- [ ] GitHub shows commits
- [ ] Workflow triggered (if applicable)
- [ ] Logs checked
- [ ] Errors fixed or documented
- [ ] Manual steps documented
- [ ] User can replicate

---

## 🎯 Lessons Learned

### What Went Wrong (2026-03-13)

1. ❌ Created GitHub Action
2. ❌ Created documentation
3. ❌ Pushed workflow file
4. ❌ **Did NOT push documentation**
5. ❌ Said "task complete"
6. ❌ User couldn't find setup guide

### What Went Right (After Fix)

1. ✅ Created all documentation
2. ✅ Added to git
3. ✅ Committed with clear message
4. ✅ Pushed to dev
5. ✅ User can access everything
6. ✅ Documented the mistake

---

## 📚 Updated Files

### Always Commit

| File Type | Always Commit | Why |
|-----------|---------------|-----|
| Code (.sh, .yml, .php) | ✅ Yes | Required for functionality |
| Documentation (.md) | ✅ Yes | User needs to access |
| Rules (.md) | ✅ Yes | AI needs to know |
| Memory (.md) | ✅ Yes | Context for future |
| Config (.json, .ini) | ✅ Yes | System configuration |

### Commit Message Format

```bash
# Good
git commit -m "Add GitHub Action for subtree sync

- sync-subtrees.yml: Workflow file
- sync-subtrees.md: Documentation
- Updated AI rules and memory"

# Bad
git commit -m "update"
git commit -m "fix"
git commit -m "stuff"
```

---

## 🔧 Git Commands Reference

### Daily Workflow

```bash
# Check status
git status

# Add all changes
git add .

# Check what will be committed
git diff --staged

# Commit
git commit -m "Descriptive message"

# Push
git push origin dev

# Verify
git log -n 3
```

### After Mistake

```bash
# If you forgot to commit
git status
git add <forgotten-files>
git commit -m "Add forgotten files"
git push origin dev

# If you forgot to push
git status
git push origin dev
```

---

## 📞 Support

### If Unsure

1. Check git status
2. If files are untracked → git add
3. If files are staged → git commit
4. If committed but not pushed → git push
5. If pushed → verify on GitHub

### Quick Check

```bash
# Are my files on GitHub?
git log -n 3 --oneline

# Compare with:
# https://github.com/laraxot/base_fixcity_fila5/commits/dev
```

---

## 🎯 Commitment

**From now on**:

1. ✅ ALWAYS git add after creating files
2. ✅ ALWAYS git commit with clear message
3. ✅ ALWAYS git push to remote
4. ✅ ALWAYS verify on GitHub
5. ✅ NEVER say "complete" without push

---

**Last Updated**: 2026-03-13  
**Reason**: Forgot to push documentation files  
**Action**: Updated rules to prevent recurrence
