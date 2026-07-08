---
title: "HasRecursiveRelationshipsContract"
type: documentation
tags: [xot, recursive-relationships, contract, adjacency-list]
module: Xot
created: 2025-01-18
updated: 2026-06-11
qmd: "HasRecursiveRelationshipsContract Xot recursive relationships vendor trait direct PHPDoc wrapper removed"
story: STORY-346
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/39"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/40"
related:
  - recursive-relationships-vendor-direct.md
---

# HasRecursiveRelationshipsContract - Documentazione Completa

## 📋 Panoramica

Il contratto `HasRecursiveRelationshipsContract` definisce l'interfaccia per modelli che implementano relazioni ricorsive (alberi gerarchici) utilizzando il pacchetto `staudenmeir/laravel-adjacency-list`.

## 🏛️ Filosofia Laraxot

### Principio: Vendor Direct + Contract PHPDoc

Laraxot usa direttamente il trait vendor `Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships`.

Il contratto `HasRecursiveRelationshipsContract` resta il confine di dominio per Actions e type hint applicativi, ma i tipi delle relazioni sono documentati in PHPDoc invece che imposti come return type nativi incompatibili con il trait upstream.

### Scopo: DRY, KISS e Manutenibilita

- **DRY**: non copiare metodi vendor in un wrapper locale.
- **KISS**: una sola implementazione runtime, quella upstream.
- **PHPStan**: i tipi utili restano nel PHPDoc del contratto.
- **Manutenibilita**: meno drift quando il pacchetto `staudenmeir/laravel-adjacency-list` cambia firma.

Vedi anche [recursive-relationships-vendor-direct.md](recursive-relationships-vendor-direct.md).

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

### 2. Trait vendor (`HasRecursiveRelationships`)

**File vendor**: `vendor/staudenmeir/laravel-adjacency-list/src/Eloquent/HasRecursiveRelationships.php`

Regola STORY-346:
- i modelli usano direttamente il trait vendor;
- il contratto conserva tipi e contesto in PHPDoc.

### 3. Uso nei Modelli

```php
<?php

namespace Modules\Limesurvey\Models;

use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

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

## 🧘 Filosofia Laraxot: Vendor Direct Pattern

### Perche usare direttamente il trait vendor?

1. **DRY**: il comportamento runtime resta nel pacchetto upstream.
2. **KISS**: non esiste un wrapper locale da sincronizzare.
3. **PHPStan**: il contratto Xot conserva i tipi in PHPDoc.
4. **Documentazione**: la regola canonica e [recursive-relationships-vendor-direct.md](recursive-relationships-vendor-direct.md).

### Pattern di Implementazione

```php
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class MyModel extends BaseModel implements HasRecursiveRelationshipsContract
{
    use HasRecursiveRelationships;
}
```

## 📚 Riferimenti

- [Vendor Package](https://github.com/staudenmeir/laravel-adjacency-list)
- [Recursive relationships vendor direct](recursive-relationships-vendor-direct.md)
- [Contracts and Interfaces](contracts-and-interfaces.md)
- [PHPStan Contract Conflicts Resolution](phpstan-contract-conflicts-resolution.md)

## 🔄 Changelog

### 2025-01-18 - Aggiornamento Completo del Contratto
### [DATE] - Aggiornamento Completo del Contratto

- ✅ Aggiunti metodi mancanti al contratto:
  - `getQualifiedParentKeyName(): string` - Nome qualificato della colonna parent
  - `getLocalKeyName(): string` - Nome della colonna chiave locale
  - `getQualifiedLocalKeyName(): string` - Nome qualificato della colonna chiave locale
  - `getDepthName(): string` - Nome della colonna depth
- ✅ Corretto tipo di ritorno di `getParentKeyName()`: da `mixed` a `string`
- ✅ Corretto tipo di ritorno di `getCustomPaths()`: da `array<string>` a `array<int|string, string>`
- ✅ Allineato contratto con trait vendor `HasAdjacencyList` da `staudenmeir/laravel-adjacency-list`
- ✅ Nota storica superata: STORY-346 ha rimosso `TypedHasRecursiveRelationships`; usare il trait vendor diretto
- ✅ Corretto `getLocalKeyName()` in `LimeQuestion` con return type `string`
- ✅ Documentazione completa aggiunta con esempi e best practices
- ✅ Verificato PHPStan livello 10: nessun errore

---

**Filosofia**: In Laraxot, rispettiamo i vendor packages ma creiamo contratti PHPDoc e trait vendor diretto per garantire qualità del codice senza duplicare API upstream.