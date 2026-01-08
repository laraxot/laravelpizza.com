# Alert

Il componente Alert è utilizzato per mostrare messaggi importanti, notifiche o feedback all'utente in modo chiaro e visibile.

## Utilizzo Base

```blade
<x-filament::alert
    type="success"
    icon="heroicon-o-check-circle"
>
    Operazione completata con successo!
</x-filament::alert>
```

## Varianti

### Tipi di Alert
```blade
<!-- Success -->
<x-filament::alert
    type="success"
    icon="heroicon-o-check-circle"
>
    Operazione completata con successo!
</x-filament::alert>

<!-- Warning -->
<x-filament::alert
    type="warning"
    icon="heroicon-o-exclamation-triangle"
>
    Attenzione: questa azione non può essere annullata.
</x-filament::alert>

<!-- Danger -->
<x-filament::alert
    type="danger"
    icon="heroicon-o-x-circle"
>
    Si è verificato un errore durante l'operazione.
</x-filament::alert>

<!-- Info -->
<x-filament::alert
    type="info"
    icon="heroicon-o-information-circle"
>
    Informazione importante da sapere.
</x-filament::alert>
```

### Con Azioni
```blade
<x-filament::alert
    type="warning"
    icon="heroicon-o-exclamation-triangle"
>
    <x-slot name="actions">
        <x-filament::button
            color="warning"
            size="sm"
            wire:click="acknowledge"
        >
            Conferma
        </x-filament::button>
    </x-slot>
    
    Devi confermare questa azione prima di procedere.
</x-filament::alert>
```

### Dismissibile
```blade
<x-filament::alert
    type="info"
    icon="heroicon-o-information-circle"
    dismissible
>
    Questo alert può essere chiuso.
</x-filament::alert>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `type` | string | 'info' | Tipo di alert (success/warning/danger/info) |
| `icon` | string | null | Nome dell'icona Heroicon |
| `dismissible` | boolean | false | Se l'alert può essere chiuso |
| `persistent` | boolean | false | Se l'alert deve persistere tra le navigazioni |
| `class` | string | null | Classi CSS aggiuntive |

## Best Practices

1. **UX/UI**
   - Usare colori appropriati per il tipo di messaggio
   - Mantenere il messaggio conciso e chiaro
   - Posizionare l'alert in modo visibile ma non invasivo

2. **Accessibilità**
   - Utilizzare attributi ARIA appropriati
   - Assicurare contrasto sufficiente
   - Fornire alternative per screen reader

3. **Implementazione**
   - Gestire correttamente la dismissione
   - Implementare timeout quando appropriato
   - Mantenere consistenza nel design

## Esempi

### Alert di Sistema
```blade
@if (session()->has('message'))
    <x-filament::alert
        type="success"
        icon="heroicon-o-check-circle"
        dismissible
    >
        {{ session('message') }}
    </x-filament::alert>
@endif
```

### Alert con HTML
```blade
<x-filament::alert
    type="info"
    icon="heroicon-o-information-circle"
>
    <p>
        Per maggiori informazioni, visita la
        <a href="#" class="underline hover:text-primary-600">
            documentazione
        </a>.
    </p>
</x-filament::alert>
```

### Alert Stack
```blade
<div class="space-y-4">
    @foreach ($notifications as $notification)
        <x-filament::alert
            :type="$notification->type"
            :icon="$notification->icon"
            dismissible
        >
            {{ $notification->message }}
            
            @if ($notification->action)
                <x-slot name="actions">
                    <x-filament::button
                        :color="$notification->type"
                        size="sm"
                        wire:click="handleNotification({{ $notification->id }})"
                    >
                        {{ $notification->action }}
                    </x-filament::button>
                </x-slot>
            @endif
        </x-filament::alert>
    @endforeach
</div>
```

## Note sulla Performance

1. **Gestione DOM**
   - Rimuovere alert dismessi dal DOM
   - Limitare il numero di alert simultanei
   - Gestire correttamente le animazioni

2. **Stato e Reattività**
   - Implementare gestione stato efficiente
   - Utilizzare eventi per comunicazione
   - Ottimizzare re-render

3. **Accessibilità e SEO**
   - Utilizzare markup semantico
   - Implementare focus management
   - Mantenere supporto per screen reader

4. **Best Practices**
   - Non abusare degli alert
   - Preferire feedback inline quando possibile
   - Mantenere consistenza nel design system 
