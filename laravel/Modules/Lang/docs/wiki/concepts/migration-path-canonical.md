---
title: Path canonico migrazioni Lang
type: concept
module: Lang
tags: [migrations, nwidart, database, path]
created: 2026-07-01
updated: 2026-07-01
related:
  - ../../redundancy-audit.md
  - ../../../../docs/wiki/concepts/module-model-migration-seeder-parity.md
---

# Path canonico migrazioni Lang

## Regola

| Vietato | Canonico |
|---------|----------|
| `database/Migrations/` | `database/migrations/` |

nwidart e Laravel scoprono le migrazioni solo sotto **`database/migrations`** (minuscolo). Su Linux `Migrations` e `migrations` sono directory diverse: duplicati case-only rompono `php artisan migrate` e i submoduli.

## Stato modulo Lang (2026-07-01)

- Esiste solo `laravel/Modules/Lang/database/migrations/`
- **Non** esiste `database/Migrations/` nel repo
- Rimosso duplicato stale `2025_03_20_000001_create_language_lines_table.php.old3`

## Migrazioni canoniche per modello

| Modello | File migrazione |
|---------|-----------------|
| `Post` | `2026_01_21_211814_create_posts_table.php` |
| `Translation` | `2026_01_21_211815_create_translations_table.php` |
| `TranslationFile` | Sushi — nessuna tabella DB |
| `language_lines` | `2024_03_20_000001_create_language_lines_table.php` — tabella Spatie translation-loader (modello vendor, non modulo) |

## Verifica

```bash
test ! -d laravel/Modules/Lang/database/Migrations && echo OK
ls laravel/Modules/Lang/database/migrations/
```

## Audit cross-modulo

```bash
find laravel/Modules -type d -name 'Migrations' 2>/dev/null
# deve essere vuoto
```
