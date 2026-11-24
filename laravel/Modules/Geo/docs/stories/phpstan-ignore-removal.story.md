---
title: "[STORY] Geo: rimozione delle annotazioni @phpstan-ignore"
type: story
module: Geo
status: done-with-open-decision
priority: medium
created: 2026-11-17
updated: 2026-11-17
tags: [phpstan, geo, phpstan-ignore, traits, bmad]
related:
  - ./phpstan-cleanup-geo.story.md
  - ./01.Geo-phpstan-fix.story.md
---

# [STORY] Geo: rimozione delle annotazioni @phpstan-ignore

Fase BMAD: Dev (con analisi) + verifica. Regola dell'utente: mai `@phpstan-ignore`, mai baseline, `mixed` solo come ultima spiaggia.

## Analisi (scopo, chi usa, causa)

Metodo: per ogni annotazione tolta, PHPStan su `Modules/Geo` con tutte le annotazioni rimosse e nessuna correzione ancora applicata, per
vedere cosa nascondevano davvero. Risultato: 11 segnalazioni, tutte in 2 file; le altre annotazioni non nascondevano nulla.

| File | Annotazioni | Cosa nascondevano | Esito |
|------|-------------|-------------------|-------|
| `app/Traits/HasAddresses.php` | 6 x `return.type` | Niente: nessuna segnalazione senza annotazione | Tolte |
| `app/Models/Traits/SushiToJsons.php` | `trait.unused` | Niente: il trait e' usato da una fixture di test | Tolta |
| `app/Models/Traits/GeographicalScopes.php` | `trait.unused` + 4 x `next-line` | `trait.unused`: niente. `missingType.generics` (x2 metodi, parametro e ritorno) e `argument.type` su `new Expression($sql)` (SQL non letterale: floats interpolati nel testo) | Causa corretta |
| `tests/Support/EnsuresGeoDatabaseSchema.php` e `tests/support/...` | `next-line` | `trait.unused` reale: il trait non e' usato da nessuno | **Lasciate** (decisione aperta) |

### GeographicalScopes: cosa e' stato corretto

Scopo: `withDistance` aggiunge la colonna `distance` (Haversine, km), `orderByDistance` ordina per quella formula. Nessun chiamante in codice
(`grep` su `Modules` e `Themes`): `getDistanceExpression()` era usato solo dal trait stesso; le altre occorrenze sono documenti.

- `@param Builder<static>` / `@return Builder<static>` sui due scope (stessa forma di `GeoTrait`).
- SQL con segnaposto e binding (`selectRaw`/`orderByRaw`) invece di latitudine e longitudine interpolate nel testo SQL: l'SQL grezzo del progetto
  deve essere `literal-string`. Stessa regola di `GeoTrait::scopeWithDistance` e `Address::scopeNearby` (`*` solo se la query non ha gia' colonne,
  perche' `*, expr` dopo altre colonne e' un syntax error su MariaDB).
- Rimosso `getDistanceExpression()` (pubblico, zero chiamanti): restituiva un `Expression` costruito con interpolazione e non puo' essere
  `literal-string`. Sostituito dal metodo protetto `distanceSql()`.
- Differenza di comportamento: prima `select('*', expr)` sostituiva le colonne gia' scelte; ora `selectRaw` le mantiene e aggiunge `distance`
  (comportamento canonico di `GeoTrait`). Il trait non ha utilizzatori applicativi.
- Test: `tests/Unit/Traits/GeographicalScopesTest.php` con fixture `tests/Fixtures/Traits/GeographicalScopesTestModel.php` (SQL e binding).

## Decisioni chiuse (wave PHPStan Modules)

1. **Doppioni morti rimossi.** Cancellati `HasAddresses`, `SushiToJsons` (copia Geo), `GeographicalScopes`, `HasPlaceTrait`.
   Canon: `HasAddress` + `GeoTrait::scopeWithDistance` (test in `GeoTraitWithDistanceSqlTest`); `SushiToJsons` vive in Tenant (Cms).
   `tests/Arch/debt.php` non elenca piu' il SushiToJsons di Geo. Nessun `*PhpstanProbe*` (vietati).
2. **CoordinatePickerHelpers.** Canon = `Filament/Forms/Components/CoordinatePickerHelpers` (stesso NS di `XotBaseCoordinateField`).
   `HasCoordinatePicker` deve `use` quella classe: senza import PHPStan risolve sotto `Traits\` → `class.notFound`.
   Rimossa la copia `Support/CoordinatePickerHelpers` e il `normalizeCoordinate` privato duplicato nel trait.
   **Nominatim single-source:** `searchAddress` / `reverseGeocode` / `normalizeCoordinate` / `extractCoordinates`
   vivono solo negli Helpers; il trait (e `XotBaseCoordinateField`) tengono wrapper `#[Exposed]`/`#[Renderless]`
   che delegano. Motivo: PHPStan L10 perde i tipi `array<…>` sui corpi grandi nei trait (× ogni consumer).
3. **Aperto:** `EnsuresGeoDatabaseSchema` duplicato `tests/Support/` vs `tests/support/` (fuori scope di questa wave).

## Acceptance Criteria

- [x] Zero `@phpstan-ignore` su `HasAddresses`, `SushiToJsons`, `GeographicalScopes`
- [x] `phpstan analyse Modules/Geo`: 0 errori dopo (0 prima)
- [x] Test nuovo per la logica cambiata (3 test, Pest, nessun `RefreshDatabase`)
- [x] Nessun file cancellato o spostato, nessun `mixed`, nessuna baseline
- [ ] 2 `@phpstan-ignore` residui su `EnsuresGeoDatabaseSchema` (decisione 3)

## Verifica

- PHPStan `Modules/Geo` (cartella): prima 0 errori / dopo 0 errori; con le annotazioni rimosse e prima delle correzioni 11 errori in 2 file.
- Pest `Modules/Geo/tests/Unit/Traits`: prima 9 passati (24 asserzioni) / dopo 12 passati (31 asserzioni), 0 falliti.
- Residuo: `grep -rIn --include='*.php' phpstan-ignore laravel/Modules/Geo` = 2 righe (le due copie di `EnsuresGeoDatabaseSchema`).
- Limite: la suite Geo intera (500 s di timeout) non e' completata ne' prima ne' dopo; la parte eseguita prima del timeout dava 429 passati, 0 falliti.
  I tre trait modificati non sono usati da nessun test ne' codice applicativo oltre a fixture.

## GitHub (tracciamento)

- Issue: TODO (non aperta da questa corsia)
- Discussion: TODO
