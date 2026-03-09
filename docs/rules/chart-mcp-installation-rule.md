# Chart MCP Installation Rule

## Obiettivo
Standardizzare installazione e configurazione dei server MCP per grafici nel progetto.

## Regole
1. Usare configurazioni MCP centrali in `laravel/.mcp.json` e `laravel/.cursor/mcp.json`.
2. Per grafici, mantenere attivi almeno:
   - `chart-antv` (`@antv/mcp-server-chart`)
   - `chart-echarts` (`@hustcc/mcp-echarts`)
3. Prima di dichiarare completata la configurazione, verificare versione pacchetto npm e validita JSON.
4. Ogni avanzamento su tooling chart deve essere tracciato in GitHub Issue e in almeno una GitHub Discussion.
5. Evitare duplicazioni di configurazione non necessarie in altri file.

## Verifica minima
- `npm view @antv/mcp-server-chart version`
- validazione sintassi JSON dei file MCP aggiornati
- commento di avanzamento su issue/discussion
