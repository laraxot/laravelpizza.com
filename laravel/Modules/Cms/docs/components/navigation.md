# Componenti di Navigazione

## Introduzione

I componenti di navigazione sono fondamentali per guidare gli utenti attraverso l'applicazione. Questa sezione documenta i componenti di navigazione disponibili nel modulo CMS.

## Breadcrumb

### Utilizzo Base
```php
<x-cms::breadcrumb>
    <x-cms::breadcrumb.item href="/">Home</x-cms::breadcrumb.item>
    <x-cms::breadcrumb.item href="/blog">Blog</x-cms::breadcrumb.item>
    <x-cms::breadcrumb.item>Articolo</x-cms::breadcrumb.item>
</x-cms::breadcrumb>
```

### Proprietà
- `separator`: string - Separatore personalizzato
- `responsive`: boolean - Comportamento responsivo
- `schema`: boolean - Aggiunge schema.org markup

### Best Practices
1. Mantenere la gerarchia chiara
2. Limitare la profondità
3. Utilizzare URL significativi
4. Includere la pagina corrente

## Pagination

### Utilizzo Base
```php
<x-cms::pagination
    :items="$posts"
    :per-page="10"
/>
```

### Proprietà
- `items`: mixed - Collection o Query Builder
- `per-page`: int - Elementi per pagina
- `simple`: boolean - Versione semplificata
- `align`: string - Allineamento (left, center, right)

### Personalizzazione
```php
<x-cms::pagination
    :items="$posts"
    view="custom-pagination"
/>
```

## Stepper

### Utilizzo Base
```php
<x-cms::stepper>
    <x-cms::stepper.step
        title="Passo 1"
        description="Descrizione del passo 1"
        :completed="true"
    />
    <x-cms::stepper.step
        title="Passo 2"
        description="Descrizione del passo 2"
        :active="true"
    />
    <x-cms::stepper.step
        title="Passo 3"
        description="Descrizione del passo 3"
    />
</x-cms::stepper>
```

### Proprietà
- `orientation`: string - Orientamento (horizontal, vertical)
- `size`: string - Dimensione (sm, md, lg)
- `type`: string - Tipo di visualizzazione (default, numbered)

### Stati dei Passi
- Completato
- Attivo
- In attesa
- Disabilitato

## Navbar

### Utilizzo Base
```php
<x-cms::navbar>
    <x-slot name="brand">
        <img src="/logo.svg" alt="Logo" />
    </x-slot>
    
    <x-cms::navbar.item href="/dashboard">
        Dashboard
    </x-cms::navbar.item>
    
    <x-cms::navbar.dropdown label="Profilo">
        <x-cms::navbar.dropdown.item href="/profile">
            Impostazioni
        </x-cms::navbar.dropdown.item>
        <x-cms::navbar.dropdown.item href="/logout">
            Logout
        </x-cms::navbar.dropdown.item>
    </x-cms::navbar.dropdown>
</x-cms::navbar>
```

### Proprietà
- `sticky`: boolean - Fissa la navbar in alto
- `transparent`: boolean - Sfondo trasparente
- `dark`: boolean - Tema scuro
- `spaced`: boolean - Spaziatura tra elementi

## Sidebar

### Utilizzo Base
```php
<x-cms::sidebar>
    <x-cms::sidebar.item
        icon="dashboard"
        href="/dashboard"
        :active="request()->is('dashboard')"
    >
        Dashboard
    </x-cms::sidebar.item>
    
    <x-cms::sidebar.group label="Amministrazione">
        <x-cms::sidebar.item href="/users">
            Utenti
        </x-cms::sidebar.item>
        <x-cms::sidebar.item href="/settings">
            Impostazioni
        </x-cms::sidebar.item>
    </x-cms::sidebar.group>
</x-cms::sidebar>
```

### Proprietà
- `collapsible`: boolean - Permette il collasso
- `mini`: boolean - Versione minimizzata
- `position`: string - Posizione (left, right)
- `overlay`: boolean - Modalità overlay su mobile

## Best Practices

### Accessibilità
1. Utilizzare landmark roles appropriati
2. Fornire skip links
3. Supportare la navigazione da tastiera
4. Mantenere focus visibile

### Mobile First
1. Design responsive
2. Menu hamburger su mobile
3. Touch targets appropriati
4. Gestione dello spazio limitato

### Performance
1. Lazy loading per menu complessi
2. Caching della navigazione
3. Ottimizzazione delle transizioni
4. Minimizzare il reflow

## Integrazione con Filament

### Resource Navigation
```php
use Filament\Resources\Resource;

class UserResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Amministrazione';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-users';
    }
}
```

### Custom Navigation
```php
use Filament\Navigation\NavigationItem;

public function getNavigationItems(): array
{
    return [
        NavigationItem::make('Dashboard')
            ->icon('heroicon-o-home')
            ->url('/admin/dashboard'),
    ];
}
```

## Troubleshooting

### Problemi Comuni
1. Menu non responsivo
   - Verificare i breakpoint
   - Controllare la gestione mobile
   
2. Problemi di routing
   - Verificare le route definite
   - Controllare i middleware
   
3. Problemi di stile
   - Verificare i conflitti CSS
   - Controllare z-index
   
4. Performance
   - Ottimizzare le query di menu
   - Implementare caching appropriato 

## Collegamenti tra versioni di navigation.md
* [navigation.md](laravel/Modules/Gdpr/docs/navigation.md)
* [navigation.md](laravel/Modules/Xot/docs/navigation.md)
* [navigation.md](laravel/Modules/UI/docs/navigation.md)
* [navigation.md](laravel/Modules/Cms/docs/blocks/navigation.md)
* [navigation.md](laravel/Modules/Cms/docs/navigation.md)
* [navigation.md](laravel/Modules/Cms/docs/components/navigation.md)

