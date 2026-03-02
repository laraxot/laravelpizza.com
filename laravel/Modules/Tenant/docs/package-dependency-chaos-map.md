# Package Dependency Chaos Map (Tenant)

## Catalogo completo
- [Composer Packages Full Catalog (2026-03-02)](../../Xot/docs/composer-packages-full-catalog-2026-03-02.md)

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
