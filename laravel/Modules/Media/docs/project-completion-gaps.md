---
title: "Lacune di completamento: Media"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "Media module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "../../Xot/docs/project-completion-readiness.md"
---

# Lacune di completamento: Media

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **542**.
- Story BMAD trovate (`*.story.md`): **36**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **542/542**.
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

Lettura read-only delle 36 story locali (`*.story.md`): 17 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `in_progress` | 1 |
| `ready-for-dev` | 5 |
| `review` | 1 |
| `draft` | 2 |
| `backlog` | 4 |
| `READY_FOR_DEV` | 1 |
| `done` | 18 |
| `superseded` | 1 |
| `unspecified` | 3 |

### Esempi prioritari da riconciliare

- `in_progress`: [`1.3-phpstan-media-fixes.story.md`](bmad/stories/1.3-phpstan-media-fixes.story.md)
- `ready-for-dev`: [`media-module-bmad-setup.story.md`](stories/media-module-bmad-setup.story.md)
- `ready-for-dev`: [`media-phpstan-swarm-verifica-fonti.story.md`](stories/media-phpstan-swarm-verifica-fonti.story.md)
- `ready-for-dev`: [`media-test-mai-eseguiti-e-doppioni-maiuscole.story.md`](stories/media-test-mai-eseguiti-e-doppioni-maiuscole.story.md)
- `ready-for-dev`: [`media-webm-non-registrato-e-clip-livewire.story.md`](stories/media-webm-non-registrato-e-clip-livewire.story.md)
- `ready-for-dev`: [`module-bmad-audit.story.md`](bmad/stories/module-bmad-audit.story.md)
- `review`: [`readme-changelog-conflict-markers.story.md`](bmad/stories/readme-changelog-conflict-markers.story.md)
- `draft`: [`cleanup-media.story.md`](bmad/stories/cleanup-media.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
