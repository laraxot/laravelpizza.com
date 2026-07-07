# 🦸 Superpowers Installation Guide

> **Last Updated**: 2026-03-31  
> **Status**: ✅ Complete  
> **Platform**: Cursor  
> **Version**: v5.0.6

---

## 📋 Prerequisites

### Required

- ✅ **Cursor IDE** installed
- ✅ **Git** configured
- ✅ **PHP 8.1+** (for Laravel projects)
- ✅ **Node.js 18+** (for frontend tooling)

### Recommended

- ✅ **Composer** (PHP dependencies)
- ✅ **Pest PHP** (testing framework)
- ✅ **PHPStan** (static analysis)

---

## 🚀 Installation Steps

### Step 1: Open Cursor

Launch Cursor IDE and open your project:

```bash
cursor /var/www/_bases/base_fixcity_fila5
```

Or use the GUI:
1. Open Cursor
2. File → Open Folder
3. Select project directory

---

### Step 2: Install Superpowers Plugin

**Method 1: Command Palette (Recommended)**

1. Press `Ctrl+Shift+P` (or `Cmd+Shift+P` on Mac)
2. Type: `Add Plugin`
3. Select: `Superpowers: Add Plugin`
4. Or type command directly: `/add-plugin superpowers`

**Method 2: Marketplace**

1. Open Cursor Settings
2. Navigate to: Extensions → Marketplace
3. Search for: `superpowers`
4. Click: `Install`

**Method 3: Chat Command**

In Cursor chat, type:
```
/add-plugin superpowers
```

---

### Step 3: Verify Installation

**Test 1: Check Plugin List**

In Cursor chat:
```
/plugin list
```

Should show:
```
✅ superpowers (v5.0.6)
```

**Test 2: Trigger a Skill**

In Cursor chat:
```
help me plan this feature
```

Expected response: Agent should invoke brainstorming skill automatically.

**Test 3: Check Skills Directory**

Verify skills are installed:
```bash
ls -la ~/.cursor/plugins/superpowers/skills/
```

Should show multiple `.md` skill files.

---

## ⚙️ Configuration

### Automatic Configuration (Default)

**No configuration required!** Superpowers works out of the box.

Skills trigger automatically based on:
- Conversation context
- Task type
- Project structure

### Optional: Project Configuration

Create `.cursor/superpowers-config.json`:

```json
{
  "workflow": {
    "enforce_tdd": true,
    "enforce_git_worktrees": true,
    "auto_review": true,
    "complexity_threshold": 10
  },
  "testing": {
    "framework": "pest",
    "coverage_target": 90,
    "parallel": true
  },
  "git": {
    "branch_prefix": "feature/",
    "use_worktrees": true,
    "worktree_base": "../worktrees"
  },
  "review": {
    "enforce_plan_compliance": true,
    "block_on_critical": true,
    "require_tests": true
  }
}
```

### Configuration Options

#### Workflow

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `enforce_tdd` | boolean | `true` | Require test-first development |
| `enforce_git_worktrees` | boolean | `true` | Use isolated worktrees |
| `auto_review` | boolean | `true` | Automatic code review |
| `complexity_threshold` | number | `10` | Max cyclomatic complexity |

#### Testing

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `framework` | string | `"pest"` | Test framework (pest/phpunit) |
| `coverage_target` | number | `90` | Target coverage percentage |
| `parallel` | boolean | `true` | Run tests in parallel |

#### Git

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `branch_prefix` | string | `"feature/"` | Prefix for feature branches |
| `use_worktrees` | boolean | `true` | Enable git worktrees |
| `worktree_base` | string | `"../worktrees"` | Base directory for worktrees |

#### Review

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `enforce_plan_compliance` | boolean | `true` | Require plan adherence |
| `block_on_critical` | boolean | `true` | Block on critical issues |
| `require_tests` | boolean | `true` | Require tests for all changes |

---

## 🔧 Post-Installation Setup

### 1. Verify PHP Testing

```bash
cd /var/www/_bases/base_fixcity_fila5/laravel
php artisan test --version
```

Expected: `Pest PHP x.x.x`

### 2. Verify Git Worktrees Support

```bash
git worktree list
```

Should show current worktree.

### 3. Test Superpowers Workflow

**Test Scenario**: Create a simple plan

In Cursor chat:
```
I want to add a new feature to track user activity. Help me plan this.
```

