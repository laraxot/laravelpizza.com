# Documentation Governance Framework

**Version**: 1.0  
**Status**: Active  
**Applies to**: All modules and themes

---

## 🎯 Purpose

This document establishes the governance framework for all documentation in the FixCity platform, ensuring consistency, quality, and maintainability across all modules and themes.

---

## 📁 Standard Directory Structure

### Module Documentation Structure

```
Modules/ModuleName/
├── docs/
│   ├── README.md                    # Module overview and quick reference
│   ├── 00-index.md                  # Alternative index (if needed)
│   ├── CHANGELOG.md                 # Module changelog
│   ├── architecture/                # Architecture decisions and patterns
│   │   ├── overview.md
│   │   └── decisions/               # ADRs (Architectural Decision Records)
│   ├── guides/                      # How-to guides and tutorials
│   ├── references/                  # API references, class documentation
│   │   ├── models/
│   │   ├── services/
│   │   └── contracts/
│   ├── best-practices/              # Best practices and patterns
│   ├── troubleshooting/             # Common issues and solutions
│   └── internal/                    # Internal notes (not for end users)
│       ├── meetings/
│       ├── drafts/
│       └── work-in-progress/
```

### Theme Documentation Structure

```
Themes/ThemeName/
├── docs/
│   ├── README.md                    # Theme overview
│   ├── getting-started/             # Installation and setup
│   ├── components/                  # Component documentation
│   │   ├── overview.md
│   │   └── [component-name].md
│   ├── customization/               # Customization guides
│   ├── build-system/                # Vite, build processes
│   └── troubleshooting/             # Theme-specific issues
```

---

## 📝 Naming Conventions

### File Naming Rules

✅ **CORRECT**:
- `user-authentication.md` (kebab-case)
- `00-index.md` (numeric prefix for ordering)
- `README.md` (standard)
- `CHANGELOG.md` (standard)
- `best-practices.md` (descriptive, lowercase)

❌ **WRONG**:
- `UserAuthentication.md` (PascalCase)
- `user_authentication.md` (snake_case - inconsistent)
- `USER_AUTHENTICATION.md` (UPPERCASE - except standard files)
- `temp.md`, `test.md`, `notes.md` (non-descriptive)
- `doc-v1.md`, `final-final.md` (versioned names)

### Directory Naming Rules

✅ **CORRECT**:
- `best-practices/` (lowercase, hyphenated)
- `guides/` (simple, lowercase)
- `references/` (clear purpose)

❌ **WRONG**:
- `BestPractices/` (PascalCase)
- `best_practices/` (underscore - use hyphen)
- `temp/`, `old/`, `backup/` (temporary names)

---

## 🚫 CRITICAL: No Temporal Strings

**RULE**: NEVER include temporal strings in documentation files.

### Forbidden Patterns

❌ **NEVER INCLUDE**:
```markdown
**Last Updated**: 2026-03-02
**Next Review**: 2026-03-16
**Version**: 12.0.0
Updated: January 2025
Gennaio 2025
*Last Updated: March 12, 2026*
```

### Why?

1. **Timeless Documentation**: Good documentation is evergreen
2. **Git History**: Use git for temporal tracking
3. **Maintenance Burden**: Dates require constant updates
4. **Misleading**: Old dates discourage readers
5. **Version Control**: Git commits track when changes happened

### Correct Pattern

✅ **DO THIS**:
```markdown
# User Authentication Guide

This guide covers user authentication implementation.

## Related
- [Session Management](session-management.md)
- [Password Reset](password-reset.md)

---

**Status**: Active  
**Owner**: @team-lead  
**Review Cycle**: Quarterly
```

Track changes via git:
```bash
git log --follow docs/user-authentication.md
git blame docs/user-authentication.md
```

---

## 📊 Documentation Quality Standards

### Content Requirements

1. **Clear Purpose**: Every document must have a clear purpose statement
2. **Target Audience**: Define who should read it
3. **Prerequisites**: List required knowledge
4. **Examples**: Include practical examples
5. **Related Links**: Cross-reference related documentation
6. **No Duplicates**: Each topic documented ONCE

### Structure Requirements

1. **Header**: Clear title and purpose
2. **Table of Contents**: For documents >500 words
3. **Sections**: Logical hierarchy (H2 → H3 → H4)
4. **Code Blocks**: Syntax-highlighted examples
5. **Warnings/Notes**: Use callouts for important info
6. **Summary**: Key takeaways at the end

### Language Requirements

1. **English Primary**: All documentation in English
2. **Italian Allowed**: Only for Italian-specific compliance (AGID)
3. **Consistent Terminology**: Use glossary terms
4. **Active Voice**: "Do this" not "This should be done"
5. **Simple Sentences**: One idea per sentence

---

## 🔍 Documentation Health Checks

### Automated Checks

Run these commands to verify documentation health:

```bash
# Find temporal strings
grep -r "Last Updated" laravel/Modules/*/docs/
grep -r "Aggiornato" laravel/Modules/*/docs/
grep -r "Updated:" laravel/Modules/*/docs/

# Find duplicate documentation
find laravel/Modules/*/docs -name "*.md" | sort | uniq -d

# Find orphaned files (no links from index)
# (Requires custom script)

# Check for broken links
# (Requires link checker tool)
```

