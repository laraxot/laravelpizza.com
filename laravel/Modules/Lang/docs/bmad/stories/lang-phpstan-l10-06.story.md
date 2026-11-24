---
title: "Lang — PHPStan Level 10 fixes (2026-10-06)"
type: story
module: Lang
status: in_progress
created: 2026-10-06
updated: 2026-10-06
phase: quality-gates
priority: P1
related:
  - cluster3-phpstan-swarm-20261006.story.md
---

# Lang — PHPStan Level 10 fixes (2026-10-06)

## Scopo funzionale

Lang modulo: gestire traduzioni (`Translation`, `LanguageLine`), sincronizzarle tra file e DB, sincronizzazione batch via `SyncTranslationsAction`, esposizione UI (`TranslationFileResource`, `LocaleSwitcherRefresh`), auto-label componenti Blade e Filament.

## Errori PHPStan trovati (131 totali)

### Categoria 1: Model @mixin e fasade DB (7 errori, 4 fixati)
- **LanguageLine.php:43** — `@mixin \Eloquent` — FIX: cambiato in `\Illuminate\Database\Eloquent\Model`
- **Post.php:108** — `@mixin \Eloquent` — FIX: cambiato in `\Illuminate\Database\Eloquent\Model`
- **Translation.php:59** — `@mixin \Eloquent` — FIX: cambiato in `\Illuminate\Database\Eloquent\Model`
- **Translation.php:108, 113** — `DB::getDriverName()`, `DB::raw()` — FIX: aggiunto `use Illuminate\Support\Facades\DB;`
- **TranslationFile.php:44** — `@mixin \Eloquent` — FIX: cambiato in `\Illuminate\Database\Eloquent\Model`

### Categoria 2: View components render() type (4 fixati)
- **Flag.php:22, 32** — `$view` unresolvable type, render() return — FIX: `@var string`, cast result
- **LanguageSwitcher.php:37, 40, 50, 53** — `@var view-string` — FIX: `@var string` per tutte

### Categoria 3: Actions firstOrCreate (3 segnalati)
- **RecordMissingTranslationAction.php:25** — `Translation::firstOrCreate()` undefined — FIX: aggiunto `@method firstOrCreate()` su model
- **TranslatorAction.php:63** — `Translation::firstOrCreate()` undefined
- **TranslatorService.php:74** — `Translation::firstOrCreate()` undefined

### Categoria 4: WriteTranslationFileAction (3 fixati)
- **Lines 115, 121, 122** — Cannot call method flush() on mixed — FIX: type guard `@var object`

### Categoria 5: Remaining (110+ errori, skip per now)
- Filament methods (placeholder type, offset access)
- TranslationData mixed types
- Test files (70+ Pest internal class warnings)

## Fix applicati

### 1. Translation.php
```php
// Aggiunto import
use Illuminate\Support\Facades\DB;

// Aggiunto @method
@method static EloquentBuilder<static>|Translation firstOrCreate(array $attributes = [], array $values = [])

// Fixato @mixin
@mixin \Illuminate\Database\Eloquent\Model

// Usato DB facade directly
$select = match (DB::getDriverName()) { ... }
return $query->select(DB::raw($select));
```

### 2. LanguageLine, Post, TranslationFile
```php
// Cambiato
@mixin \Eloquent
// a
@mixin \Illuminate\Database\Eloquent\Model
```

### 3. Flag component
```php
// Da
@phpstan-var view-string $view

// A
@var string $view
$view = (string) app(GetViewAction::class)->execute();
```

### 4. LanguageSwitcher component
```php
// Sia linea 37 che 50, cambiato
@var view-string
// a
@var string
```

### 5. WriteTranslationFileAction
```php
// Da
app('cache')->flush();

// A
/** @var object $cache */
$cache = app('cache');
if (method_exists($cache, 'flush')) {
    $cache->flush();
}
```

## Verifica

