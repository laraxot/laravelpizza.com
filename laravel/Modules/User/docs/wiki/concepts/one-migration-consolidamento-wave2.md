---
title: "User: one migration consolidamento wave 2"
type: concept
status: canonical
module: User
created: 2026-09-01
updated: 2026-09-01
tags: [migrations, user, one-migration-per-model]
qmd: "user migrations one owner profiles teams users git delete"
related:
  - ./migrations-users-inventory.md
  - ../../../Xot/docs/wiki/concepts/one-migration-per-model.md
  - ../../../../../../docs/wiki/memories/one-migration-per-model-bump-timestamp.md
  - ../../../../../../docs/wiki/memories/one-migration-per-model-bump-timestamp.md
---

# User: consolidamento migrazioni

Wave 2: un solo `create_*` top-level per tabella (`users`, `profiles`, `teams`, …).
Duplicati e `add_*`: **`git rm`**. Nessuna cartella `_archive_redundant` / `_bak`.

Owner esempi: `2026_11_12_120000_create_users_table.php`,
`2026_09_01_150108_create_profiles_table.php`,
`2026_09_01_150109_create_teams_table.php`.
