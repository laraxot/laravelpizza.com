---
qmd: "docs index audit.story"
issues: []
discussions: []
title: "Lang: audit e ricostruzione indice docs/index.md"
type: story
module: Lang
slug: docs-index-audit
status: done
created: 2026-09-03
updated: 2026-09-03
tags:
  - docs
  - index
  - audit
---

# Lang: audit e ricostruzione indice docs/index.md

**Contesto**: `Modules/Lang/docs/` contiene 1235 file `.md` (540 solo al primo livello), con moltissime varianti quasi-duplicate dello stesso argomento (`-1`, `_underscore`, `MAIUSCOLO`, `-sumy`) accumulate nel tempo. Non esisteva un indice reale, solo uno stub auto-generato vuoto.

**Cosa e' stato fatto**: analisi programmatica di tutti i 540 file di primo livello per rilevare cluster di quasi-duplicati (114 gruppi, 300 file coinvolti), scelta di un file canonico per ognuno dei 354 argomenti unici, raggruppamento in 19 sezioni tematiche in `docs/index.md`. Le 695 sottocartelle sono state linkate tramite i loro indici/README esistenti dove presenti, oppure elencate direttamente per le cartelle piccole (1-8 file).

**Cosa NON e' stato fatto**: nessun file `.md` esistente e' stato cancellato, rinominato o spostato. Le varianti duplicate restano al loro posto, elencate nella sezione "Storico / da consolidare" di `docs/index.md` in attesa di un intervento di consolidamento dedicato (fuori scope di questa story).

**Follow-up suggeriti**: consolidare `docs/integration/` e `docs/_integration/` (contenuto sovrapposto ma non identico); dare un sotto-indice a `docs/wiki/integrations/` (158 file piatti); ripulire i doppioni interni di `docs/roadmap/` (numerazione vs nomi bare).
