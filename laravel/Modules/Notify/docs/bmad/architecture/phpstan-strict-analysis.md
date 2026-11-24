---
title: "PHPStan STRICT Analysis - Tutti gli Errori"
type: concept
tags: [phpstan, strict, analysis, 2025]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan-strict-analysis-2025-10-10.deprecated phpstan strict analysis - tutti gli errori"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-1.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-100.md"
  - "./acronym-naming-conventions-1.md"
  - "./acronym-naming-conventions-2.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# PHPStan STRICT Analysis - Tutti gli Errori

**Data**: 2025-10-10T09:34:25+02:00  
**Configurazione**: phpstan-strict.neon (NO ignore, test inclusi)  
**Livello**: MAX (9)  
**Totale Errori**: **22,522**

## 📊 Distribuzione Errori per Tipo

| # | Tipo Errore | Quantità | % | Priorità | Tempo Stima |
|---|-------------|----------|---|----------|-------------|
| 1 | method.internalClass | 4,929 | 21.9% | 🟡 MEDIA | 10 min |
| 2 | method.nonObject | 4,843 | 21.5% | 🔴 ALTA | 3 ore |
| 3 | property.nonObject | 3,124 | 13.9% | 🔴 ALTA | 2 ore |
| 4 | property.notFound | 2,397 | 10.6% | 🔴 ALTA | 2 ore |
| 5 | missingType.iterableValue | 1,185 | 5.3% | 🟢 BASSA | 1 ora |
| 6 | offsetAccess.nonOffsetAccessible | 1,005 | 4.5% | 🔴 ALTA | 1.5 ore |
| 7 | missingType.generics | 755 | 3.4% | 🟢 BASSA | 30 min |
| 8 | argument.type | 731 | 3.2% | 🔴 ALTA | 1 ora |
| 9 | method.notFound | 635 | 2.8% | 🔴 ALTA | 1 ora |
| 10 | theCodingMachineSafe.function | 407 | 1.8% | 🟡 MEDIA | 30 min |
| 11 | class.notFound | 399 | 1.8% | 🔴 CRITICA | 1 ora |
| 12 | argument.templateType | 333 | 1.5% | 🟡 MEDIA | 45 min |
| 13 | larastan.noEnvCallsOutsideOfConfig | 227 | 1.0% | 🟢 BASSA | 20 min |
| 14 | cast.string | 174 | 0.8% | 🟡 MEDIA | 30 min |
| 15 | staticMethod.notFound | 156 | 0.7% | 🔴 ALTA | 30 min |
| 16 | binaryOp.invalid | 134 | 0.6% | 🟡 MEDIA | 30 min |
| 17 | missingType.return | 118 | 0.5% | 🟢 BASSA | 20 min |
| 18 | array.invalidKey | 92 | 0.4% | 🟡 MEDIA | 20 min |
| 19 | function.alreadyNarrowedType | 76 | 0.3% | 🟢 BASSA | 15 min |
| 20 | new.abstract | 73 | 0.3% | 🔴 ALTA | 20 min |
| - | Altri (50+ tipi) | ~1,729 | 7.7% | VARIA | 2 ore |

**TOTALE**: 22,522 errori | **Tempo Stimato Totale**: ~18-20 ore

## 🎯 Strategia di Correzione

### Fase 1: Quick Wins (2 ore) - Riduzione ~30%

#### 1.1 Pest Extension (10 min) - 4,929 errori
**Problema**: Errori `method.internalClass` per chiamate Pest legittime.

**Soluzione**: Aggiungere Pest extension a phpstan.neon
```neon
includes:
    - ./vendor/pestphp/pest/extension.neon
```

**Impatto**: -4,929 errori (21.9%)  
**Risultato atteso**: 17,593 errori

#### 1.2 Missing Type Annotations (1.5 ore) - 2,058 errori
**Problema**: `missingType.iterableValue` (1,185) + `missingType.generics` (755) + `missingType.return` (118)

