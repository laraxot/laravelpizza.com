# Event Detail mostra "Nessun evento trovato" - data merge gap

## Sintomo

Su `/it/events/{slug}` il link dal listing apre il dettaglio ma la pagina mostra "Nessun evento trovato".

## Root cause

Nel template CMS page i blocchi erano renderizzati cosi:

`@include($block->view, $block->data)`

In questo modo i dati globali della route (`container0`, `slug0`, `data`) non venivano passati ai blocchi.

Per `events/detail.blade.php` significa:
- `slug0` vuoto
- nessun `item/event` disponibile
- nessuna query `Event::where('slug', ... )`
- fallback UI: "Nessun evento trovato"

### 2. Volt Component `mount` Parameters Gap

In class-based Volt components used inside Folio routes with parameters (e.g., `[container0]/[slug0]/index.blade.php`), the parameters `container0` and `slug0` MUST be explicitly included in the `mount()` signature if other dependencies are also being injected, otherwise they might remain empty at the start of the `mount()` execution.

**Symptom:** `ResolvePageAction::execute($this->container0, $this->slug0)` was being called with empty strings.

**Fix:**
```php
public function mount(ResolvePageAction $resolvePageAction, string $container0, string $slug0): void
{
    $this->container0 = $container0;
    $this->slug0 = $slug0;
    // ...
}
```

### 3. `Page` Component Robustness

The `Page` component should extract `container0` and `slug0` from the `$data` array if they are not provided as individual props.

**Fix:** Added logic in `Page::__construct` to extract and sync these variables.
