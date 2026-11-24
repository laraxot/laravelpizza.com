---
title: "SendMailByRecordsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Mail\\SendMailByRecordsAction"
qmd: "SendMailByRecordsAction invio mail multiplo collezione record ciclo SendMailByRecordAction"
---

# SendMailByRecordsAction

Invia la mail a ciascun record di una collezione, delegando a `SendMailByRecordAction`.

Codice: `app/Actions/Mail/SendMailByRecordsAction.php:11-26`.

## Input

- `Collection $records` di `Model`.
- `string $mail_class`: passato a ogni invio.

## Output

`bool`: sempre `true` se nessuna eccezione.

## Invarianti

- `MAIL-RECS-INV-1`: invia in ordine a ogni record; alla prima eccezione il ciclo si interrompe e i precedenti restano inviati (righe 20-22, nessun try). Test: Nessun test dedicato.
- `MAIL-RECS-INV-2`: restituisce `true` solo se il ciclo termina senza eccezioni (riga 24). Test: Nessun test dedicato.

## Effetti collaterali

Invii SMTP multipli, non transazionali.

## Errori

Propaga la prima eccezione di `SendMailByRecordAction`.

## Non fa

- Non raccoglie gli errori per record.
- Non verifica la lista di destinatari prima di iniziare.
