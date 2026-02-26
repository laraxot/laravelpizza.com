# PHPStan Corrections - Lang Module

## Panoramica
Questo documento registra le correzioni PHPStan implementate nel modulo Lang.

**Ultimo aggiornamento**: [DATE]
**Status PHPStan Level 10**: ✅ **PASSED** - 0 errori

## Correzioni Implementate

### Post.php - Doppio Import PostFactory ([DATE])

**Problema**: Doppio import di `PostFactory` causava conflitto di namespace
```php
// ERRORE: Cannot use Modules\Lang\Database\Factories\PostFactory as PostFactory because the name is already in use
use Modules\Lang\Database\Factories\PostFactory; // Riga 7
use Modules\Lang\Database\Factories\PostFactory; // Riga 14 - DUPLICATO
```

**Soluzione**: Rimosso import duplicato alla riga 14
```php
// CORRETTO: Un solo import
use Modules\Lang\Database\Factories\PostFactory;
```

**File**: `app/Models/Post.php`
**Risultato**: ✅ PHPStan Level 10 passa senza errori

### ConvertTranslations Command

**Problema**: Type hints inadeguati per array mixed
```php
// ERRORE: Parameter expects array<string, mixed>, array<mixed, mixed> given
protected function flattenArray(array $array, string $prefix = ''): array
```

**Soluzione**: Aggiunta di type hints specifici e gestione corretta dei tipi
```php
// Corretto: Type hints appropriati
if (is_array($value)) {
    /** @var array<string, mixed> $value */
    $result = array_merge($result, $this->flattenArray($value, $newKey));
}
```

**Miglioramenti**:
- Aggiunti commenti PHPDoc per type casting
- Migliorata gestione degli array annidati
- Verifica aggiuntiva per array in `setNestedValue()`

### FindMissingTranslations Command

**Problema**: Type hints inadeguati per array mixed
```php
// ERRORE: Parameter expects array<string, mixed>, array<mixed, mixed> given
protected function checkArrayForMissing(array $array, string $namespace, string $file, string $parentKey = ''): array
```

**Soluzione**: Aggiunta di type hints specifici
```php
// Corretto: Type hints appropriati
if (is_array($value)) {
    /** @var array<string, mixed> $value */
    $missing = array_merge(
        $missing,
        $this->checkArrayForMissing($value, $namespace, $file, $currentKey)
    );
}
```

## Principi Applicati

### Type Safety
- Uso di `declare(strict_types=1);` in tutti i file
- Type hints espliciti per tutti i parametri e return types
- Gestione corretta dei tipi `mixed` con type casting appropriato

### Best Practices PHPStan
- Evitare accesso statico a proprietà di istanza
- Utilizzare type hints specifici invece di `mixed` quando possibile
- Aggiungere commenti PHPDoc per type casting quando necessario

### Gestione Array
- Type hints specifici per array associativi
- Commenti PHPDoc per type casting quando necessario
- Validazione delle chiavi come stringhe
- Gestione sicura degli array annidati

## Collegamenti Correlati

- [Console Commands](./console-commands.md)
- [Translation System](./translation-system.md)
- [FormBuilder Module PHPStan Corrections](../formbuilder/docs/phpstan-corrections.md)

## Note per Sviluppo Futuro

1. **Type Hints**: Utilizzare sempre type hints espliciti
2. **Mixed Types**: Gestire sempre i tipi `mixed` con type casting
3. **Assertions**: Validare i tipi con assertions appropriate
4. **Documentation**: Documentare sempre i parametri e return types
