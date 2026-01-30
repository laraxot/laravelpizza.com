# User Dropdown Component

## Architettura

### Panoramica
Il componente User Dropdown è un elemento di navigazione che gestisce il menu utente. È composto da:
1. Template Blade nel tema
2. Configurazione nel CMS
3. Dati di configurazione in JSON

### Flusso dei Dati
```
JSON Config (1.json)
       ↓
CMS Block Definition
       ↓
Section Component
       ↓
User Dropdown Template
       ↓
Rendering HTML
```

## Integrazione

### 1. Configurazione JSON
```json
{
  "type": "user-dropdown",
  "data": {
    "view": "pub_theme::components.blocks.navigation.user-dropdown",
    "guest_view": "pub_theme::components.blocks.navigation.login-buttons",
    "menu_items": [
      {
        "label": "Profilo",
        "url": "/profilo",
        "icon": "heroicon-o-user"
      }
    ]
  }
}
```

### 2. Template Blade
```blade
@props(['menu_items' => []])

@if(auth()->check())
    <div class="relative" x-data="{ open: false }">
        {{-- ... codice del dropdown ... --}}
        <div x-show="open">
            @foreach($menu_items as $item)
                {{-- ... rendering degli items ... --}}
            @endforeach
        </div>
    </div>
@else
    @include($guest_view)
@endif
```

### 3. Registrazione CMS
```php
Block::register('user-dropdown', [
    'name' => 'User Dropdown',
    'fields' => [
        'menu_items' => [
            'type' => 'repeater',
            'fields' => [
                'label' => ['type' => 'text'],
                'url' => ['type' => 'text'],
                'icon' => ['type' => 'text']
            ]
        ]
    ]
]);
```

## Best Practices

### 1. Configurabilità
- Utilizzare sempre i dati di configurazione
- Evitare valori hardcoded
- Fornire valori di default

### 2. Modularità
- Separare la logica dalla presentazione
- Utilizzare componenti riutilizzabili
- Mantenere la coerenza

### 3. Manutenibilità
- Documentare il codice
- Seguire le convenzioni
- Testare appropriatamente

### 4. Performance
- Ottimizzare il rendering
- Utilizzare il caching
- Minimizzare le query

## Collegamenti
- [Documentazione Tema](../laravel/Themes/One/docs/components/blocks/navigation/user-dropdown.md)
- [Documentazione CMS](../laravel/Modules/Cms/docs/components/blocks/navigation/user-dropdown.md)
- [Best Practices](../best-practices.md) 