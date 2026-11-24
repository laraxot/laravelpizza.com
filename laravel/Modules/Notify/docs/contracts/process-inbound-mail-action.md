---
title: "Contratto — ProcessInboundMailAction"
type: contract
action: "Modules\Notify\Actions\Mail\ProcessInboundMailAction"
tags: [contract, action, notify, inbound, webhook, email]
created: 2026-11-24
updated: 2026-11-24
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
