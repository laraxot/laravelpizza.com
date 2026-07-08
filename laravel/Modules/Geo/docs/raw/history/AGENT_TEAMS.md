# Agent Teams Coordination

> **Purpose**: Coordinate multiple AI agents working on the same codebase  
> **Date Established**: 2026-03-13  
> **Status**: Active  

---

## Agent Teams Structure

### Team: Subtree Sync

**Responsibility**: Maintain and improve subtree synchronization

| Role | Agent | Status |
|------|-------|--------|
| **Lead** | Qwen | ✅ Active |
| **Member** | Gemini | ✅ Active |
| **Member** | Claude | ✅ Active |

**Tasks**:
- [x] Implement dual-mode sync script (CLI + CI)
- [x] Create GitHub Actions workflow
- [x] Document usage and configuration
- [ ] Add automated testing
- [ ] Monitor sync success rate

### Team: CI/CD

**Responsibility**: GitHub Actions optimization

| Role | Agent | Status |
|------|-------|--------|
| **Lead** | Qwen | ✅ Active |
| **Member** | Gemini | ⏳ TODO |
| **Member** | Claude | ⏳ TODO |

**Tasks**:
- [x] Sync remote repo workflow
- [ ] PHPStan workflow optimization
- [ ] Test coverage workflow
- [ ] Deployment workflow

### Team: Documentation

**Responsibility**: Keep all docs updated

| Role | Agent | Status |
|------|-------|--------|
| **Member** | All Agents | ✅ Active |

**Tasks**:
- [x] Script location rule
- [x] File location rule
- [x] Sync script documentation
- [ ] Module docs standardization

---

## Communication Channels

### GitHub

- **Issues**: Track specific tasks
- **Discussions**: Coordinate decisions
- **Wiki**: Share knowledge
- **Projects**: Track progress

### Commit Messages

Use clear messages to communicate with other agents:

```
feat: Add sync remote repo script

- Script: bashscripts/git/subtrees/sync_remote_repo.sh
- Workflow: .github/workflows/sync-remote-repo.yml
- Mode: CLI + GitHub Actions CI
- Other bases should sync this script

See: bashscripts/docs/git/SYNC_REMOTE_REPO_SCRIPT.md
```

### Agent Memory

Update `AGENT_MEMORY.md` with important decisions:

```markdown
### Sync Remote Repo Script (CRITICAL)

**Script**: `bashscripts/git/subtrees/sync_remote_repo.sh`
**Workflow**: `.github/workflows/sync-remote-repo.yml`

Dual-mode: CLI + CI
Usage: `bash sync_remote_repo.sh [--org=laraxot] [--dry-run]`
```

---

## Coordination Workflow

### Before Starting Work

1. **Check Recent Commits**
   ```bash
   git log -n 20 --oneline
   ```

2. **Read Coordination Docs**
   - `docs/MULTI_AGENT_COORDINATION.md`
   - `docs/AGENT_TEAMS.md`

3. **Check for Conflicts**
   ```bash
   git status
   ls -la .lock 2>/dev/null
   ```

### During Work

1. **Use Lock Files** (for long operations)
   ```bash
   touch .lock-sync
   # Do work
   rm .lock-sync
   ```

2. **Commit Frequently**
   ```bash
   git add -A
   git commit -m "type: description"
   git push
   ```

3. **Document Decisions**
   - Add comments in code
   - Update docs
   - Create GitHub Issue if needed

### After Work

1. **Push Changes**
   ```bash
   git push origin dev
   ```

2. **Update Coordination Doc**
   - Mark tasks as complete
   - Add notes for other agents

3. **Create GitHub Items**
   - Issue for follow-up work
   - Discussion for decisions
   - PR if applicable

---

## Shared Resources

### Scripts

| Script | Team | Status |
|--------|------|--------|
| `sync_remote_repo.sh` | Subtree Sync | ✅ Done |
| `ollama-optimize.sh` | CI/CD | ✅ Done |
| `phpstan_analyze.sh` | CI/CD | ⏳ TODO |