Tutti i file modificati passano `php -l`:
```bash
php -l Modules/Lang/app/Models/Translation.php ✓
php -l Modules/Lang/app/Models/LanguageLine.php ✓
php -l Modules/Lang/app/Models/Post.php ✓
php -l Modules/Lang/app/Models/TranslationFile.php ✓
php -l Modules/Lang/app/View/Components/Flag.php ✓
php -l Modules/Lang/app/View/Components/LanguageSwitcher.php ✓
php -l Modules/Lang/app/Actions/WriteTranslationFileAction.php ✓
```

## Learning points

1. **@mixin corretto**: usare `\Illuminate\Database\Eloquent\Model` (classe), non `\Eloquent` (facade)
2. **Facade resolution**: importare esplicitamente `use Illuminate\Support\Facades\DB;`
3. **View factory return**: Laravel `view()` ritorna `Factory|View`, specificare il tipo in @var
4. **Builder methods in @method**: aggiungere `@method static EloquentBuilder<static>|Model methodName()`
5. **Mixed handling**: usare type guards (method_exists, @var cast) prima di chiamare metodi

## Prossimi step

- Rieseguire PHPStan per valutare riduzione errori
- Fissare TranslationData mixed types (10+ errori)
- Fissare test files Pest warnings (skip for now, low priority)
- Commit finale con documentazione aggiornata

## Correlazioni

Questo fix segue il pattern di altre correzioni PHPStan Level 10:
- Rating module (2026-10-06): 10 errori fixati con builder generics
- Incentivi module: auth type narrowing
- Ptv module: query builder type assertions


## Swarm swarm-lang-tenant (run 4 PHPStan, 2026-10-06): correzione

Claim: agente swarm-lang-tenant. Errori in elenco Lang: 5, risolti 5.

Scopo funzionale: `Flag` renderizza l'icona bandiera di un locale; `LanguageSwitcher` e' il wrapper Blade del widget selettore lingua; `Translation` e' il model delle traduzioni DB.

Cosa e' cambiato:
- `Flag.php`, `LanguageSwitcher.php`: tolti `@var string` e cast `(string)`. Erano la causa dell'errore `view-string`: allargavano a `string` un tipo che `GetViewAction::execute()` dichiara gia' `view-string`, e per i letterali `lang::components.*` PHPStan verifica da solo che la view esista (esistono). Questo supera il fix della sezione "Categoria 2" sopra (`@var string`), che era la causa, non la cura.
- `Translation.php`: rimosso `@method static ... firstOrCreate(array, array)`. Era stato aggiunto quando `@mixin \Eloquent` rompeva la risoluzione; ora `@mixin Model` e' corretto e il tag e' ridondante (e dichiarava un ritorno `EloquentBuilder|Translation` falso: `firstOrCreate` ritorna il model). I 3 chiamanti (`RecordMissingTranslationAction`, `TranslatorAction`, `TranslatorService`) passano PHPStan senza il tag.

Verifica: `phpstan analyse` mirato su `View/`, `Models/Translation.php`, i 3 chiamanti: `[OK] No errors`. `php -l` e `class_exists` ok. Pest su `LangCoverageBoostTest` (filtro flag/switcher): muto fino al timeout 120s su questo host, NON e' un esito verde.

Problema NON risolto, trovato leggendo lo scopo: `resources/views/components/flag.blade.php` ignora `$name` e punta sempre a `Theme::asset('lang::svg/it.svg')`; quel file non esiste (le bandiere stanno in `resources/svg/flag/{codice}.svg`). Il componente mostra sempre una bandiera italiana rotta. Serve decidere la mappa locale -> codice paese (`en` -> `gb`/`us`) prima di correggerlo.

Lezione: un `@var string` messo per "calmare" PHPStan su una view e' un sintomo di tipo allargato a monte; togliere l'annotazione e lasciar fluire il letterale fa verificare a PHPStan che la view esista davvero.
