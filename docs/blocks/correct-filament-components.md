# Uso Corretto dei Componenti Filament nei Blocchi

## Componenti Disponibili e Limitazioni

Quando si utilizzano i componenti Filament nei blocchi del tema, è fondamentale verificare quali componenti sono effettivamente disponibili nel progetto. Alcuni componenti che potrebbero essere menzionati nella documentazione ufficiale di Filament potrebbero non essere registrati o configurati nel progetto attuale.

## Errori Comuni

### 1. Utilizzo di Componenti Non Disponibili

Un errore comune è l'utilizzo di componenti che appaiono nella documentazione Filament ma non sono disponibili nel progetto:

```
InvalidArgumentException: Unable to locate a class or view for component [filament::dropdown.separator].
```

### 2. Namespace Errati

Alcuni componenti hanno namespace specifici che devono essere utilizzati correttamente:

- ✅ CORRETTO: `<x-filament::dropdown.list.item>`
- ❌ ERRATO: `<x-filament::dropdown.item>`

### 3. Componenti Alternativi e Sostituzioni

Quando un componente Filament non è disponibile, è necessario utilizzare un'alternativa:

| Componente Non Disponibile | Alternativa Corretta |
|----------------------------|----------------------|
| `<x-filament::dropdown.separator />` | `<div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>` |
| `<x-filament::dropdown.item>` | `<x-filament::dropdown.list.item>` |

## Best Practices

### 1. Verificare l'Esistenza dei Componenti

Prima di utilizzare un componente Filament, verificarne l'esistenza nel progetto:

```bash

# Cerca nel codice sorgente Filament
grep -r "dropdown.separator" vendor/filament

# Oppure, controlla i componenti registrati
grep -r "component(" vendor/filament
```

### 2. Testare i Componenti Incrementalmente

Aggiungere un componente alla volta e verificare che funzioni correttamente prima di procedere.

### 3. Utilizzare la Documentazione Ufficiale come Riferimento

La documentazione di Filament può cambiare tra le versioni. Assicurarsi di consultare la documentazione relativa alla versione in uso.

## Implementazione Corretta nel Tema

Per il componente `user-dropdown.blade.php`, l'implementazione corretta è:

```blade
@props([
    'alignment' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-800',
    'menu_items' => [],
    'guest_view' => 'pub_theme::components.blocks.navigation.login-buttons'
])

@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $user = $user ?? auth()->user();
    $locale = LaravelLocalization::getCurrentLocale();
    $isLoggedIn = auth()->check();
@endphp

@if($isLoggedIn)
    <x-filament::dropdown
        :alignment="$alignment"
        :width="$width"
        :content-classes="$contentClasses"
    >
        <x-slot name="trigger">
            <x-filament::button
                color="gray"
                icon="heroicon-o-user"
                :label="$user?->name"
            />
        </x-slot>

        @foreach($menu_items as $item)
            @if(isset($item['type']) && $item['type'] === 'divider')
                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
            @else
                <x-filament::dropdown.list.item
                    :href="$item['url']"
                    :icon="$item['icon']"
                >
                    {{ __($item['label']) }}
                </x-filament::dropdown.list.item>
            @endif
        @endforeach
    </x-filament::dropdown>

    <form
        id="logout-form"
        action="{{ route('logout', ['locale' => $locale]) }}"
        method="POST"
        class="hidden"
    >
        @csrf
    </form>
@else
    @include($guest_view)
@endif
```

## Documentazione Correlata

- [API dei Componenti Filament](../filament/components-api.md)
- [Gestione dei Dati nei Blocchi](./blade-data-handling.md)
- [Documentazione Filament Ufficiale](https://filamentphp.com/docs/3.x/support/blade-components)

---

> **Nota Importante**: Questo documento segue la regola di documentazione UI per il progetto. Riferimenti a questo documento devono essere creati in tutti i moduli che utilizzano componenti Filament nei blocchi.
