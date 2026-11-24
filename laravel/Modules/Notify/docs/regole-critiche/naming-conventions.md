---
title: "naming conventions"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_aU6YNs
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_os7zBQ
qmd: "naming conventions"
issues: []
discussions: []
---

# Naming Conventions - Database Folders

## Regola Mandatoria
Tutte le cartelle all'interno di `database/` nei moduli devono essere rigorosamente in **minuscolo**:
- `database/factories`
- `database/migrations`
- `database/seeders`

## Razionale
Garantire la compatibilità cross-platform (Linux/Windows) e l'allineamento con gli standard di caricamento automatico di Laravel e Composer.

## Azioni Correttive
In caso di rilevamento di cartelle con iniziali maiuscole (es. `Factories`), rinominarle immediatamente e aggiornare i namespace nei file PHP contenuti.
