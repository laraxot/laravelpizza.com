---
title: "Lacune di completamento: Activity"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "Activity module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "../../Xot/docs/project-completion-readiness.md"
---

# Lacune di completamento: Activity

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **737**.
- Story BMAD trovate (`*.story.md`): **39**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **720/737**.
- README/purpose mancanti: Nessun README/purpose mancante nella verifica.
- Controllo frontmatter: 17 Markdown senza frontmatter rilevato con controllo apertura file (`---` iniziale); correggere e validare il frontmatter.

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

Lettura read-only delle 39 story locali (`*.story.md`): 33 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `blocked-external` | 1 |
| `in-progress` | 1 |
| `ready-for-dev` | 5 |
| `review` | 3 |
| `draft` | 2 |
| `backlog` | 6 |
| `done` | 5 |
| `pending` | 1 |
| `superseded` | 1 |
| `unspecified` | 14 |

### Esempi prioritari da riconciliare

- `blocked-external`: [`quality-gates-phpstan-swarm-gate-activity.story.md`](bmad/stories/quality-gates-phpstan-swarm-gate-activity.story.md)
- `in-progress`: [`7.1.phpstan-activity-contracts.story.md`](stories/7.1.phpstan-activity-contracts.story.md)
- `ready-for-dev`: [`18-1-merge-conflicts-phpstan-fixes.story.md`](stories/18-1-merge-conflicts-phpstan-fixes.story.md)
- `ready-for-dev`: [`3.10.activity-pest-extend-bootstrap.story.md`](stories/3.10.activity-pest-extend-bootstrap.story.md)
- `ready-for-dev`: [`4.1.phpstan-activity-generics-fix.story.md`](stories/4.1.phpstan-activity-generics-fix.story.md)
- `ready-for-dev`: [`activity-tests-and-contract.story.md`](stories/activity-tests-and-contract.story.md)
- `ready-for-dev`: [`module-bmad-audit.story.md`](bmad/stories/module-bmad-audit.story.md)
- `review`: [`7.2.phpstan-test-harness-contracts.story.md`](stories/7.2.phpstan-test-harness-contracts.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
