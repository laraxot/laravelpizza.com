# Chart MCP Stack Memory

Data: 2026-03-09

## Decisione
Per ottenere grafici migliori in workflow agente, la baseline MCP e':
- `@antv/mcp-server-chart` (generalista e veloce)
- `@hustcc/mcp-echarts` (opzioni avanzate e dashboard)

## Dove e' configurata
- `laravel/.mcp.json`
- `laravel/.cursor/mcp.json`

## Fonte esterna verificata
- npm: `@antv/mcp-server-chart` versione `0.9.10` (verificata il 2026-03-09)

## Regola operativa
Quando si aggiorna stack visualizzazione, aggiornare sempre anche:
1. `docs/rules/*` pertinente
2. `docs/skills/*` operativo
3. issue/discussion GitHub con stato e prossimi passi
