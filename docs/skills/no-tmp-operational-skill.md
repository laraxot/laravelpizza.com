# No /tmp Operational Skill

## Trigger
Quando un task richiede file intermedi (body markdown, report, log, output CLI).

## Workflow
1. NON usare `/tmp`.
2. Creare file di supporto in repository (`docs/_work/` o `storage/app/agent/`).
3. Pulire/riordinare gli artefatti al termine del task.
4. Tracciare la regola in issue/discussion quando richiesta dall'utente.
5. Se trovi docs o comandi recenti che usano `/tmp` come output operativo, aggiornarli o segnalarli come debito prima di chiudere il task.

## Checklist rapida

- I nuovi comandi non scrivono su `/tmp`
- Gli esempi docs aggiunti non scrivono su `/tmp`
- Eventuali file intermedi necessari restano versionabili o comunque sotto il repository
