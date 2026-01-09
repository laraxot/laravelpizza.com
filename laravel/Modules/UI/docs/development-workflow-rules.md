# Development Workflow Rules - UI Module

**Date**: 2025-12-15
**Status**: Active
**Purpose**: Document the mandatory development workflow for UI module

## 🚨 Mandatory Workflow Rules

### Rule 1: Code Quality Check Cycle
**AFTER EVERY FILE MODIFICATION**, you MUST:

1. **PHPStan Analysis**
   ```bash
   ./vendor/bin/phpstan analyse path/to/modified/file.php --level=max
   ```

2. **PHPMD Analysis**
   ```bash
   ./vendor/bin/phpmd path/to/modified/file.php text cleancode,codesize,design,naming,unusedcode
   ```

3. **PHPInsights Analysis**
   ```bash
   ./vendor/bin/phpinsights analyse path/to/modified/file.php --min-quality=80 --min-complexity=80 --min-architecture=80 --min-style=80
   ```

4. **Fix All Issues**
   - Fix PHPStan errors (level max compliance)
   - Fix PHPMD violations
   - Fix PHPInsights quality issues
   - Re-run checks until perfect

### Rule 2: Documentation Update Cycle
**AFTER CODE IS PERFECT**, you MUST:

1. **Update Module Documentation**
   - Study existing docs in `Modules/UI/docs/`
   - Update relevant documentation files
   - Add new documentation if needed
   - Ensure documentation reflects current implementation

2. **Update Theme Documentation**
   - Study docs in `Themes/*/docs/`
   - Update theme documentation if affected
   - Document UI/theme integration patterns

3. **Study and Learn**
   - Analyze what you learned from the fix
   - Document patterns and anti-patterns
   - Update best practices documentation

### Rule 3: Git Workflow
**AFTER DOCUMENTATION IS UPDATED**, you MUST:

1. **Stage Changes**
   ```bash
   git add path/to/modified/file.php
   git add path/to/updated/docs/
   ```

2. **Commit with Meaningful Message**
   ```bash
   git commit -m "fix: PSR-4 autoloading compliance for UI module

   - Fixed namespace declarations in UI/Filament/Forms/Components/
   - Separated mock classes into individual files
   - Updated documentation with analysis and patterns

   🤖 Generated with [Claude Code](https://claude.com/claude-code)

   Co-Authored-By: Claude Sonnet 4.5 <noreply@anthropic.com>"
   ```

3. **Push Changes**
   ```bash
   git push origin current-branch
   ```

### Rule 4: Memory and Rules Update
**AFTER SUCCESSFUL PUSH**, you MUST:

1. **Update Internal Rules**
   - Update your understanding of project patterns
   - Remember new anti-patterns to avoid
   - Internalize successful solutions

2. **Update Memory**
   - Remember this workflow for future tasks
   - Store successful patterns in memory
   - Learn from mistakes and corrections

## 📋 Checklist for Every Change

### Before Starting
- [ ] Understand the problem thoroughly
- [ ] Study relevant documentation
- [ ] Check existing patterns in codebase

### During Implementation
- [ ] Make minimal necessary changes
- [ ] Follow XotBase extension rules
- [ ] Maintain PHPStan level 10 compliance

### After Implementation
- [ ] Run PHPStan analysis
- [ ] Run PHPMD analysis
- [ ] Run PHPInsights analysis
- [ ] Fix all issues found
- [ ] Re-run checks until perfect

### Documentation Phase
- [ ] Update module docs
- [ ] Update theme docs if relevant
- [ ] Document what you learned
- [ ] Update patterns and best practices

### Git Phase
- [ ] Stage all changes
- [ ] Commit with descriptive message
- [ ] Push to remote

### Learning Phase
- [ ] Internalize the workflow
- [ ] Remember patterns and anti-patterns
- [ ] Update your rules and memories

## 🎯 Quality Standards

### PHPStan: Level Max Compliance
- Zero errors allowed
- Strict type checking
- Complete PHPDoc documentation
- No `mixed` types when avoidable

### PHPMD: Clean Code
- No code smells
- Reasonable complexity
- Good naming conventions
- No unused code

### PHPInsights: High Quality
- Minimum 80% quality score
- Minimum 80% architecture score
- Minimum 80% complexity score
- Minimum 80% style score

## 📚 Related Documentation

- [Xot Philosophy](../Xot/docs/philosophy-complete.md)
- [PSR-4 Autoloading Error Analysis](./psr4-autoloading-error-analysis.md)
- [Development Guidelines](../../../docs/development/README.md)
- [Git Workflow](../../../docs/git-conflict-resolution/README.md)

## ⚠️ Consequences of Skipping Steps

### Skipping Code Quality Checks
- PHPStan errors in production
- Code smells and technical debt
- Reduced maintainability
- Violation of project standards

### Skipping Documentation
- Knowledge loss
- Difficult maintenance
- Poor onboarding for new developers
- Repeated mistakes

### Skipping Git Workflow
- Uncommitted changes lost
- No version history
- Difficult collaboration
- No backup of work

## 🔄 Continuous Improvement

### After Each Successful Implementation
1. **Review what worked well**
2. **Identify areas for improvement**
3. **Update this workflow document**
4. **Share learnings with team**

### Pattern Recognition
- Document successful patterns
- Document common anti-patterns
- Create reusable solutions
- Build knowledge base

---

**Remember**: This workflow is NOT optional. It is the foundation of quality software development in the Laraxot/PTVX ecosystem. Every change must go through this complete cycle to ensure maintainability, quality, and knowledge preservation.
