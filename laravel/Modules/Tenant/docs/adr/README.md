---
<<<<<<< .merge_file_OSWuT9
title: "ADR — Tenant"
type: index
owner: Tenant
updated: 2026-11-24
qmd: "Tenant ADR architecture decision record MADR formato isolamento configurazione"
---

# ADR — Tenant

Un ADR del modulo Tenant registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale sull'identificazione del tenant e sulla sua configurazione. Ogni affermazione ha un file di prova. Template condiviso: [0000-template](../../../Xot/docs/adr/0000-template.md); standard: [Xot ADR](../../../Xot/docs/adr/README.md).

## Formato MADR

Frontmatter (`title`, `type: decision`, `status`, `created`, `updated`, `decision-makers`, `module`, `qmd`) e sezioni nell'ordine: `## Contesto`, `## Driver della decisione`, `## Alternative scartate`, `## Decisione`, `## Conseguenze`, `## Conferma`. Nome file in kebab-case senza data né numero.

## ADR presenti

Elenco con stato: [INDEX.md](INDEX.md). Nessun ADR nuovo in questa passata: le decisioni dimostrabili dal codice (risoluzione della config tramite Action, overlay centralizzato) sono già coperte da [tenant-config-is-resolved-by-action](tenant-config-is-resolved-by-action.md) e [tenant-isolation-is-invariant](tenant-isolation-is-invariant.md); non si duplicano.

Policy trasversale su dati sacri e test isolati: [0013-dati-sacri-migrazioni-e-test](../../../Xot/docs/adr/0013-dati-sacri-migrazioni-e-test.md).
=======
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
>>>>>>> .merge_file_c1BwWD
