---
title: "Migrazioni — solo updateTimestamps"
type: concept
module: Xot
created: 2026-06-05
updated: 2026-06-05
qmd: "xot migration updateTimestamps XotBaseMigration no redundant timestamps softDeletes"
story: STORY-140
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/270"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/271"
related:
  - ../../../../../docs/wiki/bmad/architecture-migration-update-timestamps-only.md
  - ../../../../../docs/wiki/rules/migration-update-timestamps-only.md
---

# updateTimestamps only

Implementazione: `Modules\Xot\Database\Migrations\XotBaseMigration::updateTimestamps()`.

Regola: **non** duplicare `$table->timestamps()`, `softDeletes()`, né `string('created_by')` nello stesso file.

Audit: `bashscripts/tools/audit-migration-timestamp-redundancy.sh laravel/Modules/<Module>/database/migrations`
