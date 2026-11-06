---
title: "Lacune di completamento: Tenant"
type: audit
status: open
created: 2026-10-28
updated: 2026-10-28
tags: [project-readiness, documentation, module]
qmd: "Tenant module lacune completamento progetto backlog documentazione qualità gate test integrazione"
related:
  - "../../Xot/docs/project-completion-readiness.md"
---

# Lacune di completamento: Tenant

## Esito

Questo censimento documentale non certifica il completamento funzionale del module.
Il completamento resta **non dimostrato** finché non sono chiusi e verificati i criteri
sotto elencati e le story aperte del modulo/tema in `docs/sprint-status.yaml`.

## Evidenza documentale rilevata

- Markdown sotto `docs/`: **529**.
- Story BMAD trovate (`*.story.md`): **28**; il conteggio non implica che siano
  concluse né che coprano tutti i requisiti.
- Frontmatter iniziale presente: **528/529**.
- README/purpose mancanti: Nessun README/purpose mancante nella verifica.
- Controllo frontmatter: 1 Markdown senza frontmatter rilevato con controllo apertura file (`---` iniziale); correggere e validare il frontmatter.

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

Lettura read-only delle 28 story locali (`*.story.md`): 19 hanno uno stato diverso da done/completed/superseded/invalid o non hanno stato esplicito. I conteggi descrivono il frontmatter delle story, non sostituiscono `docs/sprint-status.yaml`.

| Stato | Numero |
|---|---:|
| `blocked` | 1 |
| `active` | 2 |
| `in-progress` | 1 |
| `ready-for-dev` | 2 |
| `review` | 3 |
| `draft` | 1 |
| `backlog` | 6 |
| `todo` | 1 |
| `done` | 9 |
| `unspecified` | 2 |

### Esempi prioritari da riconciliare

- `blocked`: [`tenant-phpstan-statement-coverage-test.story.md`](bmad/stories/tenant-phpstan-statement-coverage-test.story.md)
- `in-progress`: [`7.1.phpstan-sushi-boundaries.story.md`](stories/7.1.phpstan-sushi-boundaries.story.md)
- `active`: [`7.5-create-json-max-oneliner.story.md`](stories/7.5-create-json-max-oneliner.story.md)
- `active`: [`8.2-phpstan-l10-tenant-sushi-fixes.story.md`](bmad/stories/8.2-phpstan-l10-tenant-sushi-fixes.story.md)
- `ready-for-dev`: [`services-parity-audit-tenant.story.md`](stories/services-parity-audit-tenant.story.md)
- `ready-for-dev`: [`tenant-unit-tests-claude-audit.story.md`](stories/tenant-unit-tests-claude-audit.story.md)
- `review`: [`7.2.phpstan-test-harness-contracts.story.md`](stories/7.2.phpstan-test-harness-contracts.story.md)
- `review`: [`7.4.sushi-connection-by-name.story.md`](stories/7.4.sushi-connection-by-name.story.md)

Prima di lavorare su questi elementi, verificare lo stato canonico nello sprint status, claim/lock e dipendenze. Una story senza `status` non va considerata automaticamente completata.
