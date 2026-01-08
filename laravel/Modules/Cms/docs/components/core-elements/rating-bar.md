# Rating Bar

Il componente Rating Bar permette agli utenti di assegnare e visualizzare valutazioni attraverso un'interfaccia intuitiva basata su stelle o altri simboli.

## Utilizzo Base

```blade
<x-filament::rating
    wire:model="rating"
    :max="5"
/>
```

## Varianti

### Sola Lettura
```blade
<x-filament::rating
    :value="4"
    :max="5"
    disabled
/>
```

### Con Etichette
```blade
<div class="space-y-2">
    <x-filament::rating
        wire:model="rating"
        :max="5"
    />
    <span class="text-sm text-gray-500">
        {{ $rating }} su 5 stelle
    </span>
</div>
```

### Dimensioni Personalizzate
```blade
<!-- Small -->
<x-filament::rating
    wire:model="rating"
    :max="5"
    class="text-sm"
/>

<!-- Large -->
<x-filament::rating
    wire:model="rating"
    :max="5"
    class="text-xl"
/>
```

### Colori Personalizzati
```blade
<x-filament::rating
    wire:model="rating"
    :max="5"
    class="text-yellow-400"
/>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `value` | number | 0 | Valore corrente |
| `max` | number | 5 | Numero massimo di stelle |
| `disabled` | boolean | false | Modalità sola lettura |
| `wire:model` | string | null | Binding Livewire |
| `class` | string | null | Classi CSS aggiuntive |

## Best Practices

1. **Accessibilità**
   - Fornire etichette descrittive
   - Supportare navigazione da tastiera
   - Implementare ARIA roles appropriati

2. **UX/UI**
   - Fornire feedback visivo immediato
   - Mantenere dimensioni touch-friendly
   - Usare colori con contrasto adeguato

3. **Implementazione**
   - Gestire stati di caricamento
   - Validare input lato server
   - Implementare fallback appropriati

## Esempi

### Form di Recensione
```blade
<form wire:submit.prevent="saveReview">
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Valutazione
            </label>
            <x-filament::rating
                wire:model="review.rating"
                :max="5"
                class="mt-1"
            />
            @error('review.rating')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <x-filament::textarea
            wire:model="review.comment"
            label="Commento"
        />

        <x-filament::button type="submit">
            Invia Recensione
        </x-filament::button>
    </div>
</form>
```

### Display Aggregato
```blade
<div class="flex items-center space-x-2">
    <x-filament::rating
        :value="$averageRating"
        :max="5"
        disabled
    />
    <span class="text-sm text-gray-500">
        ({{ $reviewsCount }} recensioni)
    </span>
</div>
```

### Rating Interattivo con Feedback
```blade
<div
    x-data="{ rating: @entangle('rating') }"
    class="space-y-2"
>
    <x-filament::rating
        x-model="rating"
        :max="5"
        wire:change="updateRating"
    />
    
    <p x-show="rating > 0" class="text-sm">
        <span x-text="rating"></span> stelle - 
        <span x-text="rating <= 2 ? 'Scarso' : (rating <= 3 ? 'Medio' : (rating <= 4 ? 'Buono' : 'Eccellente'))">
        </span>
    </p>
</div>
```

## Note sulla Performance

1. **Ottimizzazione Rendering**
   - Minimizzare re-render non necessari
   - Utilizzare debounce per aggiornamenti
   - Implementare caching appropriato

2. **Gestione Eventi**
   - Ottimizzare gestione eventi touch/mouse
   - Implementare throttling quando necessario
   - Gestire memory leaks

3. **Bundle Size**
   - Utilizzare SVG ottimizzati per le stelle
   - Minimizzare dipendenze JavaScript
   - Implementare code splitting quando appropriato

4. **Accessibilità e SEO**
   - Utilizzare markup semantico
   - Implementare microdata per recensioni
   - Mantenere supporto per screen reader 
