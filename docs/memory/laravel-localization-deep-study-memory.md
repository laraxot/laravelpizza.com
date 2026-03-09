# Memory: mcamara/laravel-localization Deep Study

**Date**: 2026-03-09

## Cosa ricordare sempre

- Il package va trattato come layer di routing + redirect + view-path localizzato, non solo come helper URL.
- I problemi piu' comuni sono su form POST localizzati e su cache route tradotte.
- In LaravelPizza la configurazione corrente espone sempre il prefisso lingua (`hideDefaultLocaleInURL=false`), quindi non bisogna introdurre link senza locale per route pubbliche.

## Trigger di attenzione

- modifica middleware stack in `bootstrap/app.php`
- modifica di `config/laravellocalization.php`
- cambi a route translatable (`transRoute`)
- introduzione di nuove pagine Folio/Volt con link/action non localizzati

## Checklist rapida

- alias middleware presenti e coerenti
- link/action generati con helper package
- test su almeno 2 lingue per nuove route pubbliche
- nessun hardcode URL lingua nel codice
