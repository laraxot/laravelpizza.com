# Package Dependency Chaos Map (Meetup)

## Pacchetti studiati rilevanti
- `laravel/framework`
- `laravel/folio`
- `livewire/livewire`
- `livewire/volt`
- `filament/filament`
- `mcamara/laravel-localization`
- `spatie/laravel-data`

## Rischi principali
1. Regressioni route/page su Folio e binding Volt.
2. Interazioni server-side non allineate ai widget Filament.
3. URL non localizzati in rendering dinamico eventi.

## Test operativo minimo
```bash
php artisan test --filter=Meetup --compact
./vendor/bin/phpstan analyze Modules/Meetup --level=10
```
