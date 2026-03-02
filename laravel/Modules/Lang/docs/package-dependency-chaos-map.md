# Package Dependency Chaos Map (Lang)

## Catalogo completo
- [Composer Packages Full Catalog (2026-03-02)](../../Xot/docs/composer-packages-full-catalog-2026-03-02.md)

## Pacchetti studiati rilevanti
- `mcamara/laravel-localization`
- `spatie/laravel-translatable`
- `lara-zeus/spatie-translatable`
- `laravel/framework`

## Rischi principali
1. Namespace traduzioni errato (`pub_theme::` vs namespace modulo).
2. Strutture traduzione flattenate o incomplete.
3. Fallback locale non coerente su frontoffice.

## Test operativo minimo
```bash
php artisan test --filter=Lang --compact
./vendor/bin/phpstan analyze Modules/Lang --level=10
```
