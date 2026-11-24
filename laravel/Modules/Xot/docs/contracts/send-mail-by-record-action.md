---
title: "Contratto — SendMailByRecordAction"
type: contract
action: "Modules\Xot\Actions\Mail\SendMailByRecordAction"
tags: [contract, action, mail, pdf, personal-data]
created: 2026-11-24
updated: 2026-11-24
---

# SendMailByRecordAction

Sorgente: `app/Actions/Mail/SendMailByRecordAction.php`. Chiamante: `app/Actions/Mail/SendMailByRecordsAction.php` (un
invio per record). Manda al record il suo PDF via SMTP e registra l'invio nei log del record.

## Input

- `Model $record`: deve avere `email` non vuota, il metodo `myLogs()` e uno tra `msg(string)` e `option(string)`.
- `string $mailClass`: deve essere una classe esistente (controllata con `Assert::classExists`).

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| XOT-MAIL-RECORD-INV-1 | Senza `email` sul record nessuna mail parte e nessun log viene scritto: l'eccezione arriva prima di PDF e SMTP. | `XOT-MAIL-RECORD-INV-1` |
| XOT-MAIL-RECORD-INV-2 | Il destinatario è sempre `$record->email`, mai un indirizzo fisso o di debug. | — |
| XOT-MAIL-RECORD-INV-3 | Oggetto e testo vengono da `msg('mail_oggetto'/'mail_testo')` se esiste, altrimenti da `option(...)`. | — |
| XOT-MAIL-RECORD-INV-4 | Il log `act = 'sendMail'` si scrive solo dopo un invio SMTP riuscito. | — |

## Effetti collaterali

- Genera il PDF del record con `Export/PdfByModelAction` (`out: 'path'`, default `filename = 'my_doc.pdf'`,
  `disk = 'cache'`): scrive **sempre lo stesso file** `my_doc.pdf` sul disco `cache`. Due invii concorrenti (es. in coda
  con più worker) possono allegare il PDF di un altro record: per gli invii in parallelo è un rischio di dati personali.
- Invia una mail con il PDF allegato via `Modules\Notify\Datas\SmtpData::make()->send(EmailData)`.
- Scrive una riga di log con `$record->myLogs()->create(['act' => 'sendMail', 'handle' => authId()])`.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se `$mailClass` non esiste.
- `InvalidArgumentException` se manca `email`, `myLogs()`, `msg()`/`option()`, se l'email non è stringa, se il percorso
  del PDF non è stringa o se `myLogs()` non ha `create()`.
- Le eccezioni SMTP e di generazione del PDF risalgono: in quel caso il log non viene scritto.

## Non fa

- Non usa `$mailClass` per costruire la mail (il codice relativo è commentato): l'invio passa da `SmtpData`, la classe
  è solo controllata. Non aggiungere logica che si aspetti un `Mailable`.
- Non va in coda da sola: per l'invio asincrono il chiamante usa `->onQueue()`.
- Non cancella il PDF generato e non usa un nome di file per record.
- Non controlla consensi o preferenze di contatto del destinatario.
