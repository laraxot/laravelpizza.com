---
issues: []
discussions: []
title: "Directory Structure Rules"
module: "Media"
type: rule
tags: [directory, structure, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "directory structure rules"
related:
  - "./webm.md"
---
# Directory Structure Rules

Per il modulo Media valgono queste regole:

- `lang/lang/` non deve esistere;
- `_docs/` non deve esistere;
- le traduzioni ufficiali stanno in `lang/<locale>/`;
- la documentazione ufficiale sta in `docs/`.

La vecchia cartella duplicata individuata era `Media/bashscripts/_docs`.

Regola canonica: [no-lang-lang-and-no-underscore-docs-rule](../../../../docs/wiki/concepts/no-lang-lang-and-no-underscore-docs-rule.md).