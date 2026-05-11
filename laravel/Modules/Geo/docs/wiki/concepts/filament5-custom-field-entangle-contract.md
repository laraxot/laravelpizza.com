---
title: "Filament 5 Custom Field: contratto entangle e state binding modifiers"
type: concept
confidence: verified
created: 2026-04-28
updated: 2026-04-28
tags: [filament5, custom-field, entangle, state-binding, livewire, alpine, blade]
source: "https://filamentphp.com/docs/5.x/forms/custom-fields"
verified_against: "vendor/filament/forms/resources/views/components/*.blade.php"
---

# Filament 5 Custom Field: contratto entangle e state binding modifiers

## La domanda

Perché nel Blade del CoordinatePicker usiamo:

```blade
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
```

e **non** la forma più semplice:

```blade
state: $wire.$entangle('{{ $getStatePath() }}')
```

## Risposta breve

**La nostra sintassi è CORRETTA e allineata al 100% al codice Filament ufficiale.**

La forma semplice (`$wire.$entangle('...')`) è quella mostrata nella sezione "Introduction"
della documentazione come esempio basilare. La forma con `$applyStateBindingModifiers()`
è quella raccomandata nella sezione **"Obeying state binding modifiers"** per i campi
che devono rispettare i modificatori di reattività (`->live()`, `->live(onBlur: true)`, `->debounce()`).

## Prova dal codice sorgente Filament 5

Ogni componente ufficiale Filament che usa `$entangle` lo fa attraverso `$applyStateBindingModifiers`:

| Componente Filament | File vendor | Sintassi |
|---------------------|-------------|----------|
| **key-value** | `vendor/filament/forms/.../key-value.blade.php:34` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }}` |
| **tags-input** | `vendor/filament/forms/.../tags-input.blade.php:56` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }}` |
| **select** | `vendor/filament/forms/.../select.blade.php:195` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }}` |
| **date-time-picker** | `vendor/filament/forms/.../date-time-picker.blade.php:97` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }}` |
| **file-upload** | `vendor/filament/forms/.../file-upload.blade.php:111` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }}` |
| **slider** | `vendor/filament/forms/.../slider.blade.php:36` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }}` |
| **code-editor** | `vendor/filament/forms/.../code-editor.blade.php:35` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')", isOptimisticallyLive: false) }}` |
| **rich-editor** | `vendor/filament/forms/.../rich-editor.blade.php:70` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')", isOptimisticallyLive: false) }}` |
| **markdown-editor** | `vendor/filament/forms/.../markdown-editor.blade.php:38` | `$wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')", isOptimisticallyLive: false) }}` |
| **toggle** | `vendor/filament/forms/.../toggle.blade.php:17` | `'$wire.' . $applyStateBindingModifiers('$entangle(\'' . $statePath . '\')')` |

**Nessun componente Filament ufficiale usa** `$wire.$entangle('{{ $getStatePath() }}')` senza `$applyStateBindingModifiers`.

## `$statePath` vs `$getStatePath()` — sono equivalenti

Entrambe sono usate nel codice Filament ufficiale:

- **La maggioranza** dei componenti pre-calcola `$statePath = $getStatePath();` nel blocco `@php` e poi
  usa `$statePath` nel template (es. key-value, tags-input, select, date-time-picker, file-upload, etc.)
- Lo **slider** usa `$getStatePath()` direttamente inline

**Regola progetto (Geo)**: usare **sempre** i closure Filament:

- `$statePath = $getStatePath();`
- `$key = $getKey();`

Così evitiamo drift con l’API Filament e manteniamo compatibilità futura.

**Il nostro codice** (coordinate-picker.blade.php):
```blade
@php
$statePath = $getStatePath();
$key = $getKey();
@endphp
...
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
```

Questo è **identico** al pattern usato da `key-value.blade.php` (righe 13+34):
```blade
@php
$statePath = $getStatePath();
@endphp
...
state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
```

L'unica differenza è `$field->getStatePath()` vs `$getStatePath()`, che restituiscono
lo stesso valore: `$getStatePath()` è un magic closure Filament che chiama `$field->getStatePath()`.

## Cosa fa `$applyStateBindingModifiers()`

Questa funzione adatta il binding `wire:model` o `$entangle()` in base ai modificatori configurati
sul campo PHP. Ecco le trasformazioni:

