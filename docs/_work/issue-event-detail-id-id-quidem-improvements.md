## Context
Pagina target da migliorare: `http://127.0.0.1:8000/it/events/id-id-quidem-quae-eveniet-Jy1p`

## Stato attuale verificato
- HTTP: `200 OK`
- Il dettaglio evento si apre correttamente.
- Restano gap UX/funzionali nel blocco detail.

## Gap individuati
1. CTA "Partecipa ora" non persiste alcuna registrazione evento (solo modal client-side).
2. Messaggio disponibilita' incoerente: mostra `99` posti ma testo fisso "Posti in esaurimento!".
3. Sezione "Partecipanti" senza empty-state esplicito quando conteggio e' zero.
4. Microcopy non localizzato: tooltip copy-link in inglese (`URL Copied!`).
5. Mancano indicatori espliciti di autenticazione necessaria per iscrizione.

## Obiettivo
Rendere la pagina dettaglio evento coerente, localizzata e con CTA affidabile lato UX, senza introdurre nuovi moduli.

## Implementazione proposta
- Sostituire CTA/modal fake con CTA contestuale:
  - guest: link ad accesso/registrazione con redirect di ritorno alla pagina evento.
  - autenticato: mantenere CTA con intent chiaro (iscrizione) e messaggistica coerente.
- Rendere dinamico il messaggio disponibilita' posti (scarcity solo sotto soglia).
- Aggiungere empty-state localizzato per partecipanti a zero.
- Localizzare il feedback copy-link in italiano.
- Coprire con test Pest feature su rendering e testi critici.

## Acceptance criteria
- [ ] Pagina evento mantiene `200 OK`.
- [ ] Nessun testo incoerente sui posti disponibili.
- [ ] Se partecipanti `0`, la UI mostra messaggio esplicito localizzato.
- [ ] CTA "Partecipa" non e' piu' una falsa conferma client-side.
- [ ] Test Pest feature verde per i nuovi comportamenti.
