# Uso delle Azioni di Cast Xot

## Descrizione
Questo documento descrive l'uso delle azioni di casting pre-esistenti per risolvere problemi PHPStan e garantire type safety nel progetto.

## Azioni Disponibili

### SafeStringCastAction
**Posizione**: `laravel/Modules/Xot/app/Actions/Cast/SafeStringCastAction.php`

**Scopo**: Conversione sicura di valori mixed in string

**Uso**:
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Metodo statico
$name = SafeStringCastAction::cast($mixedValue);

// Metodo di istanza
$action = app(SafeStringCastAction::class);
$name = $action->execute($mixedValue);
```

**Casi d'uso**: Risoluzione errori `encapsedStringPart.nonString`, `binaryOp.invalid`

### SafeIntCastAction
**Posizione**: `laravel/Modules/Xot/app/Actions/Cast/SafeIntCastAction.php`

**Scopo**: Conversione sicura di valori mixed in int

**Uso**:
```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// Metodo statico base
$duration = SafeIntCastAction::cast($mixedValue);

// Con valore di default
$duration = SafeIntCastAction::cast($mixedValue, 30);

// Con validazione di range
$duration = SafeIntCastAction::castWithRange($mixedValue, 15, 120);

// Come ID positivo
$id = SafeIntCastAction::castAsId($mixedValue);
```

**Casi d'uso**: Risoluzione errori `argument.type` per parametri int, cast di durate, ID

### SafeFloatCastAction
**Posizione**: `laravel/Modules/Xot/app/Actions/Cast/SafeFloatCastAction.php`

**Scopo**: Conversione sicura di valori mixed in float

**Uso**:
```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

// Metodo statico base
$price = SafeFloatCastAction::cast($mixedValue);

// Con validazione di range
$percentage = SafeFloatCastAction::castWithRange($mixedValue, 0.0, 100.0);

// Con precisione specifica
$price = SafeFloatCastAction::castWithPrecision($mixedValue, 2);

// Come percentuale
$percentage = SafeFloatCastAction::castAsPercentage($mixedValue);

// Come importo monetario
$amount = SafeFloatCastAction::castAsCurrency($mixedValue);
```

**Casi d'uso**: Risoluzione errori `argument.type` per parametri float, importi monetari

## Regole di Utilizzo

### Regola Assoluta
- **MAI** usare cast manuali come `(string)`, `(int)`, `(float)` quando si lavora con valori mixed
- **SEMPRE** utilizzare le azioni Xot per garantire type safety e consistenza
- **SEMPRE** documentare l'uso delle azioni di casting nelle correzioni PHPStan

### Pattern di Correzione Standard
1. Identificare l'errore PHPStan di cast
2. Importare l'azione di casting appropriata
3. Sostituire il cast manuale con la chiamata all'azione
4. Documentare la correzione
5. Verificare che PHPStan non segnali più errori

## Esempi di Applicazione

### Correzione Errori String
```php
// Prima (ERRATO)
$name = (string) $mixedValue;
$description = $mixedValue . ' description';

// Dopo (CORRETTO)
use Modules\Xot\Actions\Cast\SafeStringCastAction;

$name = SafeStringCastAction::cast($mixedValue);
$description = SafeStringCastAction::cast($mixedValue) . ' description';
```

### Correzione Errori Int
```php
// Prima (ERRATO)
$duration = (int) $mixedValue;
$userId = (int) $mixedValue;

// Dopo (CORRETTO)
use Modules\Xot\Actions\Cast\SafeIntCastAction;

$duration = SafeIntCastAction::cast($mixedValue);
$userId = SafeIntCastAction::castAsId($mixedValue);
```

### Correzione Errori Float
```php
// Prima (ERRATO)
$price = (float) $mixedValue;
$percentage = (float) $mixedValue;

// Dopo (CORRETTO)
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

$price = SafeFloatCastAction::castAsCurrency($mixedValue);
$percentage = SafeFloatCastAction::castAsPercentage($mixedValue);
```

## Vantaggi dell'Uso delle Azioni Xot

1. **Type Safety**: Gestione sicura di tutti i tipi di dati
2. **Consistenza**: Comportamento uniforme in tutto il codebase
3. **Manutenibilità**: Logica centralizzata e facilmente aggiornabile
4. **Robustezza**: Gestione di tutti i casi edge e valori problematici
5. **PHPStan Compliance**: Risoluzione automatica di errori di analisi statica

## Collegamenti
- [Regole Cursor: Casting Actions](.cursor/rules/casting-actions-rule.mdc)
- [Memorie: Casting Actions](.cursor/memories/casting-actions.mdc)
- [Azioni Cast Xot](../../laravel/Modules/Xot/app/Actions/Cast/)

---
Ultimo aggiornamento: 2025-01-06
