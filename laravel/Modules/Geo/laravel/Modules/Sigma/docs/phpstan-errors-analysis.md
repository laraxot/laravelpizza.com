# PHPStan Errors Analysis - Sigma Module

> **Data Analisi**: 2025-11-24
> **Livello PHPStan**: Level 10 (Maximum Strictness)
> **Totale Errori**: 459

## 📊 Sommario Errori per File

| File | Errori | Priorità | Complessità |
|------|--------|----------|-------------|
| `Traits/Extras/FunctionExtra.php` | ~228 | 🔴 Alta | 🟡 Media |
| `Traits/Extras/MassExtra.php` | ~200 | 🔴 Alta | 🔴 Alta |
| `Wstr01lx.php` | 1 | 🟢 Bassa | 🟢 Bassa |
| `Services/SigmaService.php` | 1 | 🟢 Bassa | 🟢 Bassa |

## 🎯 Categorizzazione Errori

### 1. Generics non completi per HasMany (🔴 Priorità Alta)

**Conteggio**: ~12 occorrenze
**Impact**: Basso (warning, non blocca esecuzione)
**Effort**: Basso (semplice annotazione)

#### Errore
```
Generic type Illuminate\Database\Eloquent\Relations\HasMany<Modules\Sigma\Models\Qua00f>
does not specify all template types: TRelatedModel, TDeclaringModel
```

#### Posizioni
- Linea 128 (qua00f)
- Linea 230 (qua00f)
- Linea 368 (asz00k1)
- Linea 370 (asz00k1)
- Linea 443 (qua03f context)

#### Soluzione
```php
// ❌ ERRATO
/** @var HasMany<Qua00f> $qua00fRelation */

// ✅ CORRETTO
/** @var HasMany<Qua00f, Anag> $qua00fRelation */
// oppure per Asz00f:
/** @var HasMany<Asz00k1, Asz00f> $aszRelation */
```

#### Piano di Correzione
1. Identificare il modello dichiarante per ogni relazione
2. Aggiornare tutte le annotazioni PHPDoc con entrambi i tipi generici
3. Verificare con PHPStan

---

### 2. Accesso a Proprietà Non Definite (🔴 Priorità Alta)

**Conteggio**: ~16 occorrenze
**Impact**: Alto (potenziali runtime errors)
**Effort**: Medio (necessita PHPDoc o dynamic properties)

#### Errore
```
Access to an undefined property Modules\Sigma\Models\Qua00f::$tot
Access to an undefined property Modules\Sigma\Models\Asz00k1::$tot
```

#### Posizioni
- Linea 278: `Qua00f::$tot`
- Linea 332: `Illuminate\Database\Eloquent\Model::$tot`
- Linea 422: `Asz00k1::$tot`
- Molte altre linee simili

#### Analisi
La proprietà `$tot` viene:
1. **Creata dinamicamente** tramite `selectRaw('SUM(...) as tot')`
2. **Acceduta** come proprietà dell'oggetto risultante

#### Soluzioni Possibili

**Opzione A**: PHPDoc @property (Raccomandato per query dinamiche)
```php
/**
 * @property-read float|int|null $tot Totale calcolato dinamicamente
 */
class QueryResult extends Model
{
    // ...
}
```

**Opzione B**: Creare DTO per risultati query
```php
class GgFuoriSedeResult
{
    public function __construct(
        public readonly float|int|null $tot
    ) {}
}

// Utilizzare:
$result = new GgFuoriSedeResult(tot: $query->first()?->tot);
return $result->tot;
```

**Opzione C**: Type assertion con controllo null-safe
```php
$result = $qua00fRelation
    ->whereRaw(...)
    ->selectRaw('SUM(gg) as tot')
    ->first();

// ✅ Type-safe access
$tot = $result?->tot ?? 0;
return (float) $tot;
```