Expected flow:
1. ✅ Brainstorming skill activates
2. ✅ Agent asks clarifying questions
3. ✅ Presents structured plan
4. ✅ Waits for confirmation

---

## 🐛 Troubleshooting

### Issue: Plugin Not Found

**Error**: `Plugin 'superpowers' not found`

**Solutions**:

1. **Check Cursor Version**:
   ```
   Help → About
   ```
   Ensure Cursor is up to date.

2. **Manual Installation**:
   ```bash
   # Clone repository
   git clone https://github.com/obra/superpowers.git ~/.cursor/plugins/superpowers
   
   # Restart Cursor
   ```

3. **Verify Network**:
   Ensure internet connection for plugin marketplace.

---

### Issue: Skills Not Triggering

**Symptoms**: Agent responds normally, doesn't use skills

**Solutions**:

1. **Restart Cursor**:
   ```bash
   # Close and reopen Cursor
   ```

2. **Clear Plugin Cache**:
   ```bash
   rm -rf ~/.cursor/plugins/superpowers/.cache
   ```

3. **Use Trigger Phrases**:
   - "help me plan"
   - "let's debug this"
   - "write tests for"
   - "review this code"

4. **Check Plugin Status**:
   ```
   /plugin status superpowers
   ```

---

### Issue: Git Worktrees Fail

**Error**: `fatal: 'xxx' is already a worktree root`

**Solutions**:

```bash
# List existing worktrees
git worktree list

# Remove stale worktree
git worktree prune

# Or remove specific
git worktree remove /path/to/worktree --force

# Try again
git worktree add -b feature/my-feature ../worktrees/my-feature
```

---

### Issue: TDD Skill Not Working

**Symptoms**: Tests not running automatically

**Solutions**:

1. **Verify Test Framework**:
   ```bash
   php artisan test
   ```

2. **Check Configuration**:
   ```bash
   cat phpunit.xml
   ```

3. **Manual Test Run**:
   ```bash
   ./vendor/bin/pest
   ```

---

## 📊 Verification Checklist

After installation, verify:

- [ ] Plugin installed: `/plugin list` shows superpowers
- [ ] Skills trigger: Ask "help me plan"
- [ ] Git worktrees: `git worktree list` works
- [ ] Tests run: `php artisan test` passes
- [ ] Configuration: `.cursor/superpowers-config.json` (optional)
- [ ] Documentation: Can access skill docs

**All checked?** ✅ Installation complete!

---

## 🎓 Next Steps

### 1. Read Documentation

- [Main README](README.md) - Overview and workflow
- [Skills Reference](skills-reference.md) - All available skills
- [Workflow Guide](workflow.md) - Detailed workflow

### 2. Practice Workflow

Start with a small task:
```
Help me add a simple validation rule
```

Follow the complete workflow:
1. Brainstorming
2. Planning
3. TDD
4. Implementation
5. Review
6. Merge

### 3. Customize (Optional)

Create project-specific skills:
```
I want to create a custom skill for our deployment process
```

### 4. Join Community

- **Discord**: https://discord.gg/superpowers
- **GitHub**: https://github.com/obra/superpowers
- **Issues**: Report bugs and request features

---

## 📝 Installation Log

### 2026-03-31

**Platform**: Cursor  
**Version**: v5.0.6  
**Status**: ✅ Success

**Steps Completed**:
1. ✅ Plugin installed via `/add-plugin superpowers`
2. ✅ Verified with `/plugin list`
3. ✅ Tested brainstorming skill
4. ✅ Created documentation
5. ✅ Configured project integration

**Configuration**:
- TDD: Enabled
- Git Worktrees: Enabled
- Auto Review: Enabled
- Coverage Target: 90%

**Notes**:
- Installation smooth, no issues
- Skills trigger automatically
- Ready for production use

---

## 🔗 Related Documentation

### Internal

- [README](README.md) - Main documentation
- [Workflow Guide](workflow.md) - How to use
- [Skills Reference](skills-reference.md) - All skills
- [Project Integration](project-integration.md) - Laravel integration

### External

- [Superpowers GitHub](https://github.com/obra/superpowers)
- [Superpowers Discord](https://discord.gg/superpowers)
- [Cursor Plugins](https://cursor.com/plugins)

---

**Maintainer**: Development Team  
**Installation Date**: 2026-03-31  
**Last Verification**: 2026-03-31  
**Status**: ✅ Installed and Verified
