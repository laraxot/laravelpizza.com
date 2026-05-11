# Adjacency List Best Practices

> Questo documento sostituisce `nestedset-migration-best-practices.md` (legacy).
> Il progetto ha completato la migrazione da `kalnoy/nestedset` a `staudenmeir/laravel-adjacency-list`.

## Regola Fondamentale

**Per tutti i nuovi modelli ad albero: estendere `BaseTreeModel` o `XotBaseTreeModel`.**

```php
<?php
declare(strict_types=1);

namespace Modules\MioModulo\Models;

use Modules\Xot\Models\BaseTreeModel;

class Category extends BaseTreeModel
{
    protected $connection = 'mio_modulo';
    protected $table = 'categories';

    /** @var list<string> */
    protected $fillable = ['name', 'slug', 'parent_id'];
}
```

## Migrazione Database

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            // Adjacency List: solo parent_id
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();

            // Indici per performance
            $table->index('parent_id');

            $table->timestamps();
        });
    }
    // Niente down() — regola Laraxot
};
```

## API Disponibili (ereditate da BaseTreeModel)

### Relazioni Base
```php
$node->parent;              // Genitore diretto
$node->children;            // Figli diretti
$node->ancestors();         // Tutti gli antenati (CTE ricorsiva)
$node->descendants();       // Tutti i discendenti (CTE ricorsiva)
$node->siblings();          // Fratelli
$node->rootAncestor();      // Antenato radice
$node->bloodline();         // Albero completo
```

### Relazioni Estese
```php
$node->ancestorsAndSelf();     // Antenati + sé stesso
$node->descendantsAndSelf();   // Discendenti + sé stesso
$node->parentAndSelf();        // Genitore + sé stesso
$node->siblingsAndSelf();      // Fratelli + sé stesso
$node->childrenAndSelf();      // Figli + sé stesso
$node->rootAncestorOrSelf();   // Radice o sé stesso se root
```

### Query con Profondità
```php
// Limitare la profondità per performance
$node->descendants()->whereDepth('<=', 3)->get();

// Eager loading
Category::with(['ancestors', 'children'])->get();

// Albero completo con profondità
Category::tree()->get();
```

### Custom Key Names
```php
class LimeQuestion extends BaseTreeModel
{
    public function getParentKeyName(): string
    {
        return 'parent_qid';  // Chiave genitore custom
    }

    public function getLocalKeyName(): string
    {
        return 'qid';  // Chiave primaria custom
    }
}
```

## Cosa NON Fare

```php
// ❌ MAI usare kalnoy/nestedset
use Kalnoy\Nestedset\NodeTrait;  // RIMOSSO DAL PROGETTO

// ❌ MAI creare colonne _lft, _rgt
$table->unsignedInteger('_lft');
$table->unsignedInteger('_rgt');

// ❌ MAI usare NestedSet::columns()
NestedSet::columns($table);

// ❌ MAI implementare parent/child manualmente
public function parent() {
    return $this->belongsTo(self::class, 'parent_id');
}
```

## Riferimenti

- [Documento filosofico completo](../adjacency-list-migration.md)
- [BaseTreeModel](../../app/Models/BaseTreeModel.php)
- [staudenmeir/laravel-adjacency-list](https://github.com/staudenmeir/laravel-adjacency-list)

*Ultimo aggiornamento: marzo 2026*
