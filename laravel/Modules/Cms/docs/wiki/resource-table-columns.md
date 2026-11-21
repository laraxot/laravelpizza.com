---
title: "resource table columns"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "resource table columns"
issues: []
discussions: []
---

# Resource table columns

## BMAD story and evidence

As an administrator I need identifiable records and operational state without oversized technical columns. Acceptance: string-keyed `array<string, Column>`, fields backed by models and migrations (or Sushi schemas), sortable dates, optional technical details.

Page, Section, PageContent and Attachment use Sushi JSON schemas; preserve translatable fields and make slugs searchable. Menu parent relation is declared by recursive relationship trait.

Sources: `app/Models`, `database/migrations`, existing resource `Pages/List*.php` and `Tables/*Table.php`. QMD query attempted before editing: unavailable because better-sqlite3 ABI 127 differs from Node ABI 147; direct source inspection used.
