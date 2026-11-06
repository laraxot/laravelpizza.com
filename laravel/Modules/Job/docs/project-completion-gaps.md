---
title: "Lacune di completamento: Job"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "Job module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "../../Xot/docs/project-completion-readiness.md"
---

# Lacune di completamento: Job

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **459**.
- Story BMAD trovate (`*.story.md`): **32**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **459/459**.
- README/purpose mancanti: Nessun README/purpose mancante nella verifica.
- Controllo frontmatter: Tutti i Markdown censiti iniziano con frontmatter; validità semantica completa non controllata per ciascun documento.

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

Lettura read-only delle 32 story locali (`*.story.md`): 15 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `ready-for-dev` | 6 |
| `review` | 1 |
| `draft` | 2 |
| `done` | 17 |
| `investigated` | 1 |
| `pointer` | 1 |
| `unspecified` | 4 |

### Esempi prioritari da riconciliare

- `ready-for-dev`: [`4.27.phpstan-paramtype-coverage.story.md`](stories/4.27.phpstan-paramtype-coverage.story.md)
- `ready-for-dev`: [`4.28.phpstan-mixed-cleanup.story.md`](stories/4.28.phpstan-mixed-cleanup.story.md)
- `ready-for-dev`: [`job-config-cache-assente-e-azioni-distruttive.story.md`](stories/job-config-cache-assente-e-azioni-distruttive.story.md)
- `ready-for-dev`: [`job-livewire-ritiro-con-widget-gemelli.story.md`](stories/job-livewire-ritiro-con-widget-gemelli.story.md)
- `ready-for-dev`: [`job-module-bmad-setup.story.md`](stories/job-module-bmad-setup.story.md)
- `ready-for-dev`: [`job-widget-clock-queuelisten-e-processo-bloccante.story.md`](stories/job-widget-clock-queuelisten-e-processo-bloccante.story.md)
- `review`: [`4.26.phpstan-regression-remediation.story.md`](stories/4.26.phpstan-regression-remediation.story.md)
- `draft`: [`docs-reorg-core.story.md`](bmad/stories/docs-reorg-core.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
