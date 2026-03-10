# PHPStan Level 10 - Riepilogo Gennaio 2026

**Status**: ✅ QUICK WINS COMPLETATI
**Moduli corretti**: 15/17 (88%)

## 📊 Risultati Finali

### ✅ Moduli a 0 Errori (15)

1. **Activity** - 2 errori corretti
2. **Chart** - Già a 0 errori
3. **CloudStorage** - Già a 0 errori
4. **Cms** - Già a 0 errori
5. **DbForge** - Già a 0 errori
6. **Gdpr** - Già a 0 errori
7. **Geo** - 13 errori corretti
8. **Job** - Già a 0 errori
9. **Lang** - 1 errore corretto
10. **Media** - Già a 0 errori
11. **Notify** - Già a 0 errori
<<<<<<< .merge_file_2yZ09C
12. **healthcare_app** - 2 errori corretti
=======
<<<<<<< HEAD
12. **ModuloEsempio** - 2 errori corretti
=======
12. **ExternalProject** - 2 errori corretti
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_cJoc42
13. **UI** - 4 errori corretti
14. **User** - 1 errore critico corretto (BaseUser)
15. **Xot** - Già a 0 errori

### ⚠️ Moduli con Errori (2)

1. **Tenant** - 135 errori (da correggere)
2. **Limesurvey** - No files found (problema di configurazione)

## 🔧 Errori Corretti per Tipo

### Import Duplicati (8 file)
- `Lang/app/Models/Post.php` - PostFactory
- `UI/app/Actions/Icon/GetAllIconsAction.php` - SplFileInfo
- `UI/app/Filament/Forms/Components/AddressField.php` - HasMany, HasOne, MorphOne
- `UI/app/Filament/Tables/Columns/IconStateColumn.php` - Collection
- `Geo/database/factories/GeoNamesCapFactory.php` - GeoNamesCap
- `Xot/app/Providers/FilamentOptimizationServiceProvider.php` - PDO e altri import

### Type Narrowing (6 file)
- `Activity/app/Actions/ActivityLogger.php` - mapWithKeys() return type
- `UI/app/Filament/Forms/Components/RadioBadge.php` - is_string() ridondante
<<<<<<< .merge_file_2yZ09C
- `healthcare_app/app/Actions/Question/GetValue.php` - getExtra() return type
- `healthcare_app/app/Filament/Pages/AutoPage.php` - is_object() ridondante
=======
<<<<<<< HEAD
- `ModuloEsempio/app/Actions/Question/GetValue.php` - getExtra() return type
- `ModuloEsempio/app/Filament/Pages/AutoPage.php` - is_object() ridondante
=======
- `ExternalProject/app/Actions/Question/GetValue.php` - getExtra() return type
- `ExternalProject/app/Filament/Pages/AutoPage.php` - is_object() ridondante
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_cJoc42
- `Geo/app/Models/Address.php` - is_string() ridondante in array_filter()
- `Geo/app/Actions/UpdateClientCoordinatesBulkAction.php` - is_string() ridondante

### PHPDoc Syntax (4 file)
- `UI/app/Filament/Widgets/RedirectWidget.php` - @SuppressWarnings
- `UI/app/Filament/Widgets/UserCalendarWidget.php` - @SuppressWarnings
- `UI/app/Models/Policies/UiBasePolicy.php` - @SuppressWarnings
- `UI/app/Rules/OpeningHoursRule.php` - @SuppressWarnings

### File Corrotti (1 file)
- `UI/app/Filament/Forms/Components/ParentSelect.php` - Eliminato (non usato)

### Import Errati (1 file)
- `User/app/Models/BaseUser.php` - HasXotFactory e RelationX

## 📚 Documentazione Creata

1. `Activity/docs/phpstan-corrections-january-2026.md`
2. `UI/docs/phpstan-corrections-january-2026.md`
<<<<<<< .merge_file_2yZ09C
3. `healthcare_app/docs/phpstan-corrections-january-2026.md`
=======
<<<<<<< HEAD
3. `ModuloEsempio/docs/phpstan-corrections-january-2026.md`
=======
3. `ExternalProject/docs/phpstan-corrections-january-2026.md`
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_cJoc42
4. `Geo/docs/phpstan-corrections-january-2026.md`
5. `Xot/docs/phpstan-january-2026-summary.md` (questo file)

## 🎯 Pattern Documentati

### 1. Import Duplicati
**Problema**: Import duplicati causano errori fatali PHP che bloccano PHPStan.

**Soluzione**: Verificare sempre gli import:
```bash
grep -n "^use" file.php | sort | uniq -d
```

### 2. Type Narrowing - Rimozione Check Ridondanti
**Regola**: Dopo type narrowing, alcuni check diventano ridondanti.

**Pattern**:
```php
// ❌ SBAGLIATO - is_string() ridondante
if ($value !== null && is_string($value)) {
    return $value;
}

// ✅ CORRETTO - rimosso check ridondante
if ($value !== null) {
    return $value;
}
```

### 3. mapWithKeys() Return Type Narrowing
**Pattern**:
```php
/** @var array<string, int> $result */
$result = $collection->mapWithKeys(function (object $item, int $_key): array {
    if (! isset($item->key, $item->value)) {
        return [];
    }
    return [(string) $item->key => (int) $item->value];
})->toArray();
```

### 4. array_filter() con Type Narrowing
**Pattern**:
```php
], function ($part): bool {
    // Verifica prima il tipo, poi se è vuoto
    if (! \is_string($part)) {
        return false;
    }
    return $part !== '';
});
```

### 5. PHPDoc @SuppressWarnings
**Regola**: I valori devono essere tra virgolette:
```php
/**
 * @SuppressWarnings("PHPMD.ShortVariable")
 * @SuppressWarnings("PHPMD.UnusedFormalParameter")
 */
```

### 6. getExtra() Type Narrowing
**Pattern**:
```php
$value = $model->getExtra($key);
if (null !== $value) {
    if (\is_array($value) || \is_bool($value) || \is_float($value) || \is_int($value) || \is_string($value)) {
        /** @var array|bool|float|int|string $value */
        return $value;
    }
}
```

## 🚀 Prossimi Passi

### Tenant Module (135 errori)
- Analisi sistematica degli errori
- Categorizzazione per tipo
- Correzione batch per pattern
- Documentazione completa

### Limesurvey Module
- Verificare configurazione autoload
- Verificare se ci sono file PHP da analizzare
- Risolvere problema "No files found"

## 📈 Statistiche

- **Errori corretti**: ~23 errori
- **File modificati**: ~15 file
- **Moduli completati**: 15/17 (88%)
- **Tempo impiegato**: ~2 ore
- **Commit**: 4 commit
- **Documentazione**: 5 file creati

## 🔗 Collegamenti

- [PHPStan Code Quality Guide](./phpstan-code-quality-guide.md)
- [Activity Corrections](../activity/docs/phpstan-corrections-january-2026.md)
- [UI Corrections](../ui/docs/phpstan-corrections-january-2026.md)
<<<<<<< .merge_file_2yZ09C
- [healthcare_app Corrections](../healthcare_app/docs/phpstan-corrections-january-2026.md)
=======
<<<<<<< HEAD
- [PHPStan Code Quality Guide](../phpstan-code-quality-guide.md)
=======
- [ExternalProject Corrections](../<nome progetto>/docs/phpstan-corrections-january-2026.md)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
>>>>>>> .merge_file_cJoc42
- [Geo Corrections](../geo/docs/phpstan-corrections-january-2026.md)
