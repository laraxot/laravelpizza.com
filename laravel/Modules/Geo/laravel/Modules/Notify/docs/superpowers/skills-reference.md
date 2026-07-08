# 🦸 Superpowers Skills Reference

> **Last Updated**: 2026-03-31  
> **Status**: ✅ Active  
> **Version**: v5.0.6

---

## 📋 Overview

This document lists all available Superpowers skills with descriptions, triggers, and examples.

---

## 🎨 Planning & Design Skills

### brainstorming

**Purpose**: Refine ideas through structured questioning

**Triggers**:
- "I want to build X"
- "help me plan"
- "let's brainstorm"
- "I have an idea"

**Process**:
1. Asks clarifying questions
2. Explores alternatives
3. Presents design sections
4. Waits for validation

**Example**:
```
User: "I want to add a notification system"
Agent: [Brainstorming skill activates]
  - What types of notifications?
  - Which channels (email, SMS, push)?
  - User preferences?
  - Rate limiting?
Agent: [Presents design]
  ## Notification System Design
  ### Channels
  - Email (via Laravel Mail)
  - SMS (via Twilio)
  - Push (via Firebase)
  ### User Preferences
  - Opt-in/opt-out per channel
  - Quiet hours
  ...
```

---

### writing-plans

**Purpose**: Break work into small, testable tasks

**Triggers**:
- "create a plan"
- "break this down"
- "what are the steps"
- After brainstorming approval

**Output**: Markdown plan with:
- Task descriptions
- File paths
- Time estimates
- Verification steps

**Example**:
```markdown
## Plan: Notification System

### Task 1: Create notifications table
- File: database/migrations/2026_03_31_create_notifications_table.php
- Time: 5 min
- Verification: php artisan migrate --pretend

### Task 2: Create Notification model
- File: app/Models/Notification.php
- Time: 5 min
- Verification: phpstan analyse app/Models/Notification.php
```

---

### executing-plans

**Purpose**: Implement planned tasks

**Triggers**:
- "let's implement"
- "execute the plan"
- "start coding"
- After plan approval

**Modes**:
- **Sequential**: One task at a time
- **Parallel**: Dispatch subagents
- **Batched**: Multiple tasks with checkpoints

---

## 🔧 Development Skills

### test-driven-development

**Purpose**: Enforce RED-GREEN-REFACTOR cycle

**Triggers**:
- "write tests for"
- "implement with TDD"
- "let's do test-driven"
- During execution phase

**Process**:
```
RED:   Write failing test
  ↓
GREEN: Write minimal code
  ↓
REFACTOR: Improve code quality
  ↓
COMMIT: Save with tests passing
```

**Example**:
```php
// 1. RED - Test first
it('sends email notification', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);
    
    Notification::send($user, new TestNotification());
    
    Notification::assertSentTo($user, TestNotification::class);
});
// ❌ FAILS: Notification class doesn't exist

// 2. GREEN - Minimal implementation
class TestNotification extends Notification {
    public function via($notifiable) {
        return ['mail'];
    }
}
// ✅ PASSES

// 3. REFACTOR - Add traits, improve structure
// ✅ STILL PASSES
```

---

### using-git-worktrees

**Purpose**: Create isolated workspaces

**Triggers**:
- "create worktree"
- "start feature branch"
- Automatic after planning

**Commands**:
```bash
# Create
git worktree add -b feature/my-feature ../worktrees/my-feature

# List
git worktree list

# Remove
git worktree remove ../worktrees/my-feature
```

**Benefits**:
- Clean main branch
- Parallel development
- Easy rollback

---

### dispatching-parallel-agents

**Purpose**: Coordinate multiple subagents

**Triggers**:
- "work on multiple tasks"
- "parallelize this"
- Large plans with independent tasks

**Process**:
1. Split plan into independent tasks
2. Dispatch subagent per task
3. Each subagent follows TDD
4. Review all outputs
5. Merge results

**Example**:
```
Plan: 5 tasks
  ↓
Subagent 1: Tasks 1, 2 (migration, model)
Subagent 2: Tasks 3, 4 (actions, tests)
Subagent 3: Task 5 (API endpoints)
  ↓
All complete → Review → Merge
```

---

## 🔍 Quality Skills

### systematic-debugging

**Purpose**: Structured debugging approach

**Triggers**:
- "this is broken"
- "debug this issue"
- "fix this bug"
- "why is this failing"

**Process**:
```
1. Reproduce: Create minimal reproduction
2. Isolate: Narrow down the cause
3. Hypothesize: Form theory about root cause
4. Test: Verify hypothesis
5. Fix: Apply targeted fix
6. Verify: Ensure fix works
```

**Example**:
```
Issue: "User creation fails"
  ↓
1. Reproduce: php artisan tinker → User::create([...])
   ❌ Error: SQLSTATE error
2. Isolate: Check migration → users table exists
   Check model → User class exists
   Check fillable → ['name', 'email'] defined
3. Hypothesize: Missing database column
4. Test: Describe users table → missing 'email' column
5. Fix: Add email column in migration
6. Verify: User::create() works ✅
```

