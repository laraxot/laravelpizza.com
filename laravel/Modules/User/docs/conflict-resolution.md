---
title: "Git Conflict Resolution - Modulo User"
type: concept
tags: [conflict, resolution]
created: 2026-07-14
updated: 2026-07-14
qmd: "conflict-resolution git conflict resolution - modulo user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Git Conflict Resolution - Modulo User

## Data
- 2025-01-06

## File Risolti

| File | Esito | Note |
|------|-------|------|
| database/migrations/2023_01_01_000000_create_devices_table.php | ✅ | Ripristinata classe anonima `XotBaseMigration`, rimosso codice fuori classe |
| database/migrations/2023_01_01_000004_create_device_user_table.php | ✅ | Wrappato in anonymous class, normalizzato naming variabili |
| database/migrations/2023_01_01_000004_create_team_user_table.php | ✅ | Ripristinata struttura migrazione con `updateTimestamps()` |
| database/migrations/2023_01_01_000006_create_teams_table.php | ✅ | Ricostruita logica `tableUpdate`, default coerenti |
| database/migrations/2023_01_22_000007_create_permissions_table.php | ✅ | Ripristino completo |
| database/migrations/2025_05_16_221811_add_owner_id_to_teams_table.php | ✅ | Convertita a `XotBaseMigration`, aggiunta safe-guard su colonna |
| database/factories/OauthPersonalAccessClientFactory.php | ✅ | Tipizzazione esplicita del factory result, rimosse phpstan-ignore |
| database/seeders/UserMassSeeder.php | ✅ | Tipizzate collection factory (EloquentCollection) per evitare mixed |

## Verifiche Effettuate
- `php -l` su tutte le migrazioni/factory aggiornate: ✅
- `./vendor/bin/phpstan analyse Modules/User` → ✅ nessun errore (factory e seeder tipizzati)

## Note
- Le migrazioni seguono la regola Laraxot: `return new class() extends XotBaseMigration { ... };`
- Factory utilizza `@var OauthClient` per evitare `mixed`.
- PHPStan blocca per seeder legacy; verrà affrontato in step successivi.
