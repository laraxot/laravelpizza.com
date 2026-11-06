---
title: "Profiles Id/Uuid Policy"
type: concept
tags: [profiles, uuid, policy]
created: 2026-07-14
updated: 2026-07-14
qmd: "profiles-id-uuid-policy profiles id/uuid policy"
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

# Profiles Id/Uuid Policy

## Contract

The `profiles` table must follow this identity contract:

- `id`: primary key, integer, auto-increment
- `uuid`: separate stable external identifier

`id` is the relational database key.
`uuid` is the portable public/application identifier.

## Why

- integer primary keys keep joins, indexes, and legacy relations simpler;
- `uuid` remains available for external references, APIs, imports, and cross-system correlation;
- mixing both responsibilities into a single `id` column creates migration drift between legacy installs and current models;
- `BaseProfile` already generates `uuid` on create, so the schema must expose the column consistently.

## Repair Rule

When fixing an existing installation:

1. if `profiles.id` is UUID/string, rename-preserve that identity into `uuid` and recreate `id` as bigint auto-increment;
2. if `profiles.id` is already integer, keep it and add `uuid` if missing;
3. backfill `uuid` for old rows where it is null.

## 2026-03-12 Incident

In `base_predict_fila5`, the runtime failed with:

- insert into `profiles` ... `uuid` ...
- SQLSTATE `42S22`
- unknown column `uuid`

The real schema already had `id` as `int unsigned AUTO_INCREMENT`, so the correct fix was not to rename `id`, but to restore the missing `uuid` column and codify the mixed legacy/current repair path in a dedicated migration.
