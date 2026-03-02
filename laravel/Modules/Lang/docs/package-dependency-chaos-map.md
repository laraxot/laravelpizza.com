# Package Dependency Chaos Map (Lang)

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
