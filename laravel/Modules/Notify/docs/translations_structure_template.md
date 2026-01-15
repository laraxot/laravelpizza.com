# Template di Struttura per le Traduzioni

## Struttura Generale per i File di Traduzione

Ogni file di traduzione deve seguire questa struttura gerarchica:

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Singolare',
        'plural' => 'Nome Plurale',
    ],
    'navigation' => [
        'label' => 'Etichetta Menu',
        'group' => 'Gruppo Menu',
        'icon' => 'heroicon-o-icon-name',
        'sort' => 10, // ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // altri campi...
    ],
    'actions' => [
        'action_name' => 'Etichetta Azione',
        // altre azioni...
    ],
    'messages' => [
        'success' => 'Messaggio di successo',
        'error' => 'Messaggio di errore',
        // altri messaggi...
    ],
    'notifications' => [
        'title' => 'Titolo Notifica',
        'body' => 'Corpo Notifica',
        // altre notifiche...
    ],
];
```

## Esempio Specifico per SMS

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'SMS',
        'plural' => 'SMS',
    ],
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
        'icon' => 'heroicon-o-device-phone-mobile',
        'sort' => 10,
    ],
    'fields' => [
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero di telefono',
            'helper_text' => 'Numero di telefono con prefisso internazionale (es. +39)',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il messaggio non può superare i 160 caratteri',
        ],
        'driver' => [
            'label' => 'Provider SMS',
            'placeholder' => 'Seleziona il provider',
            'helper_text' => 'Seleziona il provider da utilizzare per l\'invio',
        ],
    ],
    'actions' => [
        'send' => 'Invia SMS',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'SMS inviato con successo',
        'error' => 'Errore nell\'invio SMS',
    ],
];
```

## Convenzioni di Naming

1. **Nomi dei File**: snake_case (es. `send_sms.php`, non `send_s_m_s.php`)
2. **Acronimi**: Trattati come una singola parola (es. `send_aws_email.php`, non `send_a_w_s_email.php`)
3. **Chiavi**: snake_case per tutte le chiavi
4. **Struttura**: Gerarchica, non piatta
