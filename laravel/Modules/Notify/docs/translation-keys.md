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