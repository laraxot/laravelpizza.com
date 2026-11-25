---
<<<<<<< .merge_file_1c0eLV
<<<<<<< .merge_file_KJoPUI
<<<<<<< .merge_file_HaXkiM
=======
=======
>>>>>>> .merge_file_08mBGK
=======
>>>>>>> .merge_file_TasaX3
<<<<<<< HEAD
title: "Best Practices"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "Best Practices"
=======
<<<<<<< .merge_file_1c0eLV
<<<<<<< .merge_file_KJoPUI
>>>>>>> .merge_file_E7MvBi
=======
>>>>>>> .merge_file_08mBGK
=======
>>>>>>> .merge_file_TasaX3
title: "best practices"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-23
qmd: "best practices"
<<<<<<< .merge_file_1c0eLV
<<<<<<< .merge_file_KJoPUI
<<<<<<< .merge_file_HaXkiM
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_E7MvBi
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_08mBGK
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_TasaX3
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
<<<<<<< .merge_file_1c0eLV
<<<<<<< .merge_file_KJoPUI
<<<<<<< .merge_file_HaXkiM
- Aggiorna `docs/index.md` con nuovi blocchi disponibili.
=======
=======
>>>>>>> .merge_file_08mBGK
=======
>>>>>>> .merge_file_TasaX3
<<<<<<< HEAD
- Aggiorna `docs/index.md` con nuovi blocchi disponibili.
=======
<<<<<<< HEAD
- Aggiorna `docs/index-2.md` con nuovi blocchi disponibili.
=======
- Aggiorna `docs/index.md` con nuovi blocchi disponibili.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_1c0eLV
<<<<<<< .merge_file_KJoPUI
>>>>>>> .merge_file_E7MvBi
=======
>>>>>>> .merge_file_08mBGK
=======
>>>>>>> .merge_file_TasaX3
- Documenta flusso approvazione contenuti.
