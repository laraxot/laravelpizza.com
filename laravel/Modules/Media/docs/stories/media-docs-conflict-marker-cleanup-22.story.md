---
title: "media docs conflict marker cleanup 2026 09 22.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "media docs conflict marker cleanup 2026 09 22.story"
issues: []
discussions: []
---

# Story: Media — pulizia marker di conflitto residui in docs/

## Status
Done.

## Contesto
Task ricorrente su 3 repo indipendenti nello stesso monorepo (Activity, Media,
Lang): verificare `docs/` per marker di merge Git irrisolti e verificare la
coerenza dell'indice. Causa radice gia' diagnosticata per l'intera fleet in
`docs/stories/5.122-gitmodules-sync-2026-09-15-safe-subset.story.md` (repo
principale): il daemon locale di auto-commit ("Marco Xot", msg ".") a volte
fa merge con un remote divergente e committa marker non risolti.

## Trovato
47 file sotto `docs/` con marker `<<<<<<< HEAD` / `=======` / `>>>>>>> `
committati (struttura piatta, un blocco per conflitto, nessun annidamento —
verificato con conteggio bilanciato `<<<`/`===`/`>>>` per file).

## Azione
Classificazione automatica per blocco (head/dev vuoto o sottoinsieme →
risoluzione automatica; contenuto divergente → giudizio manuale):
- 34 blocchi risolti automaticamente (un lato vuoto o sottoinsieme dell'altro).
- 13 blocchi divergenti risolti a mano, criteri principali: tenuto il lato
  con informazione reale quando l'altro era stub/generico; unite le sezioni
  quando entrambe portavano contenuto nuovo (es. `00-INDEX.md`: sia "Ultimo
  Aggiornamento" sia "Dependency Intelligence"); preferita la denominazione
  generica "laraxot" ai nomi di progetti ospiti (FixCity, SaluteOra)
  hardcoded — Media e' un modulo condiviso fra piu' progetti (`git remote
  -v`: remote `laraxot` e `provtv`); normalizzati alcuni link a target
  minuscoli coerenti con le altre occorrenze nello stesso file, verificando
  via `find` l'esistenza reale del file target prima di scegliere.

`docs/README.md`, `docs/index.md`, `docs/purpose.md` verificati coerenti ed
esistenti, nessuna modifica necessaria oltre alla risoluzione del conflitto
in README.md/index.md stessi.

## Verifica
```bash
cd laravel/Modules/Media
grep -rl '^<<<<<<< \|^=======$\|^>>>>>>> ' docs/ --include='*.md'
# atteso: nessun output (verificato, exit 1)
```

Commit: `61140006a7697a142cfa7f92834553ca544dfda3`.
