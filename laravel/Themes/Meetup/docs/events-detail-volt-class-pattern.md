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

Nel path standard `/it/events/{slug}`, `$resolvedEvent` deve arrivare dal route layer (Folio page plain Blade o equivalente) tramite `ResolvePageAction`, non da una query eseguita dentro la view.

## Helper logic

Se serve logica di presentazione:

- usare `@php`
- oppure un helper locale nel file Blade
- oppure una classe helper separata

Esempi tipici:

- `isUpcoming()`
- `getDate()`
- `getTime()`
- `getAvailableSpots()`

## Anti-pattern da evitare

```php
new class extends Component {
    public ?Event $event = null;
};
```

Dentro un block renderizzato via `@include`, questo pattern rompe perche' il template viene valutato nel contesto del componente padre, non come istanza Livewire indipendente.

```blade
@props(['event' => null])
```

Anche questo rompe o genera warning in una view inclusa come file Blade normale, perche' la vista non viene compilata come anonymous component.

## Vista corretta

```blade
<h1>{{ $event->title }}</h1>
<p>{{ $helper->getDate() }}</p>
```

## Regole inviolabili

- niente `$this->event` nei block CMS inclusi
- niente `wire:model` o `wire:click` se il block non e' montato come componente Livewire
- niente `@props(...)` nei block CMS inclusi via `@include`
- niente query `Event::query()->where('slug', ...)` nel block di dettaglio standard
- Volt solo dove il componente viene montato davvero
- KISS e DRY: il modello `Event` resta l'unica fonte di verita'

## Riferimenti

- [events-detail-slug0-loading.md](events-detail-slug0-loading.md)
- [helper-class-pattern.md](helper-class-pattern.md)
- [blade-logic-separation-theme.md](blade-logic-separation-theme.md)
