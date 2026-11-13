---
title: "[STORY] Docs organization pilot Seo"
type: story
status: done
priority: medium
created: 2026-10-08
updated: 2026-10-08
module: Seo
tags: [docs, organization, pilot, bmad, non-destructive, frontmatter, links, superseded]
qmd: "seo docs organization pilot indice canonico index.md frontmatter status superseded stale link rotti stub shared-components"
related:
  - ../../../../../bmad-output/docs-organization-audit-2026-10-08.md
  - ../index.md
  - ../../../../Themes/Meetup/docs/stories/2026-10-08-docs-organization-pilot.story.md
---

# [STORY] Docs organization pilot Seo

Fase BMAD: Build (manutenzione documentale). Artefatto cross-modulo: `bmad-output/docs-organization-audit-2026-10-08.md`.

## User Request

Ordine permanente dell'utente: tenere ordinate di continuo le cartelle `docs/` di moduli e temi. Questo giro: audit misurato (23 perimetri, 28.400 file `.md`) e due piloti completi e **non distruttivi**; Seo e' uno dei due. Vincoli: mai cancellare, spostare o rinominare; duplicati marcati `superseded`; contenuto stantio segnalato con nota datata e non riscritto.

## Analysis

Stato iniziale (203 file, misurato con `bashscripts/tools/docs/docs-organizer.py audit` sul commit precedente): frontmatter completo 1 file su 203, 55 file con blocco frontmatter spurio dentro il corpo, 5 indici in radice, 56 link rotti su 304 negli indici, 29 file duplicati nel contenuto, nessun `status` quasi ovunque.

Le famiglie, con lo scopo scoperto e non il sintomo:

1. **Blocchi frontmatter spurii (55 file).** Un generatore di frontmatter ha iniettato nel corpo, dopo un `---` (a volte dopo una riga vuota), le 8 righe del template (`title`, `type: note`, `tags: [documentation]`, `created`, `updated`, `qmd`, `issues: []`, `discussions: []`) quando il file aveva gia' frontmatter o una linea orizzontale. Il blocco non contiene informazione: rimuoverlo e' senza perdita. Il rilevatore e' attento ai blocchi di codice, cosi' gli esempi di schema in `PROJECT-STRUCTURE.md` e nei `_templates` restano.
2. **Copie con altro case o separatore.** I duplicati "byte-identical" dell'indice del 2026-09-26 oggi differiscono solo per `title`/`qmd` auto-generati dal nome file: il confronto va fatto sul corpo senza frontmatter. Canonico scelto con la regola: nome kebab minuscolo, poi minuscolo con underscore, poi maiuscolo; `README.md` batte `readme.md` (regola `theme-module-docs-readme-mandatory`).
3. **Cinque indici di radice** (`00-INDEX.md`, `00-index.md`, `INDEX.md`, `README.md`, `index.md`). `index.md` era l'unico completo (193 link, regola `docs-index-file`), ma con intestazione corrotta e voci invecchiate: tre file rinominati dalla normalizzazione dei nomi (`redundancy-audit-2026-05-21.md`, `git-merge-conflict-inventory-2026-04-28.md`, la cartella `root-md-files/`) e 15 file non elencati.
4. **Link rotti per profondita' sbagliata.** I template wiki sono stati copiati a profondita' diversa: `../../docs/wiki/...` doveva essere `../../../../docs/wiki/...`. Il percorso corretto esiste su disco, quindi la correzione e' verificabile. Altre famiglie: case sbagliato nei nomi modulo (`../../xot/docs/readme.md`), link scritti dalla radice del modulo (`./docs/readme-en.md`).
5. **Stub con puntatore canonico morto.** 33 file `module: theme` con `canonical: ../../../Themes/docs/shared-components/...`: la cartella `Themes/docs` non esiste nel repo. Qui non ho inventato un destinatario: `status: stub` piu' commento sul puntatore.
6. **Contenuto stantio.** Verificato su disco prima di marcare: `PHILOSOPHY.md` cita 3 file inesistenti; `structure.md` e' un dump del 2025-04-23 (9 file PHP dichiarati); `cyclomatic-complexity-report.md` generato il 2025-10-01; `dry-kiss-analysis.md` ha `[DATE]` non renderizzato; `wiki/agents.md` e `wiki/AGENTS.md` hanno `{{TYPE^}}`; `README.md` e' la concatenazione di due README con badge incoerenti. `decision-log.md` e `investigation/investigation.md` sono template vuoti (`draft`).