### Manual Review Checklist

- [ ] No temporal strings (dates, "last updated")
- [ ] Clear purpose statement
- [ ] Target audience defined
- [ ] Examples included
- [ ] Related documents linked
- [ ] No duplicate content
- [ ] Consistent terminology
- [ ] Proper heading hierarchy
- [ ] Code examples tested
- [ ] Links verified

---

## 📋 Documentation Types

### 1. README.md (Module/Theme Overview)

**Purpose**: Quick reference and entry point  
**Audience**: All developers  
**Content**:
- Quick reference table
- Core features list
- Installation/setup
- Links to key guides

**Example Structure**:
```markdown
# Module Name

## 📋 Quick Reference
| Category | Guide | File |
|----------|-------|------|
| Feature 1 | Guide Name | [link.md](link.md) |

## 🎯 Core Features
- Feature 1
- Feature 2

## Installation
...

## Related
- [Other Module](../OtherModule/docs/README.md)
```

### 2. Guides (How-To)

**Purpose**: Teach how to accomplish a task  
**Audience**: Developers implementing features  
**Content**:
- Prerequisites
- Step-by-step instructions
- Examples
- Troubleshooting

### 3. References

**Purpose**: Authoritative technical information  
**Audience**: Developers needing details  
**Content**:
- API documentation
- Class/method signatures
- Configuration options
- Edge cases

### 4. Architecture Decision Records (ADRs)

**Purpose**: Document significant architectural decisions  
**Audience**: Current and future architects  
**Content**:
- Context
- Decision
- Consequences
- Status

**Template**:
```markdown
# ADR-001: Use Spatie Queueable Actions

## Status
Accepted

## Context
...

## Decision
...

## Consequences
...
```

### 5. Best Practices

**Purpose**: Establish coding standards  
**Audience**: All developers  
**Content**:
- Recommended patterns
- Anti-patterns to avoid
- Examples
- Rationale

### 6. Troubleshooting

**Purpose**: Solve common problems  
**Audience**: Developers facing issues  
**Content**:
- Problem description
- Symptoms
- Solution
- Prevention

---

## 🗂️ Consolidation Rules

### Duplicate Elimination

**RULE**: Each topic documented ONCE across entire platform.

**Process**:
1. Identify duplicates (same topic in multiple files)
2. Choose best version as canonical
3. Merge unique content from others
4. Replace duplicates with redirects
5. Update all links

**Redirect Pattern**:
```markdown
# Old Topic Name

> **This document has been moved**
> 
> 📍 New location: [New Topic Name](new-location.md)

---

*This file kept for backward compatibility. Update your bookmarks.*
```

### Consolidation Priority

1. **Architecture**: One source of truth
2. **Best Practices**: Consolidated per module
3. **Guides**: Module-specific OK
4. **Troubleshooting**: Centralized when possible

---

## 🔄 Maintenance Workflow

### Before Creating Documentation

1. **Search Existing**: Check if topic already documented
2. **Define Purpose**: Why is this needed?
3. **Choose Location**: Correct directory structure
4. **Follow Template**: Use standard format
5. **Link to Index**: Add to module README

### After Creating Documentation

1. **Update Index**: Add to module README
2. **Cross-Reference**: Link from related docs
3. **Remove Duplicates**: Check for overlapping content
4. **Verify Links**: Test all internal links
5. **Git Commit**: Commit with clear message

### Periodic Review

**Frequency**: Quarterly  
**Process**:
1. Run health checks
2. Review outdated content
3. Consolidate duplicates
4. Update broken links
5. Archive obsolete docs

---

## 📏 Metrics and KPIs

### Documentation Quality Metrics

1. **Coverage**: % of features documented
2. **Freshness**: Time since last git update
3. **Usage**: Views/clicks (if tracked)
4. **Links**: Internal link density
5. **Examples**: Code examples per 1000 words

### Target Values

- **Coverage**: >90%
- **Freshness**: <6 months (git updated)
- **Examples**: >3 per guide
- **Links**: >5 internal links per doc
- **Duplicates**: 0

---

## 🛠️ Tools and Automation

### Recommended Tools

1. **Markdown Linter**: `markdownlint`
2. **Link Checker**: `lychee`
3. **Spell Checker**: `cspell`
4. **Search**: `grep`, `ripgrep`

### CI/CD Integration

```yaml
# .github/workflows/docs-check.yml
name: Documentation Check
on: [push, pull_request]
jobs:
  docs:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Check for temporal strings
        run: |
          ! grep -r "Last Updated" docs/
          ! grep -r "Updated:" docs/
      - name: Markdown lint
        run: npx markdownlint-cli docs/
```

---

## 📚 Related Documents

- [AGENTS.md](../../../AGENTS.md) - Agent guidelines
- [.windsurfrules](../../../.windsurfrules) - IDE rules
- [DOCUMENTATION_INDEX.md](../../../docs/DOCUMENTATION_INDEX.md) - Master index

---

**Status**: Active  
**Owner**: @architecture-team  
**Review Cycle**: Quarterly  
**Next Review**: 2026-Q2
