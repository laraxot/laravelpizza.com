---
issues: []
discussions: []
title: "Task: Ridurre Suppressioni PHPStan Inline - Lang"
module: "Lang"
type: concept
tags: [REDUNDANCY, ANALYSIS]
created: 2026-07-14
updated: 2026-07-14
qmd: "redundancy analysis"
related:
  - "./italian-text-refined-audit-report.md"
---
# Task: Ridurre Suppressioni PHPStan Inline - Lang

**Modulo**: Lang
**Priorita'**: Alta
**Completamento**: 0%

---

## File Coinvolti (7 suppressioni)

| File | Suppressioni | Tipo |
|------|-------------|------|
| `app/Actions/ReadTranslationFileAction.php` | 3 | array return type |
| `app/Actions/WriteTranslationFileAction.php` | 1 | mixed type |
| `app/Actions/SyncTranslationsAction.php` | 1 | mixed type |
| `app/Providers/LangServiceProvider.php` | 1 | config type |
| `app/Http/Livewire/Lang/Switcher.php` | 1 | locale type |

## Criteri di Completamento

- [ ] Tutte le 7 suppressioni risolte
- [ ] PHPStan 0 errori mantenuto
