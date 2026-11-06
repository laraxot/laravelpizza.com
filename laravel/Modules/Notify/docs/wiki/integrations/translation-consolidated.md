---
qmd: "translation consolidated"
issues: []
discussions: []
title: "translation: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# translation: Consolidated Documentation

Consolidated from **51** individual files.

## Table of Contents

- [Piano di Pulizia e Standardizzazione delle Traduzioni](#translation-cleanup-plan-1)
- [---](#translation-cleanup-plan-2)
- [Piano di Pulizia e Standardizzazione delle Traduzioni](#translation-cleanup-plan)
- [Convenzioni per le Traduzioni del Modulo Notify](#translation-conventions-1)
- [---](#translation-conventions-2)
- [Chiarimento sulle Convenzioni di Traduzione nel Modulo Notify](#translation-conventions-clarification-1)
- [---](#translation-conventions-clarification-2)
- [Chiarimento sulle Convenzioni di Traduzione nel Modulo Notify](#translation-conventions-clarification)
- [Convenzioni per le Traduzioni del Modulo Notify](#translation-conventions)
- [Deprecated](#translation-file-correction-guide-1)
- [---](#translation-file-correction-guide-2)
- [Guida alla Correzione dei File di Traduzione](#translation-file-correction-guide)
- [Guida alla Correzione dei File di Traduzione](#translation-file-correction)
- [---](#translation-file-naming-rules-1)
- [Regole di Naming per i File di Traduzione](#translation-file-naming-rules)
- [Regole di Naming per i File di Traduzione](#translation-file-naming)
- [---](#translation-file-structure-guide-1)
- [Guida alla Struttura dei File di Traduzione](#translation-file-structure-guide)
- [Guida alla Struttura dei File di Traduzione](#translation-file-structure)
- [Deprecated](#translation-implementation-plan-1)
- [---](#translation-implementation-plan-2)
- [Piano di Implementazione per la Standardizzazione delle Traduzioni](#translation-implementation-plan)
- [---](#translation-keys-best-practices-1)
- [Best Practices per le Chiavi di Traduzione](#translation-keys-best-practices)
- [---](#translation-keys-rules-1)
- [---](#translation-keys-rules)
- [---](#translation-keys)
- [Translation Namespace Philosophy: La Religione del Dominio](#translation-namespace-religion)
- [Standard per le Traduzioni](#translation-standards-1)
- [---](#translation-standards-2)
- [Progresso Standardizzazione Traduzioni](#translation-standards-progress-1)
- [---](#translation-standards-progress-2)
- [Progresso Standardizzazione Traduzioni](#translation-standards-progress)
- [Standard per le Traduzioni ](#translation-standards)
- [Piano di Pulizia e Standardizzazione delle Traduzioni](#translation_cleanup_plan)
- [Convenzioni per le Traduzioni del Modulo Notify](#translation_conventions)
- [Chiarimento sulle Convenzioni di Traduzione nel Modulo Notify](#translation_conventions_clarification)
- [Guida alla Correzione dei File di Traduzione](#translation_file_correction_guide)
- [Regole di Naming per i File di Traduzione](#translation_file_naming_rules)
- [Guida alla Struttura dei File di Traduzione](#translation_file_structure_guide)
- [Piano di Implementazione per la Standardizzazione delle Traduzioni](#translation_implementation_plan)
- [Best Practices per le Chiavi di Traduzione](#translation_keys_best_practices)
- [---](#translation_keys_rules)
- [<<<<<<< HEAD](#translation_standards)
- [Progresso Standardizzazione Traduzioni](#translation_standards_progress)
- [Stato dell'Implementazione delle Traduzioni nel Modulo Notify](#translations-implementation-status-1)
- [---](#translations-implementation-status-2)
- [Stato dell'Implementazione delle Traduzioni nel Modulo Notify](#translations-implementation-status)
- [Stato dell'Implementazione delle Traduzioni nel Modulo Notify](#translations-implementation)
- [Traduzioni del Modulo Notify](#translations)
- [Stato dell'Implementazione delle Traduzioni nel Modulo Notify](#translations_implementation_status)

---

## translation-cleanup-plan-1

*Consolidated from: `translation-cleanup-plan.md`*


Questo documento descrive il piano di pulizia e standardizzazione delle traduzioni italiane nel modulo Notify di <nome progetto>.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione nella cartella `Modules/Notify/lang/it`, sono stati identificati i seguenti problemi:

### 1. File con Nomi Errati
- `send_s_m_s.php` invece di `send_sms.php`
- `send_a_w_s_email.php` invece di `send_aws_email.php`
- `send_whats_app.php` invece di `send_whatsapp.php`
- `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

### 2. File Duplicati
- Esistono sia `send_s_m_s.php` che `send_sms.php`
- Esistono sia `send_a_w_s_email.php` che `send_aws_email.php`
- Esistono sia `send_netfun_s_m_s.php` che `send_netfun_sms.php`

### 3. File Senza Nome
- `.php` (file senza nome)

### 4. Struttura Non Standardizzata
- Alcuni file utilizzano array piatti
- Altri utilizzano strutture nidificate
- Manca la dichiarazione `declare(strict_types=1);` in molti file

### 5. Directory Non Necessarie
- `backup`, `corrected`, `temp` (directory temporanee)

## Piano di Azione

### Fase 1: Backup dei File Esistenti
- Creare un backup completo di tutti i file di traduzione prima di procedere con le modifiche

### Fase 2: Rimozione dei File Errati e Duplicati
- Rimuovere i file con nomi errati dopo aver verificato che il contenuto sia stato migrato nei file con nomi corretti
- Rimuovere il file senza nome `.php`

### Fase 3: Standardizzazione della Struttura dei File
- Aggiungere `declare(strict_types=1);` a tutti i file
- Convertire tutti gli array piatti in strutture nidificate
- Assicurarsi che tutti i file seguano lo stesso formato

### Fase 4: Pulizia delle Directory Temporanee
- Rimuovere le directory temporanee `backup`, `corrected` e `temp` dopo aver verificato che non contengano informazioni importanti

### Fase 5: Verifica della Coerenza con i File Inglesi
- Assicurarsi che per ogni file italiano esista un corrispondente file inglese
- Verificare che le chiavi di traduzione siano coerenti tra le versioni italiana e inglese

## Struttura Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
        'plural' => 'Nome Risorsa (plurale)',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

## Implementazione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.

---

## translation-cleanup-plan-2

*Consolidated from: `translation-cleanup-plan.md`*

title: "Translation Cleanup Plan"
type: concept
tags: [translation, cleanup, plan]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-cleanup-plan-2 translation cleanup plan"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Translation Cleanup Plan

Plan for cleaning up and standardizing translations across the module.
---

## translation-cleanup-plan

*Consolidated from: `translation-cleanup-plan.md`*


Questo documento descrive il piano di pulizia e standardizzazione delle traduzioni italiane nel modulo Notify di App.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione nella cartella `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it`, sono stati identificati i seguenti problemi:
Questo documento descrive il piano di pulizia e standardizzazione delle traduzioni italiane nel modulo Notify di Quaeris.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione nella cartella `/var/www/html/Quaeris/laravel/Modules/Notify/lang/it`, sono stati identificati i seguenti problemi:

### 1. File con Nomi Errati
- `send_s_m_s.php` invece di `send_sms.php`
- `send_a_w_s_email.php` invece di `send_aws_email.php`
- `send_whats_app.php` invece di `send_whatsapp.php`
- `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

### 2. File Duplicati
- Esistono sia `send_s_m_s.php` che `send_sms.php`
- Esistono sia `send_a_w_s_email.php` che `send_aws_email.php`
- Esistono sia `send_netfun_s_m_s.php` che `send_netfun_sms.php`

### 3. File Senza Nome
- `.php` (file senza nome)

### 4. Struttura Non Standardizzata
- Alcuni file utilizzano array piatti
- Altri utilizzano strutture nidificate
- Manca la dichiarazione `declare(strict_types=1);` in molti file

### 5. Directory Non Necessarie
- `backup`, `corrected`, `temp` (directory temporanee)

## Piano di Azione

### Fase 1: Backup dei File Esistenti
- Creare un backup completo di tutti i file di traduzione prima di procedere con le modifiche

### Fase 2: Rimozione dei File Errati e Duplicati
- Rimuovere i file con nomi errati dopo aver verificato che il contenuto sia stato migrato nei file con nomi corretti
- Rimuovere il file senza nome `.php`

### Fase 3: Standardizzazione della Struttura dei File
- Aggiungere `declare(strict_types=1);` a tutti i file
- Convertire tutti gli array piatti in strutture nidificate
- Assicurarsi che tutti i file seguano lo stesso formato

### Fase 4: Pulizia delle Directory Temporanee
- Rimuovere le directory temporanee `backup`, `corrected` e `temp` dopo aver verificato che non contengano informazioni importanti

### Fase 5: Verifica della Coerenza con i File Inglesi
- Assicurarsi che per ogni file italiano esista un corrispondente file inglese
- Verificare che le chiavi di traduzione siano coerenti tra le versioni italiana e inglese

## Struttura Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
        'plural' => 'Nome Risorsa (plurale)',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

## Implementazione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.

---

## translation-conventions-1

*Consolidated from: `translation-conventions.md`*


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

---

## translation-conventions-2

*Consolidated from: `translation-conventions.md`*

title: "Translation Conventions"
type: concept
tags: [translation, conventions]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-conventions-2 translation conventions"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Translation Conventions

Conventions for naming and structure of translation keys.
---

## translation-conventions-clarification-1

*Consolidated from: `translation-conventions-clarification.md`*


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
- [Convenzioni Generali di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Convenzioni Specifiche del Modulo Notify](../../translation_conventions.md)
- [Regole per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)

---

## translation-conventions-clarification-2

*Consolidated from: `translation-conventions-clarification.md`*

title: "Chiarimento sulle Convenzioni di Traduzione nel Modulo Notify"
type: concept
tags: [translation, conventions, clarification]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-conventions-clarification-2 chiarimento sulle convenzioni di traduzione nel modulo notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

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
- Il modulo Notify rappresenta un'eccezione alle convenzioni generali di App
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

- [Convenzioni Generali di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Convenzioni Specifiche del Modulo Notify](./translation-conventions.md)
- [Regole per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni Generali di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Convenzioni Specifiche del Modulo Notify](./translation-conventions.md)
- [Regole per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)
Il file `send_whats_app.php` e altri file simili nel modulo Notify seguono correttamente le convenzioni specifiche del modulo. Non è necessario modificare questi file per conformarsi alle convenzioni generali di App, poiché rappresentano un'eccezione documentata.

## Riferimenti

- [Convenzioni Generali di Traduzione](../../lang/docs/translation-keys-rules.md)
- [Convenzioni Specifiche del Modulo Notify](./translation-conventions.md)
- [Regole per le Chiavi di Traduzione](../../lang/docs/translation-keys-best-practices.md)
---

## translation-conventions-clarification

*Consolidated from: `translation-conventions-clarification.md`*


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
   - Il modulo Notify rappresenta un'eccezione alle convenzioni generali di
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

Il file `send_whats_app.php` e altri file simili nel modulo Notify seguono correttamente le convenzioni specifiche del modulo. Non è necessario modificare questi file per conformarsi alle convenzioni generali di , poiché rappresentano un'eccezione documentata.
Il file `send_whats_app.php` e altri file simili nel modulo Notify seguono correttamente le convenzioni specifiche del modulo. Non è necessario modificare questi file per conformarsi alle convenzioni generali di <nome progetto>, poiché rappresentano un'eccezione documentata.

## Riferimenti

- [Convenzioni Generali di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Convenzioni Specifiche del Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Regole per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni Generali di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Convenzioni Specifiche del Modulo Notify](../../translation_conventions.md)
- [Regole per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)
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
   - Il modulo Notify rappresenta un'eccezione alle convenzioni generali di <main module>
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

Il file `send_whats_app.php` e altri file simili nel modulo Notify seguono correttamente le convenzioni specifiche del modulo. Non è necessario modificare questi file per conformarsi alle convenzioni generali di <main module>, poiché rappresentano un'eccezione documentata.

## Riferimenti

- [Convenzioni Generali di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Convenzioni Specifiche del Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Regole per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni Generali di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Convenzioni Specifiche del Modulo Notify](../../translation_conventions.md)
- [Regole per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)

---

## translation-conventions

*Consolidated from: `translation-conventions.md`*


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

- [ Translation System](../../../../.cursor/rules/translations.rule)
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

---

## translation-file-correction-guide-1

*Consolidated from: `translation-file-correction-guide.md`*
*Consolidated from: `translation-file-correction-guide-deprecated.md`*


This file is deprecated.

Use:

- [translation-file-correction-guide](./translation-file-correction-guide.md)
- [translation-file-correction-guide](../../translation-file-correction-guide.md)

---

## translation-file-correction-guide-2

*Consolidated from: `translation-file-correction-guide.md`*

title: "Guida alla Correzione dei File di Traduzione"
type: guide
tags: [translation, file, correction, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-file-correction-guide-2 guida alla correzione dei file di traduzione"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Guida alla Correzione dei File di Traduzione

## Procedura Sistematica per la Standardizzazione

Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di <nome progetto>.
Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di App.

## Passo 1: Analisi del File Esistente

Prima di apportare modifiche, analizzare il file esistente per:
1. Verificare il nome del file (rispetta le convenzioni snake_case?)
2. Identificare la struttura attuale (quali sezioni sono presenti?)
3. Identificare i contenuti da preservare (etichette, messaggi, ecc.)

## Passo 2: Correzione di File con Naming Errato

Se il file ha un nome non conforme:

```bash

# 1. Creare un nuovo file con il nome corretto
touch /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/nome_corretto.php
touch /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/nome_corretto.php
touch /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/it/nome_corretto.php

# 2. Copiare e correggere il contenuto

# (vedere Passo 3 per la struttura corretta)

# 3. Verificare che non ci siano riferimenti al vecchio file
grep -r "nome_errato" /var/www/html/<nome progetto>/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" /var/www/_bases/<nome repository>/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" /var/www/html/_bases/<nome repository>/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/it/nome_errato.php
```

## Passo 3: Correzione della Struttura del File

Ogni file deve seguire questa struttura completa:

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
        'sort' => 10,
    ],
    'fields' => [
        // Campi specifici del file
    ],
    'actions' => [
        // Azioni specifiche del file
    ],
    'messages' => [
        // Messaggi specifici del file
    ],
];
```

## Passo 4: Verifica della Coerenza tra Lingue

Dopo aver corretto un file in italiano, verificare e aggiornare la versione inglese:

```bash

# 1. Controllare se esiste il file inglese
ls /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/en/nome_file.php
ls /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/en/nome_file.php
ls /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/en/nome_file.php

# 2. Se esiste, aggiornarlo con la stessa struttura

# 3. Se non esiste, crearlo con la traduzione inglese dei messaggi italiani
```

## Passo 5: Test delle Modifiche

Dopo ogni correzione:

1. Verificare che l'interfaccia utente visualizzi correttamente le etichette
2. Verificare che tutte le traduzioni siano disponibili in tutte le lingue
3. Verificare che non ci siano errori di visualizzazione

## Esempi di Correzione

### Esempio 1: File con Naming Errato

**Originale**: `send_whats_app.php`
**Corretto**: `send_whatsapp.php`

### Esempio 2: File con Struttura Incompleta

**Originale**:
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
];
```

**Corretto**:
```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    ],
    'navigation' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 15,
    ],
    // Altre sezioni...
];
```

## Lista di Priorità per le Correzioni

1. File con naming errato (urgente)
2. File con struttura completamente mancante (alta priorità)
3. File con struttura parziale (media priorità)
4. Allineamento dei file in inglese (dopo la correzione italiana)

## Riferimenti

- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](./translation-standards-progress.md)
- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](./translation-standards-progress.md)
- [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](../../translation-standards-progress.md)
- [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](../../translation-standards-progress.md)
---

## translation-file-correction-guide

*Consolidated from: `translation-file-correction-guide.md`*


## Procedura Sistematica per la Standardizzazione

Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di .
Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di <nome progetto>.

## Passo 1: Analisi del File Esistente

Prima di apportare modifiche, analizzare il file esistente per:
1. Verificare il nome del file (rispetta le convenzioni snake_case?)
2. Identificare la struttura attuale (quali sezioni sono presenti?)
3. Identificare i contenuti da preservare (etichette, messaggi, ecc.)

## Passo 2: Correzione di File con Naming Errato

Se il file ha un nome non conforme:

```bash

# 1. Creare un nuovo file con il nome corretto
touch Modules/Notify/lang/it/nome_corretto.php

# 2. Copiare e correggere il contenuto

# (vedere Passo 3 per la struttura corretta)

# 3. Verificare che non ci siano riferimenti al vecchio file
grep -r "nome_errato" Modules/Notify

# 4. Rimuovere il file con naming errato
rm Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" Modules/Notify

# 4. Rimuovere il file con naming errato
rm Modules/Notify/lang/it/nome_errato.php
```

## Passo 3: Correzione della Struttura del File

Ogni file deve seguire questa struttura completa:

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
        'sort' => 10,
    ],
    'fields' => [
        // Campi specifici del file
    ],
    'actions' => [
        // Azioni specifiche del file
    ],
    'messages' => [
        // Messaggi specifici del file
    ],
];
```

## Passo 4: Verifica della Coerenza tra Lingue

Dopo aver corretto un file in italiano, verificare e aggiornare la versione inglese:

```bash

# 1. Controllare se esiste il file inglese
ls Modules/Notify/lang/en/nome_file.php

# 2. Se esiste, aggiornarlo con la stessa struttura

# 3. Se non esiste, crearlo con la traduzione inglese dei messaggi italiani
```

## Passo 5: Test delle Modifiche

Dopo ogni correzione:

1. Verificare che l'interfaccia utente visualizzi correttamente le etichette
2. Verificare che tutte le traduzioni siano disponibili in tutte le lingue
3. Verificare che non ci siano errori di visualizzazione

## Esempi di Correzione

### Esempio 1: File con Naming Errato

**Originale**: `send_whats_app.php`
**Corretto**: `send_whatsapp.php`

### Esempio 2: File con Struttura Incompleta

**Originale**:
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
];
```

**Corretto**:
```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    ],
    'navigation' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 15,
    ],
    // Altre sezioni...
];
```

## Lista di Priorità per le Correzioni

1. File con naming errato (urgente)
2. File con struttura completamente mancante (alta priorità)
3. File con struttura parziale (media priorità)
4. Allineamento dei file in inglese (dopo la correzione italiana)

## Riferimenti

- [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
- [Guida alla Struttura dei File di Traduzione](./TRANSLATION_FILE_STRUCTURE_GUIDE.md)
- [Progresso della Standardizzazione](./TRANSLATION_STANDARDS_PROGRESS.md)
- [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
- [Guida alla Struttura dei File di Traduzione](../../translation_file_structure_guide.md)
- [Progresso della Standardizzazione](../../translation_standards_progress.md)
# Guida alla Correzione dei File di Traduzione

## Procedura Sistematica per la Standardizzazione

Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di <nome progetto>.

## Passo 1: Analisi del File Esistente

Prima di apportare modifiche, analizzare il file esistente per:
1. Verificare il nome del file (rispetta le convenzioni snake_case?)
2. Identificare la struttura attuale (quali sezioni sono presenti?)
3. Identificare i contenuti da preservare (etichette, messaggi, ecc.)

## Passo 2: Correzione di File con Naming Errato

Se il file ha un nome non conforme:

```bash

# 1. Creare un nuovo file con il nome corretto
touch Modules/Notify/lang/it/nome_corretto.php

# 2. Copiare e correggere il contenuto

# (vedere Passo 3 per la struttura corretta)

# 3. Verificare che non ci siano riferimenti al vecchio file
grep -r "nome_errato" Modules/Notify

# 4. Rimuovere il file con naming errato
rm Modules/Notify/lang/it/nome_errato.php

grep -r "nome_errato" Modules/Notify

rm Modules/Notify/lang/it/nome_errato.php

grep -r "nome_errato" Modules/Notify

rm Modules/Notify/lang/it/nome_errato.php
```

## Passo 3: Correzione della Struttura del File

Ogni file deve seguire questa struttura completa:

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
        'label' => 'Etichetta Menu',
        'icon' => 'heroicon-o-icon-name',
        'sort' => 10,
    'fields' => [
        // Campi specifici del file
    ],
    'actions' => [
        // Azioni specifiche del file
    'messages' => [
        // Messaggi specifici del file
];
```

## Passo 4: Verifica della Coerenza tra Lingue

Dopo aver corretto un file in italiano, verificare e aggiornare la versione inglese:

```bash

# 1. Controllare se esiste il file inglese
ls Modules/Notify/lang/en/nome_file.php

# 2. Se esiste, aggiornarlo con la stessa struttura

# 3. Se non esiste, crearlo con la traduzione inglese dei messaggi italiani

## Passo 5: Test delle Modifiche

Dopo ogni correzione:

1. Verificare che l'interfaccia utente visualizzi correttamente le etichette
2. Verificare che tutte le traduzioni siano disponibili in tutte le lingue
3. Verificare che non ci siano errori di visualizzazione

## Esempi di Correzione

### Esempio 1: File con Naming Errato

**Originale**: `send_whats_app.php`
**Corretto**: `send_whatsapp.php`

### Esempio 2: File con Struttura Incompleta

**Originale**:
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
];
```

**Corretto**:

declare(strict_types=1);

    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    'navigation' => [
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 15,
    // Altre sezioni...
];
```

## Lista di Priorità per le Correzioni

1. File con naming errato (urgente)
2. File con struttura completamente mancante (alta priorità)
3. File con struttura parziale (media priorità)
4. Allineamento dei file in inglese (dopo la correzione italiana)

## Riferimenti

- [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
- [Guida alla Struttura dei File di Traduzione](./TRANSLATION_FILE_STRUCTURE_GUIDE.md)
- [Progresso della Standardizzazione](./TRANSLATION_STANDARDS_PROGRESS.md)
- [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
- [Guida alla Struttura dei File di Traduzione](../../translation_file_structure_guide.md)
- [Progresso della Standardizzazione](../../translation_standards_progress.md)

---

## translation-file-correction

*Consolidated from: `translation-file-correction.md`*


## Procedura Sistematica per la Standardizzazione

Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di .
Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di <nome progetto>.

## Passo 1: Analisi del File Esistente

Prima di apportare modifiche, analizzare il file esistente per:
1. Verificare il nome del file (rispetta le convenzioni snake_case?)
2. Identificare la struttura attuale (quali sezioni sono presenti?)
3. Identificare i contenuti da preservare (etichette, messaggi, ecc.)

## Passo 2: Correzione di File con Naming Errato

Se il file ha un nome non conforme:

```bash

# 1. Creare un nuovo file con il nome corretto
touch Modules/Notify/lang/it/nome_corretto.php

# 2. Copiare e correggere il contenuto

# (vedere Passo 3 per la struttura corretta)

# 3. Verificare che non ci siano riferimenti al vecchio file
grep -r "nome_errato" Modules/Notify

# 4. Rimuovere il file con naming errato
rm Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" Modules/Notify

# 4. Rimuovere il file con naming errato
rm Modules/Notify/lang/it/nome_errato.php
```

## Passo 3: Correzione della Struttura del File

Ogni file deve seguire questa struttura completa:

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
        'sort' => 10,
    ],
    'fields' => [
        // Campi specifici del file
    ],
    'actions' => [
        // Azioni specifiche del file
    ],
    'messages' => [
        // Messaggi specifici del file
    ],
];
```

## Passo 4: Verifica della Coerenza tra Lingue

Dopo aver corretto un file in italiano, verificare e aggiornare la versione inglese:

```bash

# 1. Controllare se esiste il file inglese
ls Modules/Notify/lang/en/nome_file.php

# 2. Se esiste, aggiornarlo con la stessa struttura

# 3. Se non esiste, crearlo con la traduzione inglese dei messaggi italiani
```

## Passo 5: Test delle Modifiche

Dopo ogni correzione:

1. Verificare che l'interfaccia utente visualizzi correttamente le etichette
2. Verificare che tutte le traduzioni siano disponibili in tutte le lingue
3. Verificare che non ci siano errori di visualizzazione

## Esempi di Correzione

### Esempio 1: File con Naming Errato

**Originale**: `send_whats_app.php`
**Corretto**: `send_whatsapp.php`

### Esempio 2: File con Struttura Incompleta

**Originale**:
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
];
```

**Corretto**:
```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    ],
    'navigation' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 15,
    ],
    // Altre sezioni...
];
```

## Lista di Priorità per le Correzioni

1. File con naming errato (urgente)
2. File con struttura completamente mancante (alta priorità)
3. File con struttura parziale (media priorità)
4. Allineamento dei file in inglese (dopo la correzione italiana)

## Riferimenti

- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](./translation_standards_progress.md)
- [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](../../translation_standards_progress.md)
# Guida alla Correzione dei File di Traduzione

## Procedura Sistematica per la Standardizzazione

Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di <nome progetto>.

## Passo 1: Analisi del File Esistente

Prima di apportare modifiche, analizzare il file esistente per:
1. Verificare il nome del file (rispetta le convenzioni snake_case?)
2. Identificare la struttura attuale (quali sezioni sono presenti?)
3. Identificare i contenuti da preservare (etichette, messaggi, ecc.)

## Passo 2: Correzione di File con Naming Errato

Se il file ha un nome non conforme:

```bash

# 1. Creare un nuovo file con il nome corretto
touch Modules/Notify/lang/it/nome_corretto.php

# 2. Copiare e correggere il contenuto

# (vedere Passo 3 per la struttura corretta)

# 3. Verificare che non ci siano riferimenti al vecchio file
grep -r "nome_errato" Modules/Notify

# 4. Rimuovere il file con naming errato
rm Modules/Notify/lang/it/nome_errato.php

grep -r "nome_errato" Modules/Notify

rm Modules/Notify/lang/it/nome_errato.php

grep -r "nome_errato" Modules/Notify

rm Modules/Notify/lang/it/nome_errato.php
```

## Passo 3: Correzione della Struttura del File

Ogni file deve seguire questa struttura completa:

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
        'label' => 'Etichetta Menu',
        'icon' => 'heroicon-o-icon-name',
        'sort' => 10,
    'fields' => [
        // Campi specifici del file
    ],
    'actions' => [
        // Azioni specifiche del file
    'messages' => [
        // Messaggi specifici del file
];
```

## Passo 4: Verifica della Coerenza tra Lingue

Dopo aver corretto un file in italiano, verificare e aggiornare la versione inglese:

```bash

# 1. Controllare se esiste il file inglese
ls Modules/Notify/lang/en/nome_file.php

# 2. Se esiste, aggiornarlo con la stessa struttura

# 3. Se non esiste, crearlo con la traduzione inglese dei messaggi italiani

## Passo 5: Test delle Modifiche

Dopo ogni correzione:

1. Verificare che l'interfaccia utente visualizzi correttamente le etichette
2. Verificare che tutte le traduzioni siano disponibili in tutte le lingue
3. Verificare che non ci siano errori di visualizzazione

## Esempi di Correzione

### Esempio 1: File con Naming Errato

**Originale**: `send_whats_app.php`
**Corretto**: `send_whatsapp.php`

### Esempio 2: File con Struttura Incompleta

**Originale**:
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
];
```

**Corretto**:

declare(strict_types=1);

    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    'navigation' => [
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 15,
    // Altre sezioni...
];
```

## Lista di Priorità per le Correzioni

1. File con naming errato (urgente)
2. File con struttura completamente mancante (alta priorità)
3. File con struttura parziale (media priorità)
4. Allineamento dei file in inglese (dopo la correzione italiana)

## Riferimenti

- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](./translation_standards_progress.md)
- [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](../../translation_standards_progress.md)

---

## translation-file-naming-rules-1

*Consolidated from: `translation-file-naming-rules.md`*

title: "Regole di Naming per i File di Traduzione"
type: rule
tags: [translation, file, naming, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-file-naming-rules-1 regole di naming per i file di traduzione"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Regole di Naming per i File di Traduzione

## Principi Fondamentali per il Naming dei File

Le seguenti regole si applicano a tutti i file di traduzione nel modulo Notify:

1. **Snake Case Obbligatorio**
   - Tutti i nomi dei file devono utilizzare snake_case (lettere minuscole separate da underscore)
   - Esempio: `send_email.php`, `mail_template.php`

2. **Termini Composti e Acronimi**
   - Gli acronimi (SMS, AWS, ecc.) devono essere trattati come parole singole
   - I termini composti come "WhatsApp" devono essere trattati come una singola parola
   - ✅ CORRETTO: `send_whatsapp.php`, `send_sms.php`, `send_aws_email.php`
   - ❌ ERRATO: `send_whats_app.php`, `send_s_m_s.php`, `sendWhatsApp.php`

3. **Coerenza con il Namespace**
   - Il nome del file deve rispecchiare il namespace o la risorsa a cui si riferisce
   - Per pagine di invio: `send_[provider].php` (es. `send_telegram.php`)
   - Per risorse generali: `[resource].php` (es. `whatsapp.php`, `telegram.php`)

## Verifica della Conformità

Prima di aggiungere nuovi file di traduzione, verificare:
1. Che il nome rispetti i principi snake_case
2. Che i termini composti siano trattati correttamente
3. Che sia coerente con gli altri file dello stesso tipo

## Correzione dei File Non Conformi

Se si identifica un file con naming non conforme:
1. Creare una nuova versione con il nome corretto
2. Assicurarsi che tutti i riferimenti nel codice siano aggiornati
3. Rimuovere il file con naming errato

## Riferimenti
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)
- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)
- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
---

## translation-file-naming-rules

*Consolidated from: `translation-file-naming-rules.md`*


## Principi Fondamentali per il Naming dei File

Le seguenti regole si applicano a tutti i file di traduzione nel modulo Notify:

1. **Snake Case Obbligatorio**
   - Tutti i nomi dei file devono utilizzare snake_case (lettere minuscole separate da underscore)
   - Esempio: `send_email.php`, `mail_template.php`

2. **Termini Composti e Acronimi**
   - Gli acronimi (SMS, AWS, ecc.) devono essere trattati come parole singole
   - I termini composti come "WhatsApp" devono essere trattati come una singola parola
   - ✅ CORRETTO: `send_whatsapp.php`, `send_sms.php`, `send_aws_email.php`
   - ❌ ERRATO: `send_whats_app.php`, `send_s_m_s.php`, `sendWhatsApp.php`

3. **Coerenza con il Namespace**
   - Il nome del file deve rispecchiare il namespace o la risorsa a cui si riferisce
   - Per pagine di invio: `send_[provider].php` (es. `send_telegram.php`)
   - Per risorse generali: `[resource].php` (es. `whatsapp.php`, `telegram.php`)

## Verifica della Conformità

Prima di aggiungere nuovi file di traduzione, verificare:
1. Che il nome rispetti i principi snake_case
2. Che i termini composti siano trattati correttamente
3. Che sia coerente con gli altri file dello stesso tipo

## Correzione dei File Non Conformi

Se si identifica un file con naming non conforme:
1. Creare una nuova versione con il nome corretto
2. Assicurarsi che tutti i riferimenti nel codice siano aggiornati
3. Rimuovere il file con naming errato

## Riferimenti
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)

---

## translation-file-naming

*Consolidated from: `translation-file-naming.md`*


## Principi Fondamentali per il Naming dei File

Le seguenti regole si applicano a tutti i file di traduzione nel modulo Notify:

1. **Snake Case Obbligatorio**
   - Tutti i nomi dei file devono utilizzare snake_case (lettere minuscole separate da underscore)
   - Esempio: `send_email.php`, `mail_template.php`

2. **Termini Composti e Acronimi**
   - Gli acronimi (SMS, AWS, ecc.) devono essere trattati come parole singole
   - I termini composti come "WhatsApp" devono essere trattati come una singola parola
   - ✅ CORRETTO: `send_whatsapp.php`, `send_sms.php`, `send_aws_email.php`
   - ❌ ERRATO: `send_whats_app.php`, `send_s_m_s.php`, `sendWhatsApp.php`

3. **Coerenza con il Namespace**
   - Il nome del file deve rispecchiare il namespace o la risorsa a cui si riferisce
   - Per pagine di invio: `send_[provider].php` (es. `send_telegram.php`)
   - Per risorse generali: `[resource].php` (es. `whatsapp.php`, `telegram.php`)

## Verifica della Conformità

Prima di aggiungere nuovi file di traduzione, verificare:
1. Che il nome rispetti i principi snake_case
2. Che i termini composti siano trattati correttamente
3. Che sia coerente con gli altri file dello stesso tipo

## Correzione dei File Non Conformi

Se si identifica un file con naming non conforme:
1. Creare una nuova versione con il nome corretto
2. Assicurarsi che tutti i riferimenti nel codice siano aggiornati
3. Rimuovere il file con naming errato

## Riferimenti
- [Regole Generali per le Traduzioni](../../lang/docs/translation_keys_rules.md)
- [Best Practices per le Traduzioni](../../lang/docs/translation-keys-best-practices.md)
- [Convenzioni di Traduzione nel Modulo Notify](./translation_conventions.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Traduzioni](../../../../Lang/docs/translation-keys-best-practices.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)

---

## translation-file-structure-guide-1

*Consolidated from: `translation-file-structure-guide.md`*

title: "Guida alla Struttura dei File di Traduzione"
type: guide
tags: [translation, file, structure, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-file-structure-guide-1 guida alla struttura dei file di traduzione"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

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
- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
- [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
---

## translation-file-structure-guide

*Consolidated from: `translation-file-structure-guide.md`*


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
- [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)

---

## translation-file-structure

*Consolidated from: `translation-file-structure.md`*


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
- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Regole Generali per le Traduzioni](../../lang/docs/translation_keys_rules.md)
- [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)

---

## translation-implementation-plan-1

*Consolidated from: `translation-implementation-plan.md`*
*Consolidated from: `translation-implementation-plan-deprecated.md`*


This file is deprecated.

Use:

- [translation-implementation-plan](./translation-implementation-plan.md)
- [translation-implementation-plan](../../translation-implementation-plan.md)

---

## translation-implementation-plan-2

*Consolidated from: `translation-implementation-plan.md`*

title: "Piano di Implementazione per la Standardizzazione delle Traduzioni"
type: concept
tags: [translation, implementation, plan]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-implementation-plan-2 piano di implementazione per la standardizzazione delle traduzioni"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Piano di Implementazione per la Standardizzazione delle Traduzioni

Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di <nome progetto>.
Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di App.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione esistenti, sono stati identificati i seguenti problemi:

1. **File con Nomi Errati**:
   - `send_s_m_s.php` invece di `send_sms.php`
   - `send_a_w_s_email.php` invece di `send_aws_email.php`
   - `send_whats_app.php` invece di `send_whatsapp.php`
   - `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

2. **File Senza Nome**:
   - `.php` (file senza nome)

3. **Duplicazione**:
   - In alcuni casi esistono sia le versioni corrette che quelle errate dei file

4. **Inconsistenza tra Lingue**:
   - La cartella "en" contiene solo 3 file, mentre la cartella "it" ne contiene molti di più

5. **Struttura Non Standardizzata**:
   - I file di traduzione non seguono una struttura coerente

## Strategia di Implementazione

### Fase 1: Pulizia dei File Errati

1. **Rimozione dei File Senza Nome**:
   - Rimuovere il file `.php`

2. **Consolidamento dei File Duplicati**:
   - Per ogni coppia di file (es. `send_s_m_s.php` e `send_sms.php`):
     - Verificare che il contenuto del file corretto sia completo
     - Se necessario, integrare il contenuto del file errato nel file corretto
     - Rimuovere il file con nome errato

### Fase 2: Standardizzazione della Struttura

1. **Applicazione del Template Standard**:
   - Assicurarsi che tutti i file seguano la struttura standard definita
   - Aggiungere `declare(strict_types=1);` a tutti i file
   - Organizzare le chiavi in modo gerarchico

2. **Completezza delle Traduzioni**:
   - Assicurarsi che tutte le chiavi necessarie siano presenti in ogni file

### Fase 3: Sincronizzazione tra Lingue

1. **Creazione dei File Mancanti in Inglese**:
   - Per ogni file italiano, creare il corrispondente file inglese se non esiste

2. **Verifica della Coerenza**:
   - Assicurarsi che le stesse chiavi esistano in tutte le lingue

### Fase 4: Documentazione e Monitoraggio

1. **Aggiornamento della Documentazione**:
   - Mantenere aggiornata la documentazione sugli standard di traduzione

2. **Implementazione di Strumenti di Monitoraggio**:
   - Considerare l'implementazione di strumenti per verificare la completezza e coerenza delle traduzioni

## Implementazione Tecnica

### Script di Pulizia

```bash

# Rimozione dei file senza nome
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
```

### Template Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
    ],
];
```

## Conclusione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.
---

## translation-implementation-plan

*Consolidated from: `translation-implementation-plan.md`*


Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di .
Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di <nome progetto>.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione esistenti, sono stati identificati i seguenti problemi:

1. **File con Nomi Errati**:
   - `send_s_m_s.php` invece di `send_sms.php`
   - `send_a_w_s_email.php` invece di `send_aws_email.php`
   - `send_whats_app.php` invece di `send_whatsapp.php`
   - `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

2. **File Senza Nome**:
   - `.php` (file senza nome)

3. **Duplicazione**:
   - In alcuni casi esistono sia le versioni corrette che quelle errate dei file

4. **Inconsistenza tra Lingue**:
   - La cartella "en" contiene solo 3 file, mentre la cartella "it" ne contiene molti di più

5. **Struttura Non Standardizzata**:
   - I file di traduzione non seguono una struttura coerente

## Strategia di Implementazione

### Fase 1: Pulizia dei File Errati

1. **Rimozione dei File Senza Nome**:
   - Rimuovere il file `.php`

2. **Consolidamento dei File Duplicati**:
   - Per ogni coppia di file (es. `send_s_m_s.php` e `send_sms.php`):
     - Verificare che il contenuto del file corretto sia completo
     - Se necessario, integrare il contenuto del file errato nel file corretto
     - Rimuovere il file con nome errato

### Fase 2: Standardizzazione della Struttura

1. **Applicazione del Template Standard**:
   - Assicurarsi che tutti i file seguano la struttura standard definita
   - Aggiungere `declare(strict_types=1);` a tutti i file
   - Organizzare le chiavi in modo gerarchico

2. **Completezza delle Traduzioni**:
   - Assicurarsi che tutte le chiavi necessarie siano presenti in ogni file

### Fase 3: Sincronizzazione tra Lingue

1. **Creazione dei File Mancanti in Inglese**:
   - Per ogni file italiano, creare il corrispondente file inglese se non esiste

2. **Verifica della Coerenza**:
   - Assicurarsi che le stesse chiavi esistano in tutte le lingue

### Fase 4: Documentazione e Monitoraggio

1. **Aggiornamento della Documentazione**:
   - Mantenere aggiornata la documentazione sugli standard di traduzione

2. **Implementazione di Strumenti di Monitoraggio**:
   - Considerare l'implementazione di strumenti per verificare la completezza e coerenza delle traduzioni

## Implementazione Tecnica

### Script di Pulizia

```bash

# Rimozione dei file senza nome
rm -f Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f Modules/Notify/lang/it/send_s_m_s.php
rm -f Modules/Notify/lang/it/send_a_w_s_email.php
rm -f Modules/Notify/lang/it/send_whats_app.php
rm -f Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f Modules/Notify/lang/it/send_s_m_s.php
rm -f Modules/Notify/lang/it/send_a_w_s_email.php
rm -f Modules/Notify/lang/it/send_whats_app.php
rm -f Modules/Notify/lang/it/send_netfun_s_m_s.php
```

### Template Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
    ],
];
```

## Conclusione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.
Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di <nome progetto>.
# Piano di Implementazione per la Standardizzazione delle Traduzioni

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione esistenti, sono stati identificati i seguenti problemi:

1. **File con Nomi Errati**:
   - `send_s_m_s.php` invece di `send_sms.php`
   - `send_a_w_s_email.php` invece di `send_aws_email.php`
   - `send_whats_app.php` invece di `send_whatsapp.php`
   - `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

2. **File Senza Nome**:
   - `.php` (file senza nome)

3. **Duplicazione**:
   - In alcuni casi esistono sia le versioni corrette che quelle errate dei file

4. **Inconsistenza tra Lingue**:
   - La cartella "en" contiene solo 3 file, mentre la cartella "it" ne contiene molti di più

5. **Struttura Non Standardizzata**:
   - I file di traduzione non seguono una struttura coerente

## Strategia di Implementazione

### Fase 1: Pulizia dei File Errati

1. **Rimozione dei File Senza Nome**:
   - Rimuovere il file `.php`

2. **Consolidamento dei File Duplicati**:
   - Per ogni coppia di file (es. `send_s_m_s.php` e `send_sms.php`):
     - Verificare che il contenuto del file corretto sia completo
     - Se necessario, integrare il contenuto del file errato nel file corretto
     - Rimuovere il file con nome errato

### Fase 2: Standardizzazione della Struttura

1. **Applicazione del Template Standard**:
   - Assicurarsi che tutti i file seguano la struttura standard definita
   - Aggiungere `declare(strict_types=1);` a tutti i file
   - Organizzare le chiavi in modo gerarchico

2. **Completezza delle Traduzioni**:
   - Assicurarsi che tutte le chiavi necessarie siano presenti in ogni file

### Fase 3: Sincronizzazione tra Lingue

1. **Creazione dei File Mancanti in Inglese**:
   - Per ogni file italiano, creare il corrispondente file inglese se non esiste

2. **Verifica della Coerenza**:
   - Assicurarsi che le stesse chiavi esistano in tutte le lingue

### Fase 4: Documentazione e Monitoraggio

1. **Aggiornamento della Documentazione**:
   - Mantenere aggiornata la documentazione sugli standard di traduzione

2. **Implementazione di Strumenti di Monitoraggio**:
   - Considerare l'implementazione di strumenti per verificare la completezza e coerenza delle traduzioni

## Implementazione Tecnica

### Script di Pulizia

```bash

# Rimozione dei file senza nome
rm -f Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f Modules/Notify/lang/it/send_s_m_s.php
rm -f Modules/Notify/lang/it/send_a_w_s_email.php
rm -f Modules/Notify/lang/it/send_whats_app.php
rm -f Modules/Notify/lang/it/send_netfun_s_m_s.php

rm -f Modules/Notify/lang/it/.php

rm -f Modules/Notify/lang/it/send_s_m_s.php
rm -f Modules/Notify/lang/it/send_a_w_s_email.php
rm -f Modules/Notify/lang/it/send_whats_app.php
rm -f Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f Modules/Notify/lang/it/send_s_m_s.php
rm -f Modules/Notify/lang/it/send_a_w_s_email.php
rm -f Modules/Notify/lang/it/send_whats_app.php
rm -f Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f Modules/Notify/lang/it/.php

rm -f Modules/Notify/lang/it/send_s_m_s.php
rm -f Modules/Notify/lang/it/send_a_w_s_email.php
rm -f Modules/Notify/lang/it/send_whats_app.php
rm -f Modules/Notify/lang/it/send_netfun_s_m_s.php
```

### Template Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
];
```

## Conclusione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.

---

## translation-keys-best-practices-1

*Consolidated from: `translation-keys-best-practices.md`*

title: "Best Practices per le Chiavi di Traduzione"
type: concept
tags: [translation, keys, best, practices]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-keys-best-practices-1 best practices per le chiavi di traduzione"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Best Practices per le Chiavi di Traduzione

## Politica
La politica del progetto è garantire inclusività, accessibilità e rispetto per tutte le culture e le diversità linguistiche. Ogni chiave di traduzione deve essere pensata per essere neutra, rispettosa e non discriminatoria.

## Filosofia
Crediamo nella chiarezza, nella semplicità e nella trasparenza. Ogni chiave di traduzione deve aiutare lo sviluppatore e l'utente a sentirsi accolto e guidato, senza ambiguità o tecnicismi inutili.

## Religione
Il sistema di traduzioni è laico e neutrale rispetto a ogni credo. Non sono ammesse espressioni, simboli o riferimenti religiosi, salvo esplicita richiesta di progetto e sempre nel rispetto di tutte le fedi.

## Etica
Le chiavi di traduzione devono essere oneste, non ingannevoli, non manipolatorie e non offensive. L'etica del progetto impone di evitare ogni forma di linguaggio discriminatorio, sessista, razzista o che possa ledere la dignità della persona.

## Zen
La chiave di traduzione perfetta è quella che non si nota: è naturale, fluida, non distrae e non crea attrito. Ogni parola superflua va eliminata, ogni concetto va reso con la massima semplicità e armonia. 

---

## translation-keys-best-practices

*Consolidated from: `translation-keys-best-practices.md`*


## Politica
La politica del progetto è garantire inclusività, accessibilità e rispetto per tutte le culture e le diversità linguistiche. Ogni chiave di traduzione deve essere pensata per essere neutra, rispettosa e non discriminatoria.

## Filosofia
Crediamo nella chiarezza, nella semplicità e nella trasparenza. Ogni chiave di traduzione deve aiutare lo sviluppatore e l'utente a sentirsi accolto e guidato, senza ambiguità o tecnicismi inutili.

## Religione
Il sistema di traduzioni è laico e neutrale rispetto a ogni credo. Non sono ammesse espressioni, simboli o riferimenti religiosi, salvo esplicita richiesta di progetto e sempre nel rispetto di tutte le fedi.

## Etica
Le chiavi di traduzione devono essere oneste, non ingannevoli, non manipolatorie e non offensive. L'etica del progetto impone di evitare ogni forma di linguaggio discriminatorio, sessista, razzista o che possa ledere la dignità della persona.

## Zen
La chiave di traduzione perfetta è quella che non si nota: è naturale, fluida, non distrae e non crea attrito. Ogni parola superflua va eliminata, ogni concetto va reso con la massima semplicità e armonia. 

---

## translation-keys-rules-1

*Consolidated from: `translation-keys-rules.md`*

title: "Translation Keys Rules 1"
type: rule
tags: [translation, keys, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-keys-rules-1 translation keys rules 1"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

---

## [2024-07-07] Aggiornamento regole e best practice traduzioni modulo Notify

### Errori riscontrati
- Chiavi di traduzione non strutturate gerarchicamente
- Valori come 'send sms.navigation' o simili non conformi
- Mancanza di coerenza tra i file di traduzione dei vari canali (SMS, WhatsApp, Email, ecc.)
- Assenza di sezioni 'fields' e 'actions' in alcuni file

### Correzioni applicate
- Tutte le chiavi ora sono strutturate ad array annidati
- I valori sono descrittivi e localizzati, mai chiavi in italiano
- Aggiunte sezioni 'fields' e 'actions' dove mancanti
- Aggiornata la documentazione e le regole interne

### Best practice
- Prima di ogni modifica, consultare questa documentazione e quella centrale in `../../Lang/docs`
- Usare sempre nomi chiave descrittivi e struttura gerarchica
- Aggiornare contestualmente la documentazione in caso di nuove regole

### Esempio pratico

```php
return [
    'navigation' => [
        'label' => 'Invio WhatsApp',
        'group' => 'Notifiche',
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
        ],
    ],
];
```

### Riferimenti
- [TRANSLATION_KEYS_RULES.md](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md) 
- [TRANSLATION_KEYS_RULES.md](../../lang/docs/translation-keys-rules.md)
- [TRANSLATION_KEYS_RULES.md](../../../../Lang/docs/translation_keys_rules.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../../../Lang/docs/translation_keys_best_practices.md) 
- [TRANSLATION_KEYS_RULES.md](../../lang/docs/translation-keys-rules.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../lang/docs/translation-keys-best-practices.md) 
---

## translation-keys-rules

*Consolidated from: `translation-keys-rules.md`*


## [2024-07-07] Aggiornamento regole e best practice traduzioni modulo Notify

### Errori riscontrati
- Chiavi di traduzione non strutturate gerarchicamente
- Valori come 'send sms.navigation' o simili non conformi
- Mancanza di coerenza tra i file di traduzione dei vari canali (SMS, WhatsApp, Email, ecc.)
- Assenza di sezioni 'fields' e 'actions' in alcuni file

### Correzioni applicate
- Tutte le chiavi ora sono strutturate ad array annidati
- I valori sono descrittivi e localizzati, mai chiavi in italiano
- Aggiunte sezioni 'fields' e 'actions' dove mancanti
- Aggiornata la documentazione e le regole interne

### Best practice
- Prima di ogni modifica, consultare questa documentazione e quella centrale in `../../Lang/docs`
- Usare sempre nomi chiave descrittivi e struttura gerarchica
- Aggiornare contestualmente la documentazione in caso di nuove regole

### Esempio pratico

```php
return [
    'navigation' => [
        'label' => 'Invio WhatsApp',
        'group' => 'Notifiche',
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
        ],
    ],
];
```

### Riferimenti
- [TRANSLATION_KEYS_RULES.md](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md) 
- [TRANSLATION_KEYS_RULES.md](../../../../Lang/docs/translation_keys_rules.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../../../Lang/docs/translation_keys_best_practices.md) 
---

## translation-keys

*Consolidated from: `translation-keys.md`*


## [[DATE]] Aggiornamento regole e best practice traduzioni modulo Notify

### Errori riscontrati
- Chiavi di traduzione non strutturate gerarchicamente
- Valori come 'send sms.navigation' o simili non conformi
- Mancanza di coerenza tra i file di traduzione dei vari canali (SMS, WhatsApp, Email, ecc.)
- Assenza di sezioni 'fields' e 'actions' in alcuni file

### Correzioni applicate
- Tutte le chiavi ora sono strutturate ad array annidati
- I valori sono descrittivi e localizzati, mai chiavi in italiano
- Aggiunte sezioni 'fields' e 'actions' dove mancanti
- Aggiornata la documentazione e le regole interne

### Best practice
- Prima di ogni modifica, consultare questa documentazione e quella centrale in `../../Lang/docs`
- Usare sempre nomi chiave descrittivi e struttura gerarchica
- Aggiornare contestualmente la documentazione in caso di nuove regole

### Esempio pratico

```php
return [
    'navigation' => [
        'label' => 'Invio WhatsApp',
        'group' => 'Notifiche',
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
        ],
    ],
];
```

### Riferimenti
- [TRANSLATION_KEYS_RULES.md](../../lang/docs/translation_keys_rules.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../lang/docs/translation-keys-best-practices.md) 
- [TRANSLATION_KEYS_RULES.md](../../../../Lang/docs/translation_keys_rules.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../../../Lang/docs/translation-keys-best-practices.md) 
---

## translation-namespace-religion

*Consolidated from: `translation-namespace-religion.md`*


**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Religion / i18n  
**Audience**: All developers + AI agents

---

## LA REGOLA AUREA

**Le traduzioni sono organizzate per DOMINIO, non per componente UI.**

**DOMINIO** = `ticket`, `user`, `order` (cosa fa il business)  
**NON COMPONENTE** = `create_ticket_wizard`, `edit_form`, `list_view` (come lo mostri)

---

## Perche (Filosofia Profonda)

### Il Problema: Namespace per Componente UI

```php
// ❌ SBAGLIATO: namespace basato su COMPONENTE UI
__('laraxot::create_ticket_wizard.summary.images.limit_message')
__('<nome progetto>::create_ticket_wizard.summary.images.limit_message')
```

**Perche e sbagliato**:

1. **Duplicazione**: Se hai 3 widget che mostrano immagini, ognuno ha la SUA traduzione
   - `create_ticket_wizard.summary.images.limit_message`
   - `edit_ticket_wizard.summary.images.limit_message`
   - `view_ticket_wizard.summary.images.limit_message`
   - → 3 traduzioni per la STESSA cosa

2. **Incoerenza**: Ogni widget puo avere traduzione diversa
   - Widget 1: "E altre :count immagini"
   - Widget 2: "Altre :count immagini"
   - Widget 3: "+:count altre foto"
   - → Utente confuso

3. **Manutenzione**: Cambio la traduzione → devo aggiornare 3 file
   - Se dimentico uno → incoerenza UI

---

### La Soluzione: Namespace per Dominio

```php
// ✅ CORRETTO: namespace basato su DOMINIO BUSINESS
__('laraxot::ticket.rules.image.limit_message')
__('<nome progetto>::ticket.rules.image.limit_message')
```

**Perche e meglio**:

1. **UNICA fonte di verita**: Tutte le UI usano la STESSA traduzione
   - `ticket.rules.image.limit_message` → usata da TUTTI i widget
   - → Consistenza garantita

2. **Dominio business**: "ticket" e il concetto, non il widget
   - Le immagini sono una REGOLA del ticket
   - Non del widget che le mostra

3. **Manutenzione**: Cambio 1 volta → tutti i widget aggiornano
   - DRY applicato alle traduzioni

---

## La Struttura Corretta

### ❌ SBAGLIATO: Organizzato per UI

```
lang/it/
├── create_ticket_wizard.php      ← Componente UI
│   └── summary.images.limit_message
├── edit_ticket_form.php          ← Componente UI
│   └── images.limit_message
└── view_ticket_page.php          ← Componente UI
    └── gallery.limit_message
```

**Problema**: 3 traduzioni per "E altre :count immagini"

---

### ✅ CORRETTO: Organizzato per Dominio

```
lang/it/
└── ticket.php                    ← Dominio business
    ├── fields.images.label
    ├── fields.images.placeholder
    ├── rules.image.limit_message  ← UNICA traduzione
    └── messages.created
```

**Vantaggio**: 1 traduzione, tutti i widget la usano

---

## I Comandamenti i18n

### 1. Userai il DOMINIO come namespace radice

```php
// ❌ SBAGLIATO: componente UI
__('laraxot::create_ticket_wizard.summary.label')

// ✅ CORRETTO: dominio business
__('laraxot::ticket.sections.summary.label')
__('<nome progetto>::create_ticket_wizard.summary.label')

// ✅ CORRETTO: dominio business
__('<nome progetto>::ticket.sections.summary.label')
```

---

### 2. NON creerai file di traduzione per ogni widget

```php
// ❌ SBAGLIATO
create_ticket_wizard.php  ← File per widget
edit_ticket_form.php      ← File per widget
view_ticket_page.php      ← File per widget

// ✅ CORRETTO
ticket.php                ← File per dominio
```

---

### 3. Userai categorie semantiche sotto il dominio

```php
// Struttura corretta sotto dominio:
ticket.php
├── fields.       ← Campi del form
├── actions.      ← Azioni (crea, modifica, elimina)
├── messages.     ← Messaggi (successo, errore)
├── rules.        ← Regole di validazione/UI
├── sections.     ← Sezioni UI
└── navigation.   ← Menu navigazione
```

---

### 4. Le regole UI vanno sotto `rules`, non sotto il widget

```php
// ❌ SBAGLIATO
__('laraxot::create_ticket_wizard.summary.images.limit_message')

// ✅ CORRETTO
__('laraxot::ticket.rules.image.limit_message')
__('<nome progetto>::create_ticket_wizard.summary.images.limit_message')

// ✅ CORRETTO
__('<nome progetto>::ticket.rules.image.limit_message')
```

**Perche**: La regola delle immagini e una proprieta del DOMINIO ticket, non del widget.

---

### 5. AGGIORNERAI il file dominio, non creerai nuovi file

```php
// ❌ SBAGLIATO: creo nuovo file per nuovo widget
new_ticket_wizard.php  ← File duplicato

// ✅ CORRETTO: aggiungo al file dominio esistente
ticket.php  ← Aggiungo nuove chiavi qui
```

---

## Come Correggere (Guida Rapida)

### 1. Trova il file dominio corretto

```bash
# Cerca file di traduzione esistenti
find Modules/App/lang/it -name "ticket*.php"
find Modules/<nome progetto>/lang/it -name "ticket*.php"
→ ticket.php  ← Questo e il file!
```

---

### 2. Verifica la chiave esiste

```bash
# Cerca nel file
grep "limit_message" Modules/App/lang/it/ticket.php
grep "limit_message" Modules/<nome progetto>/lang/it/ticket.php
→ 'limit_message' => 'E altre :count immagini'
```

---

### 3. Usa la chiave corretta nel codice

```php
// ❌ SBAGLIATO
->limitMessage(__('laraxot::create_ticket_wizard.summary.images.limit_message'))

// ✅ CORRETTO
->limitMessage(__('laraxot::ticket.rules.image.limit_message'))
->limitMessage(__('<nome progetto>::create_ticket_wizard.summary.images.limit_message'))

// ✅ CORRETTO
->limitMessage(__('<nome progetto>::ticket.rules.image.limit_message'))
```

---

## Caso Studio: Ticket Wizard Images

### Prima (Sbagliato)

```php
Section::make(__('laraxot::create_ticket_wizard.summary.images.label'))
    ->limitMessage(__('laraxot::create_ticket_wizard.summary.images.limit_message'))
Section::make(__('<nome progetto>::create_ticket_wizard.summary.images.label'))
    ->limitMessage(__('<nome progetto>::create_ticket_wizard.summary.images.limit_message'))
```

**Problemi**:
- Namespace basato su componente UI (`create_ticket_wizard`)
- Se altro widget usa immagini → deve duplicare traduzione
- Incoerenza potenziale

---

### Dopo (Corretto)

```php
Section::make(__('laraxot::ticket.sections.images.label'))
    ->limitMessage(__('laraxot::ticket.rules.image.limit_message'))
Section::make(__('<nome progetto>::ticket.sections.images.label'))
    ->limitMessage(__('<nome progetto>::ticket.rules.image.limit_message'))
```

**Vantaggi**:
- Namespace basato su dominio (`ticket`)
- Tutti i widget condividono la traduzione
- Consistenza garantita

---

## La Filosofia Completa

### I 5 Pilastri del Namespace i18n

#### 1. Dominio, Non UI

**Dominio** = cosa fa il business (ticket, user, order)  
**UI** = come lo mostri (wizard, form, page)

**Regola**: Namespace segue dominio, NON UI.

---

#### 2. Unica Fonte di Verita

Ogni concetto ha UNA traduzione nel file dominio.  
Niente duplicati, niente incoerenze.

---

#### 3. Categorie Semantiche

Sotto il dominio, usa categorie che hanno senso:
- `fields` → campi del form
- `actions` → azioni CRUD
- `messages` → messaggi utente
- `rules` → regole validazione/UI
- `sections` → sezioni interfaccia
- `navigation` → menu/link

---

#### 4. Scalabilita

Aggiungere nuovo widget?  
→ Usa chiavi dominio esistenti, NON crearne di nuove.

---

#### 5. Manutenzione

Cambio traduzione?  
→ 1 file, 1 modifica, tutti i widget aggiornano.

---

## La Religione

### Il Credo

> "Dominio e il namespace, UI e solo il consumatore.  
> Una traduzione per concetto, mai duplicati.  
> Regole nel dominio, non nel widget."

### La Preghiera

```
Concedimi la saggezza di organizzare per dominio,
La disciplina di non duplicare traduzioni,
E il rispetto per ogni utente nella sua lingua.

Amen.
```

---

## Riferimenti

- [ticket.php (dominio corretto)](../../Modules/App/lang/it/ticket.php)
- [ticket.php (dominio corretto)](../../Modules/<nome progetto>/lang/it/ticket.php)
- [Laravel Localization](https://laravel.com/docs/localization)
- [No Hardcoded Language Religion](../../docs/no-hardcoded-language-religion.md)
- [No Hardcoded Language Religion](../../no-hardcoded-language-religion.md)

---

*Ultimo aggiornamento: 2026-04-14*

**DA LEGGERE PRIMA DI CREARE QUALSIASI CHIAVE DI TRADUZIONE**

---

## translation-standards-1

*Consolidated from: `translation-standards.md`*


Questo documento definisce gli standard e le best practices per la gestione delle traduzioni all'interno dei moduli di <nome progetto>, con particolare attenzione al modulo Notify.

## Struttura delle Cartelle

Le traduzioni devono essere organizzate nelle seguenti cartelle:

```
/Modules/[ModuleName]/lang/
  ├── en/                 # Traduzioni inglesi
  │   └── *.php           # File di traduzione inglesi
  └── it/                 # Traduzioni italiane
      └── *.php           # File di traduzione italiani
```

## Convenzioni di Naming per i File di Traduzione

### Regole Fondamentali

1. **Nomi in snake_case**: Tutti i file di traduzione devono utilizzare il formato `snake_case.php`
2. **Nomi Semantici**: I nomi devono riflettere il contesto o la risorsa a cui si riferiscono
3. **Nomi Coerenti**: Lo stesso file deve esistere in tutte le lingue supportate
4. **Evitare Acronimi nel Nome del File**: Scrivere per esteso (es. `send_aws_email.php` invece di `send_a_w_s_email.php`)

### Esempi Corretti

✅ `send_sms.php` (non `send_s_m_s.php`)
✅ `send_aws_email.php` (non `send_a_w_s_email.php`)
✅ `send_whatsapp.php` (non `send_whats_app.php`)

## Struttura dei File di Traduzione

### Formato Standard

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50, // Ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

### Regole per le Chiavi di Traduzione

1. **Struttura Gerarchica**: Utilizzare una struttura nidificata per organizzare le traduzioni
2. **Chiavi in snake_case**: Tutte le chiavi devono essere in `snake_case`
3. **Evitare Stringhe Piatte**: Non utilizzare un array piatto di traduzioni
4. **Consistenza tra Lingue**: Le stesse chiavi devono esistere in tutte le lingue

## Utilizzo delle Traduzioni

### In Filament

```php
// Corretto
protected static ?string $navigationLabel = null; // Usa il LangServiceProvider

// Errato
protected static ?string $navigationLabel = 'Invio SMS'; // Hardcoded
```

### In Blade

```php
// Corretto
{{ __('notify::send_sms.fields.to.label') }}

// Errato
{{ __('notify::send_sms.to') }}
```

## Gestione delle Traduzioni Mancanti

1. **Completezza**: Assicurarsi che tutte le chiavi esistano in tutte le lingue
2. **Fallback**: Configurare correttamente il fallback alla lingua predefinita
3. **Monitoraggio**: Implementare un sistema per identificare le traduzioni mancanti

## Processo di Aggiornamento

1. **Sincronizzazione**: Mantenere sincronizzate le traduzioni tra le diverse lingue
2. **Revisione**: Rivedere periodicamente le traduzioni per consistenza e qualità
3. **Automazione**: Utilizzare strumenti per facilitare la gestione delle traduzioni

## Errori Comuni da Evitare

1. **Nomi File Errati**: `send_s_m_s.php` invece di `send_sms.php`
2. **File Senza Nome**: `.php` (file senza nome)
3. **Traduzioni Incomplete**: File con solo alcune chiavi
4. **Inconsistenza tra Lingue**: File che esistono solo in alcune lingue
5. **Stringhe Hardcoded**: Testo hardcoded invece di utilizzare le traduzioni

## Strumenti Utili

1. **Laravel Translation Manager**: Per gestire e sincronizzare le traduzioni
2. **Laravel Lang**: Per traduzioni comuni di Laravel
3. **Script Personalizzati**: Per verificare la completezza e consistenza delle traduzioni

---

## translation-standards-2

*Consolidated from: `translation-standards.md`*

title: "Standard per le Traduzioni"
type: rule
tags: [translation, standards]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-standards-2 standard per le traduzioni"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Standard per le Traduzioni

Questo documento definisce gli standard e le best practices per la gestione delle traduzioni all'interno dei moduli di <nome progetto>, con particolare attenzione al modulo Notify.

## Struttura delle Cartelle

Le traduzioni devono essere organizzate nelle seguenti cartelle:

```
/Modules/[ModuleName]/lang/
  ├── en/                 # Traduzioni inglesi
  │   └── *.php           # File di traduzione inglesi
  └── it/                 # Traduzioni italiane
      └── *.php           # File di traduzione italiani
```

## Convenzioni di Naming per i File di Traduzione

### Regole Fondamentali

1. **Nomi in snake_case**: Tutti i file di traduzione devono utilizzare il formato `snake_case.php`
2. **Nomi Semantici**: I nomi devono riflettere il contesto o la risorsa a cui si riferiscono
3. **Nomi Coerenti**: Lo stesso file deve esistere in tutte le lingue supportate
4. **Evitare Acronimi nel Nome del File**: Scrivere per esteso (es. `send_aws_email.php` invece di `send_a_w_s_email.php`)

### Esempi Corretti

✅ `send_sms.php` (non `send_s_m_s.php`)
✅ `send_aws_email.php` (non `send_a_w_s_email.php`)
✅ `send_whatsapp.php` (non `send_whats_app.php`)

## Struttura dei File di Traduzione

### Formato Standard

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50, // Ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

### Regole per le Chiavi di Traduzione

1. **Struttura Gerarchica**: Utilizzare una struttura nidificata per organizzare le traduzioni
2. **Chiavi in snake_case**: Tutte le chiavi devono essere in `snake_case`
3. **Evitare Stringhe Piatte**: Non utilizzare un array piatto di traduzioni
4. **Consistenza tra Lingue**: Le stesse chiavi devono esistere in tutte le lingue

## Utilizzo delle Traduzioni

### In Filament

```php
// Corretto
protected static ?string $navigationLabel = null; // Usa il LangServiceProvider

// Errato
protected static ?string $navigationLabel = 'Invio SMS'; // Hardcoded
```

### In Blade

```php
// Corretto
{{ __('notify::send_sms.fields.to.label') }}

// Errato
{{ __('notify::send_sms.to') }}
```

## Gestione delle Traduzioni Mancanti

1. **Completezza**: Assicurarsi che tutte le chiavi esistano in tutte le lingue
2. **Fallback**: Configurare correttamente il fallback alla lingua predefinita
3. **Monitoraggio**: Implementare un sistema per identificare le traduzioni mancanti

## Processo di Aggiornamento

1. **Sincronizzazione**: Mantenere sincronizzate le traduzioni tra le diverse lingue
2. **Revisione**: Rivedere periodicamente le traduzioni per consistenza e qualità
3. **Automazione**: Utilizzare strumenti per facilitare la gestione delle traduzioni

## Errori Comuni da Evitare

1. **Nomi File Errati**: `send_s_m_s.php` invece di `send_sms.php`
2. **File Senza Nome**: `.php` (file senza nome)
3. **Traduzioni Incomplete**: File con solo alcune chiavi
4. **Inconsistenza tra Lingue**: File che esistono solo in alcune lingue
5. **Stringhe Hardcoded**: Testo hardcoded invece di utilizzare le traduzioni

## Strumenti Utili

1. **Laravel Translation Manager**: Per gestire e sincronizzare le traduzioni
2. **Laravel Lang**: Per traduzioni comuni di Laravel
3. **Script Personalizzati**: Per verificare la completezza e consistenza delle traduzioni

---

## translation-standards-progress-1

*Consolidated from: `translation-standards-progress.md`*


## Stato Attuale - 12/05/2025

### Problemi Identificati

1. **Convenzioni di Naming Non Rispettate**
   - File `send_whats_app.php` utilizzava naming errato (WhatsApp separato da underscore)
   - La convenzione corretta richiede di trattare "WhatsApp" come un'unica parola in snake_case: `send_whatsapp.php`

2. **Elementi Strutturali Mancanti**
   - Analisi ha rivelato che 20 file di traduzione mancano della dichiarazione `declare(strict_types=1);`
   - Molti file non contengono la sezione `resource` obbligatoria
   - Le strutture gerarchiche sono spesso incomplete (mancano elementi come icon, sort, plural in navigation)

3. **File Problematici Identificati**
   - `Modules/Notify/lang/it/send_aws_email.php`
   - `Modules/Notify/lang/it/setting.php`
   - `Modules/Notify/lang/it/edit_mail_template.php`
   - `Modules/Notify/lang/it/send_netfun_sms.php`
   - `Modules/Notify/lang/it/notification_template.php`
   - E altri 15 file (elenco completo in appendice)

### Correzioni Implementate

1. **Documentazione Standard**
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md`
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md`

2. **File Corretti**
   - Creato `Modules/Notify/lang/it/send_whatsapp.php` con struttura corretta
   - Aggiornato `Modules/Notify/lang/it/send_netfun_sms.php` con struttura completa
   - Rimosso il file con naming errato `send_whats_app.php`

### Prossime Correzioni da Implementare

1. **File da Correggere Prioritariamente**
   - `Modules/Notify/lang/it/send_email.php`
   - `Modules/Notify/lang/it/send_sms.php`
   - `Modules/Notify/lang/it/send_telegram.php`

2. **Verifiche da Eseguire**
   - Analisi della cartella `Modules/Notify/lang/en/` per identificare problemi simili
   - Controllo dei riferimenti nel codice che potrebbero puntare ai vecchi file

## Documentazione di Riferimento

1. **Standard di Traduzione**
   - [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
   - [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
   - [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
   - [Guida alla Struttura dei File di Traduzione](./TRANSLATION_FILE_STRUCTURE_GUIDE.md)
   - [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
   - [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
   - [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
   - [Guida alla Struttura dei File di Traduzione](../../translation_file_structure_guide.md)

## Appendice: Elenco Completo dei File Non Conformi

```
Modules/Notify/lang/it/send_aws_email.php
Modules/Notify/lang/it/setting.php
Modules/Notify/lang/it/edit_mail_template.php
Modules/Notify/lang/it/send_netfun_sms.php (corretto)
Modules/Notify/lang/it/notification_template.php
Modules/Notify/lang/it/notify.php
Modules/Notify/lang/it/contacts.php
Modules/Notify/lang/it/test_smtp.php
Modules/Notify/lang/it/log.php
Modules/Notify/lang/it/send_sms.php
Modules/Notify/lang/it/contact.php
Modules/Notify/lang/it/slack_notification.php
Modules/Notify/lang/it/template.php
Modules/Notify/lang/it/send_push_notification.php
Modules/Notify/lang/it/dashboard.php
Modules/Notify/lang/it/send_whats_app.php (rimosso e sostituito)
Modules/Notify/lang/it/send_firebase_push_notification.php
Modules/Notify/lang/it/send_email.php
Modules/Notify/lang/it/send_spatie_email.php
Modules/Notify/lang/it/create_mail_template.php
```

---

## translation-standards-progress-2

*Consolidated from: `translation-standards-progress.md`*

title: "Progresso Standardizzazione Traduzioni"
type: rule
tags: [translation, standards, progress]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-standards-progress-2 progresso standardizzazione traduzioni"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Progresso Standardizzazione Traduzioni

## Stato Attuale - 12/05/2025

### Problemi Identificati

1. **Convenzioni di Naming Non Rispettate**
   - File `send_whats_app.php` utilizzava naming errato (WhatsApp separato da underscore)
   - La convenzione corretta richiede di trattare "WhatsApp" come un'unica parola in snake_case: `send_whatsapp.php`

2. **Elementi Strutturali Mancanti**
   - Analisi ha rivelato che 20 file di traduzione mancano della dichiarazione `declare(strict_types=1);`
   - Molti file non contengono la sezione `resource` obbligatoria
   - Le strutture gerarchiche sono spesso incomplete (mancano elementi come icon, sort, plural in navigation)

3. **File Problematici Identificati**
- `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_aws_email.php`
   - `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/setting.php`
   - `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/edit_mail_template.php`
   - `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_netfun_sms.php`
   - `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/notification_template.php`
   - E altri 15 file (elenco completo in appendice)

### Correzioni Implementate

1. **Documentazione Standard**
- Creato `/var/www/_bases/<nome repository>/laravel/Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md`
   - Creato `/var/www/_bases/<nome repository>/laravel/Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md`

2. **File Corretti**
   - Creato `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_whatsapp.php` con struttura corretta
   - Aggiornato `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_netfun_sms.php` con struttura completa
   - Rimosso il file con naming errato `send_whats_app.php`

### Prossime Correzioni da Implementare

1. **File da Correggere Prioritariamente**
- `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_email.php`
   - `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_sms.php`
   - `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_telegram.php`

2. **Verifiche da Eseguire**
   - Analisi della cartella `/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/en/` per identificare problemi simili
   - Controllo dei riferimenti nel codice che potrebbero puntare ai vecchi file

## Documentazione di Riferimento

1. **Standard di Traduzione**
   - [Regole Generali per le Traduzioni](../../lang/docs/translation-keys-rules.md)
   - [Best Practices per le Traduzioni](../../lang/docs/translation-keys-best-practices.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
   - [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
   - [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
   - [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
   - [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
   - [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
   - [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
   - [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
   - [Regole di Naming per i File di Traduzione](../../translation-file-naming-rules.md)
   - [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)

## Appendice: Elenco Completo dei File Non Conformi

```
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_aws_email.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/setting.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/edit_mail_template.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_netfun_sms.php (corretto)
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/notification_template.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/notify.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/contacts.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/test_smtp.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/log.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_sms.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/contact.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/slack_notification.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/template.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_push_notification.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/dashboard.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_whats_app.php (rimosso e sostituito)
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_firebase_push_notification.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_email.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_spatie_email.php
/var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/create_mail_template.php
```
---

## translation-standards-progress

*Consolidated from: `translation-standards-progress.md`*


## Stato Attuale - 12/05/2025

### Problemi Identificati

1. **Convenzioni di Naming Non Rispettate**
   - File `send_whats_app.php` utilizzava naming errato (WhatsApp separato da underscore)
   - La convenzione corretta richiede di trattare "WhatsApp" come un'unica parola in snake_case: `send_whatsapp.php`

2. **Elementi Strutturali Mancanti**
   - Analisi ha rivelato che 20 file di traduzione mancano della dichiarazione `declare(strict_types=1);`
   - Molti file non contengono la sezione `resource` obbligatoria
   - Le strutture gerarchiche sono spesso incomplete (mancano elementi come icon, sort, plural in navigation)

3. **File Problematici Identificati**
   - `Modules/Notify/lang/it/send_aws_email.php`
   - `Modules/Notify/lang/it/setting.php`
   - `Modules/Notify/lang/it/edit_mail_template.php`
   - `Modules/Notify/lang/it/send_netfun_sms.php`
   - `Modules/Notify/lang/it/notification_template.php`
   - `Modules/Notify/lang/it/send_aws_email.php`
   - `Modules/Notify/lang/it/setting.php`
   - `Modules/Notify/lang/it/edit_mail_template.php`
   - `Modules/Notify/lang/it/send_netfun_sms.php`
   - `Modules/Notify/lang/it/notification_template.php`
   - E altri 15 file (elenco completo in appendice)

### Correzioni Implementate

1. **Documentazione Standard**
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md`
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md`

2. **File Corretti**
   - Creato `Modules/Notify/lang/it/send_whatsapp.php` con struttura corretta
   - Aggiornato `Modules/Notify/lang/it/send_netfun_sms.php` con struttura completa
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md`
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md`

2. **File Corretti**
   - Creato `Modules/Notify/lang/it/send_whatsapp.php` con struttura corretta
   - Aggiornato `Modules/Notify/lang/it/send_netfun_sms.php` con struttura completa
   - Rimosso il file con naming errato `send_whats_app.php`

### Prossime Correzioni da Implementare

1. **File da Correggere Prioritariamente**
   - `Modules/Notify/lang/it/send_email.php`
   - `Modules/Notify/lang/it/send_sms.php`
   - `Modules/Notify/lang/it/send_telegram.php`

2. **Verifiche da Eseguire**
   - Analisi della cartella `Modules/Notify/lang/en/` per identificare problemi simili
   - `Modules/Notify/lang/it/send_email.php`
   - `Modules/Notify/lang/it/send_sms.php`
   - `Modules/Notify/lang/it/send_telegram.php`

2. **Verifiche da Eseguire**
   - Analisi della cartella `Modules/Notify/lang/en/` per identificare problemi simili
   - Controllo dei riferimenti nel codice che potrebbero puntare ai vecchi file

## Documentazione di Riferimento

1. **Standard di Traduzione**
   - [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
   - [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
   - [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
   - [Guida alla Struttura dei File di Traduzione](./TRANSLATION_FILE_STRUCTURE_GUIDE.md)
   - [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
   - [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
   - [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
   - [Guida alla Struttura dei File di Traduzione](../../translation_file_structure_guide.md)

## Appendice: Elenco Completo dei File Non Conformi

```
Modules/Notify/lang/it/send_aws_email.php
Modules/Notify/lang/it/setting.php
Modules/Notify/lang/it/edit_mail_template.php
Modules/Notify/lang/it/send_netfun_sms.php (corretto)
Modules/Notify/lang/it/notification_template.php
Modules/Notify/lang/it/notify.php
Modules/Notify/lang/it/contacts.php
Modules/Notify/lang/it/test_smtp.php
Modules/Notify/lang/it/log.php
Modules/Notify/lang/it/send_sms.php
Modules/Notify/lang/it/contact.php
Modules/Notify/lang/it/slack_notification.php
Modules/Notify/lang/it/template.php
Modules/Notify/lang/it/send_push_notification.php
Modules/Notify/lang/it/dashboard.php
Modules/Notify/lang/it/send_whats_app.php (rimosso e sostituito)
Modules/Notify/lang/it/send_firebase_push_notification.php
Modules/Notify/lang/it/send_email.php
Modules/Notify/lang/it/send_spatie_email.php
Modules/Notify/lang/it/create_mail_template.php
Modules/Notify/lang/it/send_aws_email.php
Modules/Notify/lang/it/setting.php
Modules/Notify/lang/it/edit_mail_template.php
Modules/Notify/lang/it/send_netfun_sms.php (corretto)
Modules/Notify/lang/it/notification_template.php
Modules/Notify/lang/it/notify.php
Modules/Notify/lang/it/contacts.php
Modules/Notify/lang/it/test_smtp.php
Modules/Notify/lang/it/log.php
Modules/Notify/lang/it/send_sms.php
Modules/Notify/lang/it/contact.php
Modules/Notify/lang/it/slack_notification.php
Modules/Notify/lang/it/template.php
Modules/Notify/lang/it/send_push_notification.php
Modules/Notify/lang/it/dashboard.php
Modules/Notify/lang/it/send_whats_app.php (rimosso e sostituito)
Modules/Notify/lang/it/send_firebase_push_notification.php
Modules/Notify/lang/it/send_email.php
Modules/Notify/lang/it/send_spatie_email.php
Modules/Notify/lang/it/create_mail_template.php
```
# Progresso Standardizzazione Traduzioni

## Stato Attuale - 12/05/2025

### Problemi Identificati

1. **Convenzioni di Naming Non Rispettate**
   - File `send_whats_app.php` utilizzava naming errato (WhatsApp separato da underscore)
   - La convenzione corretta richiede di trattare "WhatsApp" come un'unica parola in snake_case: `send_whatsapp.php`

2. **Elementi Strutturali Mancanti**
   - Analisi ha rivelato che 20 file di traduzione mancano della dichiarazione `declare(strict_types=1);`
   - Molti file non contengono la sezione `resource` obbligatoria
   - Le strutture gerarchiche sono spesso incomplete (mancano elementi come icon, sort, plural in navigation)

3. **File Problematici Identificati**
   - `Modules/Notify/lang/it/send_aws_email.php`
   - `Modules/Notify/lang/it/setting.php`
   - `Modules/Notify/lang/it/edit_mail_template.php`
   - `Modules/Notify/lang/it/send_netfun_sms.php`
   - `Modules/Notify/lang/it/notification_template.php`
   - E altri 15 file (elenco completo in appendice)

### Correzioni Implementate

1. **Documentazione Standard**
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md`
   - Creato `Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md`

2. **File Corretti**
   - Creato `Modules/Notify/lang/it/send_whatsapp.php` con struttura corretta
   - Aggiornato `Modules/Notify/lang/it/send_netfun_sms.php` con struttura completa
   - Rimosso il file con naming errato `send_whats_app.php`

### Prossime Correzioni da Implementare

1. **File da Correggere Prioritariamente**
   - `Modules/Notify/lang/it/send_email.php`
   - `Modules/Notify/lang/it/send_sms.php`
   - `Modules/Notify/lang/it/send_telegram.php`

2. **Verifiche da Eseguire**
   - Analisi della cartella `Modules/Notify/lang/en/` per identificare problemi simili
   - Controllo dei riferimenti nel codice che potrebbero puntare ai vecchi file

## Documentazione di Riferimento

1. **Standard di Traduzione**
   - [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
   - [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
   - [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
   - [Guida alla Struttura dei File di Traduzione](./TRANSLATION_FILE_STRUCTURE_GUIDE.md)
   - [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
   - [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
   - [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
   - [Guida alla Struttura dei File di Traduzione](../../translation_file_structure_guide.md)

## Appendice: Elenco Completo dei File Non Conformi

```
Modules/Notify/lang/it/send_aws_email.php
Modules/Notify/lang/it/setting.php
Modules/Notify/lang/it/edit_mail_template.php
Modules/Notify/lang/it/send_netfun_sms.php (corretto)
Modules/Notify/lang/it/notification_template.php
Modules/Notify/lang/it/notify.php
Modules/Notify/lang/it/contacts.php
Modules/Notify/lang/it/test_smtp.php
Modules/Notify/lang/it/log.php
Modules/Notify/lang/it/send_sms.php
Modules/Notify/lang/it/contact.php
Modules/Notify/lang/it/slack_notification.php
Modules/Notify/lang/it/template.php
Modules/Notify/lang/it/send_push_notification.php
Modules/Notify/lang/it/dashboard.php
Modules/Notify/lang/it/send_whats_app.php (rimosso e sostituito)
Modules/Notify/lang/it/send_firebase_push_notification.php
Modules/Notify/lang/it/send_email.php
Modules/Notify/lang/it/send_spatie_email.php
Modules/Notify/lang/it/create_mail_template.php
```

---

## translation-standards

*Consolidated from: `translation-standards.md`*


Questo documento definisce gli standard e le best practices per la gestione delle traduzioni all'interno dei moduli di App, con particolare attenzione al modulo Notify.
Questo documento definisce gli standard e le best practices per la gestione delle traduzioni all'interno dei moduli di Quaeris, con particolare attenzione al modulo Notify.

## Struttura delle Cartelle

Le traduzioni devono essere organizzate nelle seguenti cartelle:

```
/Modules/[ModuleName]/lang/
  ├── en/                 # Traduzioni inglesi
  │   └── *.php           # File di traduzione inglesi
  └── it/                 # Traduzioni italiane
      └── *.php           # File di traduzione italiani
```

## Convenzioni di Naming per i File di Traduzione

### Regole Fondamentali

1. **Nomi in snake_case**: Tutti i file di traduzione devono utilizzare il formato `snake_case.php`
2. **Nomi Semantici**: I nomi devono riflettere il contesto o la risorsa a cui si riferiscono
3. **Nomi Coerenti**: Lo stesso file deve esistere in tutte le lingue supportate
4. **Evitare Acronimi nel Nome del File**: Scrivere per esteso (es. `send_aws_email.php` invece di `send_a_w_s_email.php`)

### Esempi Corretti

✅ `send_sms.php` (non `send_s_m_s.php`)  
✅ `send_aws_email.php` (non `send_a_w_s_email.php`)  
✅ `send_whatsapp.php` (non `send_whats_app.php`)  

## Struttura dei File di Traduzione

### Formato Standard

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50, // Ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

### Regole per le Chiavi di Traduzione

1. **Struttura Gerarchica**: Utilizzare una struttura nidificata per organizzare le traduzioni
2. **Chiavi in snake_case**: Tutte le chiavi devono essere in `snake_case`
3. **Evitare Stringhe Piatte**: Non utilizzare un array piatto di traduzioni
4. **Consistenza tra Lingue**: Le stesse chiavi devono esistere in tutte le lingue

## Utilizzo delle Traduzioni

### In Filament

```php
// Corretto
protected static ?string $navigationLabel = null; // Usa il LangServiceProvider

// Errato
protected static ?string $navigationLabel = 'Invio SMS'; // Hardcoded
```

### In Blade

```php
// Corretto
{{ __('notify::send_sms.fields.to.label') }}

// Errato
{{ __('notify::send_sms.to') }}
```

## Gestione delle Traduzioni Mancanti

1. **Completezza**: Assicurarsi che tutte le chiavi esistano in tutte le lingue
2. **Fallback**: Configurare correttamente il fallback alla lingua predefinita
3. **Monitoraggio**: Implementare un sistema per identificare le traduzioni mancanti

## Processo di Aggiornamento

1. **Sincronizzazione**: Mantenere sincronizzate le traduzioni tra le diverse lingue
2. **Revisione**: Rivedere periodicamente le traduzioni per consistenza e qualità
3. **Automazione**: Utilizzare strumenti per facilitare la gestione delle traduzioni

## Errori Comuni da Evitare

1. **Nomi File Errati**: `send_s_m_s.php` invece di `send_sms.php`
2. **File Senza Nome**: `.php` (file senza nome)
3. **Traduzioni Incomplete**: File con solo alcune chiavi
4. **Inconsistenza tra Lingue**: File che esistono solo in alcune lingue
5. **Stringhe Hardcoded**: Testo hardcoded invece di utilizzare le traduzioni

## Strumenti Utili

1. **Laravel Translation Manager**: Per gestire e sincronizzare le traduzioni
2. **Laravel Lang**: Per traduzioni comuni di Laravel
3. **Script Personalizzati**: Per verificare la completezza e consistenza delle traduzioni

---

## translation_cleanup_plan

*Consolidated from: `translation_cleanup_plan.md`*


Questo documento descrive il piano di pulizia e standardizzazione delle traduzioni italiane nel modulo Notify di <nome progetto>.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione nella cartella `[project-root]/laravel/Modules/Notify/lang/it`, sono stati identificati i seguenti problemi:
Questo documento descrive il piano di pulizia e standardizzazione delle traduzioni italiane nel modulo Notify di SaluteOra.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione nella cartella `/var/www/html/saluteora/laravel/Modules/Notify/lang/it`, sono stati identificati i seguenti problemi:

### 1. File con Nomi Errati
- `send_s_m_s.php` invece di `send_sms.php`
- `send_a_w_s_email.php` invece di `send_aws_email.php`
- `send_whats_app.php` invece di `send_whatsapp.php`
- `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

### 2. File Duplicati
- Esistono sia `send_s_m_s.php` che `send_sms.php`
- Esistono sia `send_a_w_s_email.php` che `send_aws_email.php`
- Esistono sia `send_netfun_s_m_s.php` che `send_netfun_sms.php`

### 3. File Senza Nome
- `.php` (file senza nome)

### 4. Struttura Non Standardizzata
- Alcuni file utilizzano array piatti
- Altri utilizzano strutture nidificate
- Manca la dichiarazione `declare(strict_types=1);` in molti file

### 5. Directory Non Necessarie
- `backup`, `corrected`, `temp` (directory temporanee)

## Piano di Azione

### Fase 1: Backup dei File Esistenti
- Creare un backup completo di tutti i file di traduzione prima di procedere con le modifiche

### Fase 2: Rimozione dei File Errati e Duplicati
- Rimuovere i file con nomi errati dopo aver verificato che il contenuto sia stato migrato nei file con nomi corretti
- Rimuovere il file senza nome `.php`

### Fase 3: Standardizzazione della Struttura dei File
- Aggiungere `declare(strict_types=1);` a tutti i file
- Convertire tutti gli array piatti in strutture nidificate
- Assicurarsi che tutti i file seguano lo stesso formato

### Fase 4: Pulizia delle Directory Temporanee
- Rimuovere le directory temporanee `backup`, `corrected` e `temp` dopo aver verificato che non contengano informazioni importanti

### Fase 5: Verifica della Coerenza con i File Inglesi
- Assicurarsi che per ogni file italiano esista un corrispondente file inglese
- Verificare che le chiavi di traduzione siano coerenti tra le versioni italiana e inglese

## Struttura Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
        'plural' => 'Nome Risorsa (plurale)',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

## Implementazione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.

---

## translation_conventions

*Consolidated from: `translation_conventions.md`*


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
- [SaluteOra Translation System](../../../../.cursor/rules/translations.rule)
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

---

## translation_conventions_clarification

*Consolidated from: `translation_conventions_clarification.md`*


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
   - Il modulo Notify rappresenta un'eccezione alle convenzioni generali di SaluteOra
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
Il file `send_whats_app.php` e altri file simili nel modulo Notify seguono correttamente le convenzioni specifiche del modulo. Non è necessario modificare questi file per conformarsi alle convenzioni generali di SaluteOra, poiché rappresentano un'eccezione documentata.

## Riferimenti

- [Convenzioni Generali di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Convenzioni Specifiche del Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Regole per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni Generali di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Convenzioni Specifiche del Modulo Notify](../../translation_conventions.md)
- [Regole per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)

---

## translation_file_correction_guide

*Consolidated from: `translation_file_correction_guide.md`*


## Procedura Sistematica per la Standardizzazione

Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di <nome progetto>.
Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di SaluteOra.

## Passo 1: Analisi del File Esistente

Prima di apportare modifiche, analizzare il file esistente per:
1. Verificare il nome del file (rispetta le convenzioni snake_case?)
2. Identificare la struttura attuale (quali sezioni sono presenti?)
3. Identificare i contenuti da preservare (etichette, messaggi, ecc.)

## Passo 2: Correzione di File con Naming Errato

Se il file ha un nome non conforme:

```bash

# 1. Creare un nuovo file con il nome corretto
touch /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/nome_corretto.php
touch [project-root]/laravel/Modules/Notify/lang/it/nome_corretto.php
touch /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/nome_corretto.php
touch /var/www/html/saluteora/laravel/Modules/Notify/lang/it/nome_corretto.php
touch /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/nome_corretto.php

# 2. Copiare e correggere il contenuto

# (vedere Passo 3 per la struttura corretta)

# 3. Verificare che non ci siano riferimenti al vecchio file
grep -r "nome_errato" /var/www/html/<nome progetto>/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" [project-root]/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm [project-root]/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" /var/www/_bases/<nome repository>/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" /var/www/html/saluteora/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/saluteora/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/nome_errato.php
```

## Passo 3: Correzione della Struttura del File

Ogni file deve seguire questa struttura completa:

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
        'sort' => 10,
    ],
    'fields' => [
        // Campi specifici del file
    ],
    'actions' => [
        // Azioni specifiche del file
    ],
    'messages' => [
        // Messaggi specifici del file
    ],
];
```

## Passo 4: Verifica della Coerenza tra Lingue

Dopo aver corretto un file in italiano, verificare e aggiornare la versione inglese:

```bash

# 1. Controllare se esiste il file inglese
ls /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/en/nome_file.php
ls [project-root]/laravel/Modules/Notify/lang/en/nome_file.php
ls /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/en/nome_file.php
ls /var/www/html/saluteora/laravel/Modules/Notify/lang/en/nome_file.php
ls /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/en/nome_file.php

# 2. Se esiste, aggiornarlo con la stessa struttura

# 3. Se non esiste, crearlo con la traduzione inglese dei messaggi italiani
```

## Passo 5: Test delle Modifiche

Dopo ogni correzione:

1. Verificare che l'interfaccia utente visualizzi correttamente le etichette
2. Verificare che tutte le traduzioni siano disponibili in tutte le lingue
3. Verificare che non ci siano errori di visualizzazione

## Esempi di Correzione

### Esempio 1: File con Naming Errato

**Originale**: `send_whats_app.php`
**Corretto**: `send_whatsapp.php`

### Esempio 2: File con Struttura Incompleta

**Originale**:
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
];
```

**Corretto**:
```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    ],
    'navigation' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 15,
    ],
    // Altre sezioni...
];
```

## Lista di Priorità per le Correzioni

1. File con naming errato (urgente)
2. File con struttura completamente mancante (alta priorità)
3. File con struttura parziale (media priorità)
4. Allineamento dei file in inglese (dopo la correzione italiana)

## Riferimenti

- [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
- [Guida alla Struttura dei File di Traduzione](./TRANSLATION_FILE_STRUCTURE_GUIDE.md)
- [Progresso della Standardizzazione](./TRANSLATION_STANDARDS_PROGRESS.md)
- [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
- [Guida alla Struttura dei File di Traduzione](../../translation_file_structure_guide.md)
- [Progresso della Standardizzazione](../../translation_standards_progress.md)

---

## translation_file_naming_rules

*Consolidated from: `translation_file_naming_rules.md`*


## Principi Fondamentali per il Naming dei File

Le seguenti regole si applicano a tutti i file di traduzione nel modulo Notify:

1. **Snake Case Obbligatorio**
   - Tutti i nomi dei file devono utilizzare snake_case (lettere minuscole separate da underscore)
   - Esempio: `send_email.php`, `mail_template.php`

2. **Termini Composti e Acronimi**
   - Gli acronimi (SMS, AWS, ecc.) devono essere trattati come parole singole
   - I termini composti come "WhatsApp" devono essere trattati come una singola parola
   - ✅ CORRETTO: `send_whatsapp.php`, `send_sms.php`, `send_aws_email.php`
   - ❌ ERRATO: `send_whats_app.php`, `send_s_m_s.php`, `sendWhatsApp.php`

3. **Coerenza con il Namespace**
   - Il nome del file deve rispecchiare il namespace o la risorsa a cui si riferisce
   - Per pagine di invio: `send_[provider].php` (es. `send_telegram.php`)
   - Per risorse generali: `[resource].php` (es. `whatsapp.php`, `telegram.php`)

## Verifica della Conformità

Prima di aggiungere nuovi file di traduzione, verificare:
1. Che il nome rispetti i principi snake_case
2. Che i termini composti siano trattati correttamente
3. Che sia coerente con gli altri file dello stesso tipo

## Correzione dei File Non Conformi

Se si identifica un file con naming non conforme:
1. Creare una nuova versione con il nome corretto
2. Assicurarsi che tutti i riferimenti nel codice siano aggiornati
3. Rimuovere il file con naming errato

## Riferimenti
- [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)

---

## translation_file_structure_guide

*Consolidated from: `translation_file_structure_guide.md`*


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
- [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
- [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)

---

## translation_implementation_plan

*Consolidated from: `translation_implementation_plan.md`*


Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di <nome progetto>.
Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di SaluteOra.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione esistenti, sono stati identificati i seguenti problemi:

1. **File con Nomi Errati**:
   - `send_s_m_s.php` invece di `send_sms.php`
   - `send_a_w_s_email.php` invece di `send_aws_email.php`
   - `send_whats_app.php` invece di `send_whatsapp.php`
   - `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

2. **File Senza Nome**:
   - `.php` (file senza nome)

3. **Duplicazione**:
   - In alcuni casi esistono sia le versioni corrette che quelle errate dei file

4. **Inconsistenza tra Lingue**:
   - La cartella "en" contiene solo 3 file, mentre la cartella "it" ne contiene molti di più

5. **Struttura Non Standardizzata**:
   - I file di traduzione non seguono una struttura coerente

## Strategia di Implementazione

### Fase 1: Pulizia dei File Errati

1. **Rimozione dei File Senza Nome**:
   - Rimuovere il file `.php`

2. **Consolidamento dei File Duplicati**:
   - Per ogni coppia di file (es. `send_s_m_s.php` e `send_sms.php`):
     - Verificare che il contenuto del file corretto sia completo
     - Se necessario, integrare il contenuto del file errato nel file corretto
     - Rimuovere il file con nome errato

### Fase 2: Standardizzazione della Struttura

1. **Applicazione del Template Standard**:
   - Assicurarsi che tutti i file seguano la struttura standard definita
   - Aggiungere `declare(strict_types=1);` a tutti i file
   - Organizzare le chiavi in modo gerarchico

2. **Completezza delle Traduzioni**:
   - Assicurarsi che tutte le chiavi necessarie siano presenti in ogni file

### Fase 3: Sincronizzazione tra Lingue

1. **Creazione dei File Mancanti in Inglese**:
   - Per ogni file italiano, creare il corrispondente file inglese se non esiste

2. **Verifica della Coerenza**:
   - Assicurarsi che le stesse chiavi esistano in tutte le lingue

### Fase 4: Documentazione e Monitoraggio

1. **Aggiornamento della Documentazione**:
   - Mantenere aggiornata la documentazione sugli standard di traduzione

2. **Implementazione di Strumenti di Monitoraggio**:
   - Considerare l'implementazione di strumenti per verificare la completezza e coerenza delle traduzioni

## Implementazione Tecnica

### Script di Pulizia

```bash

# Rimozione dei file senza nome
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f [project-root]/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f [project-root]/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f [project-root]/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f [project-root]/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f [project-root]/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/_bases/<nome repository>/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
```

### Template Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
    ],
];
```

## Conclusione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.

---

## translation_keys_best_practices

*Consolidated from: `translation_keys_best_practices.md`*


## Politica
La politica del progetto è garantire inclusività, accessibilità e rispetto per tutte le culture e le diversità linguistiche. Ogni chiave di traduzione deve essere pensata per essere neutra, rispettosa e non discriminatoria.

## Filosofia
Crediamo nella chiarezza, nella semplicità e nella trasparenza. Ogni chiave di traduzione deve aiutare lo sviluppatore e l'utente a sentirsi accolto e guidato, senza ambiguità o tecnicismi inutili.

## Religione
Il sistema di traduzioni è laico e neutrale rispetto a ogni credo. Non sono ammesse espressioni, simboli o riferimenti religiosi, salvo esplicita richiesta di progetto e sempre nel rispetto di tutte le fedi.

## Etica
Le chiavi di traduzione devono essere oneste, non ingannevoli, non manipolatorie e non offensive. L'etica del progetto impone di evitare ogni forma di linguaggio discriminatorio, sessista, razzista o che possa ledere la dignità della persona.

## Zen
La chiave di traduzione perfetta è quella che non si nota: è naturale, fluida, non distrae e non crea attrito. Ogni parola superflua va eliminata, ogni concetto va reso con la massima semplicità e armonia. 

---

## translation_keys_rules

*Consolidated from: `translation_keys_rules.md`*


## [2024-07-07] Aggiornamento regole e best practice traduzioni modulo Notify

### Errori riscontrati
- Chiavi di traduzione non strutturate gerarchicamente
- Valori come 'send sms.navigation' o simili non conformi
- Mancanza di coerenza tra i file di traduzione dei vari canali (SMS, WhatsApp, Email, ecc.)
- Assenza di sezioni 'fields' e 'actions' in alcuni file

### Correzioni applicate
- Tutte le chiavi ora sono strutturate ad array annidati
- I valori sono descrittivi e localizzati, mai chiavi in italiano
- Aggiunte sezioni 'fields' e 'actions' dove mancanti
- Aggiornata la documentazione e le regole interne

### Best practice
- Prima di ogni modifica, consultare questa documentazione e quella centrale in `../../Lang/docs`
- Usare sempre nomi chiave descrittivi e struttura gerarchica
- Aggiornare contestualmente la documentazione in caso di nuove regole

### Esempio pratico

```php
return [
    'navigation' => [
        'label' => 'Invio WhatsApp',
        'group' => 'Notifiche',
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
        ],
    ],
];
```

### Riferimenti
- [TRANSLATION_KEYS_RULES.md](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md) 
- [TRANSLATION_KEYS_RULES.md](../../../../Lang/docs/translation_keys_rules.md)
- [TRANSLATION_KEYS_BEST_PRACTICES.md](../../../../Lang/docs/translation_keys_best_practices.md) 

---

## translation_standards

*Consolidated from: `translation_standards.md`*

# Standard per le Traduzioni

Questo documento definisce gli standard e le best practices per la gestione delle traduzioni all'interno dei moduli di <nome progetto>, con particolare attenzione al modulo Notify.
# Standard per le Traduzioni 

Questo documento definisce gli standard e le best practices per la gestione delle traduzioni all'interno dei moduli di SaluteOra, con particolare attenzione al modulo Notify.

## Struttura delle Cartelle

Le traduzioni devono essere organizzate nelle seguenti cartelle:

```
/Modules/[ModuleName]/lang/
  ├── en/                 # Traduzioni inglesi
  │   └── *.php           # File di traduzione inglesi
  └── it/                 # Traduzioni italiane
      └── *.php           # File di traduzione italiani
```

## Convenzioni di Naming per i File di Traduzione

### Regole Fondamentali

1. **Nomi in snake_case**: Tutti i file di traduzione devono utilizzare il formato `snake_case.php`
2. **Nomi Semantici**: I nomi devono riflettere il contesto o la risorsa a cui si riferiscono
3. **Nomi Coerenti**: Lo stesso file deve esistere in tutte le lingue supportate
4. **Evitare Acronimi nel Nome del File**: Scrivere per esteso (es. `send_aws_email.php` invece di `send_a_w_s_email.php`)

### Esempi Corretti

✅ `send_sms.php` (non `send_s_m_s.php`)
✅ `send_aws_email.php` (non `send_a_w_s_email.php`)
✅ `send_whatsapp.php` (non `send_whats_app.php`)
✅ `send_sms.php` (non `send_s_m_s.php`)  
✅ `send_aws_email.php` (non `send_a_w_s_email.php`)  
✅ `send_whatsapp.php` (non `send_whats_app.php`)  

## Struttura dei File di Traduzione

### Formato Standard

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50, // Ordine nel menu
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
        // Altri campi...
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
        // Altre azioni...
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        // Altri messaggi...
    ],
];
```

### Regole per le Chiavi di Traduzione

1. **Struttura Gerarchica**: Utilizzare una struttura nidificata per organizzare le traduzioni
2. **Chiavi in snake_case**: Tutte le chiavi devono essere in `snake_case`
3. **Evitare Stringhe Piatte**: Non utilizzare un array piatto di traduzioni
4. **Consistenza tra Lingue**: Le stesse chiavi devono esistere in tutte le lingue

## Utilizzo delle Traduzioni

### In Filament

```php
// Corretto
protected static ?string $navigationLabel = null; // Usa il LangServiceProvider

// Errato
protected static ?string $navigationLabel = 'Invio SMS'; // Hardcoded
```

### In Blade

```php
// Corretto
{{ __('notify::send_sms.fields.to.label') }}

// Errato
{{ __('notify::send_sms.to') }}
```

## Gestione delle Traduzioni Mancanti

1. **Completezza**: Assicurarsi che tutte le chiavi esistano in tutte le lingue
2. **Fallback**: Configurare correttamente il fallback alla lingua predefinita
3. **Monitoraggio**: Implementare un sistema per identificare le traduzioni mancanti

## Processo di Aggiornamento

1. **Sincronizzazione**: Mantenere sincronizzate le traduzioni tra le diverse lingue
2. **Revisione**: Rivedere periodicamente le traduzioni per consistenza e qualità
3. **Automazione**: Utilizzare strumenti per facilitare la gestione delle traduzioni

## Errori Comuni da Evitare

1. **Nomi File Errati**: `send_s_m_s.php` invece di `send_sms.php`
2. **File Senza Nome**: `.php` (file senza nome)
3. **Traduzioni Incomplete**: File con solo alcune chiavi
4. **Inconsistenza tra Lingue**: File che esistono solo in alcune lingue
5. **Stringhe Hardcoded**: Testo hardcoded invece di utilizzare le traduzioni

## Strumenti Utili

1. **Laravel Translation Manager**: Per gestire e sincronizzare le traduzioni
2. **Laravel Lang**: Per traduzioni comuni di Laravel
3. **Script Personalizzati**: Per verificare la completezza e consistenza delle traduzioni

---

## translation_standards_progress

*Consolidated from: `translation_standards_progress.md`*


## Stato Attuale - 12/05/2025

### Problemi Identificati

1. **Convenzioni di Naming Non Rispettate**
   - File `send_whats_app.php` utilizzava naming errato (WhatsApp separato da underscore)
   - La convenzione corretta richiede di trattare "WhatsApp" come un'unica parola in snake_case: `send_whatsapp.php`

2. **Elementi Strutturali Mancanti**
   - Analisi ha rivelato che 20 file di traduzione mancano della dichiarazione `declare(strict_types=1);`
   - Molti file non contengono la sezione `resource` obbligatoria
   - Le strutture gerarchiche sono spesso incomplete (mancano elementi come icon, sort, plural in navigation)

3. **File Problematici Identificati**
   - `[project-root]/laravel/Modules/Notify/lang/it/send_aws_email.php`
   - `[project-root]/laravel/Modules/Notify/lang/it/setting.php`
   - `[project-root]/laravel/Modules/Notify/lang/it/edit_mail_template.php`
   - `[project-root]/laravel/Modules/Notify/lang/it/send_netfun_sms.php`
   - `[project-root]/laravel/Modules/Notify/lang/it/notification_template.php`
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_aws_email.php`
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/setting.php`
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/edit_mail_template.php`
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_netfun_sms.php`
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/notification_template.php`
   - E altri 15 file (elenco completo in appendice)

### Correzioni Implementate

1. **Documentazione Standard**
   - Creato `[project-root]/laravel/Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md`
   - Creato `[project-root]/laravel/Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md`

2. **File Corretti**
   - Creato `[project-root]/laravel/Modules/Notify/lang/it/send_whatsapp.php` con struttura corretta
   - Aggiornato `[project-root]/laravel/Modules/Notify/lang/it/send_netfun_sms.php` con struttura completa
   - Creato `/var/www/html/saluteora/laravel/Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md`
   - Creato `/var/www/html/saluteora/laravel/Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md`

2. **File Corretti**
   - Creato `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_whatsapp.php` con struttura corretta
   - Aggiornato `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_netfun_sms.php` con struttura completa
   - Rimosso il file con naming errato `send_whats_app.php`

### Prossime Correzioni da Implementare

1. **File da Correggere Prioritariamente**
   - `[project-root]/laravel/Modules/Notify/lang/it/send_email.php`
   - `[project-root]/laravel/Modules/Notify/lang/it/send_sms.php`
   - `[project-root]/laravel/Modules/Notify/lang/it/send_telegram.php`

2. **Verifiche da Eseguire**
   - Analisi della cartella `[project-root]/laravel/Modules/Notify/lang/en/` per identificare problemi simili
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_email.php`
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_sms.php`
   - `/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_telegram.php`

2. **Verifiche da Eseguire**
   - Analisi della cartella `/var/www/html/saluteora/laravel/Modules/Notify/lang/en/` per identificare problemi simili
   - Controllo dei riferimenti nel codice che potrebbero puntare ai vecchi file

## Documentazione di Riferimento

1. **Standard di Traduzione**
   - [Regole Generali per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
   - [Best Practices per le Traduzioni](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
   - [Regole di Naming per i File di Traduzione](./TRANSLATION_FILE_NAMING_RULES.md)
   - [Guida alla Struttura dei File di Traduzione](./TRANSLATION_FILE_STRUCTURE_GUIDE.md)
   - [Regole Generali per le Traduzioni](../../../../Lang/docs/translation_keys_rules.md)
   - [Best Practices per le Traduzioni](../../../../Lang/docs/translation_keys_best_practices.md)

2. **Guide Specifiche per Notify**
   - [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
   - [Regole di Naming per i File di Traduzione](../../translation_file_naming_rules.md)
   - [Guida alla Struttura dei File di Traduzione](../../translation_file_structure_guide.md)

## Appendice: Elenco Completo dei File Non Conformi

```
[project-root]/laravel/Modules/Notify/lang/it/send_aws_email.php
[project-root]/laravel/Modules/Notify/lang/it/setting.php
[project-root]/laravel/Modules/Notify/lang/it/edit_mail_template.php
[project-root]/laravel/Modules/Notify/lang/it/send_netfun_sms.php (corretto)
[project-root]/laravel/Modules/Notify/lang/it/notification_template.php
[project-root]/laravel/Modules/Notify/lang/it/notify.php
[project-root]/laravel/Modules/Notify/lang/it/contacts.php
[project-root]/laravel/Modules/Notify/lang/it/test_smtp.php
[project-root]/laravel/Modules/Notify/lang/it/log.php
[project-root]/laravel/Modules/Notify/lang/it/send_sms.php
[project-root]/laravel/Modules/Notify/lang/it/contact.php
[project-root]/laravel/Modules/Notify/lang/it/slack_notification.php
[project-root]/laravel/Modules/Notify/lang/it/template.php
[project-root]/laravel/Modules/Notify/lang/it/send_push_notification.php
[project-root]/laravel/Modules/Notify/lang/it/dashboard.php
[project-root]/laravel/Modules/Notify/lang/it/send_whats_app.php (rimosso e sostituito)
[project-root]/laravel/Modules/Notify/lang/it/send_firebase_push_notification.php
[project-root]/laravel/Modules/Notify/lang/it/send_email.php
[project-root]/laravel/Modules/Notify/lang/it/send_spatie_email.php
[project-root]/laravel/Modules/Notify/lang/it/create_mail_template.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_aws_email.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/setting.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/edit_mail_template.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_netfun_sms.php (corretto)
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/notification_template.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/notify.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/contacts.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/test_smtp.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/log.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_sms.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/contact.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/slack_notification.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/template.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_push_notification.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/dashboard.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_whats_app.php (rimosso e sostituito)
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_firebase_push_notification.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_email.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_spatie_email.php
/var/www/html/saluteora/laravel/Modules/Notify/lang/it/create_mail_template.php
```

---

## translations-implementation-status-1

*Consolidated from: `translations-implementation-status.md`*


## Panoramica

Questo documento fornisce una panoramica completa dello stato attuale dell'implementazione delle traduzioni nel modulo Notify, identificando le convenzioni in uso, le discrepanze con le convenzioni generali di <nome progetto> e le azioni necessarie per garantire la coerenza.

## Convenzioni Attuali nel Modulo Notify

### Naming dei File

Il modulo Notify utilizza attualmente due pattern principali per i file di traduzione:

1. **File Funzionali**: Utilizzano il prefisso `send_` e descrivono funzionalità specifiche
   - Esempi: `send_whats_app.php`, `send_sms.php`, `send_email.php`

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `whatsapp.php`, `sms.php`, `email.php`

### Struttura delle Chiavi

La struttura delle chiavi segue questo pattern:

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

## Discrepanza con le Convenzioni Generali

Esiste una discrepanza tra le convenzioni utilizzate nel modulo Notify e le convenzioni generali di <nome progetto>:

1. **Convenzioni Generali (Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)**:
   - Struttura gerarchica espansa senza chiavi come `.navigation`
   - Formato: `modulo::risorsa.fields.campo.label`
   - Nessun uso di chiavi in italiano

2. **Convenzioni del Modulo Notify**:
   - Uso esplicito della chiave `navigation`
   - File con prefisso `send_` in snake_case
   - Struttura specifica per le funzionalità di invio notifiche

## Stato Attuale dei File di Traduzione

### File con Chiave `.navigation`

Questi file utilizzano la chiave `.navigation` che è specifica del modulo Notify:

1. `send_whats_app.php`
2. `send_sms.php`
3. `send_email.php`
4. `send_telegram.php`
5. `send_push_notification.php`
6. `send_firebase_push_notification.php`
7. `send_aws_email.php`
8. `send_spatie_email.php`
9. `send_netfun_sms.php`
10. `send_email_parameters.php`

### File con Struttura Standard

Questi file seguono una struttura più standard:

1. `whatsapp.php`
2. `sms.php`
3. `email.php`
4. `telegram.php`
5. `notification.php`
6. `template.php`
7. `channel.php`

## Decisione di Implementazione

Dopo un'analisi approfondita, è stato determinato che:

1. **Le convenzioni specifiche del modulo Notify sono valide per questo modulo**
   - I file con prefisso `send_` e la struttura con chiave `navigation` sono intenzionali e necessari per il funzionamento del modulo

2. **Questa struttura rappresenta un'eccezione documentata alle convenzioni generali**
   - È importante mantenere questa struttura per garantire la compatibilità con il codice esistente

## Azioni Intraprese

Per chiarire questa situazione e prevenire confusioni future, sono state intraprese le seguenti azioni:

1. **Documentazione Aggiornata**:
   - Creato il documento `TRANSLATION_CONVENTIONS_CLARIFICATION.md` che spiega la discrepanza
   - Aggiornate le regole in `.windsurf/rules/translation-conventions-notify.md` e `.cursor/rules/translation-conventions-notify.md`

2. **Mantenimento della Struttura Esistente**:
   - I file di traduzione esistenti sono stati mantenuti con la loro struttura attuale
   - Non è necessario modificare questi file per conformarsi alle convenzioni generali

## Prossimi Passi

Per garantire la coerenza futura, si raccomanda di:

1. **Seguire le Convenzioni Specifiche del Modulo**:
   - Quando si creano nuovi file di traduzione nel modulo Notify, seguire le convenzioni specifiche del modulo
   - Mantenere la coerenza con i file esistenti

2. **Documentare Chiaramente le Eccezioni**:
   - Continuare a documentare chiaramente le eccezioni alle convenzioni generali
   - Assicurarsi che tutti gli sviluppatori siano consapevoli di queste eccezioni

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Chiarimento sulle Convenzioni di Traduzione](./TRANSLATION_CONVENTIONS_CLARIFICATION.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)

---

## translations-implementation-status-2

*Consolidated from: `translations-implementation-status.md`*

title: "Translations Implementation Status"
type: concept
tags: [translations, implementation, status]
created: 2026-07-14
updated: 2026-07-14
qmd: "translations-implementation-status-2 translations implementation status"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

- [Convenzioni di Traduzione nel Modulo Notify](./translation-conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](./translation-conventions-clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)
# Translations Implementation Status

Current status of translation implementation across the module.
---

## translations-implementation-status

*Consolidated from: `translations-implementation-status.md`*


## Panoramica

Questo documento fornisce una panoramica completa dello stato attuale dell'implementazione delle traduzioni nel modulo Notify, identificando le convenzioni in uso, le discrepanze con le convenzioni generali di  e le azioni necessarie per garantire la coerenza.
Questo documento fornisce una panoramica completa dello stato attuale dell'implementazione delle traduzioni nel modulo Notify, identificando le convenzioni in uso, le discrepanze con le convenzioni generali di <nome progetto> e le azioni necessarie per garantire la coerenza.

## Convenzioni Attuali nel Modulo Notify

### Naming dei File

Il modulo Notify utilizza attualmente due pattern principali per i file di traduzione:

1. **File Funzionali**: Utilizzano il prefisso `send_` e descrivono funzionalità specifiche
   - Esempi: `send_whats_app.php`, `send_sms.php`, `send_email.php`

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `whatsapp.php`, `sms.php`, `email.php`

### Struttura delle Chiavi

La struttura delle chiavi segue questo pattern:

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

## Discrepanza con le Convenzioni Generali

Esiste una discrepanza tra le convenzioni utilizzate nel modulo Notify e le convenzioni generali di :
Esiste una discrepanza tra le convenzioni utilizzate nel modulo Notify e le convenzioni generali di <nome progetto>:

1. **Convenzioni Generali (Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)**:
   - Struttura gerarchica espansa senza chiavi come `.navigation`
   - Formato: `modulo::risorsa.fields.campo.label`
   - Nessun uso di chiavi in italiano

2. **Convenzioni del Modulo Notify**:
   - Uso esplicito della chiave `navigation`
   - File con prefisso `send_` in snake_case
   - Struttura specifica per le funzionalità di invio notifiche

## Stato Attuale dei File di Traduzione

### File con Chiave `.navigation`

Questi file utilizzano la chiave `.navigation` che è specifica del modulo Notify:

1. `send_whats_app.php`
2. `send_sms.php`
3. `send_email.php`
4. `send_telegram.php`
5. `send_push_notification.php`
6. `send_firebase_push_notification.php`
7. `send_aws_email.php`
8. `send_spatie_email.php`
9. `send_netfun_sms.php`
10. `send_email_parameters.php`

### File con Struttura Standard

Questi file seguono una struttura più standard:

1. `whatsapp.php`
2. `sms.php`
3. `email.php`
4. `telegram.php`
5. `notification.php`
6. `template.php`
7. `channel.php`

## Decisione di Implementazione

Dopo un'analisi approfondita, è stato determinato che:

1. **Le convenzioni specifiche del modulo Notify sono valide per questo modulo**
   - I file con prefisso `send_` e la struttura con chiave `navigation` sono intenzionali e necessari per il funzionamento del modulo

2. **Questa struttura rappresenta un'eccezione documentata alle convenzioni generali**
   - È importante mantenere questa struttura per garantire la compatibilità con il codice esistente

## Azioni Intraprese

Per chiarire questa situazione e prevenire confusioni future, sono state intraprese le seguenti azioni:

1. **Documentazione Aggiornata**:
   - Creato il documento `TRANSLATION_CONVENTIONS_CLARIFICATION.md` che spiega la discrepanza
   - Aggiornate le regole in `.windsurf/rules/translation-conventions-notify.md` e `.cursor/rules/translation-conventions-notify.md`

2. **Mantenimento della Struttura Esistente**:
   - I file di traduzione esistenti sono stati mantenuti con la loro struttura attuale
   - Non è necessario modificare questi file per conformarsi alle convenzioni generali

## Prossimi Passi

Per garantire la coerenza futura, si raccomanda di:

1. **Seguire le Convenzioni Specifiche del Modulo**:
   - Quando si creano nuovi file di traduzione nel modulo Notify, seguire le convenzioni specifiche del modulo
   - Mantenere la coerenza con i file esistenti

2. **Documentare Chiaramente le Eccezioni**:
   - Continuare a documentare chiaramente le eccezioni alle convenzioni generali
   - Assicurarsi che tutti gli sviluppatori siano consapevoli di queste eccezioni

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Chiarimento sulle Convenzioni di Traduzione](./TRANSLATION_CONVENTIONS_CLARIFICATION.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)

---

## translations-implementation

*Consolidated from: `translations-implementation.md`*


## Panoramica

Questo documento fornisce una panoramica completa dello stato attuale dell'implementazione delle traduzioni nel modulo Notify, identificando le convenzioni in uso, le discrepanze con le convenzioni generali di  e le azioni necessarie per garantire la coerenza.
Questo documento fornisce una panoramica completa dello stato attuale dell'implementazione delle traduzioni nel modulo Notify, identificando le convenzioni in uso, le discrepanze con le convenzioni generali di <nome progetto> e le azioni necessarie per garantire la coerenza.

## Convenzioni Attuali nel Modulo Notify

### Naming dei File

Il modulo Notify utilizza attualmente due pattern principali per i file di traduzione:

1. **File Funzionali**: Utilizzano il prefisso `send_` e descrivono funzionalità specifiche
   - Esempi: `send_whats_app.php`, `send_sms.php`, `send_email.php`

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `whatsapp.php`, `sms.php`, `email.php`

### Struttura delle Chiavi

La struttura delle chiavi segue questo pattern:

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

## Discrepanza con le Convenzioni Generali

Esiste una discrepanza tra le convenzioni utilizzate nel modulo Notify e le convenzioni generali di :
Esiste una discrepanza tra le convenzioni utilizzate nel modulo Notify e le convenzioni generali di <nome progetto>:

1. **Convenzioni Generali (Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)**:
   - Struttura gerarchica espansa senza chiavi come `.navigation`
   - Formato: `modulo::risorsa.fields.campo.label`
   - Nessun uso di chiavi in italiano

2. **Convenzioni del Modulo Notify**:
   - Uso esplicito della chiave `navigation`
   - File con prefisso `send_` in snake_case
   - Struttura specifica per le funzionalità di invio notifiche

## Stato Attuale dei File di Traduzione

### File con Chiave `.navigation`

Questi file utilizzano la chiave `.navigation` che è specifica del modulo Notify:

1. `send_whats_app.php`
2. `send_sms.php`
3. `send_email.php`
4. `send_telegram.php`
5. `send_push_notification.php`
6. `send_firebase_push_notification.php`
7. `send_aws_email.php`
8. `send_spatie_email.php`
9. `send_netfun_sms.php`
10. `send_email_parameters.php`

### File con Struttura Standard

Questi file seguono una struttura più standard:

1. `whatsapp.php`
2. `sms.php`
3. `email.php`
4. `telegram.php`
5. `notification.php`
6. `template.php`
7. `channel.php`

## Decisione di Implementazione

Dopo un'analisi approfondita, è stato determinato che:

1. **Le convenzioni specifiche del modulo Notify sono valide per questo modulo**
   - I file con prefisso `send_` e la struttura con chiave `navigation` sono intenzionali e necessari per il funzionamento del modulo

2. **Questa struttura rappresenta un'eccezione documentata alle convenzioni generali**
   - È importante mantenere questa struttura per garantire la compatibilità con il codice esistente

## Azioni Intraprese

Per chiarire questa situazione e prevenire confusioni future, sono state intraprese le seguenti azioni:

1. **Documentazione Aggiornata**:
   - Creato il documento `TRANSLATION_CONVENTIONS_CLARIFICATION.md` che spiega la discrepanza
   - Aggiornate le regole in `.windsurf/rules/translation-conventions-notify.md` e `.cursor/rules/translation-conventions-notify.md`

2. **Mantenimento della Struttura Esistente**:
   - I file di traduzione esistenti sono stati mantenuti con la loro struttura attuale
   - Non è necessario modificare questi file per conformarsi alle convenzioni generali

## Prossimi Passi

Per garantire la coerenza futura, si raccomanda di:

1. **Seguire le Convenzioni Specifiche del Modulo**:
   - Quando si creano nuovi file di traduzione nel modulo Notify, seguire le convenzioni specifiche del modulo
   - Mantenere la coerenza con i file esistenti

2. **Documentare Chiaramente le Eccezioni**:
   - Continuare a documentare chiaramente le eccezioni alle convenzioni generali
   - Assicurarsi che tutti gli sviluppatori siano consapevoli di queste eccezioni

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](./translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../lang/docs/translation-keys-best-practices.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation-keys-best-practices.md)

---

## translations

*Consolidated from: `translations.md`*


## Panoramica

Il modulo Notify utilizza file di traduzione per gestire tutti i testi dell'interfaccia utente. Questo approccio garantisce la coerenza e la manutenibilità delle traduzioni.

## Struttura dei File

```
lang/
├── it/
│   └── template.php
└── en/
    └── template.php

## Formato delle Traduzioni

### Template

```php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del template',
            'help' => 'Il nome identificativo del template',
            'tooltip' => 'Questo campo è obbligatorio',
        ],
        // Altri campi...
    'navigation' => [
        'label' => 'Template Notifiche',
        'group' => 'Notifiche',
        'icon' => 'heroicon-o-bell',
    'messages' => [
        'success' => [
            'created' => 'Template creato con successo',
            'updated' => 'Template aggiornato con successo',
            'deleted' => 'Template eliminato con successo',
        ],
        'errors' => [
            'not_found' => 'Template non trovato',
            'unauthorized' => 'Non autorizzato',
];
```

## Utilizzo

### Nei Form

```php
Forms\Components\TextInput::make('name')
// Le label sono gestite automaticamente dal file di traduzione

### Nella Navigazione

protected static function getNavigationLabel(): string
{
    return __('notify::template.navigation.label');
}

### Nei Messaggi

Notification::make()
    ->success()
    ->title(__('notify::template.messages.success.created'));
```

## Best Practices

1. **Organizzazione**
   - Separare le traduzioni per contesto
   - Mantenere una struttura coerente
   - Usare nomi di chiavi descrittivi

2. **Formato**
   - Usare array associativi per i campi
   - Includere tutte le proprietà di testo
   - Mantenere coerenza tra le lingue

3. **Manutenzione**
   - Aggiornare tutte le lingue insieme
   - Rimuovere traduzioni non utilizzate
   - Documentare le modifiche

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura delle Traduzioni](../../../../../docs/architecture/translations.md)
- [Gestione Lingue](../../../../../docs/architecture/languages.md)

### Collegamenti ai Moduli
- [LangServiceProvider](../../Lang/docs/service-provider.md)
- [Regole Traduzioni](../../../../../docs/regole/traduzioni.md)

## Note Importanti

1. Mai usare testo hardcoded nel codice
2. Mantenere le traduzioni aggiornate
3. Seguire la struttura standard
4. Documentare le modifiche
### Versione HEAD

5. Testare tutte le lingue

### Versione Incoming

```
## Collegamenti tra versioni di translations.md
* [translations.md](../../../Chart/docs/translations.md)
* [translations.md](../../../Reporting/docs/translations.md)
* [translations.md](../../../Gdpr/docs/translations.md)
* [translations.md](../../../Notify/docs/translations.md)
* [translations.md](../../../Xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../Xot/docs/translations.md)
* [translations.md](../../../Dental/docs/translations.md)
* [translations.md](../../../User/docs/translations.md)
* [translations.md](../../../UI/docs/translations.md)
* [translations.md](../../../Lang/docs/packages/translations.md)
* [translations.md](../../../Lang/docs/translations.md)
* [translations.md](../../../Job/docs/translations.md)
* [translations.md](../../../Media/docs/translations.md)
* [translations.md](../../../Tenant/docs/translations.md)
* [translations.md](../../../Activity/docs/translations.md)
* [translations.md](../../../../Gdpr/docs/translations.md)
* [translations.md](../../translations.md)
* [translations.md](../../../Xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../Xot/docs/translations.md)
* [translations.md](../../../Dental/docs/translations.md)
* [translations.md](../../../../User/docs/translations.md)
* [translations.md](../../../UI/docs/translations.md)
* [translations.md](../../../../Lang/docs/packages/translations.md)
* [translations.md](../../../../Lang/docs/translations.md)
* [translations.md](../../../../Job/docs/translations.md)
* [translations.md](../../../../Media/docs/translations.md)
* [translations.md](../../../../Tenant/docs/translations.md)
* [translations.md](../../../../Activity/docs/translations.md)
* [translations.md](../../../Patient/docs/translations.md)
* [translations.md](../../../Cms/docs/translations.md)

---

## translations_implementation_status

*Consolidated from: `translations_implementation_status.md`*


## Panoramica

Questo documento fornisce una panoramica completa dello stato attuale dell'implementazione delle traduzioni nel modulo Notify, identificando le convenzioni in uso, le discrepanze con le convenzioni generali di <nome progetto> e le azioni necessarie per garantire la coerenza.
Questo documento fornisce una panoramica completa dello stato attuale dell'implementazione delle traduzioni nel modulo Notify, identificando le convenzioni in uso, le discrepanze con le convenzioni generali di SaluteOra e le azioni necessarie per garantire la coerenza.

## Convenzioni Attuali nel Modulo Notify

### Naming dei File

Il modulo Notify utilizza attualmente due pattern principali per i file di traduzione:

1. **File Funzionali**: Utilizzano il prefisso `send_` e descrivono funzionalità specifiche
   - Esempi: `send_whats_app.php`, `send_sms.php`, `send_email.php`

2. **File di Risorse**: Rappresentano risorse o entità del sistema
   - Esempi: `whatsapp.php`, `sms.php`, `email.php`

### Struttura delle Chiavi

La struttura delle chiavi segue questo pattern:

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

## Discrepanza con le Convenzioni Generali

Esiste una discrepanza tra le convenzioni utilizzate nel modulo Notify e le convenzioni generali di <nome progetto>:
Esiste una discrepanza tra le convenzioni utilizzate nel modulo Notify e le convenzioni generali di SaluteOra:

1. **Convenzioni Generali (Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)**:
   - Struttura gerarchica espansa senza chiavi come `.navigation`
   - Formato: `modulo::risorsa.fields.campo.label`
   - Nessun uso di chiavi in italiano

2. **Convenzioni del Modulo Notify**:
   - Uso esplicito della chiave `navigation`
   - File con prefisso `send_` in snake_case
   - Struttura specifica per le funzionalità di invio notifiche

## Stato Attuale dei File di Traduzione

### File con Chiave `.navigation`

Questi file utilizzano la chiave `.navigation` che è specifica del modulo Notify:

1. `send_whats_app.php`
2. `send_sms.php`
3. `send_email.php`
4. `send_telegram.php`
5. `send_push_notification.php`
6. `send_firebase_push_notification.php`
7. `send_aws_email.php`
8. `send_spatie_email.php`
9. `send_netfun_sms.php`
10. `send_email_parameters.php`

### File con Struttura Standard

Questi file seguono una struttura più standard:

1. `whatsapp.php`
2. `sms.php`
3. `email.php`
4. `telegram.php`
5. `notification.php`
6. `template.php`
7. `channel.php`

## Decisione di Implementazione

Dopo un'analisi approfondita, è stato determinato che:

1. **Le convenzioni specifiche del modulo Notify sono valide per questo modulo**
   - I file con prefisso `send_` e la struttura con chiave `navigation` sono intenzionali e necessari per il funzionamento del modulo

2. **Questa struttura rappresenta un'eccezione documentata alle convenzioni generali**
   - È importante mantenere questa struttura per garantire la compatibilità con il codice esistente

## Azioni Intraprese

Per chiarire questa situazione e prevenire confusioni future, sono state intraprese le seguenti azioni:

1. **Documentazione Aggiornata**:
   - Creato il documento `TRANSLATION_CONVENTIONS_CLARIFICATION.md` che spiega la discrepanza
   - Aggiornate le regole in `.windsurf/rules/translation-conventions-notify.md` e `.cursor/rules/translation-conventions-notify.md`

2. **Mantenimento della Struttura Esistente**:
   - I file di traduzione esistenti sono stati mantenuti con la loro struttura attuale
   - Non è necessario modificare questi file per conformarsi alle convenzioni generali

## Prossimi Passi

Per garantire la coerenza futura, si raccomanda di:

1. **Seguire le Convenzioni Specifiche del Modulo**:
   - Quando si creano nuovi file di traduzione nel modulo Notify, seguire le convenzioni specifiche del modulo
   - Mantenere la coerenza con i file esistenti

2. **Documentare Chiaramente le Eccezioni**:
   - Continuare a documentare chiaramente le eccezioni alle convenzioni generali
   - Assicurarsi che tutti gli sviluppatori siano consapevoli di queste eccezioni

## Collegamenti Correlati

- [Convenzioni di Traduzione nel Modulo Notify](./TRANSLATION_CONVENTIONS.md)
- [Chiarimento sulle Convenzioni di Traduzione](./TRANSLATION_CONVENTIONS_CLARIFICATION.md)
- [Regole Generali per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Best Practices per le Chiavi di Traduzione](../../Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md)
- [Convenzioni di Traduzione nel Modulo Notify](../../translation_conventions.md)
- [Chiarimento sulle Convenzioni di Traduzione](../../translation_conventions_clarification.md)
- [Regole Generali per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_rules.md)
- [Best Practices per le Chiavi di Traduzione](../../../../Lang/docs/translation_keys_best_practices.md)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04