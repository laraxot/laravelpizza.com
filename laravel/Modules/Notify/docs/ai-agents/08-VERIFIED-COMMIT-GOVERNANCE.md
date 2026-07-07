# Verified Commit Governance

## Regola

Nel progetto Base Predict Fila5 `git commit` e `git push` NON sono azioni automatiche di fine task.
Si eseguono solo quando il lavoro e stato verificato in modo completo e tracciabile.

## Cosa significa verificato

Per i moduli o temi toccati bisogna avere:
- `phpstan` eseguito e verde
- `phpmd` eseguito e verde
- `phpinsights` eseguito senza finding bloccanti
- test pertinenti eseguiti e verdi
- verifica runtime sui flussi reali toccati
- documentazione e indici aggiornati

## Anti-pattern da evitare

- commit per checkpoint emotivo
- push per "salvare" lavoro ancora instabile
- commit mentre ci sono ancora 500, undefined variable, parse error o regressioni note
- commit senza aver controllato i moduli adiacenti toccati dalla modifica

## Fonti canoniche

- `AGENTS.md`
- `bashscripts/ai/.agents/rules/001-no-commit-without-testing.md`
- `bashscripts/ai/.agents/rules/common/git-workflow.md`
- `bashscripts/ai/.agents/guidelines/development-workflow.md`
- `bashscripts/docs/COMMIT_AND_PUSH_RULE.md`
- `bashscripts/ai/.agents/memories/verified-work-must-be-committed.md`