### Workflows

| Workflow | Team | Status |
|----------|------|--------|
| `sync-remote-repo.yml` | Subtree Sync | ✅ Done |
| `phpstan-analysis.yml` | CI/CD | ⏳ TODO |
| `test-coverage.yml` | CI/CD | ⏳ TODO |

### Documentation

| Doc | Team | Status |
|-----|------|--------|
| `SYNC_REMOTE_REPO_SCRIPT.md` | Subtree Sync | ✅ Done |
| `script-location-rule.md` | Documentation | ✅ Done |
| `FILE_LOCATION_RULES.md` | Documentation | ✅ Done |

---

## Multi-Base Coordination

### Bases

| Base | Agent | Status |
|------|-------|--------|
| `base_ptvx_fila5` | Qwen | ✅ Active |
| `base_fixcity_fila5` | Gemini | ✅ Active |
| `base_quaeris_fila5` | Claude | ✅ Active |

### Sync Strategy

1. **Implement in One Base**
   - Test thoroughly
   - Document completely

2. **Create GitHub Discussion**
   - Explain implementation
   - Provide sync instructions

3. **Other Bases Sync**
   ```bash
   # base_fixcity_fila5
   cd /var/www/_bases/base_fixcity_fila5
   git pull origin dev
   # Copy script and docs from base_ptvx_fila5
   ```

---

## GitHub Integration

### Issue Template

```markdown
## Task: {Task Name}

**Team**: {Team Name}
**Agent**: {Agent Name}
**Priority**: High/Medium/Low

### Description

{What needs to be done}

### Implementation

{How to implement}

### Other Bases

- [ ] base_fixcity_fila5
- [ ] base_quaeris_fila5
```

### Discussion Template

```markdown
## {Topic} - Multi-Agent Discussion

**Context**: {Why this discussion is needed}

**Proposal**: {What is being proposed}

**Impact**: {How this affects other agents/bases}

### Questions for the Team

1. {Question 1}
2. {Question 2}

### Decision

{Final decision after discussion}
```

---

## Conflict Resolution

### When Two Agents Work on Same File

1. **Check Git History**
   ```bash
   git log -p --follow filename
   ```

2. **Communicate via Comments**
   ```markdown
   <!-- @qwen: Changed this to fix issue #123 -->
   <!-- @gemini: Please review before changing -->
   ```

3. **Use Pull Requests** (for major changes)

### When Conflicts Occur

1. **Stop and Assess**
2. **Create GitHub Issue**
3. **Discuss in GitHub Discussion**
4. **Agree on Solution**
5. **Implement and Document**

---

## Best Practices

### DO ✅

- Read before modifying
- Commit after every task
- Write clear commit messages
- Update documentation
- Use GitHub for coordination
- Test before pushing
- Communicate via commits/issues/discussions

### DON'T ❌

- Modify without reading
- Leave work uncommitted
- Write vague commit messages
- Skip documentation
- Work in isolation
- Push untested code
- Ignore other agents

---

## Meeting Notes

### 2026-03-13 - Initial Setup

**Attendees**: Qwen, Gemini, Claude

**Decisions**:
1. Establish agent teams structure
2. Define communication channels
3. Create coordination workflow
4. Set up GitHub integration

**Action Items**:
- [x] Qwen: Create agent teams doc
- [ ] Gemini: Review and sync to base_fixcity_fila5
- [ ] Claude: Review and sync to base_quaeris_fila5

---

## Related Documentation

| Document | Path |
|----------|------|
| **Multi-Agent Coordination** | `docs/MULTI_AGENT_COORDINATION.md` |
| **Script Location Rule** | `bashscripts/docs/script-location-rule.md` |
| **Commit & Push Rule** | `bashscripts/docs/COMMIT_AND_PUSH_RULE.md` |
| **AI Agent Junction** | `bashscripts/docs/AI_AGENT_JUNCTION_RULE.md` |

---

*Last updated: 2026-03-13*
