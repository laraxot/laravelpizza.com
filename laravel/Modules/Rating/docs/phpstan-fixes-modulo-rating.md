# PHPStan Fixes - Modulo Rating

**Data**: 2026-01-27  
**Modulo**: Rating  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## Correzioni Applicate

### 1. Conversione `$casts` in `casts()` (Laravel 12+)

**File**: `app/Models/Rating.php`

**Prima**:
```php
public $casts = [
    'extra_attributes' => SchemalessAttributes::class,
    'rule' => RuleEnum::class,
    'is_disabled' => 'boolean',
    'is_readonly' => 'boolean',
];
```

**Dopo**:
```php
/**
 * Get the attributes that should be cast.
 *
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'extra_attributes' => SchemalessAttributes::class,
        'rule' => RuleEnum::class,
        'is_disabled' => 'boolean',
        'is_readonly' => 'boolean',
    ];
}
```

**Motivazione**: `protected $casts` è deprecato in Laravel 12+. Il metodo `casts()` è obbligatorio.

### 2. Sostituzione `property_exists()` con `isset()`

**File**: `app/Models/Rating.php` (metodo `scopeWithExtraAttributes`)

**Prima**:
```php
if (property_exists($this, 'extra_attributes') && is_object($this->extra_attributes) && method_exists($this->extra_attributes, 'modelScope')) {
```

**Dopo**:
```php
// ✅ isset() invece di property_exists() - funziona per magic attributes (SchemalessAttributes cast)
if (isset($this->extra_attributes) && is_object($this->extra_attributes) && method_exists($this->extra_attributes, 'modelScope')) {
```

**Motivazione**: `property_exists()` non funziona con magic attributes Eloquent. `extra_attributes` è un cast di `SchemalessAttributes`, quindi è una magic property accessibile via `__get()`.

### 3. Correzione Errore Sintassi `.php_cs.dist.php`

**File**: `.php_cs.dist.php`

**Prima**:
```php
'method_argument_space' => [
    'on_multiline' => 'ensure_fully_multiline',
    'keep_multiple_spaces_after_comma' => true,
],
,  // ❌ Virgola extra
'braces' => [
```

**Dopo**:
```php
'method_argument_space' => [
    'on_multiline' => 'ensure_fully_multiline',
    'keep_multiple_spaces_after_comma' => true,
],
'braces' => [
```

**Motivazione**: Errore di sintassi che causava crash di PHPStan.

---

## Verifica Finale

```bash
./vendor/bin/phpstan analyse Modules/Rating --level=10
# [OK] No errors
```

---

## Riferimenti

- [Regole Model Casting](../../Xot/docs/model-casting-rules.md)
- [Property Exists vs Isset](../../Xot/docs/phpstan-code-quality-guide.md#5-property-access-su-mixed-eloquent---regola-critica)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)

*Ultimo aggiornamento: gennaio 2026*
