---
title: "Case-Insensitive File Conflicts"
qmd: "ui case conflicts md"
type: note
tags: [documentation]
---

# Case-Insensitive File Conflicts

File duplicati rilevati nel modulo `UI`:

- `Modules/UI/.github`: `CONTRIBUTING.md`, `CONTRIBUTING.md`
- `Modules/UI/.github`: `SECURITY.md`, `SECURITY.md`
- `Modules/UI/docs`: `README.md`, `README.md`
- `Modules/UI/docs/filament`: `listrecords.md`, `listrecords.md`

Uniformare ciascuna coppia scegliendo un'unica versione (in genere `README.md`, `CONTRIBUTING.md`, ecc.) e rimuovere i duplicati.
