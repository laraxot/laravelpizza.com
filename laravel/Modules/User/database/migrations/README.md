# User Module — Migration `.old` Disposition Log

> **Regola canonica — vedi:** `docs/wiki/guidelines/database-migrations-rules.md` (sezione *"Disposing of superseded migrations: never delete, never `archive/`"*)
> e `laravel/Modules/Activity/docs/migration-policy.md` (principi 1-4).
> **Mai cancellare. Mai usare `archive/` o `_bak/`.**
> I file vengono rinominati `*.php.old` nello stesso path → Laravel li ignora (glob `*.php`) ma la storia resta auditoria.

## File disposti a `.old` (2026-10-18) — User Module

| Data/Ora ISO | File originale | Motivo di smaltimento |
|:---:|---|---|
| 2026_10_18_180000 | `repair_authentication_logs_table.php` | `repair_*` prefix + frammento; schema autoritativo in `2024_01_01_000001_create_authentication_log_table.php` (`XotBaseMigration`). Archiviato 2026-10-19. |
| 2026_10_18_180001 | `repair_devices_table.php` | `repair_*` prefix + frammento; schema in `2023_01_01_000001_create_devices_table.php`. Archiviato 2026-10-19. |
| 2026_10_18_180003 | `repair_roles_table.php` | `repair_*` prefix + frammento; schema completo in `2024_01_01_000011_create_roles_table.php` (`tableCreate`+`tableUpdate`). Archiviato 2026-10-18/19. |
| 2026_10_18_180004 | `repair_permissions_table.php` | `repair_*` prefix + frammento; schema completo in `2023_01_22_000007_create_permissions_table.php`. Archiviato 2026-10-18/19. |
| 2026_10_18_180005 | `repair_model_has_roles_table.php` | `repair_*` prefix + frammento; schema in `2024_12_05_000034_create_model_has_roles_table.php`. Archiviato 2026-10-19. |
| 2026_10_18_180006 | `repair_model_has_permissions_table.php` | `repair_*` prefix + frammento; schema in `2023_01_01_000005_create_model_has_permissions_table.php`. Archiviato 2026-10-19. |
| 2026_10_18_180007 | `repair_role_has_permissions_table.php` | `repair_*` prefix + frammento; schema in `2023_01_01_000010_create_role_has_permissions_table.php`. Archiviato 2026-10-19. |
| 2026_10_18_133309 | `create_users_is_active_column.php` | Colonna aggiunta con un file nuovo, su `Schema::table` della connessione di default. `is_active` è già in `UserData::updateColumns`, con `hasColumn`. Archiviato 2026-10-19. |

## Consolidamento già completo (nessuna azione necessaria)

| Tabella | Autore primario | Stato |
|:--|:--|:--|
| roles | `2024_01_01_000011_create_roles_table.php` | ✅ Schema completo (id, team_id, name, guard_name, display_name, description + timestamps) |
| permissions | `2023_01_22_000007_create_permissions_table.php` | ✅ Schema completo (id, name, guard_name, unique + timestamps + audit) |
| model_has_permissions | `2023_01_01_000005_create_model_has_permissions_table.php` | ✅ Schema completo (id, permission_id, uuidMorphs, team_id, timestamps) |
| model_has_roles | `2024_12_05_000034_create_model_has_roles_table.php` | ✅ Schema completo (id, role_id, uuidMorphs, team_id, timestamps) |
| role_has_permissions | `2023_01_01_000010_create_role_has_permissions_table.php` | ✅ Schema completo (id, permission_id, role_id, timestamps) |

## Link

- [Database migrations rules (wiki)](../../../../docs/wiki/guidelines/database-migrations-rules.md)
- [Activity module migration policy](../../../../Modules/Activity/docs/migration-policy.md)
- [XotBaseMigration source](../../../../Modules/Xot/app/Database/Migrations/XotBaseMigration.php)
