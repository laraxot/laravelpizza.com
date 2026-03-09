Verifica completata il 2026-03-09: il crash su `/it/events/{slug}` era dovuto a un block CMS (`Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`) trattato come Volt/Livewire pur essendo renderizzato da `x-page` tramite `@include`.

Ho allineato prima le docs tema e governance, poi il template:

- rimosso `@props(...)` da una view inclusa via `@include`;
- eliminata la dipendenza da proprieta Livewire come `$this->event`;
- rimosse le `wire:*` dal block incluso;
- mantenuto il fallback plain Blade su variabili PHP semplici (`$event`, `$item`, `$slug0`).

Verifica eseguita con:

- `php artisan view:clear`
- `php artisan view:cache`
- richiesta interna Laravel sulla route evento

Esito: status `200`, senza piu `Property [$event] not found` e senza warning sulle variabili non definite introdotti da `@props`.
