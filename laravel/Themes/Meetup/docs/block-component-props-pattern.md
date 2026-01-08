# Block Component Props Pattern - Critical Rule

## Data
2025-12-01

## Problema Risolto

Gli eventi non venivano visualizzati nella pagina `/it/events` nonostante fossero presenti nel file JSON.

## Root Cause

Il componente `/Themes/Meetup/resources/views/components/blocks/events/list.blade.php` usava:

```blade
@props(['data'])

{{-- Poi accedeva con $data['events'] --}}
@foreach($data['events'] ?? [] as $event)
```

Ma il sistema `page-content.blade.php` include i blocchi con:

```blade
@include($block->view, $block->data)
```

Quando Laravel esegue `@include` con un array come secondo parametro, **espande l'array in variabili separate**.

Quindi se `$block->data` è:
```php
[
    'title' => 'Upcoming Events',
    'events' => [...]
]
```

Il template riceve `$title` e `$events`, NON `$data['title']` e `$data['events']`.

## Soluzione - Pattern Standard Laraxot

Tutti i block components DEVONO seguire questo pattern:

```blade
@props([
    'data' => [],
    'title' => null,
    'description' => null,
    'events' => [],
    // ... altre proprietà specifiche del blocco
])

@php
    // Support both formats: separate variables or $data array
    // When @include passes $block->data, Laravel expands the array into separate variables
    $title = $title ?? ($data['title'] ?? 'Default Value');
    $description = $description ?? ($data['description'] ?? 'Default Value');
    $events = $events ?? ($data['events'] ?? []);
@endphp

{{-- Ora usa le variabili normalizzate --}}
<h2>{{ $title }}</h2>
@foreach($events as $event)
    ...
@endforeach
```

## Perché Questo Pattern?

1. **Compatibilità Doppia**: Funziona sia con `@include` che con `<x-component>`
2. **Null Coalescing**: Prima controlla la variabile diretta, poi l'array `$data`
3. **Fallback Sicuri**: Valori di default se mancano entrambi
4. **Type Safety**: Dichiara tutte le props con i tipi attesi

## Riferimento

Vedere `/Themes/Meetup/resources/views/components/blocks/hero/main.blade.php` per il pattern completo implementato correttamente.

## File Corretti

- ✅ `/Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
- ✅ `/Themes/Meetup/resources/views/components/blocks/hero/main.blade.php`

## File da Verificare

Tutti gli altri block components in `/Themes/Meetup/resources/views/components/blocks/` dovrebbero seguire questo pattern:

- [ ] `/components/blocks/features/grid.blade.php`
- [ ] `/components/blocks/stats/overview.blade.php`
- [ ] `/components/blocks/cta/banner.blade.php`
- [ ] `/components/blocks/testimonials/carousel.blade.php`
- [ ] Etc.

## Regola Critica

**SEMPRE dichiarare props sia come variabili individuali CHE come array `$data`, poi normalizzare con null coalescing operator.**

```php
// ✅ CORRETTO
@props(['data' => [], 'title' => null])
@php
    $title = $title ?? ($data['title'] ?? 'Default');
@endphp
{{ $title }}

// ❌ SBAGLIATO
@props(['data'])
{{ $data['title'] }}
```

## Impact

Senza questo pattern:
- I blocchi non renderizzano i contenuti
- Errori silenti (empty arrays)
- Debugging difficile

Con questo pattern:
- Compatibilità con entrambi i metodi di inclusione
- Codice robusto e prevedibile
- Fallback automatici

## Status

✅ Pattern documentato e applicato
✅ Eventi ora vengono visualizzati correttamente
⏳ Da applicare a tutti i block components rimanenti
