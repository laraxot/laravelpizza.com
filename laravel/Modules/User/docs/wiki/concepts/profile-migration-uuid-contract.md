---
type: concept
module: User
confidence: high
updated: 2026-04-20
---

# Profile Migration UUID Contract

## Regola

La tabella `profiles` deve rispettare il contratto Laraxot:

- `id`: chiave primaria interna database
- `uuid`: identificatore esterno/pubblico

Se il modello `Profile` salva o cerca `uuid`, la migrazione canonica della tabella
deve dichiarare e backfillare la colonna tramite `tableUpdate()`.

## One Table = One Migration

Per `profiles` esiste una sola migrazione autorevole:

- `laravel/Modules/User/database/migrations/*_create_profiles_table.php`

La manutenzione schema non si fa con nuove migrazioni `add_*` o `fix_*`.
Si modifica la migrazione canonica, poi si aggiorna il timestamp del file per far rieseguire l'`up()` idempotente.

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
- `laravel/Modules/User/database/migrations/2026_04_28_120000_create_profiles_table.php`
- `laravel/Modules/Xot/docs/database/migration-base-rules.md`