**Soluzione**: Aggiungere PHPDoc type hints
```php
// Prima
public function items()
{
    return $this->hasMany(Item::class);
}

// Dopo
/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<Item>
 */
public function items(): HasMany
{
    return $this->hasMany(Item::class);
}
```

**Impatto**: -2,058 errori (9.1%)  
**Risultato atteso**: 15,535 errori

#### 1.3 Safe Functions (30 min) - 407 errori
**Problema**: `theCodingMachineSafe.function` - Uso di funzioni Safe senza gestione eccezioni.

**Soluzione**: Gestire eccezioni o usare funzioni standard
```php
// Prima
use function Safe\file_get_contents;
$content = file_get_contents($file); // Può lanciare eccezione

// Dopo - Opzione 1: Gestire eccezione
try {
    $content = Safe\file_get_contents($file);
} catch (\Safe\Exceptions\FilesystemException $e) {
    // Handle
}

// Dopo - Opzione 2: Usare funzione standard con check
$content = file_get_contents($file);
if ($content === false) {
    throw new \RuntimeException("Cannot read file");
}
```

**Impatto**: -407 errori (1.8%)  
**Risultato atteso**: 15,128 errori

### Fase 2: Type Safety (8 ore) - Riduzione ~50%

#### 2.1 Null Safety (3 ore) - 7,967 errori
**Problema**: `method.nonObject` (4,843) + `property.nonObject` (3,124)

**Soluzione**: Usare null-safe operator e type guards
```php
// Prima
$user->profile->address; // Error: profile può essere null

// Dopo - Opzione 1: Null-safe operator
$user->profile?->address;

// Dopo - Opzione 2: Type guard
if ($user->profile !== null) {
    $address = $user->profile->address;
}

// Dopo - Opzione 3: Assert
assert($user->profile !== null);
$address = $user->profile->address;
```

**Impatto**: -7,967 errori (35.4%)  
**Risultato atteso**: 7,161 errori

#### 2.2 Property Access (2 ore) - 2,397 errori
**Problema**: `property.notFound` - Accesso a proprietà non definite

**Soluzione**: Definire proprietà o usare PHPDoc
```php
// Prima
class Model {
    // $name non definito
}
$model->name; // Error

// Dopo - Opzione 1: Definire proprietà
class Model {
    public string $name = '';
}

// Dopo - Opzione 2: PHPDoc
/**
 * @property string $name
 */
class Model {
    // Dynamic property
}
```

**Impatto**: -2,397 errori (10.6%)  
**Risultato atteso**: 4,764 errori

#### 2.3 Array Access (1.5 ore) - 1,005 errori
**Problema**: `offsetAccess.nonOffsetAccessible` - Accesso array su non-array

**Soluzione**: Type guards e assertions
```php
// Prima
$data['key']; // Error: $data è mixed

// Dopo
assert(is_array($data));
$value = $data['key'];

// Oppure
if (is_array($data) && isset($data['key'])) {
    $value = $data['key'];
}
```

**Impatto**: -1,005 errori (4.5%)  
**Risultato atteso**: 3,759 errori

#### 2.4 Method Calls (1.5 ore) - 1,366 errori
**Problema**: `method.notFound` (635) + `argument.type` (731)

**Soluzione**: Verificare metodi esistenti e correggere tipi argomenti
```php
// Prima
$model->nonExistentMethod(); // Error

// Dopo
$model->existingMethod();

// Prima
$model->method('string'); // Error: expects int

// Dopo
$model->method(123);
```

**Impatto**: -1,366 errori (6.1%)  
**Risultato atteso**: 2,393 errori

### Fase 3: Refactoring (6 ore) - Riduzione ~90%

#### 3.1 Class Dependencies (1 ora) - 399 errori
**Problema**: `class.notFound` - Classi non trovate

**Soluzione**: Installare dipendenze o creare stub
```php
// Prima
use NonExistent\Class; // Error

// Dopo - Opzione 1: Installare package
composer require vendor/package

// Dopo - Opzione 2: Creare stub in phpstan_stubs.php
namespace NonExistent {
    class Class {}
}
```

