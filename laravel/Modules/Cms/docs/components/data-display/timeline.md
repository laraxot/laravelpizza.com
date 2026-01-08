# Timeline

Il componente Timeline visualizza una sequenza di eventi in ordine cronologico, ideale per mostrare storico, attività o progressi.

## Utilizzo Base

```blade
<x-filament::timeline>
    <x-filament::timeline.item
        title="Evento 1"
        date="2024-03-15 14:30"
    >
        Descrizione dell'evento 1
    </x-filament::timeline.item>
    
    <x-filament::timeline.item
        title="Evento 2"
        date="2024-03-14 09:00"
    >
        Descrizione dell'evento 2
    </x-filament::timeline.item>
</x-filament::timeline>
```

## Varianti

### Con Icone
```blade
<x-filament::timeline>
    <x-filament::timeline.item
        title="Ordine Creato"
        date="2024-03-15 14:30"
        icon="heroicon-o-shopping-cart"
    >
        Ordine #123 creato dal cliente
    </x-filament::timeline.item>
    
    <x-filament::timeline.item
        title="Pagamento Ricevuto"
        date="2024-03-15 14:35"
        icon="heroicon-o-credit-card"
        icon-color="success"
    >
        Pagamento di €50.00 ricevuto
    </x-filament::timeline.item>
</x-filament::timeline>
```

### Con Badge
```blade
<x-filament::timeline>
    <x-filament::timeline.item
        title="Stato Aggiornato"
        date="2024-03-15"
    >
        <x-slot name="badge">
            <x-filament::badge color="success">
                Completato
            </x-filament::badge>
        </x-slot>
        
        Ordine elaborato con successo
    </x-filament::timeline.item>
</x-filament::timeline>
```

### Con Contenuto Personalizzato
```blade
<x-filament::timeline>
    <x-filament::timeline.item
        title="Commento Aggiunto"
        date="2024-03-15"
    >
        <div class="p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600">
                Ottimo lavoro! Il progetto sta procedendo secondo i piani.
            </p>
            <div class="mt-2 text-xs text-gray-500">
                - Mario Rossi
            </div>
        </div>
    </x-filament::timeline.item>
</x-filament::timeline>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `align` | string | 'left' | Allineamento (left/center/right) |
| `reverse` | boolean | false | Inverte l'ordine degli elementi |
| `compact` | boolean | false | Riduce lo spazio tra gli elementi |
| `class` | string | null | Classi CSS aggiuntive |

### Props per Timeline Item
| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `title` | string | null | Titolo dell'evento |
| `date` | string/DateTime | null | Data dell'evento |
| `icon` | string | null | Nome dell'icona Heroicon |
| `iconColor` | string | 'primary' | Colore dell'icona |
| `badge` | slot | null | Badge personalizzato |

## Best Practices

1. **Accessibilità**
   - Utilizzare markup semantico
   - Fornire descrizioni chiare
   - Mantenere ordine cronologico

2. **UX/UI**
   - Mostrare date in formato leggibile
   - Utilizzare icone significative
   - Mantenere consistenza visiva

3. **Performance**
   - Implementare lazy loading
   - Ottimizzare rendering
   - Gestire efficacemente gli stati

## Esempi

### Storico Ordini
```blade
<x-filament::timeline>
    @foreach($orderHistory as $event)
        <x-filament::timeline.item
            :title="$event->title"
            :date="$event->created_at"
            :icon="$event->getIcon()"
            :icon-color="$event->getIconColor()"
        >
            <x-slot name="badge">
                <x-filament::badge :color="$event->getStatusColor()">
                    {{ $event->status }}
                </x-filament::badge>
            </x-slot>
            
            <div class="space-y-2">
                <p class="text-sm text-gray-600">
                    {{ $event->description }}
                </p>
                
                @if($event->hasDetails())
                    <div class="text-xs text-gray-500">
                        {{ $event->details }}
                    </div>
                @endif
            </div>
        </x-filament::timeline.item>
    @endforeach
</x-filament::timeline>
```

### Processo di Approvazione
```blade
<x-filament::timeline>
    @foreach($approvalSteps as $step)
        <x-filament::timeline.item
            :title="$step->title"
            :date="$step->date"
            :icon="$step->completed ? 'heroicon-o-check-circle' : 'heroicon-o-clock'"
            :icon-color="$step->completed ? 'success' : 'warning'"
        >
            <x-slot name="badge">
                @if($step->completed)
                    <x-filament::badge color="success">
                        Approvato
                    </x-filament::badge>
                @elseif($step->pending)
                    <x-filament::badge color="warning">
                        In Attesa
                    </x-filament::badge>
                @else
                    <x-filament::badge color="gray">
                        Non Iniziato
                    </x-filament::badge>
                @endif
            </x-slot>
            
            <div class="space-y-2">
                <p class="text-sm text-gray-600">
                    {{ $step->description }}
                </p>
                
                @if($step->approver)
                    <div class="text-xs text-gray-500">
                        Approvato da: {{ $step->approver->name }}
                    </div>
                @endif
            </div>
        </x-filament::timeline.item>
    @endforeach
</x-filament::timeline>
```

## Note sulla Performance

1. **Ottimizzazione Dati**
   - Implementare paginazione per timeline lunghe
   - Utilizzare cache per dati statici
   - Ottimizzare query del database

2. **Gestione DOM**
   - Minimizzare manipolazioni DOM
   - Utilizzare virtual scrolling
   - Implementare lazy loading

3. **Accessibilità e SEO**
   - Utilizzare markup semantico
   - Implementare keyboard navigation
   - Mantenere supporto per screen reader

4. **Best Practices**
   - Limitare numero di eventi visibili
   - Ottimizzare rendering icone
   - Implementare infinite scroll per timeline lunghe 
