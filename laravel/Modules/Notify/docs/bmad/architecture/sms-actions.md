---
title: "Azioni SMS"
type: concept
tags: [sms, actions]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-actions-2 azioni sms"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Azioni SMS

## Interfaccia

Tutte le azioni di invio SMS devono implementare l'interfaccia `SmsActionInterface`:

```php
namespace Modules\Notify\Contracts\SMS;

interface SmsActionInterface
{
    /**
     * Esegue l'invio dell'SMS
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(SmsData $smsData): array;
}
```

## Struttura

Le azioni SMS sono organizzate secondo questa struttura:

1. **Contratti**: Le interfacce sono definite in `app/Contracts/SMS/`
2. **Implementazioni**: Le azioni concrete sono in `app/Actions/SMS/`
3. **Regole**:
   - Ogni azione deve implementare `SmsActionInterface`
   - Il metodo `execute()` deve accettare solo `SmsData`
   - Deve restituire un array con i dettagli dell'operazione
   - Deve gestire e loggare gli errori appropriatamente

## Provider Supportati

- Netfun
- Altri provider da aggiungere...

## Esempio di Utilizzo

```php
$smsData = new SmsData(
    to: '+393331234567',
    body: 'Il tuo codice OTP è: 123456',
from: 'Quaeris'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

## Best Practices

1. **Validazione**:
   - Validare sempre i dati in ingresso
   - Verificare il formato del numero di telefono
   - Controllare la lunghezza del messaggio

2. **Gestione Errori**:
   - Usare try/catch per gestire le eccezioni
   - Loggare gli errori con dettagli
   - Implementare retry per fallimenti temporanei

3. **Performance**:
   - Utilizzare le code per l'invio
   - Implementare rate limiting
   - Monitorare l'uso dell'API

4. **Sicurezza**:
   - Validare l'input degli utenti
   - Sanitizzare i messaggi
   - Proteggere le chiavi API