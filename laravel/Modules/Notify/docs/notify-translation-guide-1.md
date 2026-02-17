# Guida alle Traduzioni nel Modulo Notify

## Introduzione

Questo documento fornisce una guida completa e dettagliata per la gestione delle traduzioni nel modulo Notify di <nome progetto>. Il modulo Notify segue convenzioni specifiche che rappresentano un'eccezione documentata alle convenzioni generali di <nome progetto>.

## Struttura dei File di Traduzione

### Tipi di File

Nel modulo Notify, esistono due tipi principali di file di traduzione:

1. **File Funzionali**: Descrivono funzionalità specifiche e utilizzano il prefisso `send_`
   - Esempi: `send_sms.php`, `send_whatsapp.php`, `send_email.php`
   - Questi file contengono traduzioni relative a funzionalità di invio di notifiche

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `sms.php`, `whatsapp.php`, `email.php`
   - Questi file contengono traduzioni relative a entità o risorse specifiche

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

## Struttura delle Chiavi

La struttura delle chiavi nei file di traduzione del modulo Notify segue questo pattern:

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
            'description' => 'Descrizione del campo',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

### Chiavi Principali

1. **navigation**: Contiene informazioni sulla navigazione
   - `label`: Nome visualizzato nella navigazione
   - `group`: Gruppo di navigazione a cui appartiene

2. **fields**: Contiene informazioni sui campi
   - `campo`: Nome del campo (es. `to`, `message`, `driver`)
     - `label`: Etichetta del campo
     - `placeholder`: Testo di placeholder
     - `helper_text`: Testo di aiuto
     - `description`: Descrizione del campo

3. **actions**: Contiene informazioni sulle azioni
   - `azione`: Nome dell'azione (es. `send`, `cancel`)
     - `label`: Etichetta dell'azione

## Esempi Pratici

### Esempio 1: File Funzionale (`send_sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'driver' => [
            'label' => 'Driver',
            'placeholder' => 'Seleziona driver',
            'helper_text' => 'Il driver da utilizzare per l\'invio',
            'description' => 'Driver per l\'invio degli SMS',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Il contenuto del messaggio da inviare',
            'description' => 'Contenuto del messaggio SMS',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero del destinatario',
            'helper_text' => 'Il numero di telefono del destinatario',
            'description' => 'Numero di telefono del destinatario',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia SMS',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
```

### Esempio 2: File di Risorsa (`sms.php`)

```php
<?php

return [
    'navigation' => [
        'label' => 'SMS',
        'group' => 'Notifiche',
    ],
    'fields' => [
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato',
            'helper_text' => 'Stato dell\'SMS',
            'description' => 'Stato corrente dell\'SMS',
        ],
        'sent_at' => [
            'label' => 'Data invio',
            'placeholder' => 'Data invio',
            'helper_text' => 'Data e ora di invio dell\'SMS',
            'description' => 'Data e ora di invio dell\'SMS',
        ],
    ],
];
```

## Eccezione alle Convenzioni Generali

È importante notare che questa struttura rappresenta un'eccezione documentata alle convenzioni generali di <nome progetto>. Mentre le convenzioni generali (descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`) prevedono una struttura gerarchica espansa senza chiavi come `.navigation`, il modulo Notify utilizza intenzionalmente questa struttura specifica.

### Motivazione dell'Eccezione

Questa eccezione è stata implementata per:

1. **Compatibilità con il codice esistente**: Il modulo Notify è stato sviluppato con questa struttura specifica
2. **Coerenza interna**: Tutti i file di traduzione nel modulo Notify seguono questa struttura
3. **Funzionalità specifiche**: Le funzionalità di invio notifiche richiedono una struttura specifica per le traduzioni

## Best Practices

1. **Coerenza**: Mantenere la coerenza con i file esistenti nel modulo Notify
2. **Completezza**: Includere tutte le chiavi necessarie per ogni campo o azione
3. **Chiarezza**: Utilizzare nomi descrittivi per le chiavi
4. **Documentazione**: Documentare chiaramente qualsiasi eccezione o caso particolare

## Verifica delle Traduzioni

Per verificare che le traduzioni siano correttamente implementate, è possibile utilizzare il seguente comando Artisan:

```bash
php artisan lang:check --module=Notify
```

Questo comando verificherà che tutte le chiavi di traduzione necessarie siano presenti in tutti i file di traduzione.

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Chiarimento sulle Convenzioni di Traduzione](./TRANSLATION_CONVENTIONS_CLARIFICATION.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Standard per le Traduzioni ](./TRANSLATION_STANDARDS.md)
