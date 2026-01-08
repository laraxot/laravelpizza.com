# Button

I pulsanti sono componenti fondamentali per l'interazione dell'utente. Questo componente fornisce diverse varianti e stili per soddisfare varie esigenze di design.

## Utilizzo Base

```blade
<x-filament::button>
    Pulsante Base
</x-filament::button>
```

## Varianti

### Colori
```blade
<!-- Primary -->
<x-filament::button color="primary">
    Primary
</x-filament::button>

<!-- Secondary -->
<x-filament::button color="secondary">
    Secondary
</x-filament::button>

<!-- Success -->
<x-filament::button color="success">
    Success
</x-filament::button>

<!-- Danger -->
<x-filament::button color="danger">
    Danger
</x-filament::button>
```

### Dimensioni
```blade
<!-- Small -->
<x-filament::button size="sm">
    Small
</x-filament::button>

<!-- Medium (default) -->
<x-filament::button size="md">
    Medium
</x-filament::button>

<!-- Large -->
<x-filament::button size="lg">
    Large
</x-filament::button>
```

### Con Icone
```blade
<x-filament::button>
    <x-slot name="icon">
        <x-heroicon-o-plus class="w-4 h-4" />
    </x-slot>
    Aggiungi
</x-filament::button>
```

### Outline
```blade
<x-filament::button outlined>
    Outline Button
</x-filament::button>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `type` | string | 'button' | Tipo del pulsante (button, submit, reset) |
| `color` | string | 'primary' | Colore del pulsante (primary, secondary, success, danger) |
| `size` | string | 'md' | Dimensione del pulsante (sm, md, lg) |
| `outlined` | boolean | false | Se il pulsante deve avere solo il bordo |
| `disabled` | boolean | false | Se il pulsante è disabilitato |
| `icon` | string | null | Nome dell'icona da mostrare |
| `iconPosition` | string | 'before' | Posizione dell'icona (before, after) |

## Best Practices

1. **Accessibilità**
   - Usare testo descrittivo per gli screen reader
   - Mantenere un contrasto adeguato
   - Aggiungere `aria-label` quando necessario

2. **UX**
   - Fornire feedback visivo sulle interazioni
   - Usare colori appropriati per le azioni
   - Mantenere consistenza nelle dimensioni

3. **Performance**
   - Evitare troppe varianti personalizzate
   - Riutilizzare stili comuni
   - Implementare lazy loading per le icone

## Esempi

### Form Submit
```blade
<x-filament::button
    type="submit"
    color="success"
    wire:loading.attr="disabled"
>
    <x-filament::loading-indicator wire:loading />
    Salva
</x-filament::button>
```

### Link Button
```blade
<x-filament::button
    tag="a"
    href="{{ route('home') }}"
    color="primary"
>
    Vai alla Home
</x-filament::button>
```

### Loading State
```blade
<x-filament::button
    wire:click="save"
    wire:loading.attr="disabled"
>
    <x-filament::loading-indicator
        wire:loading
        class="w-4 h-4"
    />
    <span wire:loading.remove>Salva</span>
    <span wire:loading>Salvataggio in corso...</span>
</x-filament::button>
```

## Note sulla Performance

1. **Ottimizzazione Bundle**
   - Utilizzare PurgeCSS per rimuovere stili non utilizzati
   - Implementare code splitting per i componenti complessi
   - Minimizzare l'uso di JavaScript custom

2. **Rendering**
   - Evitare troppe classi condizionali
   - Utilizzare cache per stati complessi
   - Implementare debounce per eventi frequenti

3. **Accessibilità e SEO**
   - Mantenere una struttura semantica
   - Implementare keyboard navigation
   - Utilizzare attributi ARIA appropriati 
