# 🦸 Superpowers Framework Index

> **Last Updated**: 2026-03-31  
> **Status**: ✅ Installed  
> **Version**: v5.0.6  
> **Platform**: Cursor

---

## 📋 Overview

**Superpowers** is an agentic skills framework that transforms coding agents into structured development partners. It enforces best practices automatically through composable skills.

### Key Features

- ✅ **Test-Driven Development**: RED-GREEN-REFACTOR cycle enforced
- ✅ **Systematic Debugging**: Process over guessing
- ✅ **Git Worktrees**: Isolated workspaces for features
- ✅ **Code Review**: Two-stage review (spec + quality)
- ✅ **Subagent Coordination**: Parallel task execution
- ✅ **Automatic Triggers**: Skills activate based on context

---

## 📁 Documentation Files

| File | Description | Purpose |
|------|-------------|---------|
| [`README.md`](README.md) | Main documentation | Overview, installation, usage |
| [`installation.md`](installation.md) | Installation guide | Step-by-step setup |
| [`workflow.md`](workflow.md) | Workflow guide | Complete development process |
| [`skills-reference.md`](skills-reference.md) | Skills reference | All available skills |
| [`laravel-modules.md`](../../laravel/Modules/docs/superpowers.md) | Laravel integration | Module-specific patterns |

---

## 🚀 Quick Start

### 1. Installation (One-Time)

```bash
# In Cursor
/add-plugin superpowers
```

### 2. Verify Installation

```bash
# In Cursor chat
/plugin list
# Should show: superpowers (v5.0.6)
```

### 3. Start Using

```bash
# In Cursor chat
help me plan this feature
```

---

## 🎯 Core Skills

### Planning & Design

| Skill | Trigger | Purpose |
|-------|---------|---------|
| `brainstorming` | "I want to build X" | Refine ideas |
| `writing-plans` | "create a plan" | Break into tasks |
| `executing-plans` | "let's implement" | Execute tasks |

### Development

| Skill | Trigger | Purpose |
|-------|---------|---------|
| `test-driven-development` | "write tests" | TDD cycle |
| `using-git-worktrees` | "create worktree" | Isolated workspace |
| `dispatching-parallel-agents` | "parallelize" | Multi-agent |

### Quality

| Skill | Trigger | Purpose |
|-------|---------|---------|
| `systematic-debugging` | "this is broken" | Debug process |
| `verification-before-completion` | "I'm done" | Final checks |
| `requesting-code-review` | "review this" | Start review |
| `receiving-code-review` | "fix feedback" | Handle review |

---

## 🔄 Standard Workflow

```
1. Brainstorming
   ↓
2. Writing Plans
   ↓
3. Git Worktree Setup
   ↓
4. TDD Execution (per task)
   ├─ RED: Write failing test
   ├─ GREEN: Write minimal code
   ├─ REFACTOR: Improve quality
   └─ COMMIT: Save progress
   ↓
5. Code Review
   ├─ Stage 1: Spec compliance
   └─ Stage 2: Code quality
   ↓
6. Finish Branch
   ├─ Merge or PR
   └─ Cleanup worktree
```

---

## 📊 Best Practices

### Test-Driven Development

**Rule**: Write tests FIRST, always

```php
// ✅ CORRECT - Test first
it('creates user', function () {
    $user = User::create(['name' => 'Test']);
    expect($user)->toBeInstanceOf(User::class);
});
// ❌ FAILS initially

// Then implement to make it pass
```

### Systematic Debugging

**Process**:
1. Reproduce the issue
2. Isolate the cause
3. Form hypothesis
4. Test hypothesis
5. Apply fix
6. Verify

### Git Worktrees

**Always use for features**:
```bash
git worktree add -b feature/my-feature ../worktrees/my-feature
```

### Code Review

**Two stages**:
1. **Spec Compliance**: Does it match the plan?
2. **Code Quality**: Is the code clean?

---

## 🎓 Learning Path

### New Users

1. ✅ Read [README](README.md)
2. ✅ Follow [Installation](installation.md)
3. ✅ Practice brainstorming
4. ✅ Try TDD on small feature
5. ✅ Complete full workflow

### Advanced Users

1. Create custom skills
2. Optimize workflow for team
3. Contribute to Superpowers
4. Mentor new users

---

## 🔧 Configuration

### Automatic (Default)

No configuration needed! Skills trigger automatically.

### Optional: Project Config

Create `.cursor/superpowers-config.json`:

```json
{
  "workflow": {
    "enforce_tdd": true,
    "enforce_git_worktrees": true,
    "auto_review": true
  },
  "testing": {
    "framework": "pest",
    "coverage_target": 90
  },
  "git": {
    "branch_prefix": "feature/",
    "use_worktrees": true
  }
}
```

---

## 📝 Examples

### Example 1: New Feature

```
User: "I want to add activity tracking"
  ↓
Agent: [Brainstorming skill]
  - What activities to track?
  - Storage duration?
  - Real-time analytics?
  ↓
Agent: [Design document]
  ↓
User: "Looks good"
  ↓
Agent: [Writing plans skill]
  - Task 1: Migration
  - Task 2: Model
  - Task 3: Actions
  - Task 4: Tests
  ↓
Agent: [TDD for each task]
  ↓
Agent: [Code review]
  ↓
Agent: [Finish branch]
```

### Example 2: Bug Fix

```
User: "User creation fails with SQL error"
  ↓
Agent: [Systematic debugging skill]
  1. Reproduce: User::create() in tinker
  2. Isolate: Check migration, model, fillable
  3. Hypothesize: Missing column
  4. Test: Describe table
  5. Fix: Add column
  6. Verify: Works ✅
```

---

## 🔗 External Resources

- **GitHub**: https://github.com/obra/superpowers
- **Discord**: https://discord.gg/superpowers
- **Issues**: https://github.com/obra/superpowers/issues

---

## 📞 Support

- **Slack**: #superpowers
- **GitHub Issues**: Label `question`
- **Documentation**: This index + linked docs

---

## 📈 Metrics

### Track Usage

```json
{
  "date": "2026-03-31",
  "skills_used": {
    "brainstorming": 3,
    "writing-plans": 2,
    "test-driven-development": 15
  },
  "tasks_completed": 25,
  "tests_written": 47
}
```

### Target Metrics

| Metric | Target |
|--------|--------|
| Test Coverage | >90% |
| Plan Compliance | 100% |
| Review Pass Rate | >95% |
| TDD Adherence | Always |

---

**Maintainer**: Development Team  
**Installation Date**: 2026-03-31  
**Last Review**: 2026-03-31  
**Next Review**: 2026-06-30  
**Status**: ✅ Installed and Active
