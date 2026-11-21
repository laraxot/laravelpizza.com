---
title: "Case-Insensitive File Conflicts"
type: concept
tags: [case, conflicts]
created: 2026-07-14
updated: 2026-07-14
qmd: "case-conflicts case-insensitive file conflicts"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Case-Insensitive File Conflicts

Nel modulo `User` sono presenti i seguenti file duplicati per sola differenza di maiuscole/minuscole:

- `Modules/User/.devcontainer`: `README.md`, `README.md`
- `Modules/User/.github`: `CONTRIBUTING.md`, `CONTRIBUTING.md`
- `Modules/User/.github`: `SECURITY.md`, `SECURITY.md`
- `Modules/User/docs`: `index.md`, `index.md`

Correggere mantenendo una sola variante coerente con le convenzioni del progetto e aggiornare gli eventuali riferimenti.
