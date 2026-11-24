# _bak — activity_log duplicate / anti-pattern (non eseguire)

Laravel non carica sottocartelle di `migrations/`.

## Vietato (consolidati nel file owner)

| File errato | Errore |
|-------------|--------|
| `2024_10_10_000000_add_attribute_changes_to_activity_table.php` | prefisso `add_*` — usare `tableUpdate` nel `create_*` |
| `2026_02_13_171410_fix_causer_id_to_uuid.php` | prefisso `fix_*` — stesso |
| `2026_07_01_000000_update_activity_log_schema.php` | `extends Migration` + nome `update_*` |
| vecchi `2023_*` / `2024_01_01_*_create_activity_table` | secondi `create_*` sullo stesso modello |

## Canon

`../2026_06_10_141000_create_activity_table.php` — `XotBaseMigration`, model `Activity`.