| Configurazione PHP | Senza modifier | Con `$applyStateBindingModifiers()` |
|--------------------|----------------|--------------------------------------|
| Nessuna (default) | `$entangle('data.location')` | `$entangle('data.location')` |
| `->live()` | `$entangle('data.location')` | `$entangle('data.location').live` |
| `->live(onBlur: true)` | `$entangle('data.location')` | `$entangle('data.location').blur` |
| `->live(debounce: '500ms')` | `$entangle('data.location')` | `$entangle('data.location').debounce.500ms` |

Senza `$applyStateBindingModifiers`, il campo **funziona** ma:
- Non rispetta `->live()` → le dipendenze reattive non si aggiornano
- Non rispetta `->debounce()` → può causare troppi round-trip Livewire
- Non rispetta `->live(onBlur: true)` → aggiornamenti ad ogni keytroke invece che al blur

Per il `CoordinatePicker` questo **importa** perché permette al form di aggiornare
correttamente altri campi che dipendono dalla posizione.

## Per wire:model (input HTML nativi)

Per input HTML nativi la stessa logica si applica con `wire:model`:

```blade
{{-- SBAGLIATO: non rispetta i modifier --}}
<input wire:model="{{ $getStatePath() }}" />

{{-- CORRETTO: rispetta live(), debounce(), etc. --}}
<input {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}" />
```

Esempio dal codice Filament `text-input.blade.php`:
```blade
$applyStateBindingModifiers('wire:model') => $statePath,
```

## Regola operativa

> In ogni custom field Filament che usa entangle o wire:model,
> **OBBLIGATORIO** usare `$applyStateBindingModifiers()` per garantire
> il rispetto dei state binding modifiers.
>
> Forma corretta:
> ```blade
> state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
> ```
>
> Forma vietata (non rispetta i modifier):
> ```blade
> state: $wire.$entangle('{{ $getStatePath() }}')
> ```

## Documenti correlati

- Doc ufficiale: [Filament Custom Fields — Obeying state binding modifiers](https://filamentphp.com/docs/5.x/forms/custom-fields#obeying-state-binding-modifiers)
- Doc ufficiale: [Filament Forms Overview — Reactivity](https://filamentphp.com/docs/5.x/forms/overview#the-basics-of-reactivity)
- Doc ufficiale: [Filament Forms Overview — Field dehydration](https://filamentphp.com/docs/5.x/forms/overview#field-dehydration)
- Wiki interno: [coordinate-picker-filament5-save-pattern.md](./coordinate-picker-filament5-save-pattern.md)

## Nota importante: `callSchemaComponentMethod()` usa `$getKey()`

Per chiamare i metodi esposti del field (es. `searchAddress`, `reverseGeocode`) dal JS del Blade:

```blade
this.$wire.callSchemaComponentMethod(
    @js($key),
    'reverseGeocode',
    { latitude: lat, longitude: lng }
)
```

Questa è la sintassi documentata nella sezione
“Calling field methods from JavaScript” e impedisce falsi amici
tipo usare DOM id / stringhe custom.

## Best practices

- Usare sempre `$statePath = $getStatePath();` e `$key = $getKey();`.
- Applicare sempre `$applyStateBindingModifiers()` su `$entangle(...)` e `wire:model`.
- Mantenere il field come adapter stateful (Blade+Alpine+Livewire), non come mini framework custom.
- Verificare sempre comportamento con `->live()`, `->live(onBlur: true)` e `->live(debounce: ...)`.

## Bad practices

- Usare `state: $wire.$entangle('{{ $getStatePath() }}')` senza wrapper.
- Usare id DOM in `callSchemaComponentMethod()` al posto della component key.
- Mescolare nello stesso fix binding state, layout CSS e logica business senza separazione.

## False friends

- "La sintassi corta è più pulita, quindi migliore": falso se viola il contratto Filament.
- "`$field->getStatePath()` e `$getStatePath()` sono diversi a runtime":
  falso, nel contesto del field convergono sullo stesso state path.
- "Se oggi non usiamo `live()`, i modifiers non servono": falso, il field è riusabile e va progettato forward-safe.

## Link verificati per approfondire

- [Filament custom fields](https://filamentphp.com/docs/5.x/forms/custom-fields)
- [Filament forms reactivity](https://filamentphp.com/docs/5.x/forms/overview#the-basics-of-reactivity)
- [Livewire Alpine entangle](https://livewire.laravel.com/docs/alpine#sharing-state-using-entangle)
