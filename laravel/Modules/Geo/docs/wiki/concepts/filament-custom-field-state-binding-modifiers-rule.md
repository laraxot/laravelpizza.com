# Filament Custom Field State Binding Modifiers Rule

> **⚠️ SUPERSEDED**: Questo documento è stato sostituito dalla versione completa con prove dal codice vendor Filament:
> → [filament5-custom-field-entangle-contract.md](./filament5-custom-field-entangle-contract.md)

## Source

- Filament 5 official docs: `https://filamentphp.com/docs/5.x/forms/custom-fields`

## Question

Perche' nel Blade del custom field compare:

```blade
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
```

invece di:

```blade
state: $wire.$entangle('{{ $getStatePath() }}')
```

## Answer

Il secondo snippet e' solo la forma base di esempio. La documentazione ufficiale, nella sezione "Obeying state binding modifiers", dice esplicitamente che quando un field si collega al proprio state path deve usare `applyStateBindingModifiers()` per rispettare i modifier Filament del binding (`defer`, `live()`, e derivati).

Quindi:

- `"$wire.$entangle('{{ $getStatePath() }}')"` va bene come esempio minimo
- `"$wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}"` e' la forma corretta in un custom field riusabile

## Why It Matters For CoordinatePicker

`CoordinatePicker` e' un field Filament riusabile, usato in contesti diversi:

- front office wizard
- back office Filament resource/page
- eventuali altri schema owner

Se il Blade bypassa `applyStateBindingModifiers()`:

- ignora eventuali `live()` configurati dal field owner
- puo' comportarsi in modo diverso dal contratto Filament
- rende meno prevedibile la sincronizzazione stato tra Alpine, Livewire e field state path

## Correct Rule

Nel Blade di un custom field Filament:

- usare sempre `$getStatePath()` come source of truth dello state path
- usare `applyStateBindingModifiers()` quando il binding passa da `wire:model` o `$entangle()`
- non usare il bare `$wire.$entangle(...)` se il field deve obbedire ai modifiers Filament

## Best Practices

- preferire:

```blade
@php
    $statePath = $getStatePath();
@endphp

<div
    x-data="{
        state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
    }"
>
```

- per `callSchemaComponentMethod()`, usare la key del component (`$getKey()`), non l'id DOM
- mantenere il field come adapter dello state path, non come Livewire component separato

## False Friends

- "la doc mostra `$wire.$entangle(...)`, quindi basta quello": falso, la stessa pagina aggiunge la regola sui binding modifiers
- "se oggi il field non usa `live()`, il modifier wrapper e' inutile": falso, il field e' riusabile e deve restare conforme al contratto Filament
- "id DOM e key schema sono equivalenti": falso, la doc di `callSchemaComponentMethod()` parla di component key
