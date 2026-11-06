---
title: "docs index audit.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "docs index audit.story"
issues: []
discussions: []
---

# Story: Docs index audit — Gdpr

**Fase BMAD**: Documentazione / manutenzione (docs-only, nessuna modifica a codice applicativo).

**Contesto**: `Modules/Gdpr/docs/` ha accumulato ~130 file `.md` tra import grezzi (`raw/root-import/`), copie root (`root-md-files/`), roadmap frammentate (`roadmap/` e `development/roadmap/`) e indici concorrenti (`index.md`, `INDEX.md`, `00-index.md`, `00-INDEX.md`).

**Azione**: aggiornato `docs/index.md` come indice unico organizzato per argomento (panoramica, conformità/consensi, pacchetti, html2pdf, qualità/performance, roadmap, task, wiki interno, raw import). Nessun file `.md` esistente è stato rinominato o cancellato.

**Duplicati rilevati**: segnalati in `docs/index.md` § "Storico / da consolidare" (indici concorrenti, coppie `.md`/`.txt`, `raw/root-import/*` vs `*-1.md`, `roadmap/` vs `development/roadmap/`, `index.md`/`INDEX.md` per-cartella in `wiki/`, tre varianti di `agents.md`).

**Verifica**: elenco file confrontato con `find Modules/Gdpr/docs -type f`; nessun file toccato oltre a `docs/index.md` e questa story.
