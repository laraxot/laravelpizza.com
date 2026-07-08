# Guida alla Struttura dei File di Traduzione

## Struttura Standard Obbligatoria

Ogni file di traduzione nel modulo Notify deve seguire questa struttura gerarchica standardizzata:

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
        'plural' => 'Nome Risorse',
    ],
    'navigation' => [
        'name' => 'Nome Menu',
        'plural' => 'Nome Menu Plurale',
        'group' => [
            'name' => 'Gruppo Menu',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'heroicon-o-icon-name',
        'sort' => 10, // Ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Testo placeholder',
            'helper_text' => 'Testo di aiuto',
            'hint' => 'Suggerimento',
        ],
        // Altri campi...
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Etichetta Azione',
            'tooltip' => 'Descrizione tooltip',
            'success_message' => 'Messaggio di successo',
            'error_message' => 'Messaggio di errore',
        ],
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

## Elementi Obbligatori

1. **Dichiarazione di Strict Types**
   - Ogni file DEVE iniziare con `<?php` seguito da `declare(strict_types=1);`

2. **Sezione Resource**
   - Definisce il nome singolare e plurale della risorsa
   - Obbligatoria in tutti i file

3. **Sezione Navigation**
   - Contiene tutte le informazioni per la visualizzazione nel menu
   - Include: name, plural, group, label, icon e sort

## Regole per le Sezioni Specifiche

### Fields (Campi)
- Ogni campo deve avere almeno una `label`
- I nomi dei campi devono essere in snake_case
- Ogni campo può avere: placeholder, helper_text, hint

### Actions (Azioni)
- Ogni azione deve avere almeno una `label`
- I nomi delle azioni devono essere in snake_case
- Le azioni possono avere: tooltip, success_message, error_message

## Esempi Corretti

### File: whatsapp.php (Risorsa generale)
```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'WhatsApp',
        'plural' => 'WhatsApp',
    ],
    'navigation' => [
        'name' => 'WhatsApp',
        'plural' => 'WhatsApp',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione delle notifiche'
        ],
        'label' => 'WhatsApp',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 10,
    ],
    // Altre sezioni...
];
```

### File: send_whatsapp.php (Pagina di invio)
```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio WhatsApp',
        'plural' => 'Invio WhatsApp',
    ],
    'navigation' => [
        'name' => 'Invio WhatsApp',
        'plural' => 'Invio WhatsApp',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche'
        ],
        'label' => 'Invio WhatsApp',
        'icon' => 'heroicon-o-paper-airplane',
        'sort' => 20,
    ],
    'fields' => [
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Scrivi il messaggio',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia',
            'success_message' => 'Messaggio inviato con successo',
            'error_message' => 'Errore nell\'invio del messaggio',
        ],
    ],
    // Altre sezioni...
];
```

## Riferimenti
- [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
