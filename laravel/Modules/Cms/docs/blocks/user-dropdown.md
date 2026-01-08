# User Dropdown Block

> **NOTA IMPORTANTE**: Per informazioni dettagliate sull'integrazione di componenti Filament in questo blocco, vedere la [documentazione nel modulo UI](../../../UI/docs/blocks/filament-component-integration.md).

## Indice
1. [Introduzione](#introduzione)
2. [Struttura del Componente](#struttura-del-componente)
3. [Configurazione](#configurazione)
4. [Gestione dei Dati](#gestione-dei-dati)
5. [Utilizzo di Componenti Filament](#utilizzo-di-componenti-filament)
6. [Best Practices](#best-practices)
7. [Errori nel Tema](#errori-nel-tema)
8. [Soluzione Raccomandata](#soluzione-raccomandata)

## Introduzione
Il componente User Dropdown è un elemento di navigazione che utilizza i componenti Blade di Filament per gestire il menu utente. Il componente riceve la sua configurazione dal file JSON della sezione.

## Configurazione
La configurazione del componente viene definita nel file JSON della sezione:

```json
{
    "name": "Dropdown Utente",
    "type": "user-dropdown",
    "data": {
        "view": "pub_theme::components.blocks.navigation.user-dropdown",
        "guest_view": "pub_theme::components.blocks.navigation.login-buttons",
        "menu_items": [
            {
                "label": "Profilo",
                "url": "/profilo",
                "icon": "heroicon-o-user"
            },
            {
                "type": "divider"
            },
            {
                "label": "Logout",
                "url": "/logout",
                "icon": "heroicon-o-arrow-left-on-rectangle"
            }
        ]
    }
}
```

## Gestione dei Dati

### Struttura Corretta
- I dati devono essere semplici e piatti
- Non utilizzare strutture nidificate per le traduzioni
- Le traduzioni sono gestite tramite il sistema di traduzioni di Laravel

### Menu Items
Ogni voce del menu deve avere:
- `label`: Testo da visualizzare (non tradotto)
- `url`: URL di destinazione
- `icon`: Icona Heroicon (opzionale)
- `type`: Tipo di elemento (link/divider)

## Utilizzo di Componenti Filament

**È fortemente raccomandato utilizzare i componenti Filament** per l'interfaccia utente nel blocco user-dropdown. Filament fornisce componenti UI ottimizzati, accessibili e ben testati.

### Vantaggi

- **Coerenza visiva**: UI coerente tra il frontoffice e il backoffice
- **Accessibilità**: Componenti già conformi alle linee guida WCAG
- **Manutenibilità**: Aggiornamenti automatici quando Filament viene aggiornato
- **Funzionalità avanzate**: Interazioni, animazioni e responsive design integrati

### Implementazione con Filament

Il componente deve utilizzare i componenti Blade di Filament per il dropdown:

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
        @if($item['type'] === 'divider')
            <x-filament::dropdown.separator />
        @else
            <x-filament::dropdown.item
                :href="$item['url']"
                :icon="$item['icon']"
            >
                {{ __($item['label']) }}
            </x-filament::dropdown.item>
        @endif
    @endforeach
</x-filament::dropdown>

@if($isLoggedIn)
    <form 
        id="logout-form" 
        action="{{ route('logout', ['locale' => $locale]) }}" 
        method="POST" 
        class="hidden"
    >
        @csrf
    </form>
@endif
```

## Errori nel Tema

Nel file `user-dropdown.blade.php` del tema One sono presenti i seguenti errori:

- **Props Mancanti**: non vengono definite le props `guest_view` e `menu_items`, quindi i dati passati dal JSON non vengono valorizzati.
- **Gestione Manuale del Markup**: il dropdown è costruito a mano con classi e markup Alpine, anziché usare il componente `Dropdown` di Filament.
- **Hardcoded URL e Traduzioni**: vengono usati URL statici e funzioni di traduzione inline, invece di passare dati localizzati dal JSON.

## Soluzione Raccomandata

### 1. Rimuovere la logica manuale
Eliminare il markup custom del dropdown nel tema e lasciare solo l'`@include` della view:
```blade
{{-- non serve altro --}}
@include($block->view, $block->data)
```

### 2. Usare il componente Filament Dropdown
Nella view `user-dropdown.blade.php`, utilizzare la sintassi:
```blade
@props([
    'guest_view' => null,
    'menu_items' => [],
])

<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::avatar :src="$user?->profile_photo_url" />
    </x-slot>

    <x-slot name="content">
        @foreach($menu_items as $item)
            @if(($item['type'] ?? 'link') === 'divider')
                <x-filament::dropdown.section />
            @else
                <x-filament::dropdown.item href="{{ $item['url'] }}" icon="{{ $item['icon'] }}">
                    {{ $item['label'] }}
                </x-filament::dropdown.item>
            @endif
        @endforeach
    </x-slot>
</x-filament::dropdown>
```
Questa soluzione sfrutta il componente dropdown di Filament, mantiene la coerenza dell'interfaccia e utilizza automaticamente le props provenienti dal JSON.

## Best Practices

### 1. Gestione dei Dati
- ✅ Mantenere la struttura dei dati semplice e piatta
- ✅ Non includere traduzioni nei dati JSON
- ✅ Utilizzare il sistema di traduzioni di Laravel
- ✅ Validare i dati in ingresso

### 2. Componenti Filament
- ✅ Utilizzare i componenti Blade di Filament
- ✅ Seguire le convenzioni di stile di Filament
- ✅ Sfruttare le funzionalità built-in di Filament

### 3. Accessibilità
- ✅ Utilizzare i componenti Filament che già implementano l'accessibilità
- ✅ Mantenere la coerenza con il design system
- ✅ Supportare la navigazione da tastiera

### 4. Performance
- ✅ Minimizzare le chiamate al database
- ✅ Utilizzare il caching quando appropriato
- ✅ Ottimizzare il rendering dei componenti

## Collegamenti
- [Documentazione Filament Blade Components](./filament-blade-components.md)
- [Best Practices UI/UX](./guida-implementazione-ux.md)
- [Documentazione Accessibilità](./accessibility.md)
- [Modulo UI - Filament Blade Components](/var/www/html/<directory progetto>/laravel/Modules/UI/docs/filament/resources.md)
- [Documentazione Blocchi Navigation](./navigation.md)
- [Modulo UI - Filament Blade Components](../UI/docs/filament/resources.md)
