# List

Il componente List è utilizzato per visualizzare elenchi di elementi in modo strutturato e accessibile.

## Utilizzo Base

```blade
<x-filament::list>
    <x-filament::list.item>
        Primo elemento
    </x-filament::list.item>
    <x-filament::list.item>
        Secondo elemento
    </x-filament::list.item>
</x-filament::list>
```

## Varianti

### Lista Ordinata
```blade
<x-filament::list type="ordered">
    <x-filament::list.item>
        Primo passo
    </x-filament::list.item>
    <x-filament::list.item>
        Secondo passo
    </x-filament::list.item>
</x-filament::list>
```

### Lista con Divisori
```blade
<x-filament::list divided>
    <x-filament::list.item>
        Elemento 1
    </x-filament::list.item>
    <x-filament::list.item>
        Elemento 2
    </x-filament::list.item>
</x-filament::list>
```

### Lista con Icone
```blade
<x-filament::list>
    <x-filament::list.item>
        <x-slot name="icon">
            <x-heroicon-o-check class="w-5 h-5 text-success-500" />
        </x-slot>
        Elemento completato
    </x-filament::list.item>
    <x-filament::list.item>
        <x-slot name="icon">
            <x-heroicon-o-clock class="w-5 h-5 text-warning-500" />
        </x-slot>
        Elemento in attesa
    </x-filament::list.item>
</x-filament::list>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `type` | string | 'unordered' | Tipo di lista (ordered/unordered) |
| `divided` | boolean | false | Aggiunge divisori tra gli elementi |
| `hoverable` | boolean | false | Aggiunge effetto hover agli elementi |
| `class` | string | null | Classi CSS aggiuntive |

### Props per List Item
| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `icon` | string/slot | null | Icona da mostrare accanto all'elemento |
| `disabled` | boolean | false | Disabilita l'elemento |
| `selected` | boolean | false | Indica se l'elemento è selezionato |

## Best Practices

1. **Accessibilità**
   - Utilizzare il tipo di lista appropriato (ordered/unordered)
   - Mantenere una struttura gerarchica chiara
   - Fornire descrizioni per le icone

2. **UX/UI**
   - Limitare la profondità delle liste annidate
   - Utilizzare divisori per liste lunghe
   - Mantenere consistenza negli stili

3. **Performance**
   - Implementare lazy loading per liste lunghe
   - Ottimizzare le immagini delle icone
   - Gestire efficacemente gli stati

## Esempi

### Lista di Notifiche
```blade
<x-filament::list divided hoverable>
    @foreach($notifications as $notification)
        <x-filament::list.item>
            <x-slot name="icon">
                @if($notification->type === 'success')
                    <x-heroicon-o-check-circle class="w-5 h-5 text-success-500" />
                @elseif($notification->type === 'warning')
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-warning-500" />
                @else
                    <x-heroicon-o-information-circle class="w-5 h-5 text-primary-500" />
                @endif
            </x-slot>
            
            {{ $notification->message }}
            
            <x-slot name="actions">
                <x-filament::button
                    size="sm"
                    wire:click="markAsRead({{ $notification->id }})"
                >
                    Segna come letto
                </x-filament::button>
            </x-slot>
        </x-filament::list.item>
    @endforeach
</x-filament::list>
```

### Lista di Task
```blade
<x-filament::list type="ordered" divided>
    @foreach($tasks as $task)
        <x-filament::list.item :disabled="$task->completed">
            <x-slot name="icon">
                @if($task->completed)
                    <x-heroicon-o-check-circle class="w-5 h-5 text-success-500" />
                @else
                    <x-heroicon-o-clock class="w-5 h-5 text-warning-500" />
                @endif
            </x-slot>
            
            {{ $task->title }}
            
            <x-slot name="description">
                {{ $task->description }}
            </x-slot>
        </x-filament::list.item>
    @endforeach
</x-filament::list>
```

## Note sulla Performance

1. **Ottimizzazione DOM**
   - Rimuovere elementi non necessari
   - Utilizzare virtual scrolling per liste lunghe
   - Implementare paginazione quando appropriato

2. **Gestione Eventi**
   - Delegare eventi per liste dinamiche
   - Implementare debounce per azioni frequenti
   - Ottimizzare la gestione dello stato

3. **Accessibilità e SEO**
   - Utilizzare markup semantico
   - Implementare keyboard navigation
   - Mantenere supporto per screen reader

4. **Best Practices**
   - Limitare il numero di elementi visualizzati
   - Implementare infinite scroll per liste lunghe
   - Utilizzare caching appropriato 
