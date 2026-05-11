# Binding dello Stato per CoordinatePicker

> **⚠️ SUPERSEDED**: Versione completa con prova dal codice vendor Filament 5:
> → [filament5-custom-field-entangle-contract.md](./filament5-custom-field-entangle-contract.md)

**Perché usiamo `{{ $applyStateBindingModifiers("$entangle('{$statePath}')") }}` invece di `$wire.$entangle('{{ $getStatePath() }}')`?**

Filament fornisce il metodo **`applyStateBindingModifiers`** (definito in `HasStateBindingModifiers`), che aggiunge automaticamente i *modificatori di binding* (es. `live`, `blur`, `debounce`) in base alla configurazione del campo (`live()`, `lazy()`, `debounce()`).

- **Entangle semplice** (`$wire.$entangle('path')`) lega lo stato ma **non** applica questi modificatori.
- **`applyStateBindingModifiers`** valuta se il binding è un entangle (`$entangle(*)`). Se lo è, sostituisce la chiusura `)` con `, true)` o `, false)` a seconda del modificatore `live`. Per espressioni non‑entangle concatena i modificatori al nome (`wire:model.live.debounce.500`).

Questo garantisce che il campo **CoordinatePicker** rispetti le impostazioni di live‑updating, debounce e lazy‑loading senza doverle specificare manualmente in ogni view.

### Riferimenti
- Filament Docs: *Custom Fields – State Binding* (<https://filamentphp.com/docs/5.x/forms/custom-fields>)
- Codice sorgente: `vendor/filament/schemas/src/Concerns/HasStateBindingModifiers.php`

### Come usarlo
```blade
@php
    $statePath = $field->getStatePath();
@endphp
<div x-data="{ state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }} }">
    <!-- … -->
</div>
```

Con questa sintassi il binding è **consistente** con le impostazioni del campo e con le best practice di Filament.