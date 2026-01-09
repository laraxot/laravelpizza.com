# PHPStan Errori Modulo Notify - 2025-01-22

## Analisi Completa

**Data Analisi**: 2025-01-22
**PHPStan Level**: 10
**Modulo**: Notify
**Errori Trovati**: 2
**Errori Corretti**: 2 ✅

---

## Errori Identificati e Corretti

### 1. NormalizePhoneNumberAction.php - ltrim con tipo errato

**File**: `app/Actions/SMS/NormalizePhoneNumberAction.php`
**Linea**: 24

**Errore**: `Parameter #1 $string of function ltrim expects string, array<string>|string given.`

**Causa**: `preg_replace()` può ritornare `array<string>|string`, ma `ltrim()` si aspetta solo `string`.

**Correzione Applicata**:
```php
// Prima
$phoneNumber = preg_replace("/\([0-9]+?\)/", '', $phoneNumber);
$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
$phoneNumber = ltrim($phoneNumber, '0');

// Dopo
$phoneNumber = preg_replace("/\([0-9]+?\)/", '', $phoneNumber);
Assert::string($phoneNumber, 'Failed to remove parentheses from phone number');

$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
Assert::string($phoneNumber, 'Failed to remove non-numeric characters from phone number');

$phoneNumber = ltrim($phoneNumber, '0');
```

### 2. WhatsAppActionFactory.php - encapsed string con tipo errato

**File**: `app/Factories/WhatsAppActionFactory.php`
**Linea**: 46

**Errore**: `Part $normalizedDriver (array<string>|string) of encapsed string cannot be cast to string.`

**Causa**: `preg_replace()` può ritornare `array<string>|string`, ma viene usato in una stringa encapsed.

**Correzione Applicata**:
```php
// Prima
$normalizedDriver = preg_replace('/[^a-zA-Z0-9]/', '', ucfirst(strtolower(is_string($driver) ? $driver : '')));
$className = "\\Modules\\Notify\\Actions\\WhatsApp\\Send{$normalizedDriver}WhatsAppAction";

// Dopo
$driver ??= Config::get('whatsapp.default', 'twilio');
Assert::string($driver, 'Driver must be a string');

$normalizedDriver = preg_replace('/[^a-zA-Z0-9]/', '', ucfirst(strtolower($driver)));
Assert::string($normalizedDriver, 'Failed to normalize driver name');

$className = "\\Modules\\Notify\\Actions\\WhatsApp\\Send{$normalizedDriver}WhatsAppAction";
```

Inoltre rimosso controllo `is_string()` ridondante dopo `Assert::string()`.

---

## Stato Correzioni

✅ **TUTTI GLI ERRORI CORRETTI** - 2025-01-22

- ✅ NormalizePhoneNumberAction.php - Aggiunto Assert::string() per type narrowing
- ✅ WhatsAppActionFactory.php - Aggiunto Assert::string() e rimosso controllo ridondante

**Risultato Finale**: 0 errori PHPStan livello 10 ✅

---

## Pattern Applicato

Stesso pattern di Chart: usare `Assert::string()` per type narrowing dopo `preg_replace()`.

---

## Collegamenti

- [PHPStan Usage](../../Xot/docs/phpstan-usage.md)
- [Code Quality Standards](../../Xot/docs/code-quality-standards.md)

*Ultimo aggiornamento: 2025-01-22*
# PHPStan Level 10 Fixes - Session 2026-01-05

## Module: Notify (2 errors)

### Priority: MEDIUM - Notification system

## Error 1: NormalizePhoneNumberAction.php:24

**Error:** Parameter #1 $string of function ltrim expects string, array<string>|string given.

**Location:** `app/Actions/SMS/NormalizePhoneNumberAction.php:24`

**Analysis:**
The `ltrim()` function receives a variable that can be either `string` or `array<string>`, but `ltrim()` only accepts `string`.

**Root Cause:** The input parameter is typed as `array<string>|string` (likely from a config or validation that allows both), but `ltrim()` requires a string.

**Solution:** Add type narrowing to ensure we only pass strings to `ltrim()`:

```php
// Before
$normalized = ltrim($phoneNumber, '+');

// After
if (is_string($phoneNumber)) {
    $normalized = ltrim($phoneNumber, '+');
} else {
    // Handle array case - concatenate or take first element
    $normalized = ltrim(implode('', $phoneNumber), '+');
}

// Or simpler - cast to string first
$normalized = ltrim((string) $phoneNumber, '+');
```

**Recommended approach:** Use Safe function wrapper:

```php
use function Safe\ltrim;

$normalized = ltrim((string) $phoneNumber, '+');
```

---

## Error 2: WhatsAppActionFactory.php:46

**Error:** Part $normalizedDriver (array<string>|string) of encapsed string cannot be cast to string.

**Location:** `app/Factories/WhatsAppActionFactory.php:46`

**Analysis:**
The code tries to use a variable in a string interpolation, but the variable can be either `string` or `array<string>`, which can't be directly cast to string in interpolation.

**Root Cause:** Similar to Error 1 - the driver name can be an array or string.

**Solution:** Cast to string before interpolation:

```php
// Before
$message = "Using driver: {$normalizedDriver}";

// After
$message = "Using driver: " . (string) $normalizedDriver;

// Or ensure it's always a string
$driverString = is_array($normalizedDriver) ? implode('|', $normalizedDriver) : $normalizedDriver;
$message = "Using driver: {$driverString}";
```

---

## Implementation Strategy

### Phase 1: Fix NormalizePhoneNumberAction
1. Read the file to understand the context
2. Add type narrowing for the input parameter
3. Use Safe function wrapper or explicit cast
4. Test with both string and array inputs

### Phase 2: Fix WhatsAppActionFactory
1. Read the file to understand the context
2. Cast driver to string before interpolation
3. Handle array case appropriately (implode or take first)
4. Test with different driver configurations

## Testing Checklist

- [ ] Run PHPStan Level 10 on Notify module - expect 0 errors
- [ ] Run PHPMD on Notify module
- [ ] Run PHPInsights on Notify module
- [ ] Test SMS normalization with various formats
- [ ] Test WhatsApp action factory with different drivers
- [ ] Git commit changes

## Related Documentation

- [Safe Functions Guide](../Xot/docs/safe-functions.md)
- [Type Narrowing Patterns](../Xot/docs/type-narrowing.md)
- [SMS Configuration](./sms_global_vs_specific_params.md)
