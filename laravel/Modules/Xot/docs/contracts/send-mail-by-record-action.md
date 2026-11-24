---
title: "SendMailByRecordAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Mail\\SendMailByRecordAction"
qmd: "SendMailByRecordAction invio mail record email allegato PDF SmtpData myLogs sendMail msg option log authId"
---

# SendMailByRecordAction

Invia una mail a un record con oggetto e corpo letti dal record, allega il PDF del modello e registra l'invio nei log.

Codice: `app/Actions/Mail/SendMailByRecordAction.php:14-99`.

## Input

- `Model $record`: deve avere `email` non vuota e il metodo `myLogs()`.
- `string $mailClass`: verificato con `Assert::classExists`, poi non usato.

## Output

`void`.

## Invarianti

- `MAIL-REC-INV-1`: la classe `$mailClass` deve esistere (riga 26), ma non è usata per costruire il messaggio: il Mailable è commentato (righe 30-36). Test: Nessun test dedicato.
- `MAIL-REC-INV-2`: email assente o vuota: `InvalidArgumentException` (righe 39-41). Test: tests/Unit/SendMailByRecordActionTest.php:25.
- `MAIL-REC-INV-3`: senza metodo `myLogs` lancia `InvalidArgumentException` (righe 43-45). Test: Nessun test dedicato.
- `MAIL-REC-INV-4`: oggetto e corpo sono letti con `msg()` (`mail_oggetto`, `mail_testo`) se esiste, altrimenti con `option()`, altrimenti eccezione (righe 52-60); valori non stringa diventano stringa vuota (righe 65-70). Test: Nessun test dedicato.
- `MAIL-REC-INV-5`: il PDF del modello è generato con `PdfByModelAction` in modalità `path` e allegato (righe 72-85). Test: Nessun test dedicato.
- `MAIL-REC-INV-6`: ordine: generazione PDF, invio SMTP, poi scrittura del log `sendMail` con `authId()` (righe 86-97). Se la scrittura del log fallisce, la mail è già partita. Test: Nessun test dedicato.

## Effetti collaterali

Scrittura di un PDF in disco (disco `cache`, tramite `PdfByModelAction`). Invio SMTP tramite `SmtpData` (esterno, non annullabile). Insert in `myLogs`. Nessuna transazione: nessun rollback se un passo fallisce dopo l'invio.

## Errori

`InvalidArgumentException` per record non validi; errori SMTP e di PDF si propagano prima del log, quindi il tentativo non viene registrato.

## Non fa

- Non usa il Mailable indicato da `$mailClass`.
- Se oggetto o corpo non sono stringhe la mail parte con valori vuoti.
- Non gestisce retry né deduplica.
- Il codice contiene un indirizzo di debug commentato: non va riattivato.
