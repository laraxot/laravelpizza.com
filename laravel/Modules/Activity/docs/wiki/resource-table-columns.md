---
title: "Resource table columns"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, wiki]
qmd: "resource table columns activity"
---
# Resource table columns

## BMAD story and evidence

As an administrator I need identifiable records and operational state without oversized technical columns. Acceptance: string-keyed `array<string, Column>`, fields backed by models and migrations (or Sushi schemas), sortable dates, optional technical details.

StoredEvent migration uses event_properties, aggregate_uuid, aggregate_version and event_version, not properties. Snapshot state and Activity properties are structured payloads; avoid raw array cells.

Sources: `app/Models`, `database/migrations`, existing resource `Pages/List*.php` and `Tables/*Table.php`. QMD query attempted before editing: unavailable because better-sqlite3 ABI 127 differs from Node ABI 147; direct source inspection used.
