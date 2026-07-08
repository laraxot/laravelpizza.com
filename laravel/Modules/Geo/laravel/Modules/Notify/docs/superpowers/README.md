# 🦸 Superpowers - Agentic Skills Framework

> **Last Updated**: 2026-03-31  
> **Status**: ✅ Installed  
> **Version**: v5.0.6  
> **Platform**: Cursor

---

## 📋 Overview

**Superpowers** is an agentic skills framework and software development methodology designed for coding agents. It provides a complete workflow built on composable "skills" that guide agents through structured development processes.

### What It Does

- **Workflow Automation**: Guides through brainstorming, planning, implementation, and review
- **Best Practices Enforcement**: TDD, systematic debugging, complexity reduction
- **Subagent Coordination**: Manages subagent-driven development with two-stage reviews
- **Git Management**: Handles isolated workspaces via git worktrees and branch management

### Supported Platforms

- ✅ **Cursor** (our platform)
- Claude Code
- Codex
- OpenCode
- Gemini CLI

---

## 🚀 Installation

### For Cursor (Our Platform)

**Method 1: Command**
```bash
/add-plugin superpowers
```

**Method 2: Marketplace**
1. Open Cursor plugin marketplace
2. Search for "superpowers"
3. Click "Install"

### Verification

After installation, start a new session and request a task:
```
"help me plan this feature"
```

The agent should automatically invoke relevant skills.

---

## ⚙️ Configuration

### Automatic Triggering

**No configuration files required!** Skills trigger automatically based on context.

### Updates

To update Superpowers skills:
```bash
# In Cursor
/plugin update superpowers
```

### Project-Specific Configuration

Create `.cursor/superpowers-config.json` for project-specific settings (optional):

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

## 📚 Skills Library

### Core Skills

#### Planning & Design
- `brainstorming` - Refines ideas through questions
- `writing-plans` - Breaks work into bite-sized tasks
- `executing-plans` - Executes planned tasks
- `dispatching-parallel-agents` - Manages subagents

#### Development
- `test-driven-development` - Enforces RED-GREEN-REFACTOR cycle
- `using-git-worktrees` - Creates isolated workspaces
- `finishing-a-development-branch` - Completes and merges branches

#### Quality
- `systematic-debugging` - Structured debugging approach
- `verification-before-completion` - Ensures quality before completion
- `requesting-code-review` - Initiates code review process
- `receiving-code-review` - Handles review feedback

#### Meta
- `writing-skills` - Create new skills
- `using-superpowers` - General usage guide

---

## 🔄 Basic Workflow

### 1. Brainstorming

**Purpose**: Refine ideas and validate design

**Process**:
1. Agent asks clarifying questions
2. Presents design sections for validation
3. Waits for user confirmation

**Example**:
```
User: "I want to add a new feature for X"
Agent: [Asks questions to understand scope, constraints, requirements]
Agent: [Presents design document]
User: "Looks good, proceed"
```

---

### 2. Using Git Worktrees

**Purpose**: Isolated workspace for each feature

**Commands**:
```bash
# Create worktree
git worktree add -b feature/my-feature ../worktrees/my-feature

# Work in isolation
cd ../worktrees/my-feature

# When done
git worktree remove ../worktrees/my-feature
```

**Benefits**:
- Clean main branch
- Parallel feature development
- Easy rollback

---

### 3. Writing Plans

**Purpose**: Break work into manageable tasks

**Plan Structure**:
```markdown
## Task 1: Create migration
- File: `database/migrations/2026_03_31_create_table.php`
- Steps:
  1. Create migration file
  2. Define schema
  3. Run migration
- Verification: `php artisan migrate --pretend`

## Task 2: Create model
- File: `app/Models/MyModel.php`
- Steps:
  1. Create model class
  2. Define fillable
  3. Add relationships
- Verification: `php artisan tinker` (test model)
```

**Task Size**: 2-5 minutes each

---

### 4. Execution

**Purpose**: Implement planned tasks

**Modes**:
1. **Sequential**: One task at a time
2. **Parallel**: Dispatch subagents per task
3. **Batched**: Execute multiple tasks with checkpoints

**Review Process**:
1. **Spec Compliance**: Does it match the plan?
2. **Code Quality**: Is the code clean and maintainable?

**Critical Issues**: Block progress until fixed

---

### 5. Test-Driven Development

**Purpose**: Ensure quality through tests first

**RED-GREEN-REFACTOR Cycle**:

```
RED:   Write failing test
  ↓
GREEN: Write minimal code to pass
  ↓
REFACTOR: Clean up while keeping tests green
  ↓
COMMIT: Save with conventional commit
```

**Example**:
```php
// 1. RED - Write test first
it('creates a new user', function () {
    $user = User::create(['name' => 'Test']);
    expect($user)->toBeInstanceOf(User::class);
});

// 2. GREEN - Write minimal implementation
class User extends Model {
    protected $fillable = ['name'];
}

// 3. REFACTOR - Improve code quality
class User extends Model {
    protected $fillable = ['name'];
    
    public function scopeActive($query) {
        return $query->whereNotNull('activated_at');
    }
}
```

---

### 6. Code Review

**Purpose**: Ensure quality before merge

**Review Checklist**:
- [ ] Matches original plan
- [ ] Tests pass
- [ ] Code follows conventions
- [ ] No critical issues
- [ ] Documentation updated

**Blocking Issues**:
- Security vulnerabilities
- Breaking changes without migration
- Missing tests for critical paths
- Performance regressions

