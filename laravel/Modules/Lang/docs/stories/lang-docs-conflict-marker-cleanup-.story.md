---
title: "lang docs conflict marker cleanup 2026 09 22.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "lang docs conflict marker cleanup 2026 09 22.story"
issues: []
discussions: []
---

# Story: Lang — pulizia marker di conflitto residui in docs/

## Status
Done.

## Contesto
Stesso task ricorrente descritto in
`Modules/Media/docs/stories/media-docs-conflict-marker-cleanup-2026-09-22.story.md`
e `Modules/Activity/docs/stories/activity-docs-conflict-marker-cleanup-2026-09-22.story.md`,
applicato a Lang. Stessa causa radice (daemon locale di auto-commit, vedi
`docs/stories/5.122-gitmodules-sync-2026-09-15-safe-subset.story.md` nel repo
principale).

## Trovato
Il grep ha trovato 9 file. Uno, `docs/stories/changelog-case-duplicate-and-
merge-conflict.story.md`, e' stato **escluso di proposito** dopo aver letto
il contesto: i marker al suo interno sono dentro un fence di codice, citati
come esempio documentale del conflitto gia' risolto in `CHANGELOG.md` (root
del modulo, non `docs/`) — non un conflitto reale. Trattarlo come tale
avrebbe distrutto la documentazione di un fix gia' fatto. Questo pattern
(citazione intenzionale) e' stato poi verificato assente nei file di
Activity prima di applicare la risoluzione di massa la'.

Dei restanti 8 file: 6 a struttura piatta (un blocco per conflitto), 2
(`CONSOLIDATION_PLAN.md`, `PRD.md`) con marker annidati su piu' generazioni.

## Azione
- 2 blocchi risolti automaticamente (un lato vuoto).
- 6 blocchi divergenti risolti a mano, caso per caso: `00-index.md` → link
<<<<<<< HEAD
<<<<<<< HEAD
  verificato al file reale (`AGENTS.md` maiuscolo esiste in root, `AGENTS.md`
=======
<<<<<<< HEAD
  verificato al file reale (`AGENTS.md` maiuscolo esiste in root, `agents.md`

verificato al file reale (`AGENTS.md` maiuscolo esiste in root, `AGENTS.md`
=======
  verificato al file reale (`AGENTS.md` maiuscolo esiste in root, `AGENTS.md`
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
  verificato al file reale (`AGENTS.md` maiuscolo esiste in root, `agents.md`

verificato al file reale (`AGENTS.md` maiuscolo esiste in root, `AGENTS.md`
>>>>>>> laraxot/dev
  no); `README.md` → tenuto il contenuto reale HEAD, scartato lo stub
  generico DEV; `docs-archive-policy.md` → fusa la versione DEV (piu'
  aggiornata) con la frase aggiuntiva di HEAD, corretti 2 link rotti verso
  `bashscripts/ai/wiki/` (verificati via `find`, puntavano a `docs/wiki/`
<<<<<<< HEAD
<<<<<<< HEAD
  inesistente); `wiki/index.md` (2 blocchi) → tenuta denominazione generica
=======
<<<<<<< HEAD
  inesistente); `wiki/INDEX.md` (2 blocchi) → tenuta denominazione generica

inesistente); `wiki/index.md` (2 blocchi) → tenuta denominazione generica
=======
  inesistente); `wiki/index.md` (2 blocchi) → tenuta denominazione generica
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
  inesistente); `wiki/INDEX.md` (2 blocchi) → tenuta denominazione generica

inesistente); `wiki/index.md` (2 blocchi) → tenuta denominazione generica
>>>>>>> laraxot/dev
  "laraxot" invece del nome di progetto ospite hardcoded "base_fixcity_fila5"
  (Lang e' condiviso fra piu' progetti, `git remote -v`: `laraxot` +
  `provtv`), corretto lo slug rotto "progetto corrente" (spazio letterale)
  in "progetto-corrente" per coerenza interna (link resta comunque rotto,
  nessun file con questo nome esiste: problema pre-esistente fuori scope).
- `CONSOLIDATION_PLAN.md` (2 blocchi) e `PRD.md` (2 blocchi): marker annidati
  risolti a mano leggendo il contenuto reale, non con il parser piatto.
  `PRD.md`: "Laravel 12+ required" preferito a "13+" per coerenza con la
  tabella requisiti 6 righe sopra nello stesso file; "architecture.md"
<<<<<<< HEAD
<<<<<<< HEAD
  preferito a "architecture.md" perche' 2 delle 3 generazioni impilate lo
=======
<<<<<<< HEAD
  preferito a "ARCHITECTURE.md" perche' 2 delle 3 generazioni impilate lo

preferito a "architecture.md" perche' 2 delle 3 generazioni impilate lo
=======
  preferito a "architecture.md" perche' 2 delle 3 generazioni impilate lo
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
  preferito a "ARCHITECTURE.md" perche' 2 delle 3 generazioni impilate lo

preferito a "architecture.md" perche' 2 delle 3 generazioni impilate lo
>>>>>>> laraxot/dev
  sceglievano.

`docs/README.md`, `docs/index.md`, `docs/purpose.md` verificati coerenti ed
esistenti.

## Verifica
```bash
cd laravel/Modules/Lang
grep -rl '^<<<<<<< \|^=======$\|^>>>>>>> ' docs/ --include='*.md'
# atteso: solo docs/stories/changelog-case-duplicate-and-merge-conflict.story.md
# (citazione intenzionale, non un conflitto reale)
```

Commit: `7402d521`.
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> laraxot/dev

## Wave docs 2026-11-23

Vedi canonica [lang-docs-conflict-marker-cleanup.story.md](./lang-docs-conflict-marker-cleanup.story.md):
45 file docs Lang a 0 marker (`/bin/grep` line-start).
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
