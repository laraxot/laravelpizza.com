# Package Dependency Chaos Map (Meetup Theme)

## Pacchetti studiati rilevanti
- `laravel/framework`
- `laravel/folio`
- `livewire/volt`
- `mcamara/laravel-localization`
- `filament/filament`

## Rischi principali
1. View namespace non risolto (`pub_theme::`).
2. Routing pagina dinamica non coerente con Folio.
3. Asset mismatch dopo build/copy.

## Test operativo minimo
```bash
cd laravel/Themes/Meetup
npm run build
npm run copy
```
