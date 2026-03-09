# Stack Upstream Deep Study: Folio, Volt, Livewire 4, Filament 5

## Fonti ufficiali studiate

- `https://github.com/laravel/folio`
- `https://github.com/livewire/volt`
- `https://livewire.laravel.com/docs/4.x/components`
- `https://github.com/filamentphp/filament/tree/5.x`
- `https://github.com/filamentphp/spatie-laravel-google-fonts-plugin`

## Sintesi tecnica applicabile a LaravelPizza

### Folio

- Router page-based per file in `resources/views/pages`.
- Helper inline ufficiali:
  - `name(string)`
  - `middleware(Closure|string|array)`
  - `render(callable)`
  - `withTrashed(bool)`
- Changelog 1.1.x evidenzia fix su named routes, nested index binding, multi-domain overlapping paths: verificare sempre prima di upgrade.

### Volt + Livewire 4 Components

- Volt e' API funzionale per componenti single-file.
- Livewire 4 docs confermano flusso component-based completo:
  proprietà, azioni, rendering, nested components, eventi, validation.
- Disponibile comando `livewire:convert` per migrare SFC/MFC senza riscrittura manuale completa.

### Filament 5

- Baseline stack upstream: Laravel 11+, Livewire 4, PHP 8.2+.
- Componenti centrali: Tables, Forms, Infolists, Widgets, Actions.

### Filament Google Fonts Plugin

- Installazione `filament/spatie-laravel-google-fonts-plugin:^5.0`.
- Richiede setup preventivo `spatie/laravel-google-fonts`.
- Uso provider nel panel:
  `->font('Inter', provider: SpatieGoogleFontProvider::class)`.
- Beneficio: font serviti da cache locale senza CDN hardcoded.

## Implicazioni pratiche per il modulo Meetup

1. Continuare strategia Folio + Volt per pagine public.
2. Evitare regressioni controller-based su route frontoffice.
3. Nei pannelli Filament, standardizzare font provider locale dove richiesto.
4. Ogni evoluzione stack va tracciata in GitHub Discussions prima di rollout.
