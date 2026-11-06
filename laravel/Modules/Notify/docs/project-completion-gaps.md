---
title: "Lacune di completamento: Notify"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "Notify module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "../../Xot/docs/project-completion-readiness.md"
---

# Lacune di completamento: Notify

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **3671**.
- Story BMAD trovate (`*.story.md`): **48**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **3652/3671**.
- README/purpose mancanti: Nessun README/purpose mancante nella verifica.
- Controllo frontmatter: 19 Markdown senza frontmatter rilevato con controllo apertura file (`---` iniziale); correggere e validare il frontmatter.

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

Lettura read-only delle 48 story locali (`*.story.md`): 33 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `active` | 1 |
| `in-progress` | 1 |
| `open` | 1 |
| `ready-for-dev` | 10 |
| `review` | 3 |
| `draft` | 2 |
| `backlog` | 5 |
| `blocked-on-owner` | 1 |
| `deferred` | 1 |
| `done` | 13 |
| `done-local-push-blocked` | 2 |
| `superseded` | 2 |
| `unspecified` | 6 |

### Esempi prioritari da riconciliare

- `active`: [`consolidation-orphan-docs.story.md`](bmad/stories/consolidation-orphan-docs.story.md)
- `in-progress`: [`resolve-conflict-markers-notify.story.md`](stories/resolve-conflict-markers-notify.story.md)
- `open`: [`notify-tracked-github-skills-hygiene.story.md`](stories/notify-tracked-github-skills-hygiene.story.md)
- `ready-for-dev`: [`01.consolidate-email-into-notify.story.md`](stories/01.consolidate-email-into-notify.story.md)
- `ready-for-dev`: [`12.1.notify-notifications-fqcn.story.md`](stories/12.1.notify-notifications-fqcn.story.md)
- `ready-for-dev`: [`4.23.phpstan-regression-remediation.story.md`](stories/4.23.phpstan-regression-remediation.story.md)
- `ready-for-dev`: [`4.25.git-conflict-marker-remediation.story.md`](stories/4.25.git-conflict-marker-remediation.story.md)
- `ready-for-dev`: [`4.32.notify-phpstan-swarm-internal-errors.story.md`](stories/4.32.notify-phpstan-swarm-internal-errors.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
