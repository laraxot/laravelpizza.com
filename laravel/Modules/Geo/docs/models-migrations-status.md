---
title: "models migrations status"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "models migrations status"
issues: []
discussions: []
---

# Geo — Stato Modelli / Migration / Seeder / Factory

> Aggiornato: 2026-07-24 — Ponytail Mode
> Obiettivo: ogni modello **concreto** che mappa una tabella deve avere migration + seeder + factory.

## Perché il gap migration (4 → ora 7)

Il modulo Geo ha 12 modelli concreti in `app/Models/`, ma **NON tutti hanno bisogno di una
tabella DB**. Cinque modelli sono backed da dati statici (Sushi in-memory o JSON su file), quindi
non richiedono migration. Solo 7 modelli mappano davvero una tabella persistente.

`abstract` / base esclusi dal conteggio: `BaseModel`, `BaseMorphPivot`, `BasePivot`, `GeoJsonModel`.

## Mappa modello → tabella

| Modello       | Backing                        | Tabella        | Migration | Seeder | Factory | Note |
|---------------|--------------------------------|----------------|-----------|--------|---------|------|
| Address       | Eloquent (DB)                  | `addresses`    | ✅ esist.  | ✅     | ✅      | — |
| Location      | Eloquent (DB)                  | `locations`    | ✅ esist.  | ✅     | ✅      | — |
| Place         | Eloquent (DB)                  | `places`       | ✅ esist.  | ✅     | ✅      | — |
| PlaceType     | Eloquent (DB)                  | `place_types`  | ✅ esist.  | ✅     | ✅      | — |
| **State**     | Eloquent (DB)                  | `states`       | 🆕 CREATA  | ✅     | ✅      | mancava |
| **County**    | Eloquent (DB)                  | `counties`     | 🆕 CREATA  | ✅     | ✅      | mancava |
| **GeoNamesCap** | Eloquent (DB)                | `geonames_cap` | 🆕 CREATA  | ✅     | ✅ (compl.) | tabella dichiarata `$table`, factory era vuota |
| Comune        | **Sushi** (`SushiToJson`, comuni.json) | in-memory | ⛔ N/A | ✅ | ✅ | dati da `resources/json/comuni.json` |
| Locality      | **Sushi**                      | in-memory      | ⛔ N/A     | ✅     | ✅      | `getRows()` in-memory |
| Province      | **Sushi**                      | in-memory      | ⛔ N/A     | ✅     | ✅      | `getRows()` in-memory (prima aveva migration, ora `.bak`) |
| Region        | **Sushi**                      | in-memory      | ⛔ N/A     | ✅     | ✅      | `getRows()` in-memory; vecchia migration → `,bak` |
| ComuneJson    | **JSON facade** (`extends GeoJsonModel`) | nessuna | ⛔ N/A | (no seeder) | (no factory) | readonly facade su comuni.json, NON è un modello Eloquent |

Conteggio migration tabelle DB: 4 esistenti + 3 nuove = **7** (= numero modelli con tabella reale). Coerente.

## Skip motivati (nessuna tabella propria)

- **Comune / Locality / Province / Region**: usano il trait `Sushi` / `SushiToJson`. Sushi genera
  una tabella SQLite in-memory a runtime dai dati statici (`getRows()` / `comuni.json`).
  Una migration persistente sarebbe ridondante e in conflitto con il pattern Sushi. Per Province e
  Region esistono vecchie migration disattivate (`.bak` / `,bak`) proprio perché migrate a Sushi.
- **ComuneJson**: non estende `BaseModel`/`Model` ma `GeoJsonModel` (astratto). È un **facade
  readonly** con metodi statici che leggono `resources/json/comuni.json` in cache. Nessuna tabella,
  nessun record persistito → niente migration/seeder/factory.

## File creati / modificati in questa iterazione

- `database/migrations/2025_07_24_000001_create_states_table.php` (nuova)
- `database/migrations/2025_07_24_000002_create_counties_table.php` (nuova)
- `database/migrations/2025_07_24_000003_create_geonames_cap_table.php` (nuova)
- `database/factories/GeoNamesCapFactory.php` (completata: `definition()` era `return []`)

Tutte le migration seguono lo stile `XotBaseMigration` (forward-only): schema in `tableCreate()`,
`updateTimestamps($table, true)` in `tableUpdate()` (timestamps + soft deletes), mai in `tableCreate()`.

## Vincolo dipendenze (nota, fuori scope)

Regola: `Modules/UI` NON deve importare `Modules\Geo\*` (direzione consentita: Geo → UI).
La violazione preesistente (`LocationSelector` in UI con `use Modules\Geo\Models\Comune;`) e' risolta:
il componente vive ora in `Modules/Geo/app/Filament/Forms/Components/LocationSelector.php`.
Nessuna dipendenza inversa introdotta da queste modifiche.
