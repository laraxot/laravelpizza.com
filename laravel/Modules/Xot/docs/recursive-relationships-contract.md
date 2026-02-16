# HasRecursiveRelationshipsContract - Documentazione Completa

## 📋 Panoramica

Il contratto `HasRecursiveRelationshipsContract` definisce l'interfaccia per modelli che implementano relazioni ricorsive (alberi gerarchici) utilizzando il pacchetto `staudenmeir/laravel-adjacency-list`.

## 🏛️ Filosofia Laraxot

### Principio: Wrapper Type-Safe per Vendor Packages

Laraxot non estende direttamente i trait vendor, ma crea:
1. **Contratto** (`HasRecursiveRelationshipsContract`) - Interfaccia type-safe
2. **Trait Wrapper** (`TypedHasRecursiveRelationships`) - Wrapper con tipi espliciti
3. **Implementazione** - I modelli implementano il contratto usando il trait wrapper

### Scopo: Type Safety e Manutenibilità

- **Type Safety**: PHPStan livello 10 garantisce che tutti i tipi siano corretti
- **Manutenibilità**: Se il vendor cambia, aggiorniamo solo il wrapper
- **Testabilità**: Possiamo mockare il contratto invece del trait vendor

## 📚 Struttura del Pacchetto Vendor

### Pacchetti Utilizzati

1. **`staudenmeir/laravel-adjacency-list`**
   - Fornisce il trait `HasAdjacencyList`
   - Gestisce relazioni ricorsive (alberi gerarchici)
   - Supporta CTE (Common Table Expressions) per query efficienti

2. **`staudenmeir/laravel-cte`**
   - Fornisce il trait `QueriesExpressions`
   - Gestisce le CTE per database diversi (Oracle, SingleStore, Firebird)

### Trait Vendor

```php
// Vendor trait combinato
trait HasRecursiveRelationships
{
    use HasAdjacencyList;      // Relazioni ricorsive
    use QueriesExpressions;    // CTE support
}
```

## 🔧 Implementazione Laraxot

### 1. Contratto (`HasRecursiveRelationshipsContract`)

**File**: `Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`

Definisce tutti i metodi pubblici esposti dal trait vendor con tipi espliciti.

### 2. Trait Wrapper (`TypedHasRecursiveRelationships`)

**File**: `Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

Wrapper che:
- Usa il trait vendor con alias `protected`
- Re-espone i metodi come `public` con tipi espliciti
- Garantisce type safety per PHPStan

### 3. Uso nei Modelli

```php
<?php

namespace Modules\Limesurvey\Models;

use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Models\Traits\TypedHasRecursiveRelationships;

