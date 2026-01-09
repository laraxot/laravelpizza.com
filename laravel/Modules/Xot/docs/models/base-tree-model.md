# BaseTreeModel Documentation

## Overview

`BaseTreeModel` is an abstract base class that provides tree structure functionality for models in the Laraxot ecosystem.

## Purpose

This class serves as the foundation for all models that need hierarchical relationships, ensuring:
- **Type Safety**: Full PHPStan Level 10 compliance
- **Consistency**: Standardized tree behavior across modules
- **Extensibility**: Easy customization for specific requirements

## Class Definition

```php
abstract class BaseTreeModel extends BaseModel implements HasRecursiveRelationshipsContract
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
}
```

## Inheritance Hierarchy

```
BaseModel
└── BaseTreeModel
    ├── LimeQuestion (Limesurvey module)
    ├── Category (various modules)
    └── [Other tree models]
```

## Key Features

### 1. Contract Implementation
- Implements `HasRecursiveRelationshipsContract`
- Provides type-safe recursive relationship methods
- Ensures PHPStan Level 10 compliance

### 2. Trait Integration
- Uses `TypedHasRecursiveRelationships` trait
- Wraps vendor package with type safety
- Provides method aliasing for consistency

### 3. BaseModel Inheritance
- Inherits all base model functionality
- Maintains connection to module-specific database
- Preserves standard Laravel model behavior

## Usage Patterns

### Basic Tree Model
```php
class Category extends BaseTreeModel
{
    protected $connection = 'my_module';
    protected $table = 'categories';

    // Inherits all tree functionality
}
```

### Custom Key Names
```php
class LimeQuestion extends BaseTreeModel
{
    public function getParentKeyName(): string
    {
        return 'parent_qid';  // Custom parent key
    }

    public function getLocalKeyName(): string
    {
        return 'qid';  // Custom primary key
    }
}
```

### Custom Depth/Path Names
```php
class CustomTree extends BaseTreeModel
{
    public function getDepthName(): string
    {
        return 'tree_depth';  // Custom depth column
    }

    public function getPathName(): string
    {
        return 'tree_path';   // Custom path column
    }
}
```

## Available Methods

### Navigation Methods
```php
$model->parent;              // Get direct parent
$model->children;            // Get direct children
$model->ancestors();         // Get all ancestors
$model->descendants();       // Get all descendants
$model->siblings();          // Get siblings
$model->rootAncestor();      // Get root ancestor
```

### Advanced Navigation
```php
$model->ancestorsAndSelf();     // Ancestors including self
$model->descendantsAndSelf();   // Descendants including self
$model->bloodline();            // Complete tree
$model->parentAndSelf();        // Parent and self
$model->siblingsAndSelf();      // Siblings and self
```

### Utility Methods
```php
$model->getDepth();             // Get node depth
$model->getPath();              // Get node path
$model->isRoot();               // Check if root
$model->isLeaf();               // Check if leaf
$model->hasChildren();          // Check if has children
```

## Database Requirements

### Required Columns (Adjacency List)
```sql
-- Primary key (can be customized)
id BIGINT PRIMARY KEY

-- Parent key (can be customized with getParentKeyName())
parent_id BIGINT NULL

-- Optional but recommended
depth INT NULL
path VARCHAR(255) NULL
```

### Indexes for Performance (Adjacency List)
```sql
-- Performance indexes
INDEX idx_parent_id (parent_id);
INDEX idx_depth (depth);
INDEX idx_path (path);
```

### Nota storica: migrazioni `kalnoy/laravel-nestedset`

Storicamente il progetto ha utilizzato `kalnoy/laravel-nestedset` (`NodeTrait`) per gestire gli alberi.
Nel modello Nested Set classico, le migrazioni seguono lo schema raccomandato nel README del pacchetto:

```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

Schema::create('categories', function (Blueprint $table) {
    $table->bigIncrements('id');

    // Colonne nested set (_lft, _rgt, parent_id) + indici
    NestedSet::columns($table);

    $table->string('name');
    $table->timestamps();
});

Schema::table('categories', function (Blueprint $table): void {
    // Rimozione colonne nested set, se necessario in migrazioni future
    NestedSet::dropColumns($table);
});
```

In pratica:

- `NestedSet::columns($table)` aggiunge le colonne standard `_lft`, `_rgt` e `parent_id`
  insieme agli indici necessari per interrogare l'albero in modo efficiente.
- Nel README ufficiale del pacchetto esiste anche la macro di schema `$table->nestedSet();`
  che è solo uno **shortcut** per chiamare internamente `NestedSet::columns($table)`.

#### Regole di utilizzo (legacy)

1. **Mai** creare a mano le colonne `_lft`, `_rgt`, `parent_id`: usare sempre
   `NestedSet::columns($table)` oppure `$table->nestedSet();`.
2. In migrazioni di refactor o rollback, usare `NestedSet::dropColumns($table)` per rimuovere
   in blocco la struttura Nested Set.
3. Quando si incontra una migrazione con `$table->nestedSet();` in un modulo legacy (es. Cms),
   va letta come equivalente al blocco mostrato sopra con `NestedSet::columns($table)`.
