# Lang Module — PHPStan

## 2026-06-10 — STORY-305 · Level 10 · 0 errori

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Lang
# [OK] No errors
```

- Test: `Assert::assert*()`, `uses(TestCase::class)`, helper al posto di `$this` in closure
- `tests/Pest.php` minimal (no `pest()->extend`)
- `TestCase::assertDatabaseHasRow()` per DB in Pest
- Tooling: `laravel/scripts/phpstan/fix-pest-tests.php`
- Issue [#332](https://github.com/laraxot/base_fixcity_fila5/issues/332) · base D[#333](https://github.com/laraxot/base_fixcity_fila5/discussions/333)

---

## Storico — Level 7 (Gennaio 2025)

Il modulo Lang era a 0 errori Level 7.
<<<<<<< HEAD
# Lang Module - PHPStan Level 7 Fixes - Gennaio 2025
# Lang Module — PHPStan

## 2026-06-10 — STORY-305 · Level 10 · 0 errori

Il modulo Lang è stato completamente risolto per PHPStan Level 7 con 0 errori rimanenti.
```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Lang
# [OK] No errors
```

- Test: `Assert::assert*()`, `uses(TestCase::class)`, helper al posto di `$this` in closure
- `tests/Pest.php` minimal (no `pest()->extend`)
- `TestCase::assertDatabaseHasRow()` per DB in Pest
- Tooling: `laravel/scripts/phpstan/fix-pest-tests.php`
- Issue [#332](https://github.com/laraxot/base_fixcity_fila5/issues/332) · base D[#333](https://github.com/laraxot/base_fixcity_fila5/discussions/333)

---

## Storico — Level 7 (Gennaio 2025)

Il modulo Lang era a 0 errori Level 7.
=======
>>>>>>> 11c7c7d (.)

## 🔧 **Correzioni Implementate**

### Filament Resources - Array Compatibility
Tutte le risorse Filament del modulo Lang sono state aggiornate per utilizzare array associativi con chiavi string, seguendo le best practices del progetto.

### Safe Casting Patterns
Implementati pattern di safe casting per tutti i casi di conversione da mixed types, utilizzando i pattern documentati nel progetto:

```php
// Pattern di Safe Casting implementati
use function Safe\json_decode;
use \Modules\Xot\Actions\Cast\SafeStringCastAction;

// Esempio di implementazione
$safeValue = SafeStringCastAction::cast($mixedValue);
```

## 📋 **Pattern Implementati**

### Array Associativi Filament
```php
/**
 * @return array<string, \Filament\Actions\Action>
 */
protected function getHeaderActions(): array
{
    return [
        'locale_switcher' => Actions\LocaleSwitcher::make(),
        'create' => Actions\CreateAction::make(),
        'export' => Actions\Action::make('export')
            ->label('Export Translations')
            ->icon('heroicon-o-document-arrow-down')
            ->action(function (): void {
                // Export implementation
            }),
    ];
}
```

### Safe Casting Implementation
```php
/**
 * Safe casting from mixed to string
 */
private function safeCastToString(mixed $value): string
{
    return is_string($value) ? $value : (string) ($value ?? '');
}

/**
 * Using SafeStringCastAction
 */
private function castWithAction(mixed $value): string
{
    return SafeStringCastAction::cast($value);
}
```

### Best Practices Seguite
- **Array Associativi**: Sempre utilizzare chiavi string per azioni Filament
- **Safe Casting**: Utilizzo di pattern sicuri per conversioni di tipo
- **PHPDoc Completo**: Specificare tipi di ritorno precisi
- **Validation**: Controlli di tipo prima del casting
- **Compatibilità**: Allineamento con classi base del progetto

## 🎯 **Risultati**
- **Errori PHPStan**: 0 (completamente risolto)
- **Safe Casting**: Implementato in tutti i punti critici
- **Compatibilità**: 100% con XotBaseListRecords
- **Standard**: Conforme alle convenzioni del progetto
- **Sicurezza**: Casting sicuro per tutti i mixed types

## 📚 **Documentazione di Riferimento**
- `docs/phpstan-level7-guide.md`: Guida completa PHPStan Level 7
- `docs/phpstan/safe-casting-patterns.md`: Pattern di casting sicuro
- `docs/phpstan/guida_filament_table_actions.md`: Guida azioni Filament

## 🔍 **Errori Risolti**
- **Mixed Type Casting**: Risolti tutti gli errori di casting da mixed a string/int/float
- **Array Compatibility**: Corretti tutti i formati array per Filament
- **Generic Types**: Aggiornati PHPDoc per generic types corretti
- **Method Signatures**: Allineate tutte le signature con le classi base

---
*Ultimo aggiornamento: Gennaio 2025*
*Ultimo aggiornamento: Gennaio 2025*
<<<<<<< HEAD
*Stato: ✅ Completato - 0 errori PHPStan*
*Stato: ✅ Completato - 0 errori PHPStan*
*Stato: ✅ Completato - 0 errori PHPStan*
*Stato: ✅ Completato - 0 errori PHPStan*
*Ultimo aggiornamento: Gennaio 2025*
*Stato: ✅ Completato - 0 errori PHPStan*
=======
*Stato: ✅ Completato - 0 errori PHPStan*
>>>>>>> 11c7c7d (.)
