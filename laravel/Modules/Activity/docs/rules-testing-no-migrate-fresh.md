---
title: "CRITICAL ARCHITECTURE RULE: NO MIGRATE:FRESH"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "critical architecture rule: no migrate:fresh activity"
---
# CRITICAL ARCHITECTURE RULE: NO MIGRATE:FRESH

## Rule
**NEVER** use `migrate:fresh` or the `RefreshDatabase` trait in any test or setup script within this modular architecture (Laraxot).

## Why?
1. **Destructive**: It destroys all tables across the default database connection.
2. **Tenant/Module Coupling**: In a modular application, tables are meant to be isolated. Wiping the entire database crashes other concurrently running tests or removes shared look-up tables that are not seeded correctly per-module.
3. **Data Loss**: Running tests with `RefreshDatabase` against a shared testing database will indiscriminately destroy other modules' data.

## Correct Approach
- Only use `DatabaseTransactions` to rollback state after tests.
- Maintain strict database boundaries.
