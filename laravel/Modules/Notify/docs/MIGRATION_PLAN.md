# Documentation Agnostic Migration Plan

## Executive Summary

**Problem**: Module and theme documentation contains **1,500+ project-specific references** (FixCity) when it should be **project-agnostic** and reusable.

**Solution**: Implement governance rules, rename files, and replace content with generic placeholders.

---

## Impact Analysis

### Scope
- **Modules**: 1,529 occurrences across 6,446 documentation files
- **Themes**: 115 occurrences across 326 documentation files
- **Total**: ~1,644 occurrences to fix

### Breakdown by Type

| Pattern | Occurrences | Priority |
|---------|-------------|----------|
| `Fixcity` (in content) | 1,050 | 🔴 HIGH |
| `FixCity` (in content) | 259 | 🔴 HIGH |
| `fixcity` (in content) | 220 | 🔴 HIGH |
| `fixcity-` (in filenames) | TBD | 🟡 MEDIUM |
| `fixcity.local` | 3 | 🟢 LOW |
| `base_fixcity_fila5` | 11 | 🟢 LOW |

---

## Completed Work (Phase 1)

### ✅ 1. Governance Document Created
**File**: `laravel/Modules/docs/AGNOSTIC_DOCUMENTATION_RULE.md`

Defines:
- Core principle: All module/theme docs must be project-agnostic
- Naming conventions for files
- Placeholder usage guidelines
- Examples and templates
- Quality check criteria

### ✅ 2. Example Conversions

#### File Renamed
- **Before**: `laravel/Modules/Cms/docs/fixcity-pages-content-blocks.md`
- **After**: `laravel/Modules/Cms/docs/pages-content-blocks.md`

#### Content Updated
- Replaced `FixCity` → `[PROJECT_NAME]`
- Replaced `fixcity` → `[project_name]`
- Added contextual notes for users
- Made examples generic with placeholders

#### Themes Documentation
**File**: `laravel/Themes/docs/README.md`

Changes:
- Removed "FixCity PTVX ecosystem" → "PTVX ecosystem"
- Replaced `base_fixcity_fila5/` → `<project_root>/`
- Replaced `fixcity.local` → `[YOUR_DOMAIN]`
- Replaced GitHub repo reference → `your-org/your-repo`
- Added placeholder guidance notes

### ✅ 3. Automation Script Created
**File**: `bashscripts/fix-docs-agnostic.sh`

Features:
- Dry-run mode to preview changes
- Bulk find-and-replace for all patterns
- File renaming for project-specific names
- Color-coded output
- Safe operation with rollback capability

---

## Action Plan

### Phase 2: Bulk Migration (Recommended Approach)

#### Option A: Fully Automated (Fastest)
```bash
# Review what will change
./bashscripts/fix-docs-agnostic.sh --dry-run

# Apply all changes
./bashscripts/fix-docs-agnostic.sh

# Review git diff
git diff laravel/Modules/ laravel/Themes/
```

**Pros**: 
- Completes in seconds
- Consistent application
- Easy to review in bulk

**Cons**:
- May miss edge cases
- Requires careful review

#### Option B: Semi-Automated (Recommended)
Process module-by-module with review:

```bash
# Example: Fix one module at a time
./bashscripts/fix-docs-agnostic-module.sh Cms --dry-run
./bashscripts/fix-docs-agnostic-module.sh Cms
git add laravel/Modules/Cms/docs/
git commit -m "docs(Cms): make documentation agnostic"

# Repeat for each module
```

**Pros**:
- Easier to review incrementally
- Can catch module-specific issues
- Smaller commits

**Cons**:
- Takes longer
- More manual work

#### Option C: Manual Review (Slowest, Most Careful)
1. Use the script to identify files
2. Manually review each file
3. Apply changes selectively
4. Update cross-references

**Best for**: Critical documentation that needs human judgment

---

## Recommended Priority Order

### Tier 1: Core Modules (Week 1)
1. ✅ **Cms** - Already done (example)
2. **Xot** - Base classes, highest impact
3. **User** - Universal across projects
4. **UI** - Theme integration layer

### Tier 2: Business Modules (Week 2)
5. **Blog** - Common reuse pattern
6. **Geo** - Location services
7. **Media** - File management
8. **Comment** - Generic feature

### Tier 3: Specialized Modules (Week 3)
9. **Activity**
10. **Notify**
11. **Rating**
12. **Tenant**
13. **Seo**
14. **AI**

### Tier 4: Themes (Week 4)
15. **Sixteen** - Frontend theme
16. **TwentyOne** - Admin theme

---

## Quality Assurance

### Pre-Commit Checklist

For each module/theme:
- [ ] No `FixCity`, `Fixcity`, `fixcity` in content
- [ ] No project-specific filenames
- [ ] Placeholders used consistently:
  - `[PROJECT_NAME]` for platform name
  - `[project_name]` for lowercase references
  - `[YOUR_DOMAIN]` for development domains
  - `[your_module]` for module references
  - `<project_root>` for project paths
- [ ] Cross-references use relative paths
- [ ] Examples are generic and reusable
- [ ] Added contextual notes where needed

### Automated Checks

