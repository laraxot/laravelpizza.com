---
id: dcp-201-nomi-dei-file-md-senza-date-e-senza-suffissi
title: Nomi dei file .md senza date e senza suffissi numerici
status: in-progress
created: 2026-10-15
updated: 2026-11-05
module: Xot
owner: Xot (tooling trasversale: bashscripts/tools/docs)
depends_on: []
related:
  - ../../../../../docs/wiki/rules/markdown-filename-conventions.md
  - ./prompts-bashscripts-improvement.story.md
owned_scope:
  - bashscripts/tools/docs/md-filenames.py
  - docs/wiki/rules/markdown-filename-conventions.md
---

# Story

Come chi mantiene le docs voglio che nessun nome di file `.md` contenga date, timestamp o suffissi di copia
(`-1.md`, `-2.md`), perche' il nome e' un indirizzo stabile: una data invecchia e rompe i link a ogni rinomina,
e una serie `-1 -2 -3` non la sa ordinare nessuno. La data utile sta nel frontmatter (`created`, `updated`).

Regola dell'utente, 2026-10-15: assoluta, senza eccezioni per le story. Rafforzata il 2026-11-05 nel mandato
permanente dello sweep PHPStan ("i files .md devono seguire delle convenzioni, una delle convenzioni e' che nei
nomifile non ci devono essere date o timestamp").

## Acceptance criteria

1. `python3 -I bashscripts/tools/docs/md-filenames.py check` esce 0 sul perimetro (esclusi gli archivi `/docs/raw/`,
   `/wiki/skills/`, `/.agents/skills/`).
2. Le collisioni (due file che senza data avrebbero lo stesso nome) non si risolvono col tool: si uniscono con una
   decisione scritta, mai con un numero o una data al posto del suffisso.
3. Dopo ogni rinomina i link relativi restano validi (`links` prima/dopo, poi `fixrefs` con la mappa salvata).
4. Un controesempio dichiarato come tale (`WRONG`, `VIETATO`, `❌`) non viene riscritto in un nome valido.
5. `selftest` verde dopo ogni modifica del tool.

## Stato al 2026-11-05

- **Fatto:** `apply` ha rinominato 176 file (User 122, Xot 26, docs/chat 21, temi TwentyOne/Meetup/Zero, Geo) e ritirato
  23 file (`.md.old`). La mappa e' stata salvata nello scratchpad della sessione, fuori dal repo.
- **Guasto trovato e chiuso:** `apply` aveva riscritto la riga `❌ WRONG: dry-kiss-analysis-2025-10-15.md` di
  `bashscripts/ai/CLAUDE.md`, trasformando il controesempio in un nome valido. Aggiunto `BAD_EXAMPLE_LINE` (salta le
  righe con `❌`, `WRONG`, `VIETATO`) e un caso di `selftest`. La riga e' stata ripristinata.
- **Misurato ora:** `check` segnala 14 violazioni residue, tutte serie o coppie numerate da decidere:
  `docs/chat/swarm/assigned-files-01/02`, `Media/docs/roadmap-root-symlink-1`, `User/docs/archive/quality-status-11` e
  `quality-status-2025-11`, `User/docs/archive/historical/phpstan-fixes-2/3` e `actions-structure-1`,
  `User/docs/bug-fixes/legacy/parse-error-orphan-methods-2025-01-27`, `Xot/docs/consolidated/lessons-learned-2` e
  `lessons-learned-1-1`, `Xot/docs/consolidated/phpstan/phpstan-fixes-summary-1` e `-2-1`, `Xot/docs/laragon/update-mysql-8`.
- **Falso positivo da valutare:** `update-mysql-8.md` contiene la versione MySQL 8, non un suffisso di copia: o si
  rinomina in `update-mysql-version-8.md` o si ammette il numero di versione nel tool.

## Tasks

- [ ] Decidere le 14 residue: per ognuna leggere i file della serie, unire il contenuto nel nome senza numero e
  collegare (non cancellare) l'altro come `superseded`.
- [ ] Rieseguire `fixrefs --map <mappa>` quando i file toccati dagli altri agenti sono committati (179 riferimenti
  saltati perche' il file che li contiene era sporco).
- [x] Allineare i riferimenti: il docstring di `md-filenames.py` citava `docs/wiki/rules/md-filenames-no-dates-no-numeric-suffix.md`
  e una memoria omonima, che non esistono (la regola canonica e' `markdown-filename-conventions.md`), e la regola
  canonica puntava questa story in `bmad-output/`, vietato dall'ordine permanente dell'utente.
- [ ] Decidere l'alias `bashscripts/docs/prompts/97-YAML-FRONTMATTER-CONVENTION.md`: e' un redirect voluto verso il
  nome minuscolo (esiste perche' file esterni lo citano) ma e' anche un nome che differisce solo per maiuscole, vietato
  da `no-case-only-variations`. O si correggono i riferimenti storici e si toglie l'alias, o si documenta l'eccezione.
- [ ] Trovare chi genera `laravel/Modules/*/docs/audits/<data>-quality-gates.md` (file con data nel nome, ricreati).

## Dev agent record

- 2026-11-05 — Claude: tool irrobustito, `check` e `links` rieseguiti. Nessun commit.
