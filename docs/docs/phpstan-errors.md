# PHPStan Errori Modulo Xot - [DATE]

## Analisi Completa

**Data Analisi**: [DATE]
**PHPStan Level**: 10
**Modulo**: Xot (Base Framework)
**Errori Trovati**: 7

---

## Errori Identificati

### 1. ParsePrintPageStringAction.php - Offset Access e Type Mismatch

**File**: `app/Actions/ParsePrintPageStringAction.php`
**Linee**: 34-35

**Errori**:
- Line 34: `Offset 0 might not exist on array|null`
- Line 35: `Parameter #1 $value of function count expects array|Countable, mixed given`

**Causa**: `preg_match_all()` può ritornare `array|null`, e `$matches[0]` potrebbe non esistere. Inoltre `count()` riceve `mixed` invece di `array|Countable`.

**Correzione Proposta**:
```php
preg_match_all($pattern, $str, $matches);

// Verifica che $matches sia un array e che contenga almeno un elemento
if (!is_array($matches) || !isset($matches[0]) || empty($matches[0])) {
    throw new \InvalidArgumentException('No valid page numbers found');
}

$matchCount = count($matches[0]);
```

---

### 2. NormalizeDriverNameAction.php - Type Mismatch preg_replace

**File**: `app/Actions/String/NormalizeDriverNameAction.php`
**Linea**: 28

**Errore**: `Parameter #1 $string of function strtolower expects string, array<string>|string given`

**Causa**: `preg_replace()` può ritornare `array<string>|string`, ma `strtolower()` si aspetta solo `string`.

**Correzione Proposta**:
```php
$driver = preg_replace('/[^a-zA-Z0-9]/', '', $driver);
Assert::string($driver, 'Driver name must be a string after normalization');
return strtolower($driver);
```

---

### 3. OptimizeFilamentMemoryCommand.php - Offset Access

**File**: `app/Console/Commands/OptimizeFilamentMemoryCommand.php`
**Linea**: 140

**Errore**: `Offset 1 might not exist on array<string>|null`

**Causa**: `preg_match()` può ritornare `array<string>|null`, e `$matches[1]` potrebbe non esistere.

**Correzione Proposta**:
```php
if (preg_match('/protected\s+\$with\s*=\s*\[([^\]]+)\]/', $content, $matches)) {
    $withContent = $matches[1] ?? '';
    // ... resto del codice
}
```

---

### 4. XotBaseMorphPivot.php - Offset Access

**File**: `app/Models/XotBaseMorphPivot.php`
**Linea**: 94

**Errore**: `Offset 1 might not exist on array<string>|null`

**Causa**: `preg_match()` può ritornare `array<string>|null`, e `$matches[1]` potrebbe non esistere.

**Correzione Proposta**:
```php
if (preg_match('/Modules\\\\(\w+)\\\\/', $namespace, $matches) && isset($matches[1])) {
    return strtolower($matches[1]);
}
```

---

### 5. XotBasePivot.php - Offset Access

**File**: `app/Models/XotBasePivot.php`
**Linea**: 73

**Errore**: `Offset 1 might not exist on array<string>|null`

**Causa**: `preg_match()` può ritornare `array<string>|null`, e `$matches[1]` potrebbe non esistere.

**Correzione Proposta**:
```php
if (preg_match('/Modules\\\\(\w+)\\\\/', $namespace, $matches) && isset($matches[1])) {
    return strtolower($matches[1]);
}
```

---

### 6. ArtisanService.php - Offset Access

**File**: `app/Services/ArtisanService.php`
**Linea**: 152

**Errore**: `Offset 1 might not exist on array|null`

**Causa**: `preg_match_all()` può ritornare `array|null`, e `$matches[1]` potrebbe non esistere.

**Correzione Proposta**:
```php
preg_match_all($pattern, $content, $matches);

if (!is_array($matches) || !isset($matches[1])) {
    return [];
}

/** @var array<int, string> $urlsRaw */
$urlsRaw = $matches[1];
```

---

## Pattern Comune

Tutti gli errori seguono lo stesso pattern:
- **Mancanza di controlli di esistenza** per offset di array risultanti da `preg_match()` o `preg_match_all()`
- **Type narrowing mancante** per valori che possono essere `null` o `mixed`

## Strategia di Correzione

1. **Aggiungere controlli di esistenza** con `isset()` o `array_key_exists()`
2. **Usare type narrowing** con `Assert::string()`, `Assert::array()`, ecc.
3. **Gestire casi null** con valori di default appropriati
4. **Verificare con PHPStan** dopo ogni correzione

---

## Priorità

1. **Alta**: ParsePrintPageStringAction (usato per parsing pagine)
2. **Media**: NormalizeDriverNameAction (usato per normalizzazione driver)
3. **Bassa**: Modelli Pivot e Service (metodi helper interni)

---

## Stato Correzioni

✅ **TUTTI GLI ERRORI CORRETTI** - [DATE]

- ✅ ParsePrintPageStringAction.php - Aggiunti controlli esistenza array
- ✅ NormalizeDriverNameAction.php - Aggiunto Assert::string() per type narrowing
- ✅ OptimizeFilamentMemoryCommand.php - Aggiunto controllo isset($matches[1])
- ✅ XotBaseMorphPivot.php - Aggiunto controllo isset($matches[1])
- ✅ XotBasePivot.php - Aggiunto controllo isset($matches[1])
- ✅ ArtisanService.php - Corretto return type (array → Renderable)

**Risultato Finale**: 0 errori PHPStan livello 10 ✅

---

## Collegamenti

- [PHPStan Fixes Summary](../phpstan-fixes-summary_2.md)
- [Code Quality Standards](../code-quality-standards.md)
- [Best Practices](../best-practices.md)
