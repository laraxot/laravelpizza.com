# PHPStan Mixed Type Casting Errors

## Problema

PHPStan segnala errori quando si tenta di fare cast non sicuri da `mixed` a tipi specifici:

```
Cannot cast mixed to int.
Cannot cast mixed to string.
```

## Causa Root

1. **Variabili Mixed**: Valori provenienti da fonti esterne (array, JSON, database) senza tipizzazione
2. **Cast Diretti**: Utilizzo di cast diretti `(int)`, `(string)` su valori mixed
3. **Mancanza di Validazione**: Assenza di controlli di tipo prima del casting

## Errori Specifici nel Modulo Lang

### SyncTranslationsAction.php

```php
// ❌ ERRORE - Cast diretto di mixed
$line = (int) $matches[1];     // Line 37
$column = (int) $matches[2];   // Line 38
$key = (string) $item;         // Line 242
```

## Soluzioni

### 1. Utilizzo di SafeCastActions

Utilizzare le azioni di casting sicuro già implementate:

```php
// ✅ CORRETTO - Utilizzo di SafeIntCastAction
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

$line = SafeIntCastAction::cast($matches[1], 0);
$column = SafeIntCastAction::cast($matches[2], 0);
```

### 2. Controlli di Tipo Espliciti

```php
// ✅ CORRETTO - Controllo di tipo prima del cast
if (is_numeric($matches[1])) {
    $line = (int) $matches[1];
} else {
    $line = 0; // valore di default
}
```

### 3. Utilizzo di Funzioni PHP Sicure

```php
// ✅ CORRETTO - Utilizzo di funzioni PHP sicure
$line = filter_var($matches[1], FILTER_VALIDATE_INT) ?: 0;
$key = filter_var($item, FILTER_SANITIZE_STRING) ?: '';
```

## Pattern di Correzione per SyncTranslationsAction

### Correzione Line 37-38

```php
// ❌ PRIMA
$line = (int) $matches[1];
$column = (int) $matches[2];

// ✅ DOPO
$line = SafeIntCastAction::cast($matches[1], 0);
$column = SafeIntCastAction::cast($matches[2], 0);
```

### Correzione Line 242

```php
// ❌ PRIMA
$key = (string) $item;

// ✅ DOPO
$key = is_string($item) ? $item : (string) $item;
// oppure
$key = SafeStringCastAction::cast($item, '');
```

## SafeStringCastAction Implementation

Se non esiste ancora, creare SafeStringCastAction:

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Cast;

use Spatie\QueueableAction\QueueableAction;

class SafeStringCastAction
{
    use QueueableAction;

    /**
     * Safely cast a mixed value to string.
     *
     * @param mixed $value
     * @param string $default
     * @return string
     */
    public static function cast(mixed $value, string $default = ''): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_null($value)) {
            return $default;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value) ?: $default;
        }

        return $default;
    }
}
```

## Best Practices

### 1. Sempre Validare Prima del Cast

```php
// ✅ CORRETTO
if (is_array($data) && isset($data['key'])) {
    $value = SafeIntCastAction::cast($data['key'], 0);
}
```

### 2. Utilizzare Valori di Default Appropriati

```php
// ✅ CORRETTO - Default significativi
$line = SafeIntCastAction::cast($matches[1], 1);    // Line numbers start from 1
$column = SafeIntCastAction::cast($matches[2], 1);  // Column numbers start from 1
$key = SafeStringCastAction::cast($item, 'unknown');
```

### 3. Documentare i Cast

```php
/**
 * Parse error line and column from regex matches.
 *
 * @param array<int, string> $matches
 * @return array{line: int, column: int}
 */
private function parseErrorLocation(array $matches): array
{
    return [
        'line' => SafeIntCastAction::cast($matches[1] ?? null, 1),
        'column' => SafeIntCastAction::cast($matches[2] ?? null, 1),
    ];
}
```

## Script di Correzione Automatica

```bash
#!/bin/bash

# Replace unsafe casts with safe cast actions

# Replace (int) casts
find Modules -name "*.php" -type f -exec sed -i 's/(int) \$\([a-zA-Z_][a-zA-Z0-9_]*\)/SafeIntCastAction::cast($\1, 0)/g' {} \;

# Replace (string) casts
find Modules -name "*.php" -type f -exec sed -i 's/(string) \$\([a-zA-Z_][a-zA-Z0-9_]*\)/SafeStringCastAction::cast($\1, '\'''\'')/g' {} \;

# Replace (float) casts
find Modules -name "*.php" -type f -exec sed -i 's/(float) \$\([a-zA-Z_][a-zA-Z0-9_]*\)/SafeFloatCastAction::cast($\1, 0.0)/g' {} \;
```

## Validazione

Dopo aver applicato le correzioni:

```bash
./vendor/bin/phpstan analyze Modules/Lang --level=9 --no-progress
```

## Note Tecniche

1. **Performance**: I safe cast hanno overhead minimo rispetto ai cast diretti
2. **Sicurezza**: Prevengono errori runtime e comportamenti inaspettati
3. **Manutenibilità**: Centralizzano la logica di casting in un punto
4. **Testabilità**: Più facili da testare rispetto ai cast inline

## Riferimenti

- [SafeFloatCastAction Documentation](../../Xot/docs/safe-casting-actions.md)
- [PHP Type Casting](https://www.php.net/manual/en/language.types.type-juggling.php)
- [PHPStan Mixed Type](https://phpstan.org/writing-php-code/phpdoc-types#mixed)

## Backlink

- [Root PHPStan Rules](../../../docs/phpstan_rules.md)
- [Lang Module Structure](./README.md)
- [Xot Safe Casting Actions](../../Xot/docs/safe-casting-actions.md)

*Ultimo aggiornamento: 2025-07-31*
