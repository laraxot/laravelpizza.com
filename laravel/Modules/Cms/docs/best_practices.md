---
<<<<<<< HEAD
title: "Best Practices"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "Best Practices"
=======
title: "best practices"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-23
qmd: "best practices"
>>>>>>> laraxot/dev
issues: []
discussions: []
---

# Best Practices – Cms

## Principi DRY/KISS
- **DRY**: Centralizza parsing pagine in `CmsService`. Usa cache per output renderizzato.
- **KISS**: Mantieni template semplici; evita logica complessa nelle view.
- **Clean Code**: Segui struttura `Model -> Repository -> Controller`.

## Componenti
- Usa `PageRepository` per query ricorrenti.
- Usa `BlockRenderer` per componenti modulari.

## Test
- Testa endpoint CMS con snapshot testing.
- Copri edge case per permessi pagina (draft vs published).

## Documentazione
<<<<<<< HEAD
- Aggiorna `docs/index.md` con nuovi blocchi disponibili.
=======
<<<<<<< HEAD
- Aggiorna `docs/INDEX.md` con nuovi blocchi disponibili.
=======
- Aggiorna `docs/index.md` con nuovi blocchi disponibili.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
- Documenta flusso approvazione contenuti.
