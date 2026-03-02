# Package Dependency Chaos Map (Tenant)

## Pacchetti studiati rilevanti
- `laravel/framework`
- `nwidart/laravel-modules`
- `spatie/laravel-data`
- `predis/predis`

## Rischi principali
1. Isolamento tenant compromesso da config connessioni non standard.
2. Mappatura ambiente testing divergente da produzione.
3. Risoluzione tenant errata su host/runtime.

## Test operativo minimo
```bash
php artisan test --filter=Tenant --compact
./vendor/bin/phpstan analyze Modules/Tenant --level=10
```
