# Livewire Volt Filament 5 Memory

## Decisione da ricordare

Il progetto usa uno stack stratificato:

- Folio per matchare la pagina;
- Volt per montare componenti Livewire single-file;
- Livewire 4 per la reattivita';
- Filament 5 completo a livello app;
- pacchetti Filament selettivi nel tema.

## Dettagli importanti

- `VoltServiceProvider` monta sia `resources/views/livewire` sia `resources/views/pages` se presenti;
- il tema `Meetup` richiede package Filament 5 modulari (`actions`, `forms`, `infolists`, `notifications`, `schemas`, `support`, `tables`, `widgets`);
- il plugin Google Fonts di Filament riguarda il panel/theme Filament e non sostituisce la strategia font del frontoffice.
