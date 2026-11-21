---
qmd: "ARCHITECTURE"
issues: []
discussions: []
title: "Lang Module Architecture"
type: architecture
tags: [module, architecture, lang]
created: 2026-08-04
updated: 2026-08-04
---
# Lang Module — Architecture

## Purpose
Translation and localization management module

## Core Components

**Models:**
- `BaseModelLang` —
- `LanguageLine` —
- `Translation` —

**Actions:**
- `SyncTranslationsAction` —
- `ValidateTranslationsAction` —

**Filament Resources:**
- `LangResource` — Main admin resource

## Database Schema
- `lang_table` — Primary table with standard Laravel columns (id, timestamps)

## Design Decisions
| Decision | Rationale |
|----------|-----------|
| XotBaseModel | Consistent base across all modules |
| Filament v5 | Standard admin interface |
| Laravel Queues | Background processing for heavy operations |

## Integration Points
**Depends On:** Xot
**Depended On By:** Activity, Notify (logging)

## Quality Gates
- **PHPStan L10**: Pending execution
- **PHPMD**: Pending analysis
- **Test Coverage**: Needs Pest test suite
