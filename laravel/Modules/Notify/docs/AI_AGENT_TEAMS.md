# AI Agent Teams - Coordination Hub

**Created**: 2026-03-13  
**Status**: Active  
**Purpose**: Coordinate multiple AI agents working on the same codebase

---

## 🎯 Why Agent Teams?

Multiple AI agents (Qwen, Claude, Cursor, etc.) are working on the same FixCity platform. Without coordination:
- ❌ Duplicate work
- ❌ Conflicting changes
- ❌ Wasted effort
- ❌ Confusion about who's doing what

**Solution**: Organized agent teams with clear responsibilities and communication channels.

---

## 👥 Current Agent Teams

### 1. **Sync Team** 🔄

**Focus**: sync_remote_repo.sh and GitHub Actions

**Members**: All AI agents working on sync functionality

**Current Tasks**:
- ✅ Fix script errors (unbound variables, missing functions)
- ✅ Test bidirectional sync (local ↔ remote)
- ✅ Monitor GitHub Action runs
- ⏳ Test on all modules

**Status**: ✅ **SUCCESS** - Bidirectional sync working!

**Test Results**:
- Local → Remote: ✅ PASS
- Remote → Local: ✅ PASS
- See: `docs/SYNC_TEST_RESULTS.md`

**Contact**: Comment on issue #11

---

### 2. **Semantic Versioning Team** 📊

**Focus**: Implement semantic versioning GitHub Action

**Current Tasks**:
- ⏳ Create `.github/workflows/semantic-versioning.yml`
- ⏳ Document in `bashscripts/docs/`
- ⏳ Test on dev branch

**Status**: 🔄 In Progress

**Contact**: Comment on issue #12

---

### 3. **Documentation Team** 📚

**Focus**: Keep all documentation synchronized

**Current Tasks**:
- ✅ Update `bashscripts/docs/ai/` with sync rules
- ✅ Update AGENTS.md with commit/push rules
- ✅ Update .windsurfrules
- ⏳ Sync `.github/` with `bashscripts/ai/.github/`

**Status**: ✅ Mostly Complete

**Key Rule**: When updating `.github/`, also update `bashscripts/ai/.github/`

**Contact**: Comment on issue #13

---

### 4. **Quality Assurance Team** ✅

**Focus**: Fix failing GitHub Actions

**Current Tasks**:
- ⏳ Fix CI - Code Quality & Tests
- ⏳ Fix Comprehensive Quality
- ⏳ Fix Semantic Versioning
- ⏳ Monitor all action runs

**Status**: 🔄 In Progress

**Contact**: Comment on issue #11

---

## 📋 How to Join a Team

1. **Check Open Issues**: `gh issue list`
2. **Choose a Team**: Based on your skills/interests
3. **Comment on Issue**: Declare your intention
4. **Start Work**: Follow team guidelines
5. **Report Progress**: Update issue with results

### Example Comment

```markdown
🤖 **Agent**: [Your Agent Name]
**Joining**: [Team Name]
**Focus**: [Specific task you'll work on]
**ETA**: [Estimated completion time]
**Updates**: [How you'll communicate progress]
```

---

## 🔄 Communication Channels

### GitHub Issues
- **Primary coordination**: Use issues for task tracking
- **Comment frequently**: Keep others informed
- **Link related issues**: Cross-reference work

### GitHub Discussions
- **Announcements**: Major milestones
- **Questions**: Ask for help
- **Decisions**: Document team decisions

### Documentation
- **Update docs**: As you work
- **Share learnings**: Help other agents
- **Keep current**: Remove outdated info

---

## 📊 Task Board

| Task | Team | Status | Assigned To | Due |
|------|------|--------|-------------|-----|
| Fix sync_remote_repo.sh | Sync | ✅ Done | All agents | 2026-03-13 |
| Test bidirectional sync | Sync | ✅ Done | All agents | 2026-03-13 |
| Create semantic versioning | SemVer | 🔄 In Progress | TBD | 2026-03-14 |
| Fix CI actions | QA | 🔄 In Progress | TBD | 2026-03-14 |
| Update docs | Docs | ✅ Done | All agents | Ongoing |

---

## 🎯 Best Practices for AI Agents

### 1. **Check Before Starting**
```bash
# Check open issues
gh issue list --state open

# Check recent activity
gh issue list --sort updated --limit 10
```

### 2. **Declare Your Work**
Comment on the relevant issue before starting:
```
🤖 Starting work on [task]
- Will [what you'll do]
- ETA: [time]
- Will report results in [issue/discussion]
```

### 3. **Test Before Pushing**
```bash
# Test scripts locally
bash -n path/to/script.sh

# Verify syntax
action-validator .github/workflows/workflow.yml
```

### 4. **Commit & Push Immediately**
When work is complete and tested:
```bash
git add .
git commit -m "type: description"
git push origin dev
```

### 5. **Document Everything**
- Scripts → `bashscripts/docs/`
- Workflows → `.github/` AND `bashscripts/ai/.github/`
- Rules → `AGENTS.md`, `.windsurfrules`

---

## 🏆 Current Achievements

### ✅ Sync Team
- Fixed all script errors
- Tested bidirectional sync successfully
- Both directions working perfectly

### ✅ Documentation Team
- Created comprehensive test plan
- Updated commit/push rules
- Created agent coordination docs

---

## 📞 Getting Help

**Stuck on something?**
1. Check existing issues first
2. Create new issue with detailed description
3. Tag relevant team members
4. Ask in GitHub Discussions

**Found a bug?**
1. Create issue with reproduction steps
2. Tag appropriate team
3. Suggest fix if possible

**Want to improve something?**
1. Discuss in GitHub Discussions
2. Get team consensus
3. Implement and test
4. Document changes

---

## 🔗 Related Resources

- **Issue #11**: Fix GitHub Actions Workflows
- **Issue #12**: AI Agent Collaboration
- **Issue #13**: Documentation Updates
- **docs/SYNC_TEST_RESULTS.md**: Latest sync test results
- **docs/SYNC_REMOTE_REPO_TEST_PLAN.md**: Test plan

---

**Last Updated**: 2026-03-13  
**Next Review**: 2026-03-14  
**Maintained By**: All AI Agents
