# 🤖 Multi-Agent AI Coordination - Critical Rules

> **Last Updated**: 2026-03-13  
> **Status**: ✅ Active  
> **Priority**: CRITICAL

---

## 🚨 Rule #1: ALWAYS Test Before Pushing

**NEVER** push code without testing:

```bash
# 1. Check syntax
bash -n script.sh

# 2. Test locally
./script.sh

# 3. Check for errors
echo $?

# 4. ONLY THEN push
git push
```

**Why**: User should NEVER find syntax errors!

---

## 🚨 Rule #2: Verify GitHub Actions

**ALWAYS** check GitHub Actions after push:

```bash
# Wait for actions to complete
sleep 60

# Check status
gh run list --repo <owner>/<repo> --limit 5

# View logs if failed
gh run view <run-id> --log-failed
```

**Why**: Actions must pass before declaring complete!

---

## 🚨 Rule #3: Multi-Agent Communication

**SEMPRE** comunicare tramite GitHub:

1. ✅ Commenta issues prima di lavorare
2. ✅ Aggiorna status nel tuo lavoro
3. ✅ Condividi risultati nei commenti
4. ✅ Tagga altri agenti per review

**Template Commento**:
```markdown
## Agent Update

**Agent**: @agent-name
**Status**: 🔄 In Progress / ✅ Complete / ❌ Blocked
**Work Done**: Description
**Issues Found**: Any problems
**Next Steps**: What's next
```

---

## 🚨 Rule #4: Test Subtree Sync

**QUANDO** lavori con subtrees:

```bash
# 1. Test script syntax
bash -n bashscripts/git/subtrees/sync_remote_repo.sh

# 2. Test locally (if possible)
./bashscripts/git/subtrees/sync_remote_repo.sh laraxot

# 3. Push to bashscripts repo
cd bashscripts
git add <files>
git commit -m "fix: description"
git push origin dev

# 4. Wait for GitHub Actions
# 5. Verify Sync Remote Repo passes
```

---

## 🚨 Rule #5: Document Everything

**OGNI** fix deve avere:

1. ✅ Commit message chiaro
2. ✅ Documentation aggiornata
3. ✅ GitHub Issue/Discussion
4. ✅ Rules/Memory aggiornate

---

## 📋 Agent Teams

### Infrastructure Team ✅ ACTIVE

**Members**:
- @marco76tv (Team Lead)

**Responsibilities**:
- GitHub Actions
- CI/CD
- DevOps
- Subtree Sync

**Current Work**:
- ✅ Fixed sync_remote_repo.sh
- ✅ Fixed sync-remote-repo.yml
- ✅ All Actions passing

---

### Documentation Team 📢 RECRUITING

**Responsibilities**:
- Module documentation
- Theme documentation
- API documentation
- User guides

**Join**: Comment on Issue #7

---

### Testing Team 📢 RECRUITING

**Responsibilities**:
- Unit tests
- Integration tests
- E2E tests
- Test automation

**Join**: Comment on Issue #8

---

## 🎯 Collaboration Workflow

### Starting Work

1. **Check existing work**:
   ```bash
   gh issue list --state open
   gh pr list --state open
   ```

2. **Claim task**:
   ```markdown
   ## Claiming Task
   
   **Agent**: @agent-name
   **Issue**: #123
   **ETA**: 2 hours
   ```

3. **Create branch**:
   ```bash
   git checkout -b agent/task-name
   ```

---

### During Work

1. **Test frequently**:
   ```bash
   bash -n script.sh
   ./script.sh
   ```

2. **Commit often**:
   ```bash
   git add .
   git commit -m "feat: progress"
   ```

3. **Update issue**:
   ```markdown
   ## Update
   
   **Progress**: 50%
   **Issues**: None
   **Next**: Testing
   ```

---

### Completing Work

1. **Final test**:
   ```bash
   bash -n script.sh
   ./script.sh
   echo $?  # Must be 0
   ```

2. **Push**:
   ```bash
   git push origin agent/task-name
   ```

3. **Create PR**:
   ```bash
   gh pr create --title "feat: description" --body "Fixes #123"
   ```

4. **Monitor Actions**:
   ```bash
   gh run list --repo <owner>/<repo>
   ```

5. **Declare complete** (ONLY if Actions pass):
   ```markdown
   ## Complete
   
   ✅ All tests passing
   ✅ GitHub Actions: SUCCESS
   ✅ Ready for merge
   ```

---

## 📊 Status Board

| Agent | Current Task | Status | ETA |
|-------|--------------|--------|-----|
| @marco76tv | Sync Remote Repo Fix | ✅ Complete | Done |
| [You?] | [Task] | 🔄 In Progress | [ETA] |

---

## 🔗 Resources

- [Multi-Agent Guide](docs/MULTI_AGENT_COLLABORATION_GUIDE.md)
- [GitHub Sync Rule](docs/GITHUB_SYNC_RULE.md)
- [AI Rules](../.qwen/AI_RULES_CRITICAL.md)
- [AI Memory](../.qwen/AI_MEMORY.md)

---

**Created**: 2026-03-13  
**By**: Multi-Agent AI Team  
**Purpose**: Enable seamless collaboration
