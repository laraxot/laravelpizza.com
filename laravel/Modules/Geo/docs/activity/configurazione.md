---
title: Configurazione Modulo
description: Configurazione Modulo
extends: _layouts.documentation
section: content
---

# Configurazione Modulo {#configurazione modulo}

Ricordarsi di modificare dentro laravel\config\event-sourcing.php, in quanto si dovrebbe usare il modulo Activity.
```php
    // 'stored_event_model' => Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent::class,
    'stored_event_model' => Modules\Activity\Models\StoredEvent::class,
``` 
per memorizzare gli eventi dentro la tabella stored_events

## Testing e PSR-4

Per i test del modulo Activity, evitare classi di supporto nominate dentro i file `*Test.php` se non rispettano il mapping PSR-4. Preferire classi anonime o file dedicati con namespace coerente. Dettagli e linee guida nel modulo:

- `../../laravel/Modules/Activity/docs/testing.md`