#### Piano di Correzione
1. **Immediate**: Usare Opzione C per accessi esistenti (null-safe + cast)
2. **Medio Termine**: Valutare creazione DTO per risultati complessi
3. **Lungo Termine**: Considerare Query Builder custom con tipi definiti

---

### 3. Metodi Chiamati su Mixed (🔴 Priorità Alta)

**Conteggio**: ~80 occorrenze
**Impact**: Alto (type safety compromessa)
**Effort**: Alto (richiede refactoring significativo)

#### Errori Tipici
```
Cannot call method whereRaw() on mixed
Cannot call method selectRaw() on mixed
Cannot call method where() on mixed
Cannot call method first() on mixed
Cannot call method getTable() on mixed
Cannot call method string() on mixed
Cannot call method integer() on mixed
```

#### Cause Principali

**1. Metodi di Relazione non Tipizzati**
```php
// ❌ Problema
$relation = $this->qua03f();  // mixed (metodo non esiste per alcuni modelli)

// ✅ Soluzione: Type Guard
if (!method_exists($this, 'qua03f')) {
    throw new \RuntimeException('Qua03f relation not defined');
}

/** @var HasMany<Qua03f, static> $relation */
$relation = $this->qua03f();
```

**2. Schema Builder non Tipizzato**
```php
// ❌ Problema
Schema::table($this->getTable(), function ($table) {
    // $table è mixed
    $table->string('column');  // Errore PHPStan
});

// ✅ Soluzione: Type Hint
Schema::table($this->getTable(), function (Blueprint $table): void {
    $table->string('column');
});
```

**3. Catene di Metodi su Query Builder**
```php
// ❌ Problema
$query = $this->where(...)->where(...);  // Perde tipo dopo primo where

// ✅ Soluzione: Type Assertion
/** @var Builder<static> $query */
$query = $this->query()
    ->where('field1', 'value1')
    ->where('field2', 'value2');
```

#### Piano di Correzione
1. **Fase 1** (Quick Wins): Aggiungere type hints per Blueprint in Schema::table()
2. **Fase 2** (Medium): Type guards per metodi di relazione dinamici
3. **Fase 3** (Long): Refactor per eliminare catene di metodi non tipizzate

---

### 4. Method Not Found (🟡 Priorità Media)

**Conteggio**: ~10 occorrenze
**Impact**: Medio (potenziali runtime errors)
**Effort**: Medio (richiede trait mixin o PHPDoc)

#### Errori
```
Call to an undefined method Modules\Sigma\Models\Anag::qua00f()
Call to an undefined method HasMany::ofListaProproPosfun()
```

#### Analisi

**Caso 1**: Metodi di relazione definiti in trait
```php
// ❌ PHPStan non sa che Anag ha qua00f()
if (method_exists($this, 'qua00f')) {
    $relation = $this->qua00f();
}

// ✅ Soluzione: Mixin o PHPDoc nel modello
/**
 * @method \Illuminate\Database\Eloquent\Relations\HasMany<Qua00f, Anag> qua00f()
 */
class Anag extends Model
{
    use SchedaTrait;  // Qui è definito qua00f()
}
```

**Caso 2**: Scope custom su relazioni
```php
// ❌ PHPStan non trova ofListaProproPosfun()
$aszRelation->ofListaProproPosfun();

// ✅ Soluzione: Builder custom con scope
class Asz00k1Builder extends Builder
{
    public function ofListaProproPosfun(): self
    {
        // logica scope
        return $this;
    }
}

// Nel modello:
public function newEloquentBuilder($query): Asz00k1Builder
{
    return new Asz00k1Builder($query);
}
```

---

### 5. Offset Access su Mixed (🟡 Priorità Media)

**Conteggio**: ~30 occorrenze
**Impact**: Alto (potenziali array access errors)
**Effort**: Medio (necessita array shapes)

#### Errori
```
Cannot access offset 'rep2kd' on mixed
Cannot access offset 'dal' on mixed
Cannot access offset 'matr' on mixed
```

