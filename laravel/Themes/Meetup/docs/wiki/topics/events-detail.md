---
title: "Topic events-detail"
type: digest
status: active
qmd: "digest ceiling 100 events-detail"
---

# Topic events-detail

Sintesi automatica di 3 documenti (chiave `events-detail`).

## Events Detail Component - Slug0 Model Loading

_Fonte: `events-detail-slug0-loading.md`_

# Events Detail Component - Slug0 Model Loading

## 🎯 Principio: Caricamento Automatico Modello da Slug

Il componente `events/detail.blade.php` è una **plain Blade view inclusa dal CMS** (NON Volt, NON Livewire, NON anonymous component Blade) e nel path standard `/it/events/{slug}` deve ricevere l'evento gia' risolto dal route layer.

## ✅ Pattern Corretto: Route Resolver + Include-Safe Plain Blade

```php
<?php

declare(strict_types=1);

/**
 * Event Detail - Plain Blade Component
 * Carica l'evento dallo slug nell'URL
 */

use Modules\Cms\Actions\ResolvePageAction;
use Modules\Meetup\Models\Event;

$container0 = (string) request()->route('container0', '');
$slug0 = (string) request()->route('slug0', '');

$resolved = app(ResolvePageAction::class)->execute($container0, $slug0);

$data = [
    'container0' => $container0,
    'slug0' => $slug0,
];

## Events Detail Component - Include-Safe Pattern

_Fonte: `events-detail-volt-class-pattern.md`_

# Events Detail Component - Include-Safe Pattern

## Stato attuale corretto

Il blocco `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php` viene renderizzato dal CMS tramite:

```blade
@include('pub_theme::components.blocks.events.detail', $data)
```

Per questo motivo non e' un componente Volt/Livewire montato. Deve quindi restare:

1. Blade puro
2. compatibile con variabili PHP semplici (`$event`, `$item`, `$slug0`, `$container0`)
3. senza uso di `$this->...`
4. senza `wire:*` che presuppongono uno stato Livewire nel block incluso
5. senza `@props(...)`, perche' `@include` non garantisce la semantica di anonymous component Blade

## Regola operativa

La pagina Folio puo' usare Volt.
Il block CMS incluso da `x-page` no.

Il resolve corretto del modello e':

```php
use Modules\Meetup\Models\Event;

$resolvedEvent = $event instanceof Event ? $event : ($item instanceof Event ? $item : null);
```

## Events detail: "Nessun evento trovato"

_Fonte: `troubleshooting/events-detail-no-event-found.md`_

# Events detail: "Nessun evento trovato"

## Sintomo

Da `/it/events` i link dettaglio aprono `/it/events/{slug}` ma il blocco detail mostra stato vuoto.

## Diagnosi

Il blocco detail e' corretto solo se riceve almeno uno tra:
- `event`
- `item`
- `slug0`

Se il renderer CMS non mergea il contesto route nei blocchi, `slug0` non arriva e il lookup evento fallisce.

## Soluzione

Nel renderer pagina CMS usare merge dati globale+blocco:

- `array_merge($data, $block->data)`

Questo mantiene DRY+KISS e risolve tutti i block che dipendono da `container0/slug0`.

## Verifica finale

- URL verificata: `/it/events/ut-quae-facere-placeat-labore-expedita-TwKN`
- Esito: `200 OK`, dettaglio evento visualizzato
- Fallback `Nessun evento trovato`: non presente
