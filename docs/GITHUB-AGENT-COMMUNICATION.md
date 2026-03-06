# GitHub-Based Inter-Agent Communication Protocol

**Critical Rule**: Multiple AI agents work in parallel. GitHub Issues & Discussions are the coordination layer.

## 🚨 CARDINAL RULE

**NEVER assume you're the only agent.** Always check GitHub Issues and Discussions BEFORE:
- Starting work on a module
- Fixing a test failure
- Updating documentation
- Making architectural decisions

## GitHub Communication Channels

### 1. GitHub Issues (Task Tracking & Blockers)

**Use for**:
- Reporting test failures that block other work
- Marking modules as "IN PROGRESS" (create issue, assign to self)
- Documenting discovered bugs or misconfigurations
- Requesting help from other agents

**Format**:
```
Title: [AGENT-WORK] Module Name - Specific Task
Labels: coverage, in-progress, agent-coordination
Body:
- Status: IN PROGRESS / BLOCKED / COMPLETED
- Agent: Agent Name (this session)
- Module: YourModule
- Work: What you're doing
- Blockers: What's blocking you (if any)
- Next: What happens after
```

**Example**:
```
Title: [AGENT-WORK] User Module - Fixing Role/Permission test failures
Labels: coverage, in-progress, user-module
Body:
- Status: IN PROGRESS
- Agent: General Purpose Agent (session 5d5a1925)
- Module: User
- Work: Fixing 50+ test failures in Role/Permission models
- Blockers: Theme model missing in UI (another agent can fix)
- Next: Update coverage-plan.md when done
```

### 2. GitHub Discussions (Coordination & Ideas)

**Use for**:
- Asking other agents questions ("Has anyone tested Geo module yet?")
- Sharing learnings ("Found: Role::$connection must be set in constructor")
- Brainstorming test strategies
- Discussing architectural decisions

**Categories**:
- **General**: Questions about project structure
- **Agent Coordination**: "Who's working on X?"
- **Test Learnings**: "Discovered pattern for testing Y"
- **Coverage Status**: "Current progress: 2,866 tests passing"

## Workflow: Before Starting Work

```
1. CHECK GitHub Issues
   gh issue list --label "coverage" --state open
   → Look for [AGENT-WORK] issues on YOUR module
   → If found: Add comment "I see you're on this, I'll handle Y instead"

2. CHECK GitHub Discussions
   gh discussion list
   → Search for module name or recent updates
   → Read recent "Coverage Status" posts

3. CREATE/UPDATE Issue if starting new module
   gh issue create \
     --title "[AGENT-WORK] ModuleName - YourTask" \
     --label "coverage,in-progress,module-name" \
     --body "Status: IN PROGRESS
   Agent: YourName
   Module: YourModule
   Work: [describe work]"

4. WORK
   - Write tests
   - Fix failures
   - Update code

5. UPDATE Issue when done
   gh issue close <issue-number>
   OR update with comment: "✅ COMPLETED: X tests, Y% coverage"

6. POST to Discussions (optional)
   gh discussion create \
     --category "Coverage Status" \
     --title "Update: ModuleName - 50 tests, 25% coverage" \
     --body "[summary of work]"
```

## Real-World Example

### Agent A working on User module:

**Issue Created** (by Agent A):
```
Title: [AGENT-WORK] User Module - Actions & Models Tests
Status: IN PROGRESS
Work: Writing tests for 5 critical Actions
Blockers: None
```

### Agent B wants to work on User but sees the issue:

**Action by Agent B**:
```
$ gh issue list --label "user-module" --state open
# Sees Agent A's issue

Comment on issue:
"I see you're on Actions/Models. I'll focus on Filament Resources instead 
to avoid conflicts. Should be done in 2 hours."
```

### Result:
✅ Parallel work without collision
✅ Clear communication
✅ Reduced merge conflicts

## Commands for Common Tasks

```bash
# List open coverage work
gh issue list --label "coverage" --state open

# Create new work issue
gh issue create --title "[AGENT-WORK] ModuleName - Task" --label coverage,in-progress

# Close when done
gh issue close <number>

# Check discussions
gh discussion list

# Post coverage update
gh discussion create --category "Coverage Status" --title "Module Update"

# See if module is being worked on
gh issue list --label "geo-module" --state open
```

## Status Tags in GitHub

Use labels consistently:
- `coverage` - All coverage-related issues
- `in-progress` - Agent is currently working
- `blocked` - Waiting for another agent to fix something
- `completed` - Work finished, tests passing
- `agent-coordination` - Communication between agents
- `module-name` - Which module (e.g., `user-module`, `meetup-module`)

## Integration with coverage-plan.md

**GitHub Issues** = Real-time coordination between agents
**coverage-plan.md** = Persistent log of what was done

When closing an issue, include:
```
Closes #123

✅ COMPLETED
- Added 50 tests
- Achieved 25% coverage
- All tests passing
- Updated coverage-plan.md
```

---

**Remember**: GitHub Issues & Discussions are your communication layer with other agents. Check before you start. Update when you finish.

**Status**: Protocol active 🤝 | Check GitHub before work ✅
**Last Updated**: 2026-03-05
