# Memory: Folio Volt Livewire4 Filament5 Deep Study

**Date**: 2026-03-09

## Decisioni da ricordare

- Folio espone API inline stabili `render/name/middleware/withTrashed`; usarle come fonte unica metadata pagina.
- Volt e' API funzionale ufficiale per SFC Livewire: per pagine tema e' la scelta primaria.
- Livewire 4 supporta conversione SFC/MFC (`livewire:convert`) utile nei refactor incrementali.
- Filament 5 richiede stack moderno (Laravel 11+, Livewire 4, PHP 8.2+).
- Per font pannello usare `SpatieGoogleFontProvider` con cache locale (no CDN hardcoded).

## Rischi frequenti

- mischiare routing controller-based e Folio sullo stesso perimetro
- introdurre componenti multi-file quando la logica resta locale alla pagina
- usare font remoti hardcoded nei pannelli Filament
- ignorare changelog Folio su edge case routing/multi-domain

## Checklist rapida

- route/pagina nuova: Folio first
- interazione locale: Volt SFC first
- admin UI: Filament 5 compatible package only
- font admin: provider Spatie + setup package completato