#### Posizioni Critiche
- Linea 521-528: Accessi a array configurazione reparto
- Linea 733-734: Accessi a array dati matricola
- Linea 1122-1128: Accessi a risultati calcoli gg

#### Soluzioni

**Opzione A**: Array Shapes (Raccomandato)
```php
/**
 * @param array{rep2kd: string, rep2ka: string, dal: int, al: int} $config
 * @return array{dal: int, al: int}
 */
public function processConfig(array $config): array
{
    $dal = $config['dal'];  // ✅ Type-safe
    $al = $config['al'];    // ✅ Type-safe
    return ['dal' => $dal, 'al' => $al];
}
```

**Opzione B**: DTO (Per strutture complesse)
```php
class RepartoConfigData
{
    public function __construct(
        public readonly string $rep2kd,
        public readonly string $rep2ka,
        public readonly int $dal,
        public readonly int $al
    ) {}
}

// Utilizzo:
public function processConfig(RepartoConfigData $config): array
{
    return ['dal' => $config->dal, 'al' => $config->al];
}
```

#### Piano di Correzione
1. Identificare tutte le strutture array utilizzate
2. Documentare shape con PHPDoc o creare DTO
3. Aggiornare signature metodi con array shapes

---

### 6. Classe Non Trovata (🟡 Priorità Media)

**Conteggio**: 6 occorrenze
**Impact**: Alto (blocca esecuzione se usata)
**Effort**: Basso (creare classe o rimuovere uso)

#### Errore
```
Class Modules\Sigma\Models\Traits\Extras\DiffAssocRecursiveAction not found
```

#### Posizioni
- Linea 770 (tutti i contesti: Anag, Asz00f, Asz00k1, Qua00f, Qua03f)
- Linea 773 (metodo execute())

#### Codice Problematico
```php
$diff = app(DiffAssocRecursiveAction::class)->execute($old_data, $new_data);
```

#### Soluzioni

**Opzione A**: Creare la Classe Mancante
```php
<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Extras;

class DiffAssocRecursiveAction
{
    /**
     * @param array<string, mixed> $array1
     * @param array<string, mixed> $array2
     * @return array<string, mixed>
     */
    public function execute(array $array1, array $array2): array
    {
        return array_diff_assoc_recursive($array1, $array2);
    }
}

/**
 * @param array<string, mixed> $array1
 * @param array<string, mixed> $array2
 * @return array<string, mixed>
 */
function array_diff_assoc_recursive(array $array1, array $array2): array
{
    $difference = [];

    foreach ($array1 as $key => $value) {
        if (is_array($value)) {
            if (!isset($array2[$key]) || !is_array($array2[$key])) {
                $difference[$key] = $value;
            } else {
                $newDiff = array_diff_assoc_recursive($value, $array2[$key]);
                if (!empty($newDiff)) {
                    $difference[$key] = $newDiff;
                }
            }
        } elseif (!array_key_exists($key, $array2) || $array2[$key] !== $value) {
            $difference[$key] = $value;
        }
    }

    return $difference;
}
```

**Opzione B**: Usare Helper Esistente
```php
// Verificare se esiste in Xot
use Modules\Xot\Services\ArrayService;

$diff = ArrayService::diffAssocRecursive($old_data, $new_data);
```

---

### 7. Errori Minori (🟢 Priorità Bassa)

#### Strict Comparison Always False
```php
// Linea 217: SigmaService.php
if ('' !== '') {  // ❌ Always false
```

**Soluzione**: Rimuovere il check o correggere la logica

#### Default Value Incompatible
```php
// Linea 199: Wstr01lx.php
public function durata(array $params = []): float
// ❌ Default [] incompatibile con array{timbr: Collection}

// ✅ Soluzione: Remove default o use nullable
public function durata(array $params): float
// oppure:
public function durata(?array $params = null): float
{
    if ($params === null) {
        $params = ['timbr' => collect()];
    }
    // ...
}
```

