# Cache troubleshooting (module Xot)

Symptom: "SQLSTATE[42S02]: Base table or view not found: 1146 Table 'fixcity_data.cache' doesn't exist"

Cause: Application is configured to use the database cache driver but the required `cache` table is missing.

Quick fixes:
- Local (temporary): set CACHE_DRIVER=file in laravel/.env and restart PHP server.
- Permanent: run `php artisan cache:table` then `php artisan migrate` to create `cache` table.

Rollback: If you switched to `file`, revert CACHE_DRIVER to previous value in .env and clear config cache.

Notes:
- Ensure migrations run with correct DB user permissions.
- Avoid running `migrate --force` on production without backups.
