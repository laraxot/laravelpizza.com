# Implementazione degli Avatar

## Collegamenti correlati
- [README modulo User](./README.md)
- [Implementazione Header con Selettore Lingua](/laravel/Modules/User/docs/HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md)
- [Collegamenti Documentazione](/docs/collegamenti-documentazione.md)

## Panoramica

Questo documento descrive l'implementazione degli avatar utente , con particolare attenzione agli avatar SVG predefiniti utilizzati quando l'utente non ha un'immagine del profilo personalizzata.

## Struttura degli Avatar SVG

Gli avatar SVG sono posizionati nella directory `/laravel/Modules/UI/resources/svg/avatars/` seguendo le convenzioni di <nome progetto> per i componenti SVG. Sono stati creati quattro avatar predefiniti con design simpatici e colorati:

1. **default-1.svg**: Avatar con sfondo viola e silhouette semplice
2. **default-2.svg**: Avatar con sfondo verde e volto sorridente
3. **default-3.svg**: Avatar con sfondo rosa e espressione vivace
4. **default-4.svg**: Avatar con sfondo arancione e espressione sorpresa

Questi avatar vengono registrati automaticamente come componenti Blade con il prefisso `ui-avatars` grazie al sistema di registrazione delle icone di <nome progetto>.

## Componente Avatar

Il componente `x-ui.avatar` è stato implementato per gestire sia gli avatar personalizzati degli utenti che gli avatar SVG predefiniti:

```php
@props(['user' => null, 'size' => 'md', 'randomSeed' => null])

@php
    $sizes = [
        'sm' => 'h-6 w-6',
        'md' => 'h-8 w-8',
        'lg' => 'h-10 w-10',
        'xl' => 'h-12 w-12',
        '2xl' => 'h-16 w-16',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];

    // Determina l'avatar da utilizzare
    $hasCustomAvatar = $user && isset($user->profile_photo_url) && $user->profile_photo_url;

    // Se non c'è un avatar personalizzato, seleziona un avatar SVG casuale
    if (!$hasCustomAvatar) {
        // Usa il seed fornito o l'ID utente o un valore casuale
        $seed = $randomSeed ?? ($user ? $user->id : rand(1, 1000));
        $avatarNumber = ($seed % 4) + 1; // Genera un numero da 1 a 4
    }
@endphp

@if($hasCustomAvatar)
    <img
        src="{{ $user->profile_photo_url }}"
        alt="{{ $user->name ?? 'User' }}"
        {{ $attributes->merge(['class' => "{$sizeClass} rounded-full object-cover"]) }}
    >
@else
    <div {{ $attributes->merge(['class' => "{$sizeClass} rounded-full overflow-hidden bg-primary-100 flex items-center justify-center"]) }}>
        @switch($avatarNumber)
            @case(1)
                <x-ui-avatars.default-1 class="w-full h-full" />
                @break
            @case(2)
                <x-ui-avatars.default-2 class="w-full h-full" />
                @break
            @case(3)
                <x-ui-avatars.default-3 class="w-full h-full" />
                @break
            @case(4)
                <x-ui-avatars.default-4 class="w-full h-full" />
                @break
            @default
                <x-ui-avatars.default-1 class="w-full h-full" />
        @endswitch
    </div>
@endif
```

### Caratteristiche del Componente

1. **Dimensioni Configurabili**: Il componente supporta diverse dimensioni (`sm`, `md`, `lg`, `xl`, `2xl`) per adattarsi a diversi contesti dell'interfaccia.
2. **Selezione Deterministica**: Gli avatar SVG vengono selezionati in modo deterministico basandosi sull'ID utente, garantendo che ogni utente abbia sempre lo stesso avatar.
3. **Fallback Casuale**: Se non è disponibile un ID utente, viene utilizzato un seed casuale per selezionare un avatar.
4. **Supporto per Avatar Personalizzati**: Se l'utente ha un'immagine del profilo personalizzata, questa viene utilizzata invece dell'avatar SVG.

## Utilizzo nel Dropdown Utente

Il componente avatar viene utilizzato nel dropdown utente nell'header:

```php
<x-ui.avatar
    :user="auth()->user()"
    size="md"
    class="ring-2 ring-white ring-opacity-50 shadow-sm"
/>
```

## Vantaggi dell'Approccio SVG

1. **Prestazioni**: Gli SVG sono leggeri e si caricano rapidamente rispetto alle immagini raster.
2. **Scalabilità**: Gli SVG si ridimensionano perfettamente su qualsiasi dispositivo senza perdita di qualità.
3. **Personalizzazione**: Gli SVG possono essere facilmente personalizzati con CSS per adattarsi al tema dell'applicazione.
4. **Accessibilità**: Gli SVG possono includere attributi di accessibilità per migliorare l'esperienza degli utenti con disabilità.
5. **Coerenza**: L'utilizzo di avatar SVG predefiniti garantisce un'esperienza utente coerente e professionale.

## Estensioni Future

Il sistema di avatar può essere esteso in futuro per includere:

1. **Più Varianti**: Aggiungere più avatar SVG per una maggiore varietà.
2. **Avatar Generati**: Implementare un sistema per generare avatar basati sul nome utente o altre caratteristiche.
3. **Personalizzazione Utente**: Permettere agli utenti di selezionare il proprio avatar SVG preferito.
4. **Temi Dinamici**: Adattare i colori degli avatar al tema dell'applicazione.

## Riferimenti

- [Documentazione SVG](https://developer.mozilla.org/en-US/docs/Web/SVG)
- [Blade Components Documentation](https://laravel.com/docs/10.x/blade#components)
- [Architettura Modulare <nome progetto>](/docs/architettura-modulare.md)
