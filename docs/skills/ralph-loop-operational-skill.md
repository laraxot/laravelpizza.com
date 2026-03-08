# Ralph Loop Operational Skill

## Quando usarla

Quando serve orchestrare lavoro iterativo con PRD + build loop mantenendo governance GitHub.

## Workflow

1. Verifica installazione:
   - `ralph help`
   - `npm list -g --depth=0 @iannuttall/ralph`
2. Genera PRD JSON:
   - `ralph prd "<obiettivo>" --out .ralph/prd-<slug>.json`
3. Esegui ciclo corto:
   - `ralph build 1 --no-commit --prd .ralph/prd-<slug>.json`
4. Trasferisci cambi necessari nel progetto secondo regole interne.
5. Aggiorna sempre GitHub Issue e GitHub Discussion con avanzamento.

## Guardrail

- No nuovi moduli non approvati.
- Git forward-only.
- Nessuna modifica fuori perimetro senza documentazione preventiva.
