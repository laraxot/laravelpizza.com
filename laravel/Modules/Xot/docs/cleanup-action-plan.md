# Documentation Cleanup & Reorganization - Action Plan

**Date**: [DATE]
**Status**: 🐮 SUPER MUCCA MODE ACTIVATED
**Scope**: Complete documentation overhaul across all modules and themes

## 📊 Initial Analysis

### Problems Identified:
- **2789 non-compliant .md files** (uppercase, dates, duplicates)
- Multiple duplicate files with variations (file.md, file_backup.md, file-duplicate.md)
- Inconsistent naming (kebab-case, snake_case, PascalCase mixed)
- Date-suffixed files (dry-kiss-analysis-[DATE].md)
- Outdated/obsolete documentation
- Missing documentation for core features

### Files to Preserve (Never Rename):
- `README.md` (only file allowed with uppercase)

### Naming Rules:
1. ✅ **kebab-case**: `model-architecture.md`
2. ❌ **snake_case**: `model_architecture.md`
3. ❌ **PascalCase**: `ModelArchitecture.md`
4. ❌ **Dates**: `analysis-[DATE].md`
5. ❌ **Duplicates**: `file-duplicate.md`, `file-backup.md`

## 🎯 Phased Approach

### Phase 1: Analysis & Inventory (Current)
- [x] Identify all docs directories
- [x] Count non-compliant files
- [ ] Categorize files by type (duplicates, dates, case issues)
- [ ] Identify obsolete documentation
- [ ] Map module functionality to required docs

### Phase 2: Module Code Analysis
For each of the 17 modules:
1. Read core model files
2. Understand module purpose and functionality
3. Identify key features and patterns
4. Document relationships with other modules

### Phase 3: Documentation Strategy
For each module, create/update:
1. `README.md` - Module overview, features, quick start
2. `architecture.md` - Technical architecture, patterns
3. `models.md` - Model documentation (if complex)
4. `configuration.md` - Configuration options
5. `integration.md` - How to integrate with other modules
6. Module-specific guides as needed

### Phase 4: Cleanup Execution
1. **Remove duplicates** - Keep most recent/complete version
2. **Rename files** - Apply kebab-case consistently
3. **Remove dates** - Update content, remove date from filename
4. **Consolidate** - Merge similar/overlapping docs
5. **Archive obsolete** - Move to `docs/archive/` if needed

### Phase 5: Quality Assurance
1. PHPStan level 10 on all modified code
2. Verify all cross-references work
3. Test any code examples in documentation
4. Run Pint on all PHP files
5. Final review and validation

## 📋 Module Priority Order

Based on importance and interdependencies:

### Tier 1 - Core Infrastructure (DO FIRST)
1. **Xot** - Base functionality, all modules depend on this
2. **User** - Authentication, authorization
3. **Tenant** - Multi-tenancy

### Tier 2 - Major Business Logic
4. **Quaeris** - Survey management (main application)
5. **Limesurvey** - Survey integration
6. **Cms** - Content management
7. **Notify** - Notifications (email/SMS)

### Tier 3 - Supporting Services
8. **Geo** - Geographic data
9. **Media** - File management
10. **Lang** - Localization
11. **Activity** - Event sourcing / audit

### Tier 4 - Specialized Features
12. **Chart** - Chart generation
13. **Gdpr** - Privacy/consent
14. **CloudStorage** - Cloud file storage
15. **Job** - Queue/background jobs
16. **DbForge** - Database management
17. **UI** - UI components

## 🔧 Tools & Commands

### Find non-compliant files:
```bash
# Files with dates
find Modules/*/docs -name "*[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]*.md"

# Files with uppercase (except README.md)
find Modules/*/docs -name "*.md" | grep -E "[A-Z]" | grep -v README.md

# Duplicate files
find Modules/*/docs -name "*-duplicate.md"
find Modules/*/docs -name "*-backup.md"
find Modules/*/docs -name "*_backup.md"

# Snake_case files
find Modules/*/docs -name "*_*.md" | grep -v README
```

### Batch rename examples:
```bash
# Remove dates from filenames
for f in *-2025-*.md; do
    mv "$f" "${f%%-2025-*}.md"
done

# Convert snake_case to kebab-case
for f in *_*.md; do
    mv "$f" "${f//_/-}"
done
```

## 📊 Estimated Effort

- **Phase 1**: 2 hours (analysis)
- **Phase 2**: 8 hours (code analysis, 17 modules × ~30min each)
- **Phase 3**: 10 hours (documentation writing)
- **Phase 4**: 6 hours (cleanup execution)
- **Phase 5**: 4 hours (QA)

**Total**: ~30 hours of focused work

## 🎯 Success Criteria

1. ✅ Zero files with dates in filename
2. ✅ Zero uppercase files (except README.md)
3. ✅ Zero duplicate files
4. ✅ All modules have complete, up-to-date documentation
5. ✅ PHPStan level 10 passes on all modules
6. ✅ All code formatted with Pint
7. ✅ Documentation cross-references work correctly

## 📝 Notes

- Keep `docs/archive/` for historical documentation
- Document reasons for major architectural decisions
- Include practical examples in all guides
- Link related documentation between modules
- Keep model documentation in `docs/models/` subdirectory

---

**Next Step**: Begin Phase 2 - Module Code Analysis (starting with Xot)
