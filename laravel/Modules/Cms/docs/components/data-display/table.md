# Table

Il componente Table fornisce un modo strutturato per visualizzare dati tabulari con funzionalità avanzate di ordinamento, filtro e paginazione.

## Utilizzo Base

```blade
<x-filament::table>
    <x-slot name="header">
        <x-filament::table.row>
            <x-filament::table.header>Nome</x-filament::table.header>
            <x-filament::table.header>Email</x-filament::table.header>
            <x-filament::table.header>Ruolo</x-filament::table.header>
        </x-filament::table.row>
    </x-slot>
    
    <x-filament::table.row>
        <x-filament::table.cell>Mario Rossi</x-filament::table.cell>
        <x-filament::table.cell>mario@example.com</x-filament::table.cell>
        <x-filament::table.cell>Admin</x-filament::table.cell>
    </x-filament::table.row>
</x-filament::table>
```

## Varianti

### Con Selezione
```blade
<x-filament::table selection>
    <x-slot name="header">
        <x-filament::table.row>
            <x-filament::table.header selection />
            <x-filament::table.header>Nome</x-filament::table.header>
            <x-filament::table.header>Email</x-filament::table.header>
        </x-filament::table.row>
    </x-slot>
    
    @foreach($users as $user)
        <x-filament::table.row :record="$user">
            <x-filament::table.cell selection />
            <x-filament::table.cell>{{ $user->name }}</x-filament::table.cell>
            <x-filament::table.cell>{{ $user->email }}</x-filament::table.cell>
        </x-filament::table.row>
    @endforeach
</x-filament::table>
```

### Con Ordinamento
```blade
<x-filament::table>
    <x-slot name="header">
        <x-filament::table.row>
            <x-filament::table.header
                sortable
                wire:click="sortBy('name')"
                :direction="$sortField === 'name' ? $sortDirection : null"
            >
                Nome
            </x-filament::table.header>
            <x-filament::table.header
                sortable
                wire:click="sortBy('email')"
                :direction="$sortField === 'email' ? $sortDirection : null"
            >
                Email
            </x-filament::table.header>
        </x-filament::table.row>
    </x-slot>
    
    <!-- Righe della tabella -->
</x-filament::table>
```

### Con Azioni
```blade
<x-filament::table>
    <x-slot name="header">
        <x-filament::table.row>
            <x-filament::table.header>Nome</x-filament::table.header>
            <x-filament::table.header>Email</x-filament::table.header>
            <x-filament::table.header>Azioni</x-filament::table.header>
        </x-filament::table.row>
    </x-slot>
    
    @foreach($users as $user)
        <x-filament::table.row>
            <x-filament::table.cell>{{ $user->name }}</x-filament::table.cell>
            <x-filament::table.cell>{{ $user->email }}</x-filament::table.cell>
            <x-filament::table.cell>
                <x-filament::button
                    size="sm"
                    wire:click="edit({{ $user->id }})"
                >
                    Modifica
                </x-filament::button>
                
                <x-filament::button
                    size="sm"
                    color="danger"
                    wire:click="delete({{ $user->id }})"
                >
                    Elimina
                </x-filament::button>
            </x-filament::table.cell>
        </x-filament::table.row>
    @endforeach
</x-filament::table>
```

## Props/Configurazione

| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `striped` | boolean | false | Righe alternate |
| `hoverable` | boolean | false | Effetto hover sulle righe |
| `selection` | boolean | false | Abilita selezione righe |
| `bordered` | boolean | false | Aggiunge bordi alla tabella |
| `dense` | boolean | false | Riduce lo spazio tra le righe |
| `sticky` | boolean | false | Header fisso durante lo scroll |

### Props per Header
| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `sortable` | boolean | false | Abilita ordinamento |
| `alignment` | string | 'left' | Allineamento (left/center/right) |
| `hidden` | boolean | false | Nasconde la colonna |

### Props per Cell
| Prop | Tipo | Default | Descrizione |
|------|------|---------|-------------|
| `alignment` | string | 'left' | Allineamento (left/center/right) |
| `colspan` | int | 1 | Numero di colonne da occupare |
| `color` | string | null | Colore del testo |

## Best Practices

1. **Accessibilità**
   - Utilizzare markup semantico
   - Fornire caption per screen reader
   - Mantenere ordine logico dei contenuti

2. **UX/UI**
   - Implementare paginazione per grandi dataset
   - Fornire feedback per azioni
   - Mantenere layout responsive

3. **Performance**
   - Lazy loading per dati
   - Ottimizzare ordinamento e filtri
   - Gestire efficacemente gli stati

## Esempi

### Tabella Utenti con Filtri
```blade
<div>
    <div class="mb-4">
        <x-filament::input
            wire:model.debounce.300ms="search"
            placeholder="Cerca..."
        />
    </div>
    
    <x-filament::table>
        <x-slot name="header">
            <x-filament::table.row>
                <x-filament::table.header
                    sortable
                    wire:click="sortBy('name')"
                    :direction="$sortField === 'name' ? $sortDirection : null"
                >
                    Nome
                </x-filament::table.header>
                <x-filament::table.header
                    sortable
                    wire:click="sortBy('email')"
                    :direction="$sortField === 'email' ? $sortDirection : null"
                >
                    Email
                </x-filament::table.header>
                <x-filament::table.header
                    sortable
                    wire:click="sortBy('role')"
                    :direction="$sortField === 'role' ? $sortDirection : null"
                >
                    Ruolo
                </x-filament::table.header>
                <x-filament::table.header>
                    Azioni
                </x-filament::table.header>
            </x-filament::table.row>
        </x-slot>
        
        @foreach($users as $user)
            <x-filament::table.row>
                <x-filament::table.cell>{{ $user->name }}</x-filament::table.cell>
                <x-filament::table.cell>{{ $user->email }}</x-filament::table.cell>
                <x-filament::table.cell>{{ $user->role }}</x-filament::table.cell>
                <x-filament::table.cell>
                    <x-filament::button
                        size="sm"
                        wire:click="edit({{ $user->id }})"
                    >
                        Modifica
                    </x-filament::button>
                </x-filament::table.cell>
            </x-filament::table.row>
        @endforeach
    </x-filament::table>
    
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
```

## Note sulla Performance

1. **Ottimizzazione Dati**
   - Implementare paginazione lato server
   - Utilizzare cache per dati statici
   - Ottimizzare query del database

2. **Gestione DOM**
   - Minimizzare manipolazioni DOM
   - Utilizzare virtual scrolling
   - Implementare lazy loading

3. **Eventi e Stato**
   - Debounce per ricerche
   - Throttle per ordinamento
   - Gestione efficiente dello stato

4. **Best Practices**
   - Limitare numero di righe visibili
   - Ottimizzare rendering colonne
   - Implementare infinite scroll 