Add to CI/CD:
```bash
# Fail if project-specific refs found in docs
if grep -r "FixCity" laravel/Modules/*/docs/ laravel/Themes/*/docs/; then
  echo "❌ Project-specific references found in documentation"
  exit 1
fi
```

### Git Hook (Optional)

Create `.git/hooks/pre-commit`:
```bash
#!/bin/bash
# Check for project-specific docs in staged changes
if git diff --cached --name-only | grep -E "^(laravel/Modules|laravel/Themes)/.*/docs/.*\.md$" | xargs grep -l "FixCity" 2>/dev/null; then
  echo "❌ Commit blocked: Project-specific references in documentation"
  echo "Run: ./bashscripts/fix-docs-agnostic.sh --dry-run"
  exit 1
fi
```

---

## Migration Examples

### Before → After Comparison

#### Example 1: Module README

**Before**:
```markdown
# FixCity Blog Module

This module provides blog functionality for FixCity platform.
Access at: fixcity.local/blog
```

**After**:
```markdown
# Blog Module

This module provides blog functionality for [PROJECT_NAME] platform.
Access at: `[YOUR_DOMAIN]/blog`

> **Note**: Replace `[PROJECT_NAME]` and `[YOUR_DOMAIN]` with your actual project values.
```

#### Example 2: Integration Guide

**Before**:
```markdown
## FixCity Integration

1. Add to Fixcity config:
   ```php
   config('fixcity.blog.settings')
   ```

2. Routes available at fixcity.local/admin/blog
```

**After**:
```markdown
## Project Integration

1. Add to your project config:
   ```php
   config('[project_name].blog.settings')
   ```

2. Routes available at `[YOUR_DOMAIN]/admin/blog`

> **Note**: Replace `[project_name]` with your actual project name.
```

---

## Risk Mitigation

### Potential Issues

1. **Broken Cross-References**
   - **Risk**: Links to other docs might break
   - **Mitigation**: Use relative paths, test all links

2. **Loss of Context**
   - **Risk**: Generic docs might be less helpful
   - **Mitigation**: Add examples in comments, keep project-specific examples in project docs

3. **Incomplete Migration**
   - **Risk**: Some refs might be missed
   - **Mitigation**: Use automated script + manual review

4. **User Confusion**
   - **Risk**: Placeholders might confuse users
   - **Mitigation**: Add clear guidance notes, provide examples

### Rollback Plan

If issues are found:
```bash
# Git makes rollback easy
git checkout HEAD -- laravel/Modules/Cms/docs/

# Or revert specific commits
git revert <commit-hash>
```

---

## Success Metrics

### Quantitative
- ✅ 0 occurrences of "FixCity" in module/theme docs
- ✅ 0 occurrences of "fixcity" in module/theme docs
- ✅ 100% of filenames are project-agnostic
- ✅ 100% of cross-references use relative paths

### Qualitative
- ✅ Documentation is understandable without project context
- ✅ Examples are easily adaptable to new projects
- ✅ New developers can understand module purpose
- ✅ Documentation can be reused in other projects

---

## Next Steps

### Immediate (This Session)
1. ✅ Created governance rule
2. ✅ Fixed Cms module example
3. ✅ Fixed Themes master index
4. ✅ Created automation script
5. ✅ Created this migration plan

### Short Term (This Week)
1. Run script in dry-run mode to review full scope
2. Choose migration approach (A, B, or C)
3. Start with Tier 1 modules (Xot, User, UI)
4. Set up automated quality checks

### Medium Term (This Month)
1. Complete all module migrations
2. Complete theme migrations
3. Add pre-commit hook
4. Update CI/CD checks
5. Train team on new standards

### Long Term (Ongoing)
1. Enforce rule in code reviews
2. Periodic audits
3. Update examples as needed
4. Gather feedback and improve

---

## Resources

### Created Files
- `laravel/Modules/docs/AGNOSTIC_DOCUMENTATION_RULE.md` - Governance rule
- `bashscripts/fix-docs-agnostic.sh` - Automation script
- `laravel/Modules/docs/MIGRATION_PLAN.md` - This document

### Modified Files
- `laravel/Modules/Cms/docs/pages-content-blocks.md` - Example conversion
- `laravel/Themes/docs/README.md` - Master index updated

### External References
- [Filament Builder Docs](https://filamentphp.com/docs/5.x/forms/builder)
- [Laravel Documentation Standards](https://laravel.com/docs/contributions#documentation)
- [Keep a Changelog](https://keepachangelog.com/)

---

## FAQ

**Q: Why not keep project-specific docs in modules?**  
A: Modules should be reusable. Project-specific docs create coupling and reduce portability.

**Q: Where should project-specific documentation go?**  
A: In `docs/project/` at the project root, not in individual modules.

**Q: What if a module is truly project-specific?**  
A: Consider keeping it in the project root, not in the reusable Modules directory.

**Q: How do I handle module-to-module references?**  
A: Use generic names: "Blog Module" instead of "FixCity Blog Module".

**Q: Can I still mention FixCity in examples?**  
A: Yes, but clearly mark them as examples: "e.g., 'fixcity' for a civic platform".

---

**Version**: 1.0  
**Created**: 2026-03-30  
**Status**: Phase 1 Complete, Ready for Phase 2  
**Owner**: Development Team
