# Livewire PropertyNotFound su Event Detail

## Sintomo

Errore runtime:

- `Livewire\Exceptions\PropertyNotFoundException`
- `Property [$event] not found on component: [container0.view]`
- URL tipico: `/it/events/{slug}`

## Root cause

Il blocco `components/blocks/events/detail.blade.php` veniva trattato come se fosse un componente Volt/Livewire dentro un include CMS.

Nel flusso CMS:

1. `x-page` include i blocchi con `@include($block->view, $block->data)`.
2. In questo contesto, `$this` punta al componente parent (`container0.view`), non a un componente Volt indipendente.
3. Se il blocco usa proprietà/metodi Livewire (`$this->event`, `wire:click`, `wire:model`) senza mount esplicito come Livewire component, scatta `PropertyNotFound`.

## Regola operativa

- I blocchi CMS inclusi via `@include` devono essere **plain Blade**.
- Niente stato Livewire locale nel file block incluso.
- Per interazioni UI locali (modali), usare Alpine (`x-data`) o mountare un componente Livewire dedicato con `@livewire(...)`.

## Fix applicato

- `events/detail.blade.php` convertito a plain Blade:
  - risoluzione evento via variabili PHP (`$event`, `$item`, `$slug0`);
  - rimozione dipendenze da `$this->...`;
  - modal RSVP gestita con Alpine invece di `wire:*`.
