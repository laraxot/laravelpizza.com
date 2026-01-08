# User Dropdown Block

## Panoramica
Il blocco User Dropdown è un componente di navigazione che gestisce il menu utente, supportando sia utenti autenticati che non autenticati.

## Configurazione nel CMS

### 1. Registrazione del Blocco
```php
// In un ServiceProvider
public function boot()
{
    Block::register('user-dropdown', [
        'name' => 'User Dropdown',
        'description' => 'Menu dropdown per la gestione utente',
        'icon' => 'heroicon-o-user',
        'fields' => [
            'menu_items' => [
                'type' => 'repeater',
                'label' => ['label' => 'Elementi Menu'],
                'fields' => [
                    'label' => [
                        'type' => 'text',
                        'label' => ['label' => 'Etichetta'],
                        'required' => true
                    ],
                    'url' => [
                        'type' => 'text',
                        'label' => ['label' => 'URL'],
                        'required' => true
                    ],
                    'icon' => [
                        'type' => 'text',
                        'label' => ['label' => 'Icona'],
                        'tooltip' => ['label' => 'Nome dell\'icona Heroicon']
                    ],
                    'type' => [
                        'type' => 'select',
                        'label' => ['label' => 'Tipo'],
                        'options' => [
                            'link' => ['label' => 'Link'],
                            'divider' => ['label' => 'Divisore']
                        ]
                    ]
                ]
            ]
        ]
    ]);
}
```

### 2. Struttura dei Dati
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
      },
      {
        "type": "divider"
      },
      {
        "label": "Logout",
        "url": "/logout",
        "icon": "heroicon-o-arrow-left-on-rectangle"
      }
    ]
  }
}
```

### 3. Validazione dei Dati
```php
// Nel ServiceProvider
public function boot()
{
    Validator::extend('valid_menu_item', function ($attribute, $value, $parameters, $validator) {
        if (!is_array($value)) {
            return false;
        }
        
        if (isset($value['type']) && $value['type'] === 'divider') {
            return true;
        }
        
        return isset($value['label']) && isset($value['url']);
    });
}
```

## Best Practices

### 1. Gestione Dati
- Validare sempre i dati in ingresso
- Fornire valori di default appropriati
- Gestire errori in modo elegante

### 2. Accessibilità
- Supportare la navigazione da tastiera
- Fornire ARIA labels
- Mantenere la struttura semantica

### 3. Performance
- Minimizzare le query al database
- Utilizzare il caching quando appropriato
- Ottimizzare il rendering

### 4. Sicurezza
- Sanitizzare gli URL
- Validare i permessi utente
- Proteggere le rotte sensibili

## Collegamenti
- [Documentazione Blocchi](../README.md)
- [Best Practices CMS](../../best-practices.md)
- [Guida Componenti](../../components.md) 