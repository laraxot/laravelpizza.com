# Convenzioni per le Traduzioni del Modulo Notify

## Regole Fondamentali
- Le chiavi di traduzione devono essere in inglese, strutturate e gerarchiche (es. `notify.send_whatsapp.label`).
- I valori devono essere localizzati in italiano naturale e descrittivo.
- Non usare mai chiavi tecniche o placeholder come `.navigation`.
- I file di traduzione devono essere raggruppati per contesto (es. `notify.php`, `whatsapp.php`, `sms.php`), non per singola view o azione.
- Non lasciare mai file o cartelle di backup/temp/corrected nel repository.

## Esempio Corretto
```php
// notify.php
return [
    'send_whatsapp' => [
        'label' => 'Invio WhatsApp',
        'group' => 'Notifiche',
        'description' => 'Invia un messaggio WhatsApp tramite provider configurato',
    ],
    'send_sms' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
        'description' => 'Invia un SMS tramite provider configurato',
    ],
];
```

## Errori Comuni
- Chiavi come `'label' => 'send whats app.navigation'` sono errate: non sono localizzate e non seguono lo standard.
- File di traduzione per singola view/azione generano confusione e ridondanza.
- Cartelle di backup/temp/corrected non devono mai essere committate.

## Motivazione
- Facilita la manutenzione e la localizzazione multi-lingua.
- Migliora l'esperienza utente e la coerenza del progetto.
- Permette automazione e refactoring sicuri.

## Checklist PR
- Nessun file di traduzione deve contenere chiavi tecniche o placeholder.
- Tutte le chiavi devono essere localizzate e strutturate.
- I file devono essere raggruppati per contesto.
- Nessuna cartella di backup/temp/corrected nel repository.

## Struttura dei File di Traduzione

Tutti i file di traduzione nel modulo Notify devono seguire una struttura gerarchica precisa e convenzioni di naming specifiche per garantire la corretta applicazione automatica delle traduzioni tramite il LangServiceProvider.

## Regole Fondamentali

1. **Nomi dei File**
   - I nomi dei file devono essere in snake_case
   - Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
   - ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`
   - ❌ ERRATO: `send_s_m_s.php`, `send_a_w_s_email.php`

2. **Struttura Gerarchica**
   - Ogni file deve seguire la struttura gerarchica standard:
     ```php
     return [
         'navigation' => [
             'label' => 'Invio SMS',
             'group' => 'Notifiche',
         ],
         'fields' => [
             'to' => [
                 'label' => 'Destinatario',
                 'placeholder' => 'Inserisci il numero di telefono',
                 'helper_text' => 'Numero di telefono del destinatario',
             ],
             // Altri campi...
         ],
         'actions' => [
             'send' => [
                 'label' => 'Invia SMS',
                 'tooltip' => 'Invia un messaggio SMS al destinatario',
             ],
             // Altre azioni...
         ],
         // Altre sezioni...
     ];
     ```

3. **Convenzioni per le Chiavi**
   - Utilizzare snake_case per tutte le chiavi
   - Non utilizzare traduzioni statiche nelle chiavi (es. `'label' => 'send sms.navigation'`)
   - Evitare abbreviazioni non standard

## Esempio di Implementazione Corretta

### File: `/lang/it/send_sms.php`
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Test',
    ],
    'fields' => [
        'from' => [
            'label' => 'Mittente',
            'placeholder' => 'Inserisci il mittente',
            'helper_text' => 'Nome o numero del mittente',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci il numero di telefono',
            'helper_text' => 'Numero di telefono del destinatario',
        ],
        'body' => [
            'label' => 'Testo del messaggio',
            'placeholder' => 'Inserisci il testo del messaggio',
            'helper_text' => 'Il testo da inviare via SMS',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia SMS',
            'tooltip' => 'Invia un messaggio SMS al destinatario',
        ],
    ],
    'messages' => [
        'success' => 'SMS inviato con successo a :recipient',
        'error' => 'Errore durante l\'invio dell\'SMS: :error',
    ],
];
```