---

### verification-before-completion

**Purpose**: Ensure quality before marking complete

**Triggers**:
- "I'm done"
- "ready to merge"
- "verify this works"
- Before finishing branch

**Checklist**:
- [ ] All tests pass
- [ ] PHPStan passes
- [ ] Plan completed
- [ ] Review passed
- [ ] Documentation updated

**Commands**:
```bash
php artisan test                    # Tests
./vendor/bin/phpstan analyse        # Static analysis
git diff --stat                     # Changes
```

---

### requesting-code-review

**Purpose**: Initiate code review process

**Triggers**:
- "review this code"
- "I need a review"
- "check my work"
- After implementation

**Process**:
1. Present changes
2. Link to plan
3. Show test results
4. Request specific feedback

**Example**:
```
## Code Review Request

**Plan**: [Link to plan]
**Changes**: 5 files, +234 lines
**Tests**: 12 passed, 0 failed

### Specific Questions
1. Is the notification queue strategy correct?
2. Should we add rate limiting?
3. Any security concerns?

### Files Changed
- app/Models/Notification.php
- app/Actions/SendNotificationAction.php
- tests/Feature/NotificationTest.php
```

---

### receiving-code-review

**Purpose**: Handle review feedback

**Triggers**:
- Review comments received
- "fix review issues"
- "address feedback"

**Process**:
1. Acknowledge feedback
2. Categorize (blocking/non-blocking)
3. Create fix plan
4. Implement fixes
5. Re-request review

**Response Template**:
```
## Review Feedback Response

### Blocking Issues
- [x] Missing tests for edge case → Fixed in commit abc123
- [x] Security concern with user input → Added validation

### Non-Blocking
- [ ] Suggestion: Extract method → Created ticket #456
- [ ] Future: Add caching → Added to roadmap

### Ready for Re-review
All blocking issues resolved. Tests passing.
```

---

### finishing-a-development-branch

**Purpose**: Complete and merge feature

**Triggers**:
- "finish this branch"
- "ready to merge"
- "complete the feature"

**Process**:
1. Final verification
2. Present merge options
3. Execute merge
4. Cleanup worktree
5. Update documentation

**Options**:
```
A) Merge to main
   git checkout main && git merge feature/x

B) Create Pull Request
   git push && open PR on GitHub

C) Keep as branch
   git push origin feature/x
```

---

## 📚 Meta Skills

### writing-skills

**Purpose**: Create new custom skills

**Triggers**:
- "create a skill for"
- "I want to automate"
- "custom workflow"

**Skill Template**:
```markdown
# Skill Name

**Purpose**: What it does

**Triggers**: When it activates

**Process**: Step-by-step

**Example**: Usage example

**Output**: What it produces
```

**Example**:
```markdown
# deploy-to-production

**Purpose**: Deploy to production safely

**Triggers**:
- "deploy to production"
- "release this feature"

**Process**:
1. Verify tests pass
2. Check changelog updated
3. Create release branch
4. Run deployment script
5. Verify health checks
6. Monitor for issues

**Output**: Deployment report
```

---

### using-superpowers

**Purpose**: General usage guide

**Triggers**:
- "how do I use"
- "help with superpowers"
- "what can you do"

**Provides**:
- Overview of available skills
- Workflow explanation
- Best practices
- Examples

---

## 🎯 Skill Combinations

### Common Workflows

#### New Feature
```
brainstorming
  → writing-plans
    → using-git-worktrees
      → test-driven-development
        → executing-plans
          → requesting-code-review
            → finishing-a-branch
```

#### Bug Fix
```
systematic-debugging
  → writing-plans (for fix)
    → test-driven-development (write regression test)
      → executing-plans
        → verification-before-completion
          → finishing-a-branch
```

#### Code Review
```
requesting-code-review
  → receiving-code-review
    → executing-plans (for fixes)
      → verification-before-completion
        → finishing-a-branch
```

---

## 📊 Skill Statistics

### Usage Tracking

Track skill usage in `.superpowers/skills-log.json`:

```json
{
  "date": "2026-03-31",
  "skills_used": {
    "brainstorming": 3,
    "writing-plans": 2,
    "test-driven-development": 15,
    "systematic-debugging": 5,
    "requesting-code-review": 2
  },
  "tasks_completed": 25,
  "tests_written": 47,
  "bugs_fixed": 5
}
```

---

## 🔗 Related Documentation

### Internal

- [README](README.md) - Overview
- [Installation](installation.md) - Setup
- [Workflow](workflow.md) - How to use

### External

- [Superpowers GitHub](https://github.com/obra/superpowers)
- [Superpowers Discord](https://discord.gg/superpowers)

---

**Maintainer**: Development Team  
**Last Review**: 2026-03-31  
**Next Review**: 2026-06-30  
**Status**: ✅ Active
