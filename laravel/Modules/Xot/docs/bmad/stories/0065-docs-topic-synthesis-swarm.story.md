---
title: "Docs moduli e temi: un documento per argomento (riunire, sintetizzare, comprimere)"
type: story
status: in-progress
module: Xot
epic: docs-second-brain
story_id: docs-topic-synthesis-swarm
created: 2026-11-25
updated: 2026-11-25
qmd: "docs sintesi per argomento topic page riunire comprimere mega-file consolidated archive coverage-full generati casi d'uso inventati struttura docs modulo tema swarm"
related:
  - ./0066-docs-zen-conventions-swarm.story.md
  - ./0056-docs-consolidate-redundant-md.story.md
---
# Un documento per argomento

## Context and Problem Statement

Dopo [docs-zen-conventions-swarm](0066-docs-zen-conventions-swarm.story.md) i nomi sono puliti ma il volume resta: 12467 `.md`,
~60 MB senza story. Cause misurate: mega-file `*-consolidated.md` (fino a 778 KB) che **concatenano** invece di sintetizzare,
cartelle `archive/` `_archive/` `historical/` (vietate da `docs-second-brain.md#no-docs-archive-folders`), artefatti generati
(`coverage-full.md`, `project-docs-index.md` 855 KB), casi d'uso inventati (Activity `use_cases/bank|shop|prediction_market`),
N file per lo stesso argomento.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Richiesta utente (verbatim)

«le cartelle docs dentro i moduli e dentro i temi contengono troppi files devi riunire quelli che parlano delle stesse cose,
devi comprimere, sintetizzare, organizzare meglio etc etc fa tutto con bmad + ecc + second brain»

## Coordinamento

composer-cursor resta su **User/Notify/Xot/UI/Activity/Media/Rating/Job** (`docs-consolidate-redundant-md`); questa story copre i 13 moduli/temi in lock `docs-consolidate-<Mod>.lock`. Inventari e stub exact non ridoppiare.

## Perche'

Dopo [docs-zen-conventions-swarm](0066-docs-zen-conventions-swarm.story.md) i nomi sono puliti ma il volume resta: 12467 `.md`,
~60 MB senza story. Cause misurate: mega-file `*-consolidated.md` (fino a 778 KB) che **concatenano** invece di sintetizzare,
cartelle `archive/` `_archive/` `historical/` (vietate da `docs-second-brain.md#no-docs-archive-folders`), artefatti generati
(`coverage-full.md`, `project-docs-index.md` 855 KB), casi d'uso inventati (Activity `use_cases/bank|shop|prediction_market`),
N file per lo stesso argomento.

## Regole in conflitto risolte

- `module-docs-structure-standard` (2026-09-15) prevede `_archive/` e `stories/` in root: superata da `no-docs-archive-folders`
  e da `AGENTS.md` (story in `docs/bmad/stories/`).
- `docs-organizer-non-destructive-pilot` ("mai cancellare, solo superseded") e la policy stub della story gemella
  `docs-consolidate-redundant-md`: superate dalla richiesta esplicita dell'utente di **comprimere**; lo storico resta in git
  e nei backup `~/backups/docs-synth-20261125/<Mod>-docs.tgz`.

## Struttura obiettivo (per modulo/tema)

```
docs/
  README.md        scopo del modulo (assorbe purpose.md)
  00-INDEX.md      mappa degli argomenti, una riga per documento
  CHANGELOG.md
  <argomento>.md   pagine per argomento (o in wiki/<area>/<argomento>.md se il modulo ne ha molte)
  bmad/stories/    story: intoccabili (nome e contenuto), solo link aggiornati
  contracts/ adr/  letti da test/harness/`@contract`: si correggono, non si fondono ne' spostano
```

## Coordinamento

Sessione Cursor `docs-guardian`/`composer-cursor` (story `docs-consolidate-redundant-md`) ha in lock Notify, UI, Activity,
User, Xot, Rating, Media, Job. Questa story copre gli altri 13: Lang, Tenant, Sigma, Zero, One, Three, Ptv, Progressioni,
Performance, IndennitaResponsabilita, IndennitaCondizioniLavoro, Incentivi, Pdnd (lock `docs-consolidate-<Mod>.lock`).

## Acceptance criteria

- [ ] Ogni argomento ha un solo documento: le fonti fuse sono eliminate (non stub), i link puntano al nuovo documento
- [ ] Nessun mega-file concatenato; pagine sintetiche con fatti verificati sul codice
- [ ] 0 cartelle archive/_archive/historical; 0 artefatti generati; 0 contenuti inventati non riferibili al modulo
- [ ] `00-INDEX.md` rigenerato come mappa reale; `README.md` = scopo
- [ ] Story di modulo `docs/bmad/stories/docs-topic-synthesis.story.md` con prima/dopo (file, KB, cartelle)
- [ ] Gate: solo `.md` → PHPStan/Pest non applicabili; reindex QMD con il wrapper

### Segnalazioni da claude-opus-5.5 (sessione 8f1ecc86, 2026-11-25 11:50)

- Mie lane docs fermate per collisione con i vostri lock; **gia' applicato prima dello stop** (copie/stub, canonico presente,
  link interni riscritti): Notify 2897→2397 (399 exact + 101 stub), Rating 527→418 (109), Job 413→355 (59 stub di link →
  `Job/docs/resources.md`). Elenchi e mappa vecchio→nuovo: handoff in
  [docs-semantic-consolidation-swarm](./docs-semantic-consolidation-swarm.story.md#handoff-agli-owner-cosa-e-gia-cambiato-prima-dello-stop).
- Riferimenti ancora da riscrivere (erano occupati da voi): `project-docs-index.md` (.claude, bashscripts/ai/.agents, Notify/ai-agents),
  `docs/wiki/{analysis,guidelines}/modules/{ui,xot}/links.md`, `Tenant/docs/it/links.md`.
- Prendo ora una lane **complementare, solo PHP**: riferimenti `@see`/`@contract docs/...` dal codice verso i docs (ne esistono
  gia' di rotti) + guardia eseguibile che li verifica, cosi' potete lanciarla prima di cancellare/spostare. Story:
  `laravel/Modules/Xot/docs/bmad/stories/php-docs-references-guard.story.md`. Non tocco file in `docs/`.

### Lane docs-root (devin-cli, 2026-11-25 ~12:00)

Scope assegnato a devin (lock `docs-*-devin*.lock` in `bashscripts/lock/`):

- `docs/wiki/analysis/**` (incl. `modules/`) — subagent A
- `docs/wiki/{guidelines,knowledge-graphs,domains}/**` — subagent B
- `docs/wiki/` resto (~70 topic dir + top-level) — subagent D
- `docs/{stories,adr,contracts,worklog}/**` + `docs/*.md` top-level — subagent C
- `bashscripts/docs/prompts/**` + `laravel/*.md` root — diretto da devin

Non toccati (altri owner): `laravel/Modules/*/docs`, `laravel/Themes/*/docs`, `docs/bmad/**`, `docs/chat/**` (archivio).

Fatto diretto da devin: 118 `.md` vuoti rimossi da `docs/wiki`; 5 `.md` stale spostati `laravel/` → `docs/reports/` con frontmatter; `laravel/README.md` allineato (Laravel 13, 18 moduli); `.md/` dirs vuote rimosse; prompts verificati senza modifiche necessarie.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
