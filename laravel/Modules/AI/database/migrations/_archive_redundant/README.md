# Migration archiviate (Xot)

File in questa cartella **non vengono eseguiti** da `php artisan migrate` su fresh install.

## Tabella `cache`

| Stato | File |
|-------|------|
| **Canonica** | `../2023_09_04_125039_create_cache_table.php` |
| Archiviata | `2023_09_04_000000_create_cache_table.php` (stesso CREATE: key, value, expiration) |

`cache_locks` resta in `../2023_09_04_125039_create_cache_locks_table.php` (tabella distinta).
