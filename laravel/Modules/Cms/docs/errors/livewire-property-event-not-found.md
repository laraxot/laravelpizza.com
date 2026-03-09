# Livewire Property `$event` Not Found (container0.view)

## Sintomo

Errore su route dinamica `/it/events/{slug}`:

- `Livewire\Exceptions\PropertyNotFoundException`
- `Property [$event] not found on component: [container0.view]`

## Causa

`x-page` renderizza i blocchi CMS con `@include($block->view, $block->data)`.

Se il block file incluso usa stato/metodi Livewire (`$this->event`, `wire:click`, `wire:model`) senza essere montato esplicitamente come componente Livewire, `$this` punta al parent (`container0.view`) e la property non esiste.

## Regola

- Block inclusi via `@include` devono restare **plain Blade**.
- Se serve stato reattivo:
  - usare Alpine per UI locale, oppure
  - montare un componente Livewire dedicato con `@livewire(...)`.
- Per i dettagli dinamici (`/it/events/{slug}`), il modello deve essere risolto prima nel route layer tramite `ResolvePageAction` e passato a `x-page` come `item`/`event`.
- **Best Practice Decoupling**: Quando si referenziano modelli correlati (come `creator`, `updater`), usare sempre i Contracts (es. `ProfileContract`) nei PHPDocs per evitare accoppiamento stretto tra i moduli.