## Changes

Solo `laravel/Modules/Seo/docs/`, 187 file toccati (186 modificati, 1 nuovo: questa story), nessuno cancellato, spostato o rinominato. Esclusi per regola: `raw/` (immutabile), le story esistenti, i file con lock o toccati da meno di 10 minuti.

- `index.md`: indice canonico, frontmatter completo (`type: index`, `canonical: true`), legenda degli stati, voci invecchiate corrette, tutti i 205 `.md` raggiungibili, sezioni BMAD e moduli correlati.
- `00-INDEX.md`, `00-index.md`, `INDEX.md`: `status: superseded`, `superseded_by: index.md`, nota visibile sotto il frontmatter.
- 25 file `superseded` in tutto (copie di nome diverso; elenco: `grep -rl "^status: superseded" docs`). Nessun file spostato.
- Frontmatter: 50 blocchi spurii rimossi, `status` aggiunto a 186 file (`active` 119, `stub` 33, `superseded` 25, `stale` 7, `draft` 2), `updated`/`tags`/`qmd` aggiunti dove mancavano.
- Link: 81 correzioni deterministiche (case, profondita' di `../`, prefisso `./docs/`) e 4 manuali; 126 note `_(target mancante, verificato 2026-10-08)_` su link il cui bersaglio non esiste (64 file, i `superseded` esclusi).
- Stale e draft: nota datata `> Nota 2026-10-08 (docs-audit): ...` sotto il frontmatter, contenuto invariato.
- Strumento: `bashscripts/tools/docs/docs-organizer.py` (sottocomandi `audit`, `links`, `frontmatter`, `dups`, `stale`; dry-run di default).

## Verification

- Audit prima/dopo con lo stesso strumento: frontmatter completo 1/203 -> 188/205; blocchi spurii 55 -> 6 (tutti in `raw/`); duplicati di contenuto non marcati 29 -> 6 (copie in `raw/`); indici attivi in radice 4 -> 1; link rotti negli indici 56/304 -> 27/321 (bersagli inesistenti, tutti annotati); debito 408 -> 220.
- Copertura indice: 205 file `.md`, 0 non elencati, 0 link rotti in `index.md`.
- Nessuna perdita di contenuto: su `git diff -U0` ogni riga rimossa e' una riga del template spurio, una voce di `index.md` riscritta, o la vecchia versione di un link/chiave modificata nello stesso hunk.
- Il commit di sync automatico `f1a2a6d` ha gia' incluso queste modifiche; nessun commit manuale da parte mia.

## Decisions

- Canonico = `index.md` (non `00-INDEX.md`): regola `docs-index-file`, 12 perimetri su 23 hanno `index.md` come indice piu' ricco, e qui era l'unico completo. `README.md` resta l'ingresso del modulo e non e' un indice.
- Nessun rinominare dei 30 gruppi di varianti di nome (`PRD.md`/`prd.md`...): i link e gli altri agenti li citano; si marca soltanto.
- Stub `shared-components`: non ripuntati a un file "simile" in Xot; la scelta del destinatario spetta al proprietario.

## Aperto

- 27 bersagli di link che non sono mai esistiti (es. `roadmap/*.md` e `phpstan/level_*.md` citati da `roadmap.md`): decidere se creare le pagine o togliere le voci.
- Dopo la story `2026-10-08-services-to-actions-seo.story.md` (rimozione di `app/Services/MetatagService.php`) vanno riverificati `services-to-adapters-conversion.md`, `duplicate-methods-analysis.md`, `wiki/concepts/no-app-support-queueable-actions.md`: citano il file rimosso.
- `PHILOSOPHY.md` e `philosophy.md` sono due documenti diversi con lo stesso nome logico; `README.md` di `docs/` va ricomposto in un solo documento.
- Il frontmatter generico (`type: note`, `tags: [documentation]`, `qmd` uguale al titolo) resta su 100+ file: arricchirlo richiede lettura di ogni file.

## GitHub

Issue: TODO (gh non installato su questa macchina)
Discussion: TODO
