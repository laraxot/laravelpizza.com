# Chart MCP Visualization Skill

## Quando usarla
- Quando servono grafici migliori per analisi, dashboard o report.
- Quando si deve generare o rifinire configurazioni chart via MCP.

## Stack consigliata
1. `chart-antv` per generazione veloce di grafici standard.
2. `chart-echarts` per opzioni avanzate (tooltip complessi, combinati, drilldown).

## Workflow
1. Verifica file MCP: `laravel/.mcp.json` e `laravel/.cursor/mcp.json`.
2. Conferma versioni npm dei server principali.
3. Scegli libreria in base al bisogno:
   - output rapido e chiaro -> AntV
   - controllo fine e interattivita -> ECharts
4. Salva prompt/modelli chart riutilizzabili dentro docs modulo/tema coinvolto.
5. Aggiorna issue/discussion con:
   - grafico target
   - server MCP usato
   - limiti osservati
   - step successivo

## Non fare
- Non duplicare server equivalenti senza motivo.
- Non dichiarare completamento senza test/config verificati.
