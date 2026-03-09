Analisi completata sulla pagina `http://127.0.0.1:8000/it/events/id-id-quidem-quae-eveniet-Jy1p`.

Evidenze runtime:
- HTTP `200 OK`
- Dettaglio evento renderizzato correttamente

Gap confermati:
1. CTA RSVP attuale apre solo modal frontend (nessuna registrazione effettiva).
2. Messaggio "Posti in esaurimento!" mostrato anche con alta disponibilita' (`99` posti), quindi incoerente.
3. Sezione partecipanti non mostra stato esplicito quando count = 0.
4. Copy-link social share usa testo hardcoded inglese (`URL Copied!` / `Copy to clipboard`).

Implementazione imminente:
- CTA contestuale guest/auth (guest -> login/register con redirect alla pagina evento)
- scaricity copy condizionale su soglia posti disponibili
- empty-state localizzato per partecipanti a zero
- localizzazione microcopy copy-link in componente SEO
- Pest feature test dedicato alla pagina evento per regressioni UX
