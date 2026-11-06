---
title: "Lacune di completamento: User"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "User module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "../../Xot/docs/project-completion-readiness.md"
---

# Lacune di completamento: User

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **2195**.
- Story BMAD trovate (`*.story.md`): **155**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **2034/2195**.
- README/purpose mancanti: Nessun README/purpose mancante nella verifica.
- Controllo frontmatter: 161 Markdown senza frontmatter rilevato con controllo apertura file (`---` iniziale); correggere e validare il frontmatter.

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

Lettura read-only delle 155 story locali (`*.story.md`): 104 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `blocked` | 2 |
| `blocked-decision` | 1 |
| `in-progress` | 3 |
| `needs-decision` | 1 |
| `open` | 1 |
| `ready-for-dev` | 11 |
| `review` | 7 |
| `draft` | 3 |
| `backlog` | 47 |
| `blocked-on-owner` | 1 |
| `blocked-verification` | 1 |
| `completed` | 2 |
| `done` | 46 |
| `done-partial` | 1 |
| `done-pending-prod-sync` | 1 |
| `done-with-open-decisions` | 1 |
| `implemented-runtime-pending` | 2 |
| `resolved` | 1 |
| `superseded` | 2 |
| `unspecified` | 21 |

### Esempi prioritari da riconciliare

- `blocked`: [`10.4.retire-gdpr-profile-livewire.story.md`](stories/10.4.retire-gdpr-profile-livewire.story.md)
- `blocked-decision`: [`gitignore-database-rule-hides-tests.story.md`](bmad/stories/gitignore-database-rule-hides-tests.story.md)
- `blocked`: [`livewire-residual-conversion-cluster-c.story.md`](bmad/stories/livewire-residual-conversion-cluster-c.story.md)
- `in-progress`: [`dcp-290-pagine-di-accesso-e-reset-password-a-tema-e-accessibili.story.md`](stories/dcp-290-pagine-di-accesso-e-reset-password-a-tema-e-accessibili.story.md)
- `in-progress`: [`dcp-53-area-personale-pagine-con-scopo.story.md`](stories/dcp-53-area-personale-pagine-con-scopo.story.md)
- `in-progress`: [`user-orphan-basetable-dedup-clustering.story.md`](bmad/stories/user-orphan-basetable-dedup-clustering.story.md)
- `needs-decision`: [`dcp-144-accesso-del-cittadino-con-spid-cie-o-decisione-motivata.story.md`](stories/dcp-144-accesso-del-cittadino-con-spid-cie-o-decisione-motivata.story.md)
- `open`: [`user-guest-project-names-removal.story.md`](stories/user-guest-project-names-removal.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
