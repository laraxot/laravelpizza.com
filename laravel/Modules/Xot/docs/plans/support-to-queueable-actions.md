---
title: "Support to Queueable Actions"
type: note
status: draft
updated: 2026-10-22
tags: [docs, xot, plans]
qmd: "support to queueable actions xot"
---
# Support to Queueable Actions

## Intent

`app/Support` mixed registries, schema probes, formatters, adapters and domain
operations under a name that does not describe their lifecycle. The migration
assigns each responsibility to its owning module and exposes executable use
cases through Spatie Queueable Actions.

## Rules

- No directory named `Support` remains anywhere below a production module
  `app/` root. Test fixtures may use `tests/Support` because those helpers are
  test infrastructure, not application behavior.
- Actions live under the owning module's `app/Actions` namespace and expose a
  typed `execute()` method.
- Existing domain APIs are preserved through the already-canonical Actions;
  callers and tests are migrated together, without compatibility classes in
  `Support`.
- Pure multi-operation contracts and infrastructure adapters remain adapters or
  contracts when they are not use cases; they are not forced into a fake queue.
- No `Support` namespace is retained under production `app`; technical code is
  named by its role (`Adapters`, `Infrastructure`, `Contracts`) and executable
  behavior is exposed by an Action.
- A class is not made queueable merely because it was previously placed in a
  Support folder. Queueability belongs to an application use case; framework
  builders and pure infrastructure keep their native role in a semantic
  namespace.
- Seeder fixtures are named by their purpose (`Database/Seeders/Demo`), so
  deterministic demo data remains explicit without pretending it is an
  asynchronous application use case.
- The migration must preserve localization, nullable behavior, serialization,
  and Filament panel configuration.

## Work sequence

1. Inventory each Support class and all callers.
2. Reuse existing Actions where an equivalent already exists.
3. Convert only the remaining executable responsibility to a typed Action.
4. Migrate imports, tests and module documentation.
5. Prove no Support directories or namespaces remain, then run PHPStan and
   focused tests.

## Verification gates

```bash
find laravel/Modules -type d -path '*/app/*/Support' -o -type d -path '*/app/Support'
rg -n '^(namespace|use) (Modules|Themes|App)\\[^;]*\\Support([\\; ]|\\\\)' laravel/Modules laravel/Themes
cd laravel && ./vendor/bin/phpstan analyse Modules --memory-limit=1G
```

The first two commands must return no active application references. Runtime
tests remain subject to the configured test database and are reported as
unverified if that external dependency is unavailable.


## Status 2026-10-22

Production `app/Support` = **0**. Faux-Action cleanup: Geo config → `Infrastructure\Config`;
AI registry → `Adapters`; Blog ArticleDelegates morto rimosso. Ratchet: `NoServicesTest`.
Process: `docs/second-brain/process/no-app-support-queueable-actions.md`.
