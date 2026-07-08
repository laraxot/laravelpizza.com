- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Rating

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Rilevamenti rapidi (scan modulo)

- **Filament:** 2 `*Resource.php` (`RatingResource`, `RatingMorphResource`); nessun nome Resource duplicato a livello root, ma **classi Table gemelle** in `RatingResource/Tables/` (`RatingTable.php` + `RatingsTable.php`) e in `RatingMorphResource/Tables/` (`RatingMorphTable.php` + `RatingMorphsTable.php`) — verificare quale è referenziata e rimuovere l’altra.
- **Widget / RelationManager duplicati:** `StatsOverview` in `Filament/Widgets/` e in `HasRatingResource/Widgets/`; `RatingsRelationManager` in `RelationManagers/` e in `HasRatingResource/RelationManagers/`.
- **Migrazioni:** 5 file in `database/migrations/`; **doppio `create_ratings_table`** (`2023_01_01_000000` e `2026_03_12_180000`) — allineare a una sola create + alter (vedi tabella §12 nel [report cross-modulo](../docs/redundancy-report.md)).
- **Modelli base:** `BaseRating` canonico qui; copia parallela in `Modules/Xot/app/Models/BaseRating.php` da eliminare o delegare.
- **Conformità Laraxot:** `BaseMorphPivot` estende `MorphPivot` invece di `XotBaseMorphPivot`; `EventServiceProvider` non usa `XotBaseEventServiceProvider`.

## Problemi Trovati

### 1. 🟠 BaseMorphPivot NON estende XotBaseMorphPivot

**File**: `app/Models/BaseMorphPivot.php`

```php
// ATTUALE (NON conforme)
abstract class BaseMorphPivot extends MorphPivot
{
    use Updater;
}

// CORRETTO
abstract class BaseMorphPivot extends XotBaseMorphPivot {}
```

### 2. 🟠 BaseRating — Duplicato in Xot

**File**: `app/Models/BaseRating.php`

Esiste una copia in `Modules/Xot/app/Models/BaseRating.php`. Rating è il modulo canonico per questo modello.

**Azione suggerita**: Eliminare la copia in Xot. Tutti gli import dovrebbero puntare a `Modules\Rating\Models\BaseRating`.

### 3. 🟡 EventServiceProvider — Non usa XotBaseEventServiceProvider

**File**: `app/Providers/EventServiceProvider.php`

Estende `BaseEventServiceProvider` (Laravel) invece di `XotBaseEventServiceProvider`.

### 4. 🟠 Filament — Table e widget duplicati nello stesso modulo

| Coppia | Path |
|--------|------|
| `RatingTable` / `RatingsTable` | `RatingResource/Tables/` |
| `RatingMorphTable` / `RatingMorphsTable` | `RatingMorphResource/Tables/` |
| `StatsOverview` | `Filament/Widgets/` vs `HasRatingResource/Widgets/` |
| `RatingsRelationManager` | `RelationManagers/` vs `HasRatingResource/RelationManagers/` |

**Azione suggerita:** Una sola implementazione per tipo; `HasRatingResource` dovrebbe riusare classi condivise, non clonarle.

### 5. 🔴 Migrazioni `ratings` — Doppia create

| File | Tabella |
|------|---------|
| `2023_01_01_000000_create_ratings_table.php` | `ratings` |
| `2026_03_12_180000_create_ratings_table.php` | `ratings` (seconda create) |

**Azione suggerita:** Tenere la create storica e convertire la 2026 in migration `alter` o rimuoverla se già applicata in ambienti target.

## Riepilogo

| Priorità | Problema | Stato |
|----------|----------|-------|
| 🔴 | Doppia migration `create_ratings_table` | Da consolidare |
| 🟠 | Table/widget Filament duplicati | Da unificare |
| 🟠 | BaseMorphPivot non conforme | Da risolvere |
| 🟠 | BaseRating duplicato in Xot | Xot da pulire |
| 🟡 | EventServiceProvider inconsistente | Da standardizzare |
