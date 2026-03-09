## Contesto
Miglioramento della pagina evento:
`/it/events/id-id-quidem-quae-eveniet-Jy1p`

Issue correlata: #530

## Problemi osservati sul rendering attuale
- CTA "Partecipa ora" con modal client-side che non crea una registrazione reale.
- Scarcity copy fissa ("Posti in esaurimento!") anche con alta disponibilita'.
- Sezione partecipanti senza empty state esplicito quando count = 0.
- Feedback copy-link non localizzato (inglese).

## Proposta
1. CTA contestuale per guest/autenticato (evitare false conferme).
2. Messaggio disponibilita' basato su soglie reali.
3. Empty state localizzato per partecipanti a zero.
4. Copy-link localizzato e accessibile.
5. Test Pest feature dedicato per evitare regressioni.

## Decisione richiesta
Confermare che il comportamento corretto, lato UX, sia:
- guest -> login/register con redirect alla stessa pagina evento
- autenticato -> azione di iscrizione esplicita (anche se backend registrazione verra' evoluto in step successivo)
