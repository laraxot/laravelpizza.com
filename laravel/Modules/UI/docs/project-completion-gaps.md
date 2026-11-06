---
title: "Lacune di completamento: UI"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "UI module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "../../Xot/docs/project-completion-readiness.md"
---

# Lacune di completamento: UI

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **444**.
- Story BMAD trovate (`*.story.md`): **22**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **444/444**.
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

Lettura read-only delle 22 story locali (`*.story.md`): 13 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `active` | 1 |
| `in-progress` | 1 |
| `in_progress` | 2 |
| `ready-for-dev` | 3 |
| `review` | 2 |
| `backlog` | 2 |
| `todo` | 1 |
| `done` | 8 |
| `partial` | 1 |
| `superseded` | 1 |

### Esempi prioritari da riconciliare

- `in_progress`: [`1.4-phpstan-ui-fixes.story.md`](bmad/stories/1.4-phpstan-ui-fixes.story.md)
- `in_progress`: [`group-column-type-enum-getlabel-fix.story.md`](bmad/stories/group-column-type-enum-getlabel-fix.story.md)
- `in-progress`: [`resolve-conflict-markers-ui.story.md`](stories/resolve-conflict-markers-ui.story.md)
- `active`: [`schema-org-reusable-components.story.md`](bmad/stories/schema-org-reusable-components.story.md)
- `ready-for-dev`: [`module-bmad-audit.story.md`](bmad/stories/module-bmad-audit.story.md)
- `ready-for-dev`: [`ui-filament-contract-and-livewire-retire.story.md`](stories/ui-filament-contract-and-livewire-retire.story.md)
- `ready-for-dev`: [`ui-module-bmad-setup.story.md`](stories/ui-module-bmad-setup.story.md)
- `review`: [`app-header-guest-ux.story.md`](bmad/stories/app-header-guest-ux.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
