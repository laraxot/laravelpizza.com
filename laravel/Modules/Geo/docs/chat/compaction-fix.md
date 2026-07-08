# Fix per "Compaction exhausted: context still exceeds model limits after 3 attempts"

## Azioni eseguite
1. Aggiornamento di context-mode:
   - `ctx upgrade` → portata la versione v1.0.124 → v1.0.141 (include miglioramenti alla compressione del contesto)
2. Verifica configurazione `.context-mode.json`:
   - `maxTokens`: ridotto a 180 000
   - `compactThreshold`: impostato a 0.85
   - `maxRetries`: lasciato a 3 (default)
3. Riduzione dei token caricati:
   - Utilizzo di `qmd search --limit 5` in tutti i prompt
   - Evitative di file pesanti dalle dipendenze
4. Esecuzione di diagnostica:
   - `ctx doctor` per individuare hotspot token
   - Esecuzione di phpstan/phpmd/phpinsights per verificare qualità
   - Installazione globale di puppeteer e playwright per test visuali
5. Creazione di lock‑file prima di operazioni su file grandi (es. `doclock.lock` → post‑write removal)

## Aggiornamenti wiki
- `docs/wiki/concepts/context-mode-overflow-prevention.md`: aggiunta sezione “Configurazione consigliata post‑fix”
- `docs/wiki/concepts/second-brain-operating-model.md`: riferimento al nuovo lock‑file workflow
- `docs/wiki/log.md`: voce “2026‑05‑19 – Fix compaction exhausted error (see compaction‑fix.md)”

## Prossimi step
- Aprire issue GitHub per tracciamento:  
  ```bash
  gh issue create --repo provtv/base_ptvx_fila5_mono \
    --title "[Fix] Compaction exhausted error" \
    --body "Aggiornamento context-mode, revisione .context-mode.json, lock‑file introdotto."
  ```
- Documentare configurazioni in `docs/wiki/sources/context-mode-config.yaml` per condivisione del team.

> **Nota**: tutti i file modificati devono rispettare la policy di “forward only” su Git; nessun `git reset` o `revert` sarà usato.