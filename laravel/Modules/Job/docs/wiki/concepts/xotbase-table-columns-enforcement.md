---
title: "XotBaseResourceTable Columns Enforcement — Job Module"
type: concept
sources: []
confidence: high
created: 2026-05-07
updated: 2026-05-07
tags: [xotbase, filament, tables, enforcement]
related:
  - phpstan-schedule-schema-return-type.md
  - ../../../../../../docs/wiki/concepts/xotbase-table-columns-enforcement.md
---

# Job Module: XotBaseResourceTable Columns

9 Table files populated with columns from job/queue models.

Resources: Export, FailedImportRow, FailedJob, Import, JobBatch, JobManager, Job, JobsWaiting, Schedule

Reference implementation: `FailedJobsTable.php` with `id`, `connection`, `queue`, `failed_at` — all Job Table files follow this pattern.
