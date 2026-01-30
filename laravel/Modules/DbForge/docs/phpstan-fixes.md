# PHPStan Errori Modulo DbForge - 2025-01-22

## Analisi Completa

**Data Analisi**: 2025-01-22  
**PHPStan Level**: 10  
**Modulo**: DbForge  
**Errori Trovati**: 3  
**Errori Corretti**: 3 ✅

---

## Errori Identificati e Corretti

### 1. GenerateModelsFromSchemaCommand.php - Offset access

**File**: `app/Console/Commands/GenerateModelsFromSchemaCommand.php`  
**Linea**: 237

**Errore**: `Offset 1 might not exist on array<string>|null.`

**Causa**: `preg_match()` può ritornare `array<string>|null`, e `$matches[1]` potrebbe non esistere.

**Correzione Applicata**:
```php
// Prima
if (preg_match('/^(.+)_id$/', $fk['column'], $matches)) {
    $methodName = Str::camel($matches[1]);
}

// Dopo
if (preg_match('/^(.+)_id$/', $fk['column'], $matches) && isset($matches[1])) {
    $methodName = Str::camel($matches[1]);
}
```

### 2-3. GenerateModelsFromSchemaCommand.php - Encapsed string (2 occorrenze)

**File**: `app/Console/Commands/GenerateModelsFromSchemaCommand.php`  
**Linee**: 309, 311

**Errore**: `Part $fillableStr (array<string>|string) of encapsed string cannot be cast to string.`

**Causa**: `preg_replace()` può ritornare `array<string>|string`, ma `var_export()` con `true` ritorna sempre `string`. PHPStan non lo riconosce automaticamente.

**Correzione Applicata**:
```php
// Prima
$fillableStr = (string) preg_replace('/^/m', '        ', var_export($fillable, true));
$castsStr = (string) preg_replace('/^/m', '        ', var_export($casts, true));

// Dopo
// var_export con return=true ritorna sempre string
/** @var string $fillableExport */
$fillableExport = var_export($fillable, true);
$fillableStrRaw = preg_replace('/^/m', '        ', $fillableExport);
Assert::string($fillableStrRaw, 'Failed to format fillable array');
/** @var string $fillableStr */
$fillableStr = $fillableStrRaw;

// var_export con return=true ritorna sempre string
/** @var string $castsExport */
$castsExport = var_export($casts, true);
$castsStrRaw = preg_replace('/^/m', '        ', $castsExport);
Assert::string($castsStrRaw, 'Failed to format casts array');
/** @var string $castsStr */
$castsStr = $castsStrRaw;
```

---

## Stato Correzioni

✅ **TUTTI GLI ERRORI CORRETTI** - 2025-01-22

- ✅ GenerateModelsFromSchemaCommand.php - Aggiunto controllo isset($matches[1])
- ✅ GenerateModelsFromSchemaCommand.php - Aggiunto PHPDoc e Assert::string() per var_export

**Risultato Finale**: 0 errori PHPStan livello 10 ✅

---

## Pattern Applicato

1. **Offset Access**: Sempre verificare `isset($matches[1])` dopo `preg_match()`
2. **var_export()**: Annotare esplicitamente con PHPDoc `@var string` perché PHPStan non riconosce automaticamente che `var_export($data, true)` ritorna sempre `string`

---

## Collegamenti

- [PHPStan Usage](../../Xot/docs/phpstan-usage.md)
- [Code Quality Standards](../../Xot/docs/code-quality-standards.md)

*Ultimo aggiornamento: 2025-01-22*

