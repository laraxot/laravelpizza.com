---
title: "Lacune di completamento: Xot"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "Xot module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "./project-completion-readiness.md"
---

# Lacune di completamento: Xot

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **1556**.
- Story BMAD trovate (`*.story.md`): **151**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **1552/1556**.
- README/purpose mancanti: Nessun README/purpose mancante nella verifica.
- Controllo frontmatter: 4 Markdown senza frontmatter rilevato con controllo apertura file (`---` iniziale); correggere e validare il frontmatter.

## Lavoro necessario per poter chiudere

1. Riconciliare i requisiti del module con le story BMAD: nessun requisito senza AC,
   owner, dipendenze e stato verificabile.
2. Chiudere le story non concluse nel relativo sprint status; non dedurre `done` dal
   solo fatto che il codice o una story esistano.
3. Verificare le boundary del modulo/tema con i consumatori, permessi, tenant, dati e
   contratti di integrazione applicabili; registrare le prove nella story owner.
4. Eseguire i gate applicabili (Pest, PHPStan per modulo e controlli di qualità) e
   riportare comando, esito e limiti ambientali. Nessuna verifica funzionale è stata
   eseguita da questo censimento documentale.
5. Aggiornare i documenti e gli indici QMD dopo ogni chiusura; i nomi `.md` restano
   kebab-case stabili, senza date o timestamp.

## Criterio di chiusura

Story e acceptance criteria pertinenti chiusi; regressioni assenti nei gate applicabili;
integrazioni reali documentate; documentazione e QMD aggiornati. Questo file va aggiornato
solo con evidenze nuove, non con supposizioni.

## Story BMAD non concluse nel corpus owner

Lettura read-only delle 151 story locali (`*.story.md`): 115 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `blocked` | 4 |
| `active` | 9 |
| `in-progress` | 28 |
| `in_progress` | 5 |
| `open` | 9 |
| `ready` | 5 |
| `ready-for-dev` | 27 |
| `review` | 11 |
| `draft` | 5 |
| `backlog` | 3 |
| `todo` | 1 |
| `analysis-and-design` | 3 |
| `done` | 34 |
| `done-needs-review` | 1 |
| `done-pending-verification` | 1 |
| `done-with-blocker` | 1 |
| `partially-done` | 1 |
| `superseded` | 2 |
| `unspecified` | 1 |

### Esempi prioritari da riconciliare

- `blocked`: [`dcp-243-test-model-module-xot-contro-api-reale.story.md`](stories/dcp-243-test-model-module-xot-contro-api-reale.story.md)
- `blocked`: [`env-page-broken-unused-team-decision.story.md`](stories/env-page-broken-unused-team-decision.story.md)
- `blocked`: [`fix-xot-feature-tests.story.md`](stories/fix-xot-feature-tests.story.md)
- `blocked`: [`xot-test-env-pending-migrations.story.md`](stories/xot-test-env-pending-migrations.story.md)
- `in_progress`: [`1.1-phpstan-xot-fixes.story.md`](bmad/stories/1.1-phpstan-xot-fixes.story.md)
- `in-progress`: [`10.01-docs-orphan-consolidation.story.md`](bmad/stories/10.01-docs-orphan-consolidation.story.md)
- `in-progress`: [`5.249-bmad-docs-fleet-completion.story.md`](bmad/stories/5.249-bmad-docs-fleet-completion.story.md)
- `in-progress`: [`5.256-user-module-clusters-widgets-actions.story.md`](bmad/stories/5.256-user-module-clusters-widgets-actions.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