---

## 📋 Piano di Azione Completo

### 🎯 Fase 1: Quick Wins (1-2 giorni)

**Priorità**: Correggere errori semplici e ad alto impatto

1. **Generics HasMany**: Aggiungere secondo parametro template ✅ Easy
2. **Type Hints Blueprint**: Aggiungere in tutti Schema::table() ✅ Easy
3. **Null-Safe Access**: Convertire accessi a `$tot` in null-coalescing ✅ Easy
4. **Strict Comparison**: Correggere check sempre false in SigmaService ✅ Easy
5. **Default Value**: Correggere signature in Wstr01lx ✅ Easy

**Target Errori Risolti**: ~50 errori (~11%)

### 🔨 Fase 2: Refactoring Medio (3-5 giorni)

**Priorità**: Migliorare type safety senza modifiche architetturali

1. **Array Shapes**: Documentare tutte le strutture array
2. **Type Guards**: Aggiungere per metodi di relazione dinamici
3. **PHPDoc Methods**: Documentare metodi trait nei modelli
4. **Create DiffAssocRecursiveAction**: Implementare classe mancante
5. **Query Builder Types**: Aggiungere type assertions per catene query

**Target Errori Risolti**: ~200 errori (~44%)

### 🏗️ Fase 3: Refactoring Profondo (1-2 settimane)

**Priorità**: Miglioramenti architetturali a lungo termine

1. **DTO per Query Results**: Creare DTO tipizzati per risultati complessi
2. **Custom Query Builders**: Implementare builder personalizzati con scope tipizzati
3. **Trait Refactor**: Separare logica complessa in servizi standalone
4. **Mass Queries Refactor**: Rivedere logica SQL raw in MassExtra.php
5. **Test Coverage**: Aggiungere test per tutte le correzioni

**Target Errori Risolti**: Tutti i rimanenti (~209 errori, ~45%)

---

## 🎯 Priorità per Impatto Business

### 🔴 Critico (Fare Subito)
- **Accesso a $tot non definito**: Potenziale null pointer in produzione
- **Classe DiffAssocRecursiveAction mancante**: Blocca esecuzione
- **Method Not Found**: Runtime errors se chiamati

### 🟡 Importante (Fare Presto)
- **Offset Access su Mixed**: Array access errors potenziali
- **Metodi su Mixed**: Perdita di type safety, debugging difficile

### 🟢 Migliorie (Fare Quando Possibile)
- **Generics HasMany**: Solo warning, non blocca esecuzione
- **Strict Comparison**: Dead code, non impatta funzionalità

---

## 📊 Metriche di Successo

| Metrica | Attuale | Target Fase 1 | Target Fase 2 | Target Finale |
|---------|---------|---------------|---------------|---------------|
| Errori PHPStan | 459 | 409 (~-11%) | 259 (~-44%) | 0 (100%) |
| Level PHPStan | 10 | 10 | 10 | 10 |
| Coverage Tests | ?? | ?? | 60%+ | 80%+ |
| Tech Debt | Alto | Medio | Medio | Basso |

---

## 🔗 Riferimenti Utili

- **[PHPStan Level 10 Guide](https://phpstan.org/user-guide/rule-levels)**
- **[Laravel Generics](https://phpstan.org/blog/generics-in-php-using-phpdocs)**
- **[Array Shapes Documentation](https://phpstan.org/writing-php-code/phpdoc-types#array-shapes)**
- **[CLAUDE.md](../../../CLAUDE.md)** - Linee guida progetto
- **[docs/claude/eloquent-properties.md](../../../docs/claude/eloquent-properties.md)** - Property handling

---

**Prossimi Passi**: Procedere con Fase 1 (Quick Wins) per ridurre immediatamente gli errori più semplici.
