---
title: Configurazione Modulo
description: Configurazione Modulo
extends: _layouts.documentation
section: content
type: note
status: draft
updated: 2026-10-18
tags: [docs, xot, activity]
qmd: "configurazione modulo {#configurazione modulo} xot"
---

# Configurazione Modulo {#configurazione modulo}

Ricordarsi di modificare dentro laravel\config\event-sourcing.php, in quanto si dovrebbe usare il modulo Activity.
```php
    // 'stored_event_model' => Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent::class,
    'stored_event_model' => Modules\Activity\Models\StoredEvent::class,
``` 
per memorizzare gli eventi dentro la tabella stored_events