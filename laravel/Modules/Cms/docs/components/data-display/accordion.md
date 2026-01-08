# Accordion

Il componente Accordion permette di organizzare contenuti in sezioni collassabili, ottimizzando lo spazio e migliorando la leggibilità dell'interfaccia.

## Utilizzo Base

```blade
<x-filament::accordion>
    <x-filament::accordion.item>
        <x-slot name="trigger">
            Sezione 1
        </x-slot>
        
        Contenuto della sezione 1
    </x-filament::accordion.item>
    
    <x-filament::accordion.item>
        <x-slot name="trigger">
            Sezione 2
        </x-slot>
        
        Contenuto della sezione 2
    </x-filament::accordion.item>
</x-filament::accordion>
```

## Varianti

### Con Icone
```blade
<x-filament::accordion>
    <x-filament::accordion.item>
        <x-slot name="trigger">
            <div class="flex items-center">
                <x-heroicon-o-user class="w-5 h-5 mr-2" />
                Informazioni Personali
            </div>
        </x-slot>
        
        Contenuto della sezione
    </x-filament::accordion.item>
</x-filament::accordion>
```

### Con Badge
```blade
<x-filament::accordion>
    <x-filament::accordion.item>
        <x-slot name="trigger">
            <div class="flex items-center justify-between">
                <span>Notifiche</span>
                <x-filament::badge>
                    3 nuove
                </x-filament::badge>
            </div>
        </x-slot>
        
        Contenuto delle notifiche
    </x-filament::accordion.item>
</x-filament::accordion>
```

### Stile Bordo
```blade
<x-filament::accordion class="border rounded-lg divide-y">
    <x-filament::accordion.item>
        <x-slot name="trigger">
            Sezione 1
        </x-slot>
        
        Contenuto della sezione 1
    </x-filament::accordion.item>
</x-filament::accordion>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `multiple` | boolean | false | Permette l'apertura di più sezioni |
| `defaultOpen` | array/string | [] | ID delle sezioni aperte di default |
| `iconPosition` | string | 'after' | Posizione dell'icona (before/after) |
| `disabled` | boolean | false | Disabilita l'interazione |
| `class` | string | null | Classi CSS aggiuntive |

## Best Practices

1. **Accessibilità**
   - Utilizzare attributi ARIA appropriati
   - Supportare navigazione da tastiera
   - Fornire feedback visivi chiari

2. **UX/UI**
   - Mantenere titoli concisi e descrittivi
   - Limitare il numero di sezioni
   - Fornire indicatori visivi dello stato

3. **Performance**
   - Lazy loading per contenuti pesanti
   - Ottimizzare animazioni
   - Gestire stati di caricamento

## Esempi

### FAQ
```blade
<x-filament::accordion>
    @foreach($faqs as $faq)
        <x-filament::accordion.item>
            <x-slot name="trigger">
                {{ $faq->question }}
            </x-slot>
            
            {!! $faq->answer !!}
        </x-filament::accordion.item>
    @endforeach
</x-filament::accordion>
```

### Form Sections
```blade
<form wire:submit.prevent="save">
    <x-filament::accordion>
        <x-filament::accordion.item>
            <x-slot name="trigger">
                Informazioni Personali
            </x-slot>
            
            <div class="space-y-4">
                <x-filament::input
                    wire:model="name"
                    label="Nome"
                />
                
                <x-filament::input
                    wire:model="email"
                    type="email"
                    label="Email"
                />
            </div>
        </x-filament::accordion.item>
        
        <x-filament::accordion.item>
            <x-slot name="trigger">
                Preferenze
            </x-slot>
            
            <div class="space-y-4">
                <x-filament::toggle
                    wire:model="notifications"
                    label="Notifiche Email"
                />
                
                <x-filament::toggle
                    wire:model="newsletter"
                    label="Newsletter"
                />
            </div>
        </x-filament::accordion.item>
    </x-filament::accordion>
    
    <div class="mt-4">
        <x-filament::button type="submit">
            Salva
        </x-filament::button>
    </div>
</form>
```

## Note sulla Performance

1. **Ottimizzazione Contenuti**
   - Implementare lazy loading per contenuti pesanti
   - Utilizzare placeholder durante il caricamento
   - Minimizzare il DOM iniziale

2. **Animazioni**
   - Utilizzare CSS transforms
   - Evitare animazioni complesse
   - Rispettare `prefers-reduced-motion`

3. **Gestione Eventi**
   - Implementare debounce per eventi frequenti
   - Ottimizzare gestione dello stato
   - Minimizzare re-render non necessari

4. **Accessibilità e SEO**
   - Utilizzare markup semantico
   - Implementare keyboard navigation
   - Mantenere supporto per screen reader 
