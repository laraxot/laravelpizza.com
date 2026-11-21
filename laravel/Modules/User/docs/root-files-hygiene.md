---
title: "Root files hygiene"
type: concept
tags: [root, files, hygiene]
created: 2026-07-14
updated: 2026-07-14
qmd: "root-files-hygiene root files hygiene"
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

# Root files hygiene

## 2026-07-08 16:48

Root normalized to keep no `.txt` files, at most four Markdown files, and a single module/theme workspace file named after the directory.

- moved `git-reset.md` to `docs/root-md-files/git-reset.md` (root markdown limit is four files)

## 2026-07-08 16:51

- created `User.code-workspace` as the single canonical root workspace file.
