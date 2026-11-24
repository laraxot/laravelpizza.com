---
title: "Backup traduzioni User — in-place .bak"
type: concept
module: User
tags: [user, lang, ponytail, bak]
created: 2026-06-30
updated: 2026-06-30
qmd: "User lang backup in-place bak no archive folder ponytail"
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
---

# Backup traduzioni User — in-place

## Problema

~281 file `*.backup_*` sparsi sotto `lang/{locale}/` — rumore ponytail. Tentativo errato wave 4: cartella `lang/archive.bak/` (**anti-pattern** — vedi regola generale).

## Regola canonica

- **Mai** cartelle `archive.bak`, `Legacy`, `Old` sotto `lang/`
- Backup → `lang/{locale}/nome.php.bak` **stesso path** del file attivo
- Cronologia → Git, non albero parallelo

## Stato (2026-06-30)

281 backup spostati da `archive.bak/` (rimossa) → `lang/{locale}/*.php.bak`.

File attivi: solo `lang/{locale}/*.php` (no `.bak`).

## Verifica

```bash
cd laravel
find Modules/User/lang -type d \( -iname 'legacy' -o -iname 'archive*' \) | wc -l   # atteso: 0
find Modules/User/lang -name '*.backup_*' | wc -l                                   # atteso: 0
find Modules/User/lang -name '*.php.bak' | wc -l                                    # ~281
bash ../bashscripts/tools/audit-module-quality-gates.sh User --phpstan-only
```

## Collegamenti

- [no-legacy-folders-code.md](../../../../../../docs/wiki/concepts/no-legacy-folders-code.md)
- [ponytail-audit-over-engineering.md](../../ponytail-audit-over-engineering.md)
