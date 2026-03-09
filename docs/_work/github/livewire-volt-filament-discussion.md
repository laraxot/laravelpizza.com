Ho studiato quattro fonti ufficiali insieme:

- `livewire/volt`
- documentazione Livewire 4.x sui components
- `filamentphp/filament` ramo `5.x`
- `filamentphp/spatie-laravel-google-fonts-plugin`

La decisione che ne esce per LaravelPizza e' una separazione di responsabilita' molto netta.

## Stack contract

- Folio -> routing file-based e page tree
- Volt / Livewire -> stato, lifecycle, azioni utente, componenti interattivi
- Filament 5 -> admin panel, resources, pages, widgets, actions, schemas
- Google Fonts plugin -> typography del panel Filament

## Anti-pattern da evitare

1. usare Volt per sostituire panel patterns di Filament;
2. usare Filament per risolvere frontoffice che appartiene a Folio + Volt;
3. infilare lifecycle e stato direttamente nei Blade host;
4. usare il plugin Google Fonts come precedente per il tema pubblico.

## Regola pratica

Se il problema e':

- URL / page tree -> Folio
- interazione pagina -> Volt / Livewire
- admin UI strutturata -> Filament
- typography admin -> plugin Filament

Questa separazione aiuta a evitare l'errore architetturale piu' comune nel repo: ibridi in cui ogni layer compensa limiti del precedente invece di usare il contratto giusto.
