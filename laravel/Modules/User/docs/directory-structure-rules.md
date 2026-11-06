---
title: "Directory Structure Rules"
type: rule
tags: [directory, structure, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "directory-structure-rules directory structure rules"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Directory Structure Rules

Per il modulo User valgono queste regole:

- `lang/lang/` non deve esistere;
- `_docs/` non deve esistere;
- le traduzioni ufficiali stanno in `lang/<locale>/`;
- la documentazione ufficiale sta in `docs/`.

La vecchia cartella duplicata individuata era `User/docs/_docs`.

Regola canonica: [no-lang-lang-and-no-underscore-docs-rule](../../../../docs/wiki/concepts/no-lang-lang-and-no-underscore-docs-rule.md).