class LimeQuestion extends BaseModel implements HasRecursiveRelationshipsContract
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    public function getParentKeyName(): string
    {
        return 'parent_qid';  // Override se necessario
    }

    public function getLocalKeyName(): string
    {
        return 'qid';  // Override se necessario
    }
}
```

## 📝 Metodi del Contratto

### Metodi di Configurazione

#### `getParentKeyName(): string`
Restituisce il nome della colonna che contiene la chiave del parent.

**Default**: `'parent_id'`

**Esempio**:
```php
public function getParentKeyName(): string
{
    return 'parent_qid';  // Per LimeQuestion
}
```

#### `getQualifiedParentKeyName(): string`
Restituisce il nome qualificato (con tabella) della colonna parent key.

**Esempio**: `'lime_questions.parent_qid'`

#### `getLocalKeyName(): string`
Restituisce il nome della colonna chiave locale (primary key).

**Default**: Restituisce `getKeyName()` del modello

#### `getQualifiedLocalKeyName(): string`
Restituisce il nome qualificato della colonna chiave locale.

**Esempio**: `'lime_questions.qid'`

#### `getDepthName(): string`
Restituisce il nome della colonna depth (profondità nell'albero).

**Default**: `'depth'`

#### `getPathName(): string`
Restituisce il nome della colonna path (percorso nell'albero).

**Default**: `'path'`

#### `getPathSeparator(): string`
Restituisce il separatore usato nel path.

**Default**: `'.'`

#### `getCustomPaths(): array<int|string, string>`
Restituisce array di percorsi personalizzati aggiuntivi.

**Default**: `[]`

**Esempio**:
```php
public function getCustomPaths(): array
{
    return [
        'name' => 'title',
        'separator' => '/',
    ];
}
```

#### `getExpressionName(): string`
Restituisce il nome della Common Table Expression (CTE).

**Default**: `'laravel_cte'`

### Metodi di Relazione

#### `ancestors(): Ancestors`
Restituisce tutti gli antenati (parent ricorsivi) del modello.

**Tipo**: `Ancestors<static, static>`

#### `ancestorsAndSelf(): Ancestors`
Restituisce tutti gli antenati incluso il modello stesso.

**Tipo**: `Ancestors<static, static>`

#### `bloodline(): Bloodline`
Restituisce antenati, discendenti e il modello stesso.

**Tipo**: `Bloodline<static, static>`

#### `children(): HasMany`
Restituisce i figli diretti del modello.

**Tipo**: `HasMany<static, static>`

#### `childrenAndSelf(): Descendants`
Restituisce i figli diretti incluso il modello stesso.

**Tipo**: `Descendants<static, static>`

#### `descendants(): Descendants`
Restituisce tutti i discendenti (figli ricorsivi) del modello.

**Tipo**: `Descendants<static, static>`

#### `descendantsAndSelf(): Descendants`
Restituisce tutti i discendenti incluso il modello stesso.

**Tipo**: `Descendants<static, static>`

#### `parent(): BelongsTo`
Restituisce il parent diretto del modello.

**Tipo**: `BelongsTo<static, static>`

#### `parentAndSelf(): Ancestors`
Restituisce il parent diretto incluso il modello stesso.

**Tipo**: `Ancestors<static, static>`

#### `rootAncestor(): RootAncestor`
Restituisce l'antenato root (senza parent).

**Tipo**: `RootAncestor<static, static>`

#### `rootAncestorOrSelf(): RootAncestorOrSelf`
Restituisce l'antenato root o il modello stesso se è root.

**Tipo**: `RootAncestorOrSelf<static, static>`

#### `siblings(): Siblings`
Restituisce i fratelli (modelli con lo stesso parent) del modello.

**Tipo**: `Siblings<static, static>`

#### `siblingsAndSelf(): Siblings`
Restituisce i fratelli incluso il modello stesso.

**Tipo**: `Siblings<static, static>`

### Metodi di Utilità

#### `getFirstPathSegment(): string`
Restituisce il primo segmento del path del modello.

**Esempio**: Se `path = '1.2.3'`, restituisce `'1'`

#### `hasNestedPath(): bool`
Verifica se il path del modello è annidato (contiene separatori).

**Esempio**: `'1.2.3'` → `true`, `'1'` → `false`

#### `isIntegerAttribute(string $attribute): bool`
Verifica se un attributo è castato come integer.

**Esempio**: Se `$casts['id'] = 'int'`, restituisce `true`

#### `getLabel(): string`
Metodo aggiunto da XOT, utilizzato nelle options delle select.

**Esempio**:
```php
public function getLabel(): string
{
    return $this->qid.']'.$this->title.']'.strip_tags($this->question);
}
```

### Metodi Statici

#### `withMaxDepth(int $maxDepth, callable $query): mixed`
Esegue una query con un vincolo di profondità massima per la query ricorsiva.

**Esempio**:
```php
$result = Model::withMaxDepth(3, function () {
    return Model::where('active', true)->get();
});
```

## 🎯 Proprietà PHPDoc

Il contratto definisce anche le proprietà accessibili via magic methods:

```php
/**
 * @property int $id
 * @property string $name
 * @property int $depth
 * @property Collection<static> $children
 * @property int|null $children_count
 * @property Collection<static> $ancestors
 * @property Collection<static> $ancestorsAndSelf
 * @property Collection<static> $bloodline
 * @property Collection<static> $childrenAndSelf
 * @property Collection<static> $descendants
 * @property Collection<static> $descendantsAndSelf
 * @property Collection<static> $parentAndSelf
 * @property static|null $parent
 * @property static|null $rootAncestor
 * @property Collection<static> $siblings
 * @property Collection<static> $siblingsAndSelf
 */
