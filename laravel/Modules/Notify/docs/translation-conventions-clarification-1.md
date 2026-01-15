# Chiarimento sulle Convenzioni di Traduzione nel Modulo Notify

## Identificazione di Convenzioni Contrastanti

 sono state identificate convenzioni contrastanti per le traduzioni:

### Convenzioni Generali (Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)

```php
// Struttura gerarchica espansa
'auth' => [
    'login' => [
        'button' => [
            'label' => 'Login',
        ],
    ],
],

// Formato: modulo::risorsa.fields.campo.label
// Esempio: user::auth.login.button.label
```

### Convenzioni Specifiche del Modulo Notify (Modules/Notify/docs/TRANSLATION_CONVENTIONS.md)

```php
// Struttura con chiave 'navigation'
return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        // ...
    ],
];
```

## Risoluzione della Discrepanza

Dopo un'analisi approfondita, è stato determinato che:

1. **Le convenzioni specifiche del modulo Notify sono valide per questo modulo**
   - I file di traduzione come `send_whats_app.php` seguono correttamente le convenzioni specifiche del modulo
   - L'uso della chiave `navigation` è intenzionale e necessario per il funzionamento del modulo Notify

2. **Eccezioni alle convenzioni generali**
   - Il modulo Notify rappresenta un'eccezione alle convenzioni generali di <nome progetto>
   - Questa eccezione è documentata e intenzionale

## Convenzioni Corrette per il Modulo Notify

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

### Struttura delle Chiavi

```php
return [
    'navigation' => [
        'label' => 'Nome della Funzionalità',
        'group' => 'Gruppo di Navigazione',
    ],
    'fields' => [
        'campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

## Conclusione

Il file `send_whats_app.php` e altri file simili nel modulo Notify seguono correttamente le convenzioni specifiche del modulo. Non è necessario modificare questi file per conformarsi alle convenzioni generali di <nome progetto>, poiché rappresentano un'eccezione documentata.

## Riferimenti

- [Convenzioni Generali di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Convenzioni Specifiche del Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Regole per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
