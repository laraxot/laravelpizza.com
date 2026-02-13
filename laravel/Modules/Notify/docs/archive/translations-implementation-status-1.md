# Stato dell'Implementazione delle Traduzioni nel Modulo Notify

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
