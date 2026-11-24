---
title: "ADR — modulo Tenant"
type: index
tags: [adr, decisioni, tenant, multi-sito]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Tenant

Il **perché** di come lo stesso codice serve più siti: come si sceglie il tenant dall'host, come le connessioni dei
moduli restano una sola transazione, perché i test non scrivono sui contenuti versionati del sito.

Leggili prima di toccare `GetTenantNameAction`, `GetTenantFilePathAction`, `TenantServiceProvider::registerDB()` o i
trait Sushi. Formato e regole: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Decisioni

- [Il tenant è la cartella di config del dominio invertito](tenant-name-from-reversed-host.md) — host → `config/com/example/foo`, symlink risolti, niente database.
- [Connessione per modulo, alias della default](module-connections-alias-default.md) — stessa istanza `Connection` finché la config coincide.
- [Nei test i contenuti JSON vanno in una copia sotto storage](tenant-json-content-isolated-in-tests.md) — `database/content/` mai scritto dai test.

## Decisioni precedenti (formato libero, non ancora ADR)

- [Rimozione del controllo runningInConsole](../runninginconsole-check-decision.md)
- [arr-first vs collect-first](../arr-first-vs-collect-first-decision.md)
- [Decision log](../decision-log.md)
