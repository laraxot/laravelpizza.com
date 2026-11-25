---
title: "Swarm docs moduli e temi: convenzioni .md, ridondanza, inquinamento generato"
type: story
status: review
module: Xot
epic: docs-second-brain
story_id: docs-zen-conventions-swarm
created: 2026-11-25
updated: 2026-11-25
qmd: "docs moduli temi convenzioni md kebab-case nomi senza date frontmatter qmd duplicati esatti md5 template fabbricati annidamento ricorsivo docs/wiki/laravel/Modules models/models swarm random"
related:
  - ./0087-git-objects-slimming-independent-repos.story.md
  - ./0145-phpstan-modules-swarm-devin-session.story.md
---
# Swarm docs moduli e temi

## Context and Problem Statement

Gate PHPStan `analyse Modules` = **0 errori** (2026-11-25, cache privata, exit 0; un primo run aveva 2 internal
error transitori su Notify `MailTemplate`/`NotificationTemplate`, riscritti alle 10:37 dal merge `a6a34ea` durante l'analisi).
Il debito reale e' nei docs: rumore che degrada QMD, gonfia la storia git (vedi story slim) e confonde gli agenti.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Perche'

Gate PHPStan `analyse Modules` = **0 errori** (2026-11-25, cache privata, exit 0; un primo run aveva 2 internal
error transitori su Notify `MailTemplate`/`NotificationTemplate`, riscritti alle 10:37 dal merge `a6a34ea` durante l'analisi).
Il debito reale e' nei docs: rumore che degrada QMD, gonfia la storia git (vedi story slim) e confonde gli agenti.

## Baseline (21 cartelle docs, 15908 `.md`)

| Problema | Numero |
|---|---:|
| copie esatte (md5) oltre la prima | 1408 |
| nomi con data/timestamp | 20 |
| nomi non kebab (esclusi README/CHANGELOG/00-INDEX) | ~1804 |
| senza frontmatter | 439 |
| senza chiave `qmd` | 562 |
| annidamenti generati (`docs/wiki/laravel/Modules/...`, `models/models/...`) | presenti |
| template generici fabbricati (`product_roadmap`, `sprint_planning`, `user_research`...) | 9-11 moduli |

## Swarm (ordine random `shuf`, lock `bashscripts/lock/docs-zen-20261125-<Mod>.lock`)

| Lane | Moduli |
|---|---|
| A | Notify |
| B | User |
| C | Lang, Tenant, Three, UI |
| D | One, Performance, Zero, Ptv, IndennitaResponsabilita, Pdnd, Incentivi |
| E | Sigma, Progressioni, Job, Xot |
| F | Media, IndennitaCondizioniLavoro, Activity, Rating |

Ogni lane scrive/aggiorna `docs/bmad/stories/docs-zen-conventions.story.md` nel modulo/tema owner.

## Esito (6 lane chiuse, 2026-11-25)

| Metrica | Prima | Dopo |
|---|---:|---:|
| `.md` in docs moduli/temi | 15908 | 12467 |
| nomi con data (escluse story) | 20 | 0 |
| non-kebab (escluse eccezioni) | ~1804 | 3 (story Xot `STORY-XXX`, `STORY-512`, `ST-XX`: nomi story non si cambiano) |
| senza frontmatter | 439 | 0 |
| senza `qmd` | 562 | 0 |
| copie esatte | 1408 | 209 (76 gruppi = story protette; 47 gruppi cross-modulo) |
| marker conflitto | 0 | 0 |

Per lane: Notify 3855→2897, User 3207→2108 (link rotti 8222→2488), Lang 1148→872, UI 1024→836, Activity 995→730,
Media 639→472, IndennitaResponsabilita 500→370, Rating 621→527, Job 476→412, Xot 716→700, altri −2..−50.
Story di modulo: `laravel/Modules/*/docs/bmad/stories/docs-zen-conventions.story.md` (+ Themes One/Zero/Three).
Backup User: `~/backups/docs-zen-20261125/`. Nessun commit.

Eccezioni ai nomi kebab confermate dal codice (non rinominare): `adr/INDEX.md`, `contracts/INDEX.md`,
`contracts/_template.md` (letti da `bashscripts/tools/harness/harness-audit.py` e
`Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php`), `wiki/SCHEMA.md` (ricreato da
`setup-llm-wiki-structure.sh`), `AGENTS.md`, `00-INDEX.md`, `README.md`, `CHANGELOG.md`.

## Backlog (non eseguito, serve decisione o lettura umana)

- 47 gruppi di doc generici identici fra moduli (`agent-confidence-protocol`, `gitmodules-sync-session`, `binary-assets`,
  `adr/0000-template`): repo autonomi (copia) vs canonico unico nel second brain (link). Decisione architetturale.
- Story duplicate identiche (76 gruppi): marcare `superseded`, mai eliminare.
- Quarantene `_da-riconciliare/` (Notify 757 file, Lang): riconciliazione per lettura.
- Sezioni `## Contenuto fuso da ...` create in automatico: da rileggere.
- Link residui verso file rimossi in `Notify/docs/ai-agents/project-docs-index.md` (indice generato: rigenerare); 2488 link
  rotti preesistenti in User; 4 link in `Themes/Zero/docs` verso file User rinominati.
- `index-generated.md` di Job/Rating/Activity: rigenerare.

## Acceptance criteria

- [x] 0 nomi con data, 0 non-kebab (eccezioni README/CHANGELOG/00-INDEX, `*.story.md` invariati)
- [x] 0 file senza frontmatter/`qmd`
- [ ] copie esatte e annidamenti generati rimossi con link aggiornati
- [ ] nessun link nuovo rotto verso file rinominati/rimossi
- [x] story di modulo con prima/dopo; `qmd update`

## Gate

Solo `.md`: PHPStan/Pint/Pest non applicabili (skip documentato), PHPStan gia' 0.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
