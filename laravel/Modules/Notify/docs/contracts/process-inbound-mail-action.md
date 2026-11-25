---
title: "Contratto — ProcessInboundMailAction"
type: contract
action: "Modules\Notify\Actions\Mail\ProcessInboundMailAction"
tags: [contract, action, notify, inbound, webhook, email]
created: 2026-11-24
updated: 2026-11-24
owner: Notify
status: accepted
qmd: "ProcessInboundMailAction webhook inbound email postmark mailgun MIME token InboundEmail eml"
---

# ProcessInboundMailAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Mail/ProcessInboundMailAction.php`. Decisione: [token nel percorso](../adr/webhooks-authenticate-with-a-token-in-the-path.md).

## Input

- `POST /api/inbound/{provider}/{token}` (rotta `notify.inbound`, `routes/api.php`).
- Payload riconosciuti, in quest'ordine: Postmark JSON (`MessageID`/`FromFull`), Mailgun form (`sender`/`body-mime`), MIME grezzo
  (`Content-Type: message/rfc822` o corpo che inizia con `From:`).
- Config: `notify.notify.inbound_token` (`MAIL_INBOUND_TOKEN`).

## Output

- `401 {"error":"unauthorized"}` con token errato o non configurato.
- `422 {"error":"unparseable"}` se il payload non è riconosciuto.
- `200 {"ok": true}` dopo il salvataggio.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| NOTIFY-INBOUND-INV-1 | Token confrontato con `hash_equals`; token non configurato = 401 per tutti, prima di leggere il payload. | `NOTIFY-INBOUND-INV-1` |
| NOTIFY-INBOUND-INV-2 | Un messaggio è una riga di `inbound_emails` per (`provider`, `message_id`): la ritrasmissione aggiorna, non duplica. | — |
| NOTIFY-INBOUND-INV-3 | Un payload non riconosciuto non scrive nulla (né file né riga) e risponde 422. | — |
| NOTIFY-INBOUND-INV-4 | La riga salvata ha `status = 'received'` e `received_at`. | — |

Debito: INV-2 e INV-4 sono provate da `tests/Feature/InboundMailWebhookTest.php` («stores postmark payload», «is idempotent on
message id»), oggi rosse nel DB di prova condiviso (manca la tabella `inbound_emails`): i group si aggiungono quando tornano verdi.

## Effetti collaterali

- Il corpo grezzo (o `body-mime`) su disco `local` in `inbound/{provider}/AAAA/MM/GG/<uuid>.eml`, se non vuoto; il percorso in `raw_path`.
- `InboundEmail::updateOrCreate` sulla connessione `notify`.
- `Log::warning('notify.inbound.parse_failed')` quando il payload non si legge.

## Errori

- Errori di parsing → 422 (non escono). Errori di disco o database → eccezione al framework (500, il provider riprova).

## Non fa

- Non deduplica i file: ogni ritrasmissione scrive un nuovo `.eml`, anche quando la riga viene solo aggiornata.
- Con `message_id` nullo la chiave diventa (`provider`, NULL): un secondo messaggio senza ID aggiorna la stessa riga (comportamento
  del codice com'è, da non imitare).
- Non smista né risponde ai messaggi e non crea entità di dominio: lo fa il progetto leggendo `inbound_emails`.
- Non cancella mai i `.eml` né le righe: la conservazione dei dati personali va decisa dal progetto.
- Non valida il `{provider}` dell'URL: è solo un'etichetta.
Webhook invocabile (`__invoke`) che riceve email in ingresso da Postmark, Mailgun o MIME grezzo e le salva in `InboundEmail`.

## Input

- `Request $request`: payload del provider.
- `string $provider`: provider dalla route.
- Route `token`: confrontato con `config('notify.notify.inbound_token')`.

## Output

- `JsonResponse`: `200 {ok: true}`; `401 {error: unauthorized}`; `422 {error: unparseable}`.

## Invarianti

- `NOTIFY-INBOUND-INV-1`: token assente, vuoto o diverso (`hash_equals`) risponde `401` senza altri effetti. Test: nessuno dedicato verificato (nessun riferimento nei test del modulo).
- `NOTIFY-INBOUND-INV-2`: il riconoscimento del formato e' in ordine: `MessageID` o `FromFull` = Postmark; `sender` o `body-mime` = Mailgun; `Content-Type` `message/rfc822` o corpo che inizia con `From:` = MIME; altrimenti eccezione e `422`.
- `NOTIFY-INBOUND-INV-3`: il messaggio grezzo viene salvato su disco disk `local` in `inbound/<provider>/AAAA/MM/GG/<uuid>.eml`, se il contenuto non e' vuoto.
- `NOTIFY-INBOUND-INV-4`: `InboundEmail::updateOrCreate` con chiave `(provider, message_id)`; `status = received`, `received_at = now()`.

## Effetti collaterali

- Scrittura file su disco `local`.
- Upsert nella tabella `inbound_emails` (modello `InboundEmail`).
- Nessuna coda, nessun evento.

## Errori

- Estrazione fallita: `Log::warning('notify.inbound.parse_failed')` e `422`.
- Errori di storage o DB dopo l'estrazione non sono catturati: escono come `500`.

## Rischi rilevati (da correggere, non corretti qui)

- Mailgun: il corpo `body-mime` viene decodificato in base64 per il parsing (riga 151, `base64_decode`), ma `storeRaw()` salva la stringa non decodificata. Il file `.eml` e il parsing non coincidono: verificare il formato reale del provider.
- Se `message_id` e' `null` (nessun id nel payload), la chiave di `updateOrCreate` non trova righe esistenti: possibili duplicati per retry.

## Non fa

- Non verifica la firma del provider: l'unico controllo e' il token nel path.
- Non invia risposte ne' notifiche interne.