### File: `/lang/en/send_sms.php`
```php
<?php

return [
    'navigation' => [
        'label' => 'Send SMS',
        'group' => 'Test',
    ],
    'fields' => [
        'from' => [
            'label' => 'From',
            'placeholder' => 'Enter sender',
            'helper_text' => 'Sender name or number',
        ],
        'to' => [
            'label' => 'To',
            'placeholder' => 'Enter phone number',
            'helper_text' => 'Recipient phone number',
        ],
        'body' => [
            'label' => 'Message body',
            'placeholder' => 'Enter message text',
            'helper_text' => 'Text to send via SMS',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Send SMS',
            'tooltip' => 'Send an SMS message to the recipient',
        ],
    ],
    'messages' => [
        'success' => 'SMS successfully sent to :recipient',
        'error' => 'Error sending SMS: :error',
    ],
];
```

## Linee Guida per le Pagine Filament

Per le pagine Filament nel cluster Test, la struttura delle traduzioni deve essere:

```php
return [
    'navigation' => [
        'label' => 'Nome della pagina', // Visualizzato nella navigazione
        'group' => 'Nome del gruppo',   // Gruppo di navigazione
    ],
    'fields' => [
        // Campi del form...
    ],
    'actions' => [
        // Azioni della pagina...
    ],
    'messages' => [
        // Messaggi di feedback...
    ],
];
```

## Accesso alle Traduzioni nel Codice

Evitare l'uso di funzioni di traduzione dirette nel codice. Il LangServiceProvider gestisce automaticamente le traduzioni in base ai nomi dei campi e dei componenti.

### ❌ ERRATO
```php
TextInput::make('to')
    ->label(__('notify::send_sms.fields.to.label'))
```

### ✅ CORRETTO
```php
TextInput::make('to') // La traduzione viene applicata automaticamente
```

## Verifica delle Traduzioni

Per verificare se le traduzioni sono applicate correttamente:

1. Impostare la lingua dell'applicazione (tramite URL o preferenze utente)
2. Verificare che i componenti dell'interfaccia utente visualizzino le etichette tradotte
3. Controllare che tutti i messaggi di sistema siano tradotti

## Riferimenti

- [<nome progetto> Translation System](../../../../.cursor/rules/translations.rule)
- [Filament Translations](../../../../.cursor/rules/filament-translations.rule)
- [Laravel Localization](https://laravel.com/docs/10.x/localization)

## Nota sui collegamenti

Tutti i collegamenti nei file `.md` **devono essere relativi** rispetto alla posizione del file stesso, per garantire portabilità e funzionamento sia su GitHub che in locale. Non usare mai path assoluti o riferimenti hardcoded alla root del progetto.

## Politica
La politica del progetto è garantire inclusività, accessibilità e rispetto per tutte le culture e le diversità linguistiche. Ogni traduzione deve essere pensata per essere neutra, rispettosa e non discriminatoria.

## Filosofia
Crediamo nella chiarezza, nella semplicità e nella trasparenza. Ogni stringa tradotta deve aiutare l'utente a sentirsi accolto e guidato, senza ambiguità o tecnicismi inutili.

## Religione
Il sistema di traduzioni è laico e neutrale rispetto a ogni credo. Non sono ammesse espressioni, simboli o riferimenti religiosi, salvo esplicita richiesta di progetto e sempre nel rispetto di tutte le fedi.

## Etica
Le traduzioni devono essere oneste, non ingannevoli, non manipolatorie e non offensive. L'etica del progetto impone di evitare ogni forma di linguaggio discriminatorio, sessista, razzista o che possa ledere la dignità della persona.

## Zen
La traduzione perfetta è quella che non si nota: è naturale, fluida, non distrae e non crea attrito. Ogni parola superflua va eliminata, ogni concetto va reso con la massima semplicità e armonia.
