## Progress update

Nuova regola operativa consolidata:

- nel progetto non va usato `Log::info(...)`

Motivazione:

- rumore nei log
- debug permanente nel codice
- rischio di loggare dati non necessari
- sostituzione impropria di test e quality gate

Aggiornamenti locali eseguiti:

- `docs/rules/no-log-info-rule.md`
- `docs/memory/no-log-info-memory.md`
- `docs/skills/no-log-info-skill.md`
- riallineamento delle regole di verifica e quality gate

Da qui in avanti il default operativo resta:

- niente `Log::info(...)`
- prima test, phpstan, phpinsights e osservabilita' motivata
