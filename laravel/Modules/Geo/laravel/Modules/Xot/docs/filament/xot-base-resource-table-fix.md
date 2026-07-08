# XotBaseResourceTable: Static Method Context Bug Fix

**Data:** 2026-05-26  
**Commit:** 533beaa6e  
**Issue:** [#148](https://github.com/provtv/base_ptv_fila5_mono/issues/148)

## Problema

File: `laravel/Modules/Xot/app/Filament/Resources/Tables/XotBaseResourceTable.php`

### Bug 1: Missing Import
```php
// @return array<int|string, Column>  // ← usa Column
abstract public function getTableColumns(): array;
```
Ma non aveva l'import: `use Filament\Tables\Columns\Column;`

### Bug 2: Static Method Context
```php
// ❌ ERRATO
public static function configure(Table $table): Table {
    return $this->table($table);  // $this non esiste in static!
}

// ✅ CORRETTO (PHPStan level-max: no new static() in abstract class)
public static function configure(Table $table): Table {
    /** @var static $tableConfigurator */
    $tableConfigurator = app(static::class);
    return $tableConfigurator->table($table);
}
```

## Impatto

- **App boot failure** — PHP parse error
- **Filament resource discovery broken** — Tutti i `Resources` che estendono `XotBaseResourceTable` non caricabili
- **Memory exhaustion** — Laravel tentava di ricaricare il file infinite volte

## Soluzione

✅ **Commit 533beaa6e:**
```diff
+use Filament\Tables\Columns\Column;
 use Filament\Tables\Table;
 use Modules\Xot\Filament\Traits\HasXotTable;

-    return $this->table($table);
+    /** @var static $tableConfigurator */
+    $tableConfigurator = app(static::class);
+    return $tableConfigurator->table($table);
```

## Zen Filosofico

> **"Un metodo statico chiama `$this` — è come cercare il proprio riflesso in uno specchio rotto."**

Il pattern statico in PHP non ha accesso al contesto dell'istanza. Da PHPStan 2 level-max, `new static()` in una classe astratta è vietato (`new.staticInAbstractClassStaticMethod`). La risoluzione via `app(static::class)` delega al container Laravel l'istanza concreta quando `configure()` è invocato da una sottoclasse (es. `EventsTable::configure()`).

## Risorse Affette

- ✅ `Lang/TranslationFileResource`
- ✅ `User/OauthAuthCodeResource`
- ✅ `User/OauthClientResource`
- ✅ `User/SocialProviderResource`
- ✅ e altri 50+ Resources Filament

## Lezioni Apprese

1. **Static methods need static access** — No `$this`, usa `self::` o `static::`
2. **Abstract methods must be compatible** — Type hints (docblock) devono avere imports corrispondenti
3. **Test discovery early** — Il bootstrap di Filament avrebbe dovuto fallire prima in test
