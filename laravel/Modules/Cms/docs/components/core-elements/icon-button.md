# Icon Button

I pulsanti con icona sono componenti compatti che utilizzano simboli grafici per comunicare azioni in modo efficace. Sono particolarmente utili quando lo spazio è limitato o quando si vuole mantenere un'interfaccia pulita e minimalista.

## Utilizzo Base

```blade
<x-job::icon-button>
    <x-heroicon-o-home class="w-5 h-5" />
</x-job::icon-button>
```

## Varianti

### Dimensioni
```blade
<!-- Small -->
<x-job::icon-button size="sm">
    <x-heroicon-o-plus class="w-4 h-4" />
</x-job::icon-button>

<!-- Medium (default) -->
<x-job::icon-button size="md">
    <x-heroicon-o-plus class="w-5 h-5" />
</x-job::icon-button>

<!-- Large -->
<x-job::icon-button size="lg">
    <x-heroicon-o-plus class="w-6 h-6" />
</x-job::icon-button>
```

### Colori
```blade
<!-- Primary -->
<x-job::icon-button color="primary">
    <x-heroicon-o-pencil class="w-5 h-5" />
</x-job::icon-button>

<!-- Danger -->
<x-job::icon-button color="danger">
    <x-heroicon-o-trash class="w-5 h-5" />
</x-job::icon-button>

<!-- Warning -->
<x-job::icon-button color="warning">
    <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
</x-job::icon-button>
```

### Con Tooltip
```blade
<x-job::icon-button
    tooltip="Modifica elemento"
    color="primary"
>
    <x-heroicon-o-pencil class="w-5 h-5" />
</x-job::icon-button>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `color` | string | 'primary' | Colore del pulsante |
| `darkMode` | boolean | false | Modalità scura |
| `disabled` | boolean | false | Stato disabilitato |
| `size` | string | 'md' | Dimensione (sm, md, lg) |
| `tooltip` | string | null | Testo del tooltip |
| `type` | string | 'button' | Tipo del pulsante |
| `labelSrOnly` | boolean | false | Label solo per screen reader |

## Best Practices

1. **Accessibilità**
   - Fornire sempre un `aria-label` o tooltip
   - Mantenere dimensioni minime per il touch
   - Usare contrasti appropriati

2. **UX/UI**
   - Usare icone universalmente riconoscibili
   - Mantenere consistenza nelle dimensioni
   - Fornire feedback visivo sulle interazioni

3. **Implementazione**
   - Riutilizzare le stesse icone per azioni simili
   - Mantenere la coerenza nei colori
   - Implementare stati hover/focus appropriati

## Esempi

### Pulsante di Azione
```blade
<x-job::icon-button
    color="primary"
    tooltip="Aggiungi nuovo"
    wire:click="create"
>
    <x-heroicon-o-plus class="w-5 h-5" />
</x-job::icon-button>
```

### Pulsante di Navigazione
```blade
<x-job::icon-button
    tag="a"
    href="{{ route('home') }}"
    color="secondary"
    tooltip="Torna alla home"
>
    <x-heroicon-o-home class="w-5 h-5" />
</x-job::icon-button>
```

### Pulsante con Loading State
```blade
<x-job::icon-button
    wire:click="delete"
    wire:loading.attr="disabled"
    color="danger"
    tooltip="Elimina"
>
    <x-heroicon-o-trash
        wire:loading.remove
        class="w-5 h-5"
    />
    <x-filament::loading-indicator
        wire:loading
        class="w-5 h-5"
    />
</x-job::icon-button>
```

## Note sulla Performance

1. **Ottimizzazione Icone**
   - Utilizzare SVG ottimizzati
   - Implementare lazy loading per icone grandi
   - Considerare l'uso di sprite SVG

2. **Gestione Eventi**
   - Implementare debounce per click rapidi
   - Gestire stati loading appropriatamente
   - Minimizzare re-render non necessari

3. **Bundle Size**
   - Importare solo le icone necessarie
   - Utilizzare un sistema di icon font quando appropriato
   - Implementare code splitting per set di icone grandi 
