# PHPStan Syntax Fixes - Modulo Job

**Versione PHPStan**: 1.12.x
**Livello**: max
**Status**: ✅ IMPORT CONFLICT RISOLTO

## 🔧 Correzione Implementata

### GetTaskFrequenciesActionTest.php - Function Import Conflict

**Problema**:
```
Cannot use function Safe\class_uses as class_uses because the name is already in use
```

**Causa**: Conflitto tra import esplicito di `Safe\class_uses` e funzione `class_uses()` già disponibile globalmente nel contesto Pest.

**Impatto**:
- ❌ Syntax error bloccante
- ❌ PHPStan non poteva analizzare il file
- ❌ Conflitto di naming nel namespace globale

## 💡 Soluzione Implementata

### Prima della Correzione

```php
<?php

declare(strict_types=1);

use Modules\Job\Actions\GetTaskFrequenciesAction;

use function Safe\class_uses;           // ❌ Conflict!
use function Safe\file_get_contents;

describe('GetTaskFrequenciesAction', function (): void {
    it('has queueable action trait', function (): void {
        $action = new GetTaskFrequenciesAction();
        $traits = class_uses($action);  // Usa l'import

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });
});
```

### Dopo la Correzione

```php
<?php

declare(strict_types=1);

use Modules\Job\Actions\GetTaskFrequenciesAction;

use function Safe\file_get_contents;    // ✅ Solo quello necessario

describe('GetTaskFrequenciesAction', function (): void {
    it('has queueable action trait', function (): void {
        $action = new GetTaskFrequenciesAction();
        $traits = \Safe\class_uses($action);  // ✅ Fully qualified name

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });
});
```

**File Modificato**: `Modules/Job/tests/Unit/GetTaskFrequenciesActionTest.php`

## 📋 Strategie di Risoluzione Conflict

### Strategia 1: Fully Qualified Name (Scelta Implementata)

```php
// ✅ SOLUZIONE APPLICATA
// Non importare, usare FQN nel codice
$traits = \Safe\class_uses($object);
```

**Vantaggi**:
- ✅ Nessun conflict
- ✅ Esplicito sulla provenienza
- ✅ Funziona sempre

### Strategia 2: Alias (Alternativa)

```php
// ✅ ALTERNATIVA VALIDA
use function Safe\class_uses as safe_class_uses;

$traits = safe_class_uses($object);
```

**Vantaggi**:
- ✅ Nessun conflict
- ✅ Import esplicito
- ❌ Nome più verboso

### Strategia 3: Rimuovere Import (Non Raccomandata)

```php
// ⚠️ POSSIBILE MA NON IDEALE
// Usare la funzione global (unsafe)
$traits = class_uses($object);  // Potrebbe ritornare false!
```

**Svantaggi**:
- ❌ Non type-safe
- ❌ Può ritornare `false` invece di exception
- ❌ PHPStan warning

## ✅ Risultato

### Prima
- **Syntax Error**: Sì ❌
- **Import Conflicts**: 1 ❌
- **PHPStan Analysis**: Bloccata ❌

### Dopo
- **Syntax Error**: No ✅
- **Import Conflicts**: 0 ✅
- **PHPStan Analysis**: Completata ✅

## 🎯 Best Practices

### Quando Usare Fully Qualified Names

```php
// ✅ Usa FQN quando c'è potenziale conflict
$data = \Safe\json_decode($string);
$traits = \Safe\class_uses($object);

// ✅ Import quando non c'è conflict
use function Safe\file_get_contents;
$content = file_get_contents($path);
```

### Import Conflicts in Pest Tests

Pest tests hanno molte funzioni helper globali che possono confliggere:

- `class_uses()` - Già disponibile
- `method_exists()` - Già disponibile
- `trait_exists()` - Già disponibile

**Soluzione**: Usa FQN per Safe variants di queste funzioni.

## 📊 Impatto della Correzione

| Aspetto | Prima | Dopo |
|---------|-------|------|
| Syntax Errors | 1 | 0 ✅ |
| Import Conflicts | 1 | 0 ✅ |
| Type Safety | Partial | Full ✅ |
| PHPStan Blocking | Sì | No ✅ |

## 🔗 Collegamenti

- [Analisi Generale PHPStan](../../../../docs/project/quality/phpstan-analysis.md)
- [Safe Functions Documentation](https://github.com/thecodingmachine/safe)
- [Pest Testing Framework](https://pestphp.com/)

## 📝 Note Tecniche

### Perché il Conflict?

1. **Pest Global Functions**: Pest registra molte funzioni helper nel namespace globale
2. **PHP Function Lookup**: PHP cerca prima nel namespace locale, poi nel globale
3. **Safe Functions**: Sono wrapper che lanciano exceptions invece di ritornare `false`

### Safe vs Unsafe Functions

```php
// ❌ Unsafe - Può ritornare false
$traits = class_uses($object);
if ($traits === false) {
    // Error handling required
}

// ✅ Safe - Lancia exception
$traits = \Safe\class_uses($object);
// Se fallisce, lancia exception automaticamente
```

## ⚠️ Linee Guida per Import

### DO ✅

```php
// Import solo quando non c'è conflict
use function Safe\file_get_contents;
use function Safe\json_decode;

// FQN quando c'è potential conflict
$traits = \Safe\class_uses($obj);
```

### DON'T ❌

```php
// Non importare se causa conflict
use function Safe\class_uses;  // ❌ Conflict con Pest!

// Non usare unsafe functions senza error handling
$traits = class_uses($obj);    // ❌ Può ritornare false!
```

## 🎓 Lezioni Apprese

1. **Context Matters**: In Pest tests, essere consapevoli delle funzioni globali disponibili
2. **FQN is OK**: Usare fully qualified names è perfettamente accettabile
3. **Safe by Default**: Preferire sempre Safe functions per migliore type safety
4. **Explicit > Implicit**: FQN rende esplicita la provenienza della funzione

---

**Fix Completato**: [DATE]
**Priority**: ALTA
**Impact**: BASSO (Solo 1 test file)
**Type Safety**: MIGLIORATA ✅
