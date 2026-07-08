---
title: handoff PHPStan zero moduli
type: chat
tags: [handoff, phpstan, bootstrap, quality-gate]
updated: 2026-06-15
related:
  - ../wiki/memories/phpstan-modules-inventory.md
  - ../wiki/reflective.md
  - ../../laravel/Modules/Ptv/docs/wiki/log.md
---

# Handoff — PHPStan 0 su `Modules/*` (2026-06-15)

## Stato verificato

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
# [OK] No errors — 701 file (config: phpstan.neon, NON modificare)
```

## Ultimi fix (modulo Ptv)

| Area | Fix |
|------|-----|
| `Check::execute()` | Parametro `$criteriEsclusione` come `iterable<int, Model>` (evita covarianza Eloquent vs Support) |
| `BaseSchedaResource` | `Collection::make($eloquent->all())` per covarianza template |
| `TrovaEsclusiBy*` | Stesso bridge Eloquent → Support Collection |
| `TrovaEsclusiByModelClassYearAction` | `setAttribute('value_real')` al posto di property dinamica + ignore |

## Aperto (handoff precedente)

- **Lang:** 8 errori chiavi duplicate (`locale_switcher_refresh`, `translation_editor`) — vedi [handoff-job-lang-merge-phpstan-confidence.md](handoff-job-lang-merge-phpstan-confidence.md)
- **Merge marker sweep:** `git grep '^<<<<<<< '`

## Regole sessione

- `phpstan.neon`: solo utente
- Git forward-only
- Test: solo Pest

**Agente:** Auto (Cursor) · **Data:** 2026-06-15
