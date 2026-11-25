---
title: "Indice contract — Xot"
type: index
status: active
owner: Xot
created: 2026-11-23
updated: 2026-11-24
qmd: "xot contract indice invarianti pest group coperto non coperto backlog contract action"
---

# Indice contract — Xot

Inventario dei contratti comportamentali del pacchetto **Xot**. Un contratto descrive un'operazione o un confine pubblico esistente; ogni invariante ha un ID stabile e, se esiste un test, un gruppo Pest con lo stesso ID. L'assenza di copertura è dichiarata, non sottintesa. Formato: [contract-authoring-standard](contract-authoring-standard.md), [README](README.md), decisione [ADR 0012](../adr/0012-behavioral-contract-governance.md).

Verifica di un invariante: `rg -n "group\('<ID>'\)" laravel/Modules/Xot/tests`; esecuzione: `vendor/bin/pest --group=<ID>` da `laravel/`.

## Contract

| Contract | Owner / classe | Invarianti | Stato copertura |
|---|---|---|---|
| [bootstrap-provider-registry](bootstrap-provider-registry.md) | `bootstrap/providers.php` (registro provider Laravel) | `BOOTSTRAP-PROVIDERS-001`, `BOOTSTRAP-PROVIDERS-002`, `BOOTSTRAP-PROVIDERS-003` | non coperto (nessun `group('...')` con questi ID in `Modules/Xot/tests`) |
| [xotbase-classes](xotbase-classes.md) | famiglia `XotBase*` (`XotBaseResource`, `XotBaseModel`, `XotBasePolicy`, `XotBaseServiceProvider`, `XotBaseMigration`, `XotBaseTestCase`) | nessun ID dichiarato nel file | non coperto: contratto narrativo senza invarianti con ID |

## Documenti di metodo (non sono contract)

Non contengono invarianti propri e non vanno contati come contract.

- [contract-authoring-standard](contract-authoring-standard.md) — standard di authoring (tipo `standard`).
- [behavioral-contract-template](behavioral-contract-template.md), [0000-template](0000-template.md), [_template](template.md) — modelli; gli ID `MODULE-INV-1` e `<SCOPE>-INV-1` sono segnaposto, **non coperto** e da non citare.
- [README](README.md) — convenzioni storiche del pacchetto.
- [Regola Action Behavioral Contract](../rules/action-behavioral-contract.md) — quando il contract è obbligatorio.

## Stato di copertura

| ID | Contract | Gruppo Pest | Stato |
|---|---|---|---|
| `BOOTSTRAP-PROVIDERS-001` | bootstrap-provider-registry | assente | non coperto |
| `BOOTSTRAP-PROVIDERS-002` | bootstrap-provider-registry | assente | non coperto |
| `BOOTSTRAP-PROVIDERS-003` | bootstrap-provider-registry | assente | non coperto |
| `MODULE-INV-1` | modello (segnaposto) | assente | non coperto |

Divergenza docs-codice rilevata il 2026-11-24: `BOOTSTRAP-PROVIDERS-001` (e [ADR 0009](../adr/0009-laravel-bootstrap-provider-registry.md)) dicono che `bootstrap/providers.php` contiene solo `AppServiceProvider`, ma il file in `laravel/bootstrap/providers.php` elenca anche `App\Providers\Filament\AdminPanelProvider`. Va deciso se correggere il contract o il file; in attesa il contract non è verificato. Il test `Modules/Xot/tests/Unit/Bootstrap/FolioProviderNotRegisteredTest.php` controlla solo l'assenza di `FolioServiceProvider` e non copre nessun ID.

Divergenza di formato: il [README](README.md) prescrive ID `<OWNER>-<OPERAZIONE>-INV-<N>`, il template `<SCOPE>-INV-<N>`; gli ID del contract bootstrap (`BOOTSTRAP-PROVIDERS-00N`) seguono un terzo schema. Quando si scrive il primo test si allineano.

## Backlog contract

Nessun contract nuovo in questo giro. Xot ha **238 file** in `app/Actions`, nessun contract di Action e nessun marker `@contract` nei docblock (`rg -c "@contract" app/Actions` vuoto). Contract da scrivere per rischio decrescente, solo dove il codice lo dimostra:

- Action che scrivono su filesystem o config: `SavePhpArrayAction` (`app/Actions/Arr`), azioni in `Actions/File`, `Actions/Config`, `Actions/Composer`, `Actions/Artisan`.
- Action sul confine con i tenant: `GetTenantConfigArrayAction`.
- Invarianti di `XotBaseMigration` (`tableCreate()` / `tableUpdate()`, forward-only) già descritte in [xotbase-classes](xotbase-classes.md): da estrarre con ID e gruppo Pest.
- Le restanti Action di lettura/trasformazione non hanno effetti collaterali e restano fuori scopo ([ADR 0011](../adr/0011-contract-docblock-reference.md)).