```

## 🔍 Esempi di Utilizzo

### Esempio 1: Navigazione Albero

```php
$question = LimeQuestion::find(5);

// Ottenere tutti gli antenati
$ancestors = $question->ancestors()->get();

// Ottenere tutti i discendenti
$descendants = $question->descendants()->get();

// Ottenere il root
$root = $question->rootAncestor()->first();

// Ottenere i fratelli
$siblings = $question->siblings()->get();
```

### Esempio 2: Query con Vincoli

```php
// Solo discendenti fino a profondità 2
$descendants = $question->descendants()
    ->whereDepth('<=', 2)
    ->get();

// Solo antenati fino a profondità 3
$ancestors = $question->ancestors()
    ->whereDepth('<=', 3)
    ->get();
```

### Esempio 3: Verifica Posizione

```php
// Verificare se è root
$isRoot = $question->isRoot();

// Verificare se è leaf (senza figli)
$isLeaf = $question->isLeaf();

// Verificare se ha parent
$hasParent = $question->hasParent();

// Verificare se ha figli
$hasChildren = $question->hasChildren();
```

## 🧘 Filosofia Laraxot: Wrapper Pattern

### Perché Non Usare Direttamente il Trait Vendor?

1. **Type Safety**: Il trait vendor non ha tipi espliciti per PHPStan livello 10
2. **Manutenibilità**: Se il vendor cambia, aggiorniamo solo il wrapper
3. **Testabilità**: Possiamo mockare il contratto invece del trait
4. **Documentazione**: Il contratto documenta esplicitamente cosa è disponibile

### Pattern di Implementazione

```php
// ❌ SBAGLIATO - Usare direttamente il trait vendor
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class MyModel extends BaseModel
{
    use HasRecursiveRelationships;  // No type safety
}

// ✅ CORRETTO - Usare il contratto e il trait wrapper
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Models\Traits\TypedHasRecursiveRelationships;

class MyModel extends BaseModel implements HasRecursiveRelationshipsContract
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;  // Type safe
}
```

## 📚 Riferimenti

- [Vendor Package](https://github.com/staudenmeir/laravel-adjacency-list)
- [TypedHasRecursiveRelationships Trait](../app/Models/Traits/TypedHasRecursiveRelationships.php)
- [Contracts and Interfaces](contracts-and-interfaces.md)
- [PHPStan Contract Conflicts Resolution](phpstan-contract-conflicts-resolution.md)

## 🔄 Changelog

### [DATE] - Aggiornamento Completo del Contratto

- ✅ Aggiunti metodi mancanti al contratto:
  - `getQualifiedParentKeyName(): string` - Nome qualificato della colonna parent
  - `getLocalKeyName(): string` - Nome della colonna chiave locale
  - `getQualifiedLocalKeyName(): string` - Nome qualificato della colonna chiave locale
  - `getDepthName(): string` - Nome della colonna depth
- ✅ Corretto tipo di ritorno di `getParentKeyName()`: da `mixed` a `string`
- ✅ Corretto tipo di ritorno di `getCustomPaths()`: da `array<string>` a `array<int|string, string>`
- ✅ Allineato contratto con trait vendor `HasAdjacencyList` da `staudenmeir/laravel-adjacency-list`
- ✅ Aggiornato `BaseTreeModel` in Limesurvey per usare `TypedHasRecursiveRelationships` invece del trait vendor diretto
- ✅ Corretto `getLocalKeyName()` in `LimeQuestion` con return type `string`
- ✅ Documentazione completa aggiunta con esempi e best practices
- ✅ Verificato PHPStan livello 10: nessun errore

---

**Filosofia**: In Laraxot, rispettiamo i vendor packages ma creiamo wrapper type-safe per garantire qualità del codice e manutenibilità.
