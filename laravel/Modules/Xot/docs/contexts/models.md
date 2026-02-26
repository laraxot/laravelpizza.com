# Contesti dei Modelli

Questo documento definisce i contesti e le regole per i modelli dell'applicazione.

## Modelli Base

### User
```php
[
    'type' => 'base',
    'traits' => [
        'HasFactory',
        'Notifiable',
        'HasParent'
    ],
    'relationships' => [
        'doctor',
        'patient'
    ],
    'table' => 'users',
    'type_column' => 'type'
]
```

## Modelli Figli

### Doctor
```php
[
    'extends' => 'User',
    'type' => 'child',
    'traits' => [
        'HasParent'
    ],
    'context' => 'medical',
    'validations' => [
        'medical_license',
        'specialization'
    ]
]
```

### Patient
```php
[
    'extends' => 'User',
    'type' => 'child',
    'traits' => [
        'HasParent'
    ],
    'context' => 'medical',
    'validations' => [
        'health_insurance',
        'medical_history'
    ]
]
```

## Regole di Validazione

1. **Trait Obbligatori**
   - Ogni modello deve implementare i trait specificati nel suo contesto
   - I trait mancanti verranno segnalati durante la validazione

2. **Relazioni**
   - Le relazioni definite nel contesto devono essere implementate come metodi pubblici
   - Le relazioni mancanti verranno segnalate durante la validazione

3. **Estensioni**
   - I modelli figli devono estendere correttamente il modello base specificato
   - Le estensioni errate verranno segnalate durante la validazione

4. **Validazioni Specifiche**
   - Ogni modello può definire validazioni specifiche per il suo contesto
   - Le validazioni devono essere implementate nel modello

## Utilizzo

Per validare i contesti dei modelli:

```bash

# Validare tutti i modelli
php artisan mcp:validate

# Validare un modello specifico
php artisan mcp:validate Doctor
```

## Note Tecniche

- I contesti sono definiti nel comando `McpValidateCommand`
- La validazione utilizza la reflection per analizzare le classi
- I risultati della validazione vengono mostrati nella console
- Le violazioni vengono segnalate con messaggi di errore 
