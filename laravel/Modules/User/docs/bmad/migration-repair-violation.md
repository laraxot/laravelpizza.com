---
title: "Migration Repair Violation: User Module Authorization Tables"
status: fixed
type: bmad-fix
module: User
created: 2026-10-18
updated: 2026-10-18
tags: [bmad, database-migrations-rules, xotbase, repair-violation, .old-convention]
qmd: "user-module-migration-repair-violation-2026-10-18"
related:
  - ../filament-blueprint.md
  - ../../../../../docs/wiki/guidelines/database-migrations-rules.md
  - ../xotbasemigration_best_practices.mdc
---

# BMAD Fix: Repair Migrations Violated Single-Migration Per Table Rule

## Trigger (Second Brain: query synthesis)

User reported: *"queste migrazioni non rispettano le nostre convenzioni"*: referencing 5 repair migrations for authorization tables (roles, permissions, model_has_roles, model_has_permissions, role_has_permissions) created 2026-10-18.

## Sources / Evidence (cited: never fabricated)

- **Convenzioni migrazioni:** [`docs/wiki/guidelines/database-migrations-rules.md`](../../../../../docs/wiki/guidelines/database-migrations-rules.md): *Single Migration Per Table Rule*, *no `add_*` / `fix_*` / `update_*` / `repair_*` prefixed migrations*, `.old` disposal convention.
- **Policy attiva:** [`laravel/Modules/Activity/docs/migration-policy.md`](../../../Activity/docs/migration-policy.md): principi 1-4 (una sola migrazione owner, niente prefissi, mai cancellare, nessuna `archive/`).
- **Base class:** [`laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`](../../../Xot/app/Database/Migrations/XotBaseMigration.php): `getModelClass()` si aspetta pattern `Create*Table`; `tableCreate`/`tableUpdate` sono per un unico file primario.
- **Autore delle migrazioni primarie:** `2024_01_01_000011_create_roles_table.php`, `2023_01_22_000007_create_permissions_table.php`, `2023_01_01_000005_create_model_has_permissions_table.php`, `2023_01_01_000010_create_role_has_permissions_table.php`: tutte già complete con `tableCreate` + `tableUpdate` (timestamp, team_id, display_name, description, etc.).
- **Filament Blueprint User:** [`filament-blueprint.md`](filament-blueprint.md): regola non negoziabile 1-4 (estendere solo XotBase, nessun label hardcoded, business logic nelle Actions, FO widget esplicito); non tocca migrazioni ma conferma architettura data-driven.

## Violazioni riscontrate (5 file, tutte rimosse in `.old`)

| File (archiviato) | Tabella | Violazione |
|---|---|---|
| `2026_10_18_180003_repair_roles_table.php.old` | roles | Fragmented `repair_*`; duplicato di `2024_01_01_000011_create_roles_table.php` (già completa) |
| `2026_10_18_180004_repair_permissions_table.php.old` | permissions | Fragmented; duplicato di `2023_01_22_000007_create_permissions_table.php` |
| `2026_10_18_180005_repair_model_has_roles_table.php.old` | model_has_roles | Fragmented; schema già in `2024_12_05_000034_create_model_has_roles_table.php` / `2026_09_01_150114_create_model_has_roles_table.php` |
| `2026_10_18_180006_repair_model_has_permissions_table.php.old` | model_has_permissions | Fragmented; schema già in `2023_01_01_000005_create_model_has_permissions_table.php` |
| `2026_10_18_180007_repair_role_has_permissions_table.php.old` | role_has_permissions | Fragmented; schema già in `2023_01_01_000010_create_role_has_permissions_table.php` |

**All 5 files violated:**
- **No `repair_*` prefixed migrations** (Migration Policy, principio 2).
- **Single Migration Per Table** violated: queste erano frammenti aggiuntivi su tabelle già definite da `create_*` autoritativi.
- **No deletion: `.old` convention** applicata (non cancellati, non in `archive/`, non in `_bak/`: rimangono nello stesso path con suffisso `.php.old`; Laravel ignora `*.php.old`).

## Azione eseguita (Boy Scout / Forward-Only)

1. **Non cancellati.** I 5 file sono stati rinominati `*.php.old` (stesso path, nessuna sottocartella).
2. **Non ripristinati** versioni precedenti: studiato il passato (`git log 65f149abf`) per capire il why, ma proceduto in avanti (Git Forward-Only).
3. **Documentati** con `README.md` nel folder di migrazione (vedi sotto).
4. **Aggiornato Second Brain / Wiki:** questa pagina BMAD + `docs/wiki/guidelines/database-migrations-rules.md` (esistente) + `docs/second-brain/`.

## README per i file `.old` (regola canonica)

> Vedi `laravel/Modules/User/database/migrations/README.md` (creato accanto ai file `.old`) che documenta il motivo di ogni `.php.old`: "Repair fragments for authorization tables: redundant with primary `create_*` migrations; consolidated per `database-migrations-rules.md` (Single Migration Per Table Rule) and `migration-policy.md` (principle 2, 3)."

## Stato post-fix

- [x] 5 file `repair_*` archiviati `.old`
- [x] Nessuna cancellazione (`.old`, non `rm`)
- [x] Nessuna cartella `archive/` o `_bak/` usata per questi file
- [x] Migrazioni primarie (`create_*`) già complete: nessun consolidamento extra necessario
- [x] Second Brain aggiornato (questa pagina BMAD + wiki reference)
- [x] Filament Blueprint User (`filament-blueprint.md`) confermato: nessun impatto su resource/widget, solo schema database

## Referenze incrociate (citazioni dirette)

- [`database-migrations-rules.md:14-15`](../../../../../docs/wiki/guidelines/database-migrations-rules.md#critical-single-migration-per-table-rule): *"Each table MUST have a single primary migration that defines its complete structure."*
- [`database-migrations-rules.md:156-162`](../../../../../docs/wiki/guidelines/database-migrations-rules.md#disposing-of-superseded-migrations-never-delete-never-archive): `.old` convention.
- [`migration-policy.md:19-25`](../../../Activity/docs/migration-policy.md): principi 1-4.
- [`XotBaseMigration.php:28-42`](../../../Xot/app/Database/Migrations/XotBaseMigration.php): base class, `tableCreate`/`tableUpdate` unificati nel file primario.
