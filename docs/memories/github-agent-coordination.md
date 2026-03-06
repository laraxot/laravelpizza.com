# Memory: GitHub-Based Agent Coordination

**Date**: 2026-03-05
**Updated**: Every session start
**Critical**: Always check before starting work

## The Discovery

Multiple AI agents work in parallel on the same LaravelPizza codebase. Previous coordination via `coverage-plan.md` alone was insufficient because:
- Agents worked faster than doc could be updated atomically
- Changes were made that other agents didn't see
- Assumptions that work hadn't been done led to re-work
- Test failures got fixed but not communicated

## The Solution: GitHub Issues & Discussions

GitHub provides:
1. **Real-time visibility** of active work
2. **Atomic locking** (issue labels prevent collision)
3. **Async communication** between agents
4. **Historical record** (what was done, by whom)

## Workflow (Every Session Start)

```
SESSION START
  ↓
CHECK GitHub Issues
  (gh issue list --label "coverage" --state open)
  ↓
  Found [AGENT-WORK] issue on YOUR target?
    YES → Choose different module OR add comment "I'll do XYZ part"
    NO → Continue
  ↓
CHECK GitHub Discussions
  (gh discussion list)
  ↓
  See recent learnings about your module?
    YES → Learn from it, avoid same mistakes
    NO → Continue
  ↓
CREATE [AGENT-WORK] Issue (if starting new module)
  (gh issue create --title "[AGENT-WORK] ModuleName - Task" --label "coverage,in-progress,module-name")
  ↓
WORK
  ↓
UPDATE coverage-plan.md (after tests pass)
  ↓
CLOSE Issue (or comment: ✅ COMPLETED)
  ↓
POST to Discussions (optional: share learnings)
```

## Key Insights

### 1. Real-Time Coordination is Essential
Without GitHub coordination:
- Agent A: "I'll fix User Role/Permission tests"
- Agent B: Starts same work (doesn't see Agent A working)
- Collision + wasted effort

With GitHub coordination:
- Agent A: Creates issue "[AGENT-WORK] User - Fix Role/Permission"
- Agent B: Sees issue, chooses different module
- ✅ Parallel work, no collision

### 2. Tests Get Fixed Fast
The 101 test failures reported in paste file were likely already being fixed by other agents when I was still reading the output. GitHub Issues would have shown:
- "Role/Permission tests: IN PROGRESS by Agent X"
- "UI Theme model issue: IN PROGRESS by Agent Y"

### 3. Documentation is Secondary
`coverage-plan.md` still needed for:
- Historical record ("what got done today")
- High-level progress tracking
- But NOT for real-time coordination (too slow)

GitHub Issues = Real-time coordination
coverage-plan.md = Historical log

## Commands to Remember

```bash
# Check if work started on YOUR module
gh issue list --label "my-module" --state open

# Create new work issue
gh issue create --title "[AGENT-WORK] ModuleName - Task" \
  --label "coverage,in-progress,module-name"

# See what others are discovering
gh discussion list

# Post a learning
gh discussion create --category "Test Learnings" \
  --title "Pattern: Testing X requires Y setup"

# Close when done
gh issue close <number>
```

## Rules to Hardcode into Brain

1. **FIRST action of every session**: Check GitHub Issues
2. **NEVER start work without checking**: Is anyone else on this module?
3. **ALWAYS create [AGENT-WORK] issue** before starting new module
4. **ALWAYS check Discussions** for learnings about your module
5. **ALWAYS close issue or post completion comment** when done
6. **ALWAYS reference issue in commit message**: `Closes #123`

## Status Tracking

### Issue Labels (use consistently)
- `coverage` - All coverage work
- `in-progress` - Agent actively working
- `blocked` - Waiting for another agent
- `completed` - Done, tests passing
- `agent-coordination` - About communication
- `module-name` - Which module

### Issue Title Format
```
[AGENT-WORK] ModuleName - Specific Task
```

Examples:
```
[AGENT-WORK] User Module - Fix Role/Permission test failures
[AGENT-WORK] Geo Module - Write Location service tests
[AGENT-WORK] Meetup Module - Complete Event CRUD actions
```

## Why This Matters

**Before**: Sequential work, assumptions, re-work
**After**: Parallel coordination, visibility, efficiency

Switching from sequential to parallel execution requires:
1. ✅ Multi-agent protocol (AGENTS-COORDINATION.md)
2. ✅ GitHub-based communication (GITHUB-AGENT-COMMUNICATION.md)
3. ✅ Coverage-plan.md for logging (still needed)
4. ✅ This memory to remind future agents

## Next Session Checklist

- [ ] Read this memory
- [ ] Check GitHub Issues
- [ ] Check GitHub Discussions
- [ ] Choose module (or use existing issue)
- [ ] Create issue if new work
- [ ] Work on tests
- [ ] Close issue when done
- [ ] Post to discussions if discovered pattern

---

**Status**: Protocol active and tested 🤝
**Verified**: 2026-03-05 (discovered benefit of GitHub coordination)
**Next**: All agents must follow GitHub protocol before starting work