4. Nelle **nuove** migrazioni Laraxot, la regola è di preferire `BaseTreeModel` (adjacency list)
   e considerare l'uso di Nested Set solo per compatibilità storica.

#### Differenza filosofica con BaseTreeModel

- **Nested Set (kalnoy)**: ottimizzato per query di alberi molto grandi con letture veloci,
  ma con migrazioni e update più complessi (serve gestire `_lft`/`_rgt`).
- **BaseTreeModel (adjacency list tipizzata)**: usa `parent_id`/`depth`/`path` con trait
  `TypedHasRecursiveRelationships`, privilegiando:
  - type safety (PHPStan livello 10),
  - semplicità nelle migrazioni (nessun `_lft`/`_rgt` da mantenere a mano),
  - integrazione diretta con il pacchetto `staudenmeir/laravel-adjacency-list`.

Per i nuovi modelli ad albero in Laraxot:

- **Regola attuale**: estendere `BaseTreeModel` e usare il pattern adjacency list documentato qui.
- **Regola storica/di compatibilità**: quando si incontra codice legacy basato su `NodeTrait`,
  le migrazioni vanno lette alla luce dello schema Nested Set (_lft, _rgt, parent_id) mostrato sopra
  e, se si fa refactoring, documentate le conversioni in questa pagina.

## Configuration Options

### Custom Column Names
Override these methods in your model:

```php
public function getParentKeyName(): string
{
    return 'custom_parent_id';
}

public function getLocalKeyName(): string
{
    return 'custom_id';
}

public function getDepthName(): string
{
    return 'custom_depth';
}

public function getPathName(): string
{
    return 'custom_path';
}
```

### Custom Path Separator
```php
public function getPathSeparator(): string
{
    return '.';  // Default: '/'
}
```

## Performance Considerations

### Database Optimization
1. **Add proper indexes** on parent_id, depth, and path columns
2. **Use depth constraints** for deep trees: `withMaxDepth(5)`
3. **Consider materialized paths** for very large trees

### Query Optimization
```php
// Efficient queries with depth limits
$descendants = $model->descendants()->withMaxDepth(3)->get();

// Eager loading to prevent N+1
$nodes = TreeModel::with(['ancestors', 'children'])->get();
```

## Integration Examples

### Limesurvey Module
```php
class LimeQuestion extends BaseTreeModel
{
    protected $connection = 'limesurvey';
    protected $table = 'lime_questions';

    public function getParentKeyName(): string
    {
        return 'parent_qid';
    }

    public function getLocalKeyName(): string
    {
        return 'qid';
    }
}
```

### Menu System
```php
class MenuItem extends BaseTreeModel
{
    protected $table = 'menu_items';

    public function getParentKeyName(): string
    {
        return 'parent_id';
    }

    // Custom methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
```

## Testing Tree Models

### Unit Test Example
```php
class LimeQuestionTest extends TestCase
{
    public function test_tree_relationships()
    {
        $parent = LimeQuestion::create(['title' => 'Parent']);
        $child = LimeQuestion::create([
            'title' => 'Child',
            'parent_qid' => $parent->qid
        ]);

        $this->assertEquals($parent->qid, $child->parent->qid);
        $this->assertTrue($parent->children->contains($child));
        $this->assertTrue($child->ancestors->contains($parent));
    }
}
```

## Migration from Other Tree Libraries

### From Nested Sets
```php
// Before: Nested sets
class OldModel extends Model {
    use Kalnoy\Nestedset\NodeTrait;
}

// After: Adjacency list with BaseTreeModel
class NewModel extends BaseTreeModel {
    // Automatic tree functionality
}
```

### From Custom Implementation
```php
// Before: Manual parent/child
class OldModel extends Model {
    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }
}

// After: Full tree functionality
class NewModel extends BaseTreeModel {
    // Inherits parent(), children(), ancestors(), descendants(), etc.
}
```

## Best Practices

1. **Always extend BaseTreeModel** for new tree structures
2. **Customize only necessary methods** (key names, column names)
3. **Add database indexes** for performance
4. **Use depth constraints** for large trees
5. **Test tree relationships** thoroughly
6. **Document custom configurations** in model PHPDoc

## Troubleshooting

### Common Issues
1. **"Method not found"**: Ensure model extends BaseTreeModel
2. **Type errors**: Check return type declarations
3. **Performance issues**: Add missing database indexes
4. **Infinite recursion**: Verify data integrity

### Debug Tools
```php
// Check tree integrity
$model->ancestors()->count();  // Should not cause infinite loop
$model->descendants()->count();  // Should be reasonable number

// Verify parent/child relationships
$model->parent;  // Should return single model or null
$model->children;  // Should return collection
```

## Related Documentation

- [HasRecursiveRelationshipsContract](contracts/has-recursive-relationships-contract.md)
- [TypedHasRecursiveRelationships Trait](traits/typed-has-recursive-relationships.md)
- [Laravel Adjacency List Package](https://github.com/staudenmeir/laravel-adjacency-list)
