---
type: concept
module: User
confidence: high
updated: 2026-06-05
---

# Profile Migration UUID Contract

## Regola (runtime User)

`BaseProfile` genera `uuid` in `creating`. Il contratto richiede colonna `uuid` nella tabella `profiles` del DB usato dal modello concreto.

## Owner schema in Fixcity (questo progetto)

Per connessione `fixcity`, **owner migrazione = modulo Fixcity** (non User):

- `laravel/Modules/Fixcity/database/migrations/2026_06_10_123000_create_profiles_table.php`

Le migrazioni `create_profiles_table` in User/Blog sono state archiviate in `_bak/*.merged` per rispettare 1 modello = 1 migrazione owner.

Vedi [profiles-ownership-boundary-rule](./profiles-ownership-boundary-rule.md) e [Fixcity profiles-uuid-contract](../../../Fixcity/docs/wiki/concepts/profiles-uuid-contract.md).

## One table = one migration

- niente `add_*` / `repair_*` su `profiles`
- evoluzione: edit file owner Fixcity + **bump timestamp** nel nome file

## Fix 2026-04-20

- errore osservato: `table profiles has no column named uuid`
- causa: installazione con tabella `profiles` senza colonna `uuid`, mentre `BaseProfile::booted()` la valorizza in create
- correzione:
  - mantenuta una sola migrazione `create_profiles_table`
  - confermata colonna `uuid` in `tableCreate()`
  - confermata aggiunta idempotente in `tableUpdate()` con `if (! $this->hasColumn('uuid'))`
  - aggiornato timestamp del file migrazione per riesecuzione controllata

## Fix 2026-04-28 (MariaDB syntax)

- errore osservato: `SQLSTATE[42000] ... near 'after id'` durante `CREATE TABLE profiles`
- causa: uso di `->after('id')` nel blocco `tableCreate()`
- dettaglio tecnico: `after()` e' un posizionamento colonna valido per `ALTER TABLE`,
  non per la definizione colonna nel `CREATE TABLE` generato da Laravel su MariaDB
- correzione:
  - rimosso `->after('id')` da `tableCreate()` per `uuid`
  - mantenuto `->after(...)` solo nel blocco `tableUpdate()` (additive alter, idempotente)

## Implicazione pratica

Quando compare un bug schema su `profiles`, la prima domanda non e':
"serve una nuova migrazione?"

La prima domanda corretta e':
"la migrazione canonica `create_profiles_table` e' completa e ha timestamp coerente per essere rieseguita?"

## Riferimenti

- `laravel/Modules/User/app/Models/BaseProfile.php`
- `laravel/Modules/Fixcity/database/migrations/2026_06_10_123000_create_profiles_table.php`
- [architecture-one-migration-per-model](../../../../../docs/wiki/bmad/architecture-one-migration-per-model.md)
- `laravel/Modules/Xot/docs/database/migration-base-rules.md`
