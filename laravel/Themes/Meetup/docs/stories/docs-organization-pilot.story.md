---
title: "[STORY] Docs organization pilot Meetup"
type: story
status: done
priority: medium
created: 2026-10-08
updated: 2026-10-08
theme: Meetup
tags: [docs, organization, pilot, bmad, non-destructive, frontmatter, links, stale]
qmd: "meetup theme docs organization pilot indice canonico 00-INDEX frontmatter status stub stale link rotti shared-components README"
related:
  - ../00-INDEX.md
  - ../../../../../bmad-output/docs-organization-audit.md
  - ../../../../Modules/Seo/docs/stories/docs-organization-pilot.story.md
---

# [STORY] Docs organization pilot Meetup

Fase BMAD: Build (manutenzione documentale). Artefatto cross-modulo: `bmad-output/docs-organization-audit.md`.

## User Request

Ordine permanente dell'utente: tenere ordinate di continuo le cartelle `docs/` di moduli e temi. Questo giro: audit misurato e due piloti completi non distruttivi; Meetup e' il pilota piccolo (34 file). Vincoli: mai cancellare, spostare o rinominare; contenuto stantio segnalato con nota datata e non riscritto.

## Analysis

Stato iniziale (34 file): frontmatter completo 1 su 34 (manca quasi ovunque `status`), un solo indice (`00-INDEX.md`, minimo, senza BMAD), nessun `README.md` in `docs/` (obbligatorio per `theme-module-docs-readme-mandatory`), 20 link rotti su 49 negli indici, nessun duplicato esatto.

Famiglie, con lo scopo scoperto:

1. **Link `../..` a profondita' sbagliata.** `wiki/` e i suoi concetti puntavano a `../../../../docs/wiki/...`: i template sono stati copiati da un livello diverso e servivano uno o due `../` in piu'. Il bersaglio corretto esiste (verificato su disco), quindi 16 correzioni sono deterministiche.
2. **Stub verso un canonico che non c'e'.** Sette file dichiarano `canonical: ../../docs/shared-components/...` (o ne portano il link nel corpo): `Themes/docs` non esiste nel repo. Qui il canonico reale c'era solo per due casi, dove lo stesso modulo Seo (`ON-DEMAND-PATTERN.md`) dichiara `docs/wiki/rules/on-demand-pattern.md` come fonte: ripuntati `ON-DEMAND-PATTERN.md` e `QMD-SETUP.md` (a `docs/wiki/qmd-setup.md`, unico omonimo). Per gli altri nessuna scelta inventata.
3. **Indici wiki on-demand** (`commands`, `memories`, `rules`, `skills`): rimandavano a `../rules/00-TRIGGER_MAP.md` e `../rules/on-demand-pattern.md`, che nel wiki del tema non esistono; ripuntati alla Trigger Map e alla regola del wiki di progetto (`docs/wiki/rules/`).
4. **Contenuto stantio** (verificato): `root-file-policy.md` e `root-files-hygiene.md` citano la soglia di 4 `.md` (ora 5) e un `Meetup.code-workspace` che non esiste; `wiki/index.md` elenca cartelle assenti (entities, sources, comparisons, decisions, _archive); `meetup-completion-roadmap.md` e `wiki/concepts/testing.md` parlano di test in una cartella `tests/` che il tema non ha; `cross-theme-redundancy-doc-stub.md` cita `Modules/Sixteen` (e' un tema).
5. **Dossier BMAD doppio.** `bmad/README.md` e `bmad/bmad-dossier.md` dicono la stessa cosa in due forme, creati ieri dal flusso BMAD: collegati entrambi nell'indice, la fusione resta al proprietario.

## Changes

Solo `laravel/Themes/Meetup/docs/`: 32 file modificati, 2 nuovi (`README.md` e questa story), nessuno cancellato, spostato o rinominato. `raw/` non toccato.

- `00-INDEX.md`: indice canonico riscritto (`canonical: true`), tutti i 36 `.md` con stato e nota, legenda degli stati. Era l'unico indice: nessun duplicato da marcare.
- `README.md`: nuovo, ingresso a `docs/` come richiede la regola; dichiara di non essere un indice e rimanda a `00-INDEX.md`.
- Frontmatter: `status` aggiunto a 32 file (`active` 17, `stub` 10, `stale` 6 piu' `status` gia' presente nel dossier BMAD), `tags`/`qmd` dove mancavano.
- Link: 16 correzioni deterministiche (profondita' di `../`), 26 ripuntamenti espliciti verificati su disco (2 stub e 4 indici wiki, 6 file), 31 note `_(target mancante, verificato 2026-10-08)_` in 13 file per bersagli che non esistono.
- Stale: nota datata `> Nota 2026-10-08 (docs-audit): ...` sotto il frontmatter di 6 file; 4 stub con nota "stub senza contenuto locale".

## Verification

- Audit prima/dopo con `bashscripts/tools/docs/docs-organizer.py`: frontmatter completo 1/34 -> 34/36; link rotti negli indici 20/49 -> 13/61 (bersagli inesistenti, tutti annotati); debito 60 -> 26; indici attivi in radice 1.
- Copertura indice: 36 `.md`, 0 non elencati, 0 link rotti in `00-INDEX.md` e `README.md`.
- Duplicati: 0 (verificato sul corpo senza frontmatter), quindi nessun `superseded`.

## Decisions

- Meetup resta con `00-INDEX.md` come indice canonico (e' l'unico esistente); il nome `index.md` della regola `docs-index-file` e `00-INDEX.md` della prassi di 22 perimetri su 23 sono in conflitto: la scelta di nome e' nella proposta del report cross-modulo, non qui.
- `README.md` creato perche' la regola lo rende obbligatorio; e' un ingresso, non un secondo indice.
- Nessun ripuntamento a file "simili" per gli stub `shared-components` (REDUNDANCY_ANALYSIS, codex-error-fix, merge-conflicts-list, template wiki): annotati, non indovinati.

## Aperto

- `PERFORMANCE-OPTIMIZATION.md` e `PROJECT-STRUCTURE.md`: il canonico condiviso non e' stato individuato in modo univoco (esistono piu' omonimi in `docs/wiki/`, `bashscripts/ai/wiki/`).
- Dossier BMAD doppio (`bmad/README.md` / `bmad/bmad-dossier.md`) da unificare.
- Decidere cosa fare del wiki locale: la struttura dichiarata in `wiki/index.md` non esiste e il tema e' satellite.
- `raw/README.md` (immutabile) ha ancora il puntatore canonico morto.

## GitHub

Issue: TODO (gh non installato su questa macchina)
Discussion: TODO
