---
title: Directory database lowercase — factories
type: concept
module: Tenant
tags: [tenant, database, factories, structure, laravel-modules]
created: 2026-07-01
updated: 2026-07-01
qmd: "tenant database factories lowercase no Factories_ CamelCase seeders migrations"
related:
  - ./lowercase-tests-directory.md
  - ../../../../../docs/wiki/concepts/database-folder-lowercase-rule.md
  - ../../../../../docs/wiki/concepts/module-structure-organization-rule.md
  - ../log.md
---

# Directory database lowercase — factories

Il modulo Tenant usa **solo** cartelle `database/` in minuscolo, allineate a Laravel e `composer.json` PSR-4.

## Regola

| Canonico | Vietato |
|----------|---------|
| `database/factories/` | `database/Factories/`, `database/Factories_/`, `database/Factories_old/` |
| `database/seeders/` | `database/Seeders/` |
| `database/migrations/` | `database/Migrations/` |

Regola progetto: [database-folder-lowercase-rule.md](../../../../../docs/wiki/concepts/database-folder-lowercase-rule.md).

## Perché `Factories_/` non deve esistere

- Suffisso `_` o `_old` = copia stale, spesso in `.gitignore` ma ancora su disco → confusione su quale factory sia attiva.
- `composer.json` del modulo mappa `Modules\Tenant\Database\Factories\` → `database/factories/` (minuscolo).
- Duplicati CamelCase possono contenere import errati (es. `User\Models\Tenant` vs `Tenant\Models\Tenant`).

## Stato 2026-07-01

- **Canonico:** `database/factories/` (tutte le factory attive).
- **Rimosso:** `database/Factories_/` (copia stale, solo `DomainFactory` obsoleto + `.gitkeep`).
- **Rimosso:** `database/Factories/` (duplicato CamelCase già coperto in `factories/`).

Audit repo: `bash bashscripts/tools/audit-database-folder-lowercase.sh Tenant`

## Checklist agente

1. Nuova factory → solo `database/factories/{Model}Factory.php`.
2. Mai creare `Factories_`, `Factories_old`, `Seeders` maiuscolo.
3. File superato → `{Name}Factory.php.bak` **in-place** in `factories/`, non nuova cartella parallela.
