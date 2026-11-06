---
title: "Lang Module: BMAD Stories & Remaining Work"
type: concept
sources: ["../../AGENTS.md", "laravel/Modules/Lang/app/Models/TranslationFile.php"]
confidence: high
created: 2026-10-26
updated: 2026-10-26
tags: [bmad, lang, module, stories, remaining-work]
related:
  - ../../docs/second-brain/project/bmad-architecture.md
status: draft
qmd: "lang module   bmad stories & remaining work lang"
---

# Lang Module: BMAD Stories & Remaining Work

## Module Overview
The Lang module manages internationalization, translation files, and multilingual content.

## Key Fix Applied
- **TranslationFile.php**: Added `@var array<int, array<string, mixed>>` return type: PHPStan fix completed 2026-10-26

## Remaining Work (BMAD Brainstorming)

### Critical / High Priority
1. **PHPStan Zero Verification** ✅: Global pass confirmed
2. **Translation File Patterns**: Verify `loadTranslationDataWithErrorHandling()` type integrity

### Medium Priority
3. **Module Documentation**: Document translation key conventions and file management
4. **Test Coverage**: Add tests for translation loading and error handling
5. **BMAD Stories**: Create module-specific stories in `laravel/Modules/Lang/docs/stories/`

### Low Priority / Polish
6. **Documentation Cleanup**: Remove or archive obsolete translation docs

## Next Actions
- Create module-specific story files
- Verify error handling robustness
- Create gate files for any open stories
- Update translation key conventions doc (`laravel/Modules/Fixcity/docs/translation-key-convention.md`)