---

### 7. Finishing Branch

**Purpose**: Complete and merge feature

**Steps**:
1. Verify all tests pass
2. Present merge options:
   - Merge to main
   - Create Pull Request
   - Keep as feature branch
3. Clean up worktree
4. Update documentation

---

## 📁 Project Integration

### File Structure

```
base_fixcity_fila5/
├── .cursor/
│   ├── superpowers-config.json    ← Optional configuration
│   └── skills/                     ← Custom skills (if any)
├── docs/
│   ├── superpowers/
│   │   ├── README.md              ← This file
│   │   ├── installation.md
│   │   ├── workflow.md
│   │   └── skills-reference.md
│   └── index.md                    ← Updated with superpowers refs
└── laravel/
    └── Modules/
        └── docs/
            └── superpowers.md      ← Module-specific guide
```

---

## 🎯 Best Practices

### Test-Driven Development

**Rule**: Write tests FIRST, always

```php
// ✅ CORRECT - Test first
// 1. Write test
it('validates email', function () {
    User::create(['email' => 'invalid']); // Should fail
});

// 2. Run test (RED)
// 3. Implement validation
// 4. Run test (GREEN)

// ❌ WRONG - Code first
User::create(['email' => 'test@example.com']);
// Now write test to prove it works
```

---

### Systematic Debugging

**Rule**: Process over guessing

**Steps**:
1. **Reproduce**: Create minimal reproduction
2. **Isolate**: Narrow down the cause
3. **Hypothesize**: Form theory about root cause
4. **Test**: Verify hypothesis
5. **Fix**: Apply targeted fix
6. **Verify**: Ensure fix works and doesn't break anything

---

### Complexity Reduction

**Rule**: Simplicity is the primary goal

**Strategies**:
- Extract methods for clarity
- Remove duplication (DRY)
- Use descriptive names
- Keep functions small (<20 lines)
- Prefer composition over inheritance

---

### Evidence Over Claims

**Rule**: Verify before declaring success

```bash
# ✅ CORRECT - Verify with commands
php artisan test                    # Tests pass
phpstan analyse --level=10         # No errors
git diff --stat                    # Show changes

# ❌ WRONG - Just claim
"I think it works"
"Should be fixed"
```

---

## 🔧 Troubleshooting

### Issue: Skills Not Triggering

**Symptoms**: Agent doesn't use Superpowers skills

**Solutions**:
1. Verify installation: `/add-plugin superpowers`
2. Restart Cursor
3. Start new session
4. Use trigger phrases: "help me plan", "let's debug"

---

### Issue: Worktree Creation Fails

**Symptoms**: `git worktree add` fails

**Solutions**:
```bash
# Check existing worktrees
git worktree list

# Remove stale worktrees
git worktree prune

# Try again
git worktree add -b feature/my-feature ../worktrees/my-feature
```

---

### Issue: Tests Not Running

**Symptoms**: Test skill doesn't execute tests

**Solutions**:
```bash
# Verify test framework
php artisan test --version

# Run manually
php artisan test

# Check configuration
cat phpunit.xml
```

---

## 🔗 Related Documentation

### Internal

- [TDD Guide](testing/tdd.md) - Test-driven development
- [Git Workflow](git/workflow.md) - Git best practices
- [Code Review](quality/code-review.md) - Review process
- [Debugging](debugging/systematic.md) - Debugging guide

### External

- [Superpowers GitHub](https://github.com/obra/superpowers)
- [Superpowers Discord](https://discord.gg/superpowers)
- [Plugin Marketplace](https://cursor.com/plugins/superpowers)

---

## 📊 Workflow Metrics

### Target Metrics

| Metric | Target | Current |
|--------|--------|---------|
| Test Coverage | >90% | - |
| Plan Compliance | 100% | - |
| Review Pass Rate | >95% | - |
| Worktree Usage | Always | - |

### Tracking

Track metrics in `.superpowers/metrics.json`:

```json
{
  "sessions": [],
  "tasks_completed": 0,
  "tests_written": 0,
  "bugs_fixed": 0
}
```

---

## 🎓 Learning Path

### New Users

1. **Read**: This README
2. **Install**: Follow installation steps
3. **Practice**: Use brainstorming skill
4. **Apply**: Try TDD on small feature
5. **Master**: Full workflow end-to-end

### Advanced Users

1. **Customize**: Create project-specific skills
2. **Optimize**: Tune workflow for team
3. **Contribute**: Add skills to repository
4. **Mentor**: Help new users

---

## 📝 Maintenance

### Update Schedule

- **Weekly**: Check for plugin updates
- **Monthly**: Review workflow effectiveness
- **Quarterly**: Update custom skills
- **Annually**: Full workflow audit

### Contributing

1. Fork repository
2. Create branch: `feature/my-skill`
3. Write skill following `writing-skills` guide
4. Test thoroughly
5. Submit PR

---

## 📞 Support

### Getting Help

- **Discord**: Superpowers community
- **GitHub Issues**: https://github.com/obra/superpowers/issues
- **Documentation**: This file and linked docs

### Common Questions

**Q: Do I need to configure anything?**  
A: No, skills trigger automatically.

**Q: Can I create custom skills?**  
A: Yes, see `writing-skills` guide.

**Q: How do I update?**  
A: `/plugin update superpowers` in Cursor.

---

**Maintainer**: Development Team  
**Last Review**: 2026-03-31  
**Next Review**: 2026-06-30  
**Status**: ✅ Installed and Active
