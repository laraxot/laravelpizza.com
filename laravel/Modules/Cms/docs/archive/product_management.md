# Gestione Prodotti con Laravel Folio e Volt

Questa guida spiega come implementare un sistema di gestione prodotti utilizzando Laravel Folio per il routing e Volt per la reattività dei componenti.

## Prerequisiti

- Laravel 10+
- Laravel Folio
- Laravel Volt
- Filament v3
- PHP 8.1+

## Struttura del Database

### Schema Prodotti

```php
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('stock')->default(0);
        $table->string('sku')->unique();
        $table->boolean('is_active')->default(true);
        $table->jsonb('metadata')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}
```

### Schema Categorie

```php
public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->nestedSet();
        $table->timestamps();
    });

    Schema::create('category_product', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
```

## Modelli

### Product Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'sku',
        'is_active',
        'metadata'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
```

### Category Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
```

## Struttura delle Route con Folio

```
resources/
└── views/
    └── pages/
        └── products/
            ├── index.blade.php
            ├── create.blade.php
            ├── [id]/
            │   ├── edit.blade.php
            │   └── show.blade.php
            └── categories/
                ├── index.blade.php
                ├── create.blade.php
                └── [id]/
                    ├── edit.blade.php
                    └── show.blade.php
```

## Componenti Volt

### Lista Prodotti

```php
<?php

use function Livewire\Volt\{state, computed};
use App\Models\Product;

state([
    'search' => '',
    'sortField' => 'name',
    'sortDirection' => 'asc',
    'perPage' => 10
]);

$products = computed(function () {
    return Product::query()
        ->when($this->search, fn($query) => 
            $query->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%")
        )
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
});

$sort = function (string $field) {
    if ($field === $this->sortField) {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        $this->sortField = $field;
        $this->sortDirection = 'asc';
    }
};
?>

<div>
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="Cerca prodotti...">
    </div>

    <table class="min-w-full">
        <thead>
            <tr>
                <th wire:click="sort('name')">Nome</th>
                <th wire:click="sort('price')">Prezzo</th>
                <th wire:click="sort('stock')">Stock</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($this->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>€ {{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="/products/{{ $product->id }}/edit">Modifica</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $this->products->links() }}
</div>
```

### Form Creazione/Modifica Prodotto

```php
<?php

use function Livewire\Volt\{state, rules, mount};
use App\Models\Product;

state([
    'product' => [
        'name' => '',
        'description' => '',
        'price' => '',
        'stock' => 0,
        'sku' => '',
        'is_active' => true,
    ],
    'selectedCategories' => []
]);

rules([
    'product.name' => 'required|min:3',
    'product.price' => 'required|numeric|min:0',
    'product.stock' => 'required|integer|min:0',
    'product.sku' => 'required|unique:products,sku',
]);

$mount = function (?Product $product = null) {
    if ($product) {
        $this->product = $product->toArray();
        $this->selectedCategories = $product->categories->pluck('id')->toArray();
    }
};

$save = function () {
    $this->validate();

    $product = Product::updateOrCreate(
        ['id' => $this->product['id'] ?? null],
        $this->product
    );

    $product->categories()->sync($this->selectedCategories);

    session()->flash('message', 'Prodotto salvato con successo.');
    
    return redirect()->route('products.index');
};
?>

<form wire:submit="save">
    <!-- Form fields -->
</form>
```

## Integrazione con Filament

### ProductResource

```php
<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Resources\Resource;
use Filament\Resources\Forms\Form;
use Filament\Resources\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form fields
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Table columns
            ])
            ->filters([
                // Filters
            ])
            ->actions([
                // Actions
            ]);
    }
}
```

## Best Practices

### 1. Organizzazione del Codice

- Separare la logica di business dai componenti
- Utilizzare service classes per operazioni complesse
- Implementare repository pattern per l'accesso ai dati

### 2. Performance

- Implementare lazy loading per le relazioni
- Utilizzare cache per dati frequentemente acceduti
- Ottimizzare le query con eager loading

### 3. Validazione

- Validare input lato server e client
- Implementare regole di validazione personalizzate
- Gestire correttamente gli errori

### 4. SEO

- Generare slug automaticamente
- Implementare meta tags dinamici
- Ottimizzare per i motori di ricerca

## Testing

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Livewire\Volt\Volt;

class ProductTest extends TestCase
{
    /** @test */
    public function it_can_create_a_product()
    {
        $productData = [
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 10,
            'sku' => 'TEST-001'
        ];

        Volt::test('products.create-form')
            ->set('product', $productData)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', $productData);
    }
}
```

## Riferimenti

- [Laravel Folio Documentation](https://github.com/laravel/folio)
- [Laravel Volt Documentation](https://livewire.laravel.com/project_docs/volt)
- [Filament Documentation](https://filamentphp.com) 

## Collegamenti tra versioni di product-management.md
* [product-management.md](laravel/Modules/Cms/project_docs/product-management.md)
* [product-management.md](laravel/Modules/Cms/project_docs/components/product-management.md)

