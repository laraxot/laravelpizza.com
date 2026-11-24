---
title: "architecture testing env"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "architecture testing env"
issues: []
discussions: []
---

# Testing Environment

Geo tests follow the owning Xot module's canonical database policy:
[`../../Xot/docs/testing-database-strategy.md`](../../Xot/docs/testing-database-strategy.md).
Use the tracked secret-free `.env.testing` template, MySQL/MariaDB `_test` databases, and
credentials injected through dedicated `FIXCITY_TEST_DB_*` environment variables. Never
copy `.env` or reuse development credentials. Do not run migrations until an authorized DBA
has provisioned and granted access to the isolated test databases.
