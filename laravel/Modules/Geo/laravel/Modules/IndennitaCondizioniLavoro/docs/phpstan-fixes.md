# PHPStan Level 10 Fixes - 2025-11-12

## Status Iniziale
- **Errori PHPStan**: 81
- **Issues PHPMD**: ~90
- **Complessità**: Alta (CondizioniLavoro.php)

## Fixes Applicati

### 1. PHPDoc Parse Errors ✅
**File**: `MakePdf.php`, `ReplicateIndennita.php`
**Problema**: Sintassi PHPDoc non valida `array{anno/valutatore:...}`
**Soluzione**: Quotato la chiave `array{'anno/valutatore':...}`
**Errori risolti**: 2

### 2. Model Type Safety Issues 🔄 IN CORSO
**File**: `CondizioniLavoro.php`, `ServizioEsterno.php`, `IndennitaTipo.php`
**Problema**:
- Accesso a proprietà `$pivot` non definita su IndennitaTipoDettaglio
- Assegnamenti `mixed` a proprietà tipizzate
- Parametri `mixed` passati a Carbon::parse()
- Accessor che ritornano `mixed` invece di tipi specifici

**Da Risolvere**:
- [ ] Definire relazione pivot corretta con custom pivot class
- [ ] Aggiungere assertions o type guards per mixed values
- [ ] Correggere return types degli accessor
- [ ] Aggiungere null checks appropriati

### 3. Filament Resource Type Issues ⏳ PENDING
**File**: `CondizioniLavoroResource.php`, `ListCondizioniLavoros.php`, `CompilaCondizioniLavoro.php`
**Problema**:
- Property access su `mixed`
- Foreach su non-iterables
- Parametri con tipo mixed

### 4. Code Quality Issues (PHPMD) ⏳ PENDING
**Priorità Bassa - Da Refactor Successivo**:
- Complessità ciclomatica: `CondizioniLavoro::populate()` = 19 (threshold 10)
- Metodo lungo: 114 linee (threshold 100)
- Naming: variabili snake_case da convertire in camelCase
- Static access: Normale per Filament, può essere ignorato

## Approccio Sistematico

### Priorità 1: Type Safety Critico
1. Definire custom pivot class per IndennitaTipoDettaglio relation
2. Aggiungere PHPStan annotations dove necessario
3. Implementare type guards e assertions

### Priorità 2: Accessor Return Types
1. Correggere ServizioEsterno accessor methods
2. Gestire null cases in MutatorTrait

### Priorità 3: Filament Resources
1. Aggiungere type hints espliciti
2. Validare iterables prima di foreach

### Priorità 4: Refactoring (Post-Fix)
1. Semplificare `populate()` method
2. Estrarre logica in metodi più piccoli
3. Standardizzare naming conventions

## Note Tecniche

### Pivot Relation Pattern
La relazione many-to-many tra CondizioniLavoro e IndennitaTipoDettaglio usa una pivot table custom.
Serve definire: `ServisioEsternoIndennitaTipoDettaglioPivot` come pivot class.

### Carbon Parse Issues
Molti accessor chiamano `Carbon::parse($mixed)`. Serve validazione input:
```php
if ($value !== null && (is_string($value) || $value instanceof DateTimeInterface)) {
    return Carbon::parse($value);
}
```

### Accessor Guard Pattern
Il modulo segue già il pattern accessor-guard per i metodi con `save()` (verificato in `accessor-guard-audit.md`).

## Documentazione Correlata
- [Accessor Guard Audit](./accessor-guard-audit.md)
- [PHPStan Improvements 2025](./phpstan-improvements.md)
- [Wire Model Reactivity](./wire-model-input-reactivity.md)

## Timeline
- **Start**: 2025-11-12 12:00
- **PHPDoc Fixes**: 2025-11-12 12:30 ✅
- **Model Fixes**: In corso...
- **Target Completion**: 2025-11-12 EOD

## Obiettivo Finale
**Target**: 0 errori PHPStan Level 10
**Current**: 81 errori
**Progress**: 2.5% (2/81)

## scan modulo completo 2026-05-21

**comando:** `cd laravel && ./vendor/bin/phpstan analyse Modules/IndennitaCondizioniLavoro --no-progress`  
**esito:** 4 errori → 0

| file | fix |
|------|-----|
| `ListStabiDirigentes.php` | `@phpstan-ignore method.childReturnType` (come `XotBaseListRecords`; parent Ptv restituisce `Action\|ActionGroup`) |
| `IndennitaTipo.php` | `whereRaw('? between dal and al', [$safeAnno])` al posto di SQL concatenata |
| `RelationshipTrait.php` | stesso binding parametrizzato + anno numerico sicuro |

## scan 2026-06-18

| file | fix |
|------|-----|
| `CondizioniLavoroAdmsTable.php:41` | Separato `$this->tableFilters` in `$rawFilters` con `@phpstan-ignore-next-line property.notFound`, poi `@var array<string, mixed>` per il risultato del ternary |
| `CondizioniLavorosTable.php:32,41` | Stesso pattern — `rawFilters` + type assertion |

**Pattern vincente per tableFilters in Table classes:**
```php
/** @phpstan-ignore-next-line property.notFound */
$rawFilters = $this->tableFilters;
/** @var array<string, mixed> $tableFilters */
$tableFilters = is_array($rawFilters) ? $rawFilters : [];
app(SomeAction::class)->execute($tableFilters);
```

### UI — stub per Cms

| file | fix |
|------|-----|
| `phpstan-stubs/CmsActionStubs.php` | Creato stub per `Modules\Cms\Actions\ResolveLocalizedBlockDataAction` |
| `phpstan-bootstrap.php` | Aggiunto `require_once` per caricare lo stub |

*ultimo aggiornamento scan: 2026-06-18*

## scan 2026-07-07

**comando:** `cd laravel && ./vendor/bin/phpstan analyse Modules/IndennitaCondizioniLavoro --no-progress --error-format=table`  
**esito codice:** 0 errori nel modulo; resta solo ignore stale in `phpstan.neon` (`larastan.noEnvCallsOutsideOfConfig`), modificabile solo dall'utente.

| file | fix |
|------|-----|
| `IndennitaTipoDettaglioAnno.php` | `pluck()` normalizzato con loop tipizzato e guard `is_string()` per restituire `array<int|string, string|null>` |
| `ServizioEsterno.php` | relazione opzionale verso modulo Trasferte risolta con `class-string<Model>` dinamico unico, evitando branch con generic `HasMany` divergenti |

Pattern: quando una relazione punta a un modulo opzionale, scegliere una sola variabile `class-string<Model>` validata con `class_exists()` + `is_subclass_of()` e passarla a `hasMany()`.