**Impatto**: -399 errori (1.8%)  
**Risultato atteso**: 1,994 errori

#### 3.2 Template Types (45 min) - 333 errori
**Problema**: `argument.templateType` - Tipi generici non corrispondenti

**Soluzione**: Correggere type hints generici
```php
// Prima
/** @return Collection */
public function items(): Collection // Error: missing generic

// Dopo
/** @return Collection<int, Item> */
public function items(): Collection
```

**Impatto**: -333 errori (1.5%)  
**Risultato atteso**: 1,661 errori

#### 3.3 Environment Calls (20 min) - 227 errori
**Problema**: `larastan.noEnvCallsOutsideOfConfig` - env() fuori da config

**Soluzione**: Usare config() invece di env()
```php
// Prima
$value = env('APP_KEY'); // Error: env() fuori da config/

// Dopo
$value = config('app.key');
```

**Impatto**: -227 errori (1.0%)  
**Risultato atteso**: 1,434 errori

#### 3.4 Altri Errori (4 ore) - ~1,434 errori
- Cast types (174)
- Static methods (156)
- Binary operations (134)
- Array keys (92)
- Abstract instantiation (73)
- Altri vari (~805)

**Impatto**: -1,434 errori (6.4%)  
**Risultato atteso**: **0 errori**

### Fase 4: Validazione (2 ore)

1. **Test Suite Completa** (1 ora)
   - Eseguire tutti i test Pest
   - Verificare nessuna regressione
   - Coverage > 80%

2. **PHPStan Finale** (30 min)
   - Analisi completa livello MAX
   - Verificare 0 errori
   - Generare report finale

3. **Documentazione** (30 min)
   - Aggiornare best practices
   - Documentare pattern usati
   - Creare guida manutenzione

## 📋 Piano di Implementazione

### Giorno 1 (8 ore)
- ✅ Analisi completa (fatto)
- [ ] Fase 1: Quick Wins (2 ore) → 15,128 errori
- [ ] Fase 2.1: Null Safety (3 ore) → 7,161 errori
- [ ] Fase 2.2: Property Access (2 ore) → 4,764 errori
- [ ] Review e commit

### Giorno 2 (8 ore)
- [ ] Fase 2.3: Array Access (1.5 ore) → 3,759 errori
- [ ] Fase 2.4: Method Calls (1.5 ore) → 2,393 errori
- [ ] Fase 3.1: Class Dependencies (1 ora) → 1,994 errori
- [ ] Fase 3.2: Template Types (45 min) → 1,661 errori
- [ ] Fase 3.3: Environment Calls (20 min) → 1,434 errori
- [ ] Fase 3.4: Altri Errori (3 ore) → 0 errori
- [ ] Review e commit

### Giorno 3 (4 ore)
- [ ] Fase 4: Validazione (2 ore)
- [ ] Fix eventuali regressioni (1 ora)
- [ ] Documentazione finale (1 ora)
- [ ] **OBIETTIVO: 0 ERRORI PHPSTAN MAX**

## 🎯 Metriche di Successo

| Checkpoint | Errori | Riduzione | Tempo Cumulativo |
|------------|--------|-----------|------------------|
| Inizio | 22,522 | 0% | 0h |
| Dopo Fase 1 | 15,128 | 32.8% | 2h |
| Dopo Fase 2 | 2,393 | 89.4% | 10h |
| Dopo Fase 3 | 0 | 100% | 16h |
| Dopo Validazione | 0 | 100% | 18h |

## 🚀 Prossimi Passi IMMEDIATI

1. **Aggiungere Pest extension** (5 min)
2. **Iniziare correzioni Fase 1.2** (Missing Types)
3. **Procedere sistematicamente** seguendo il piano

---

**Creato**: 2025-10-10T09:34:25+02:00  
**Status**: 📋 PIANO PRONTO  
**Obiettivo**: 0 errori in ~18-20 ore di lavoro
