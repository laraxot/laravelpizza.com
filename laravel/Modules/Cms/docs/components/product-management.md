# Gestione Prodotti con Volt e Folio

## Introduzione

Questa guida illustra come implementare un sistema di gestione prodotti nel modulo CMS utilizzando Laravel Volt e Folio, con focus su performance e usabilità.

## Struttura Base

### 1. Modello Prodotto
```php
namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

### 2. Migrazione
```php
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('stock')->default(0);
        $table->foreignId('category_id')->constrained();
        $table->boolean('status')->default(true);
        $table->softDeletes();
        $table->timestamps();
    });
}
```

## Implementazione Volt

### 1. Lista Prodotti
```php
<?php

// resources/views/pages/products/index.blade.php
use function Livewire\Volt\{state, computed};
use Modules\Cms\Models\Product;

state([
    'search' => '',
    'sortField' => 'name',
    'sortDirection' => 'asc',
    'perPage' => 10,
]);

$products = computed(function () {
    return Product::query()
        ->when($this->search, fn($query) => 
            $query->where('name', 'like', "%{$this->search}%")
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

<x-layouts.cms>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Prodotti</h1>
            
            <x-cms::input-field
                wire:model.live="search"
                type="search"
                placeholder="Cerca prodotti..."
            />
        </div>

        <div class="bg-white shadow-sm rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th wire:click="sort('name')" class="cursor-pointer">
                            Nome
                            @if($sortField === 'name')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sort('price')" class="cursor-pointer">
                            Prezzo
                            @if($sortField === 'price')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th>Stock</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>€ {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <x-cms::button-link 
                                    :href="route('cms.products.edit', $product)"
                                    size="sm"
                                >
                                    Modifica
                                </x-cms::button-link>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-layouts.cms>
```

### 2. Form di Creazione/Modifica
```php
<?php

// resources/views/pages/products/[Product]/edit.blade.php
use function Livewire\Volt\{state, rules, mount};
use Modules\Cms\Models\{Product, Category};

state([
    'product' => null,
    'categories' => [],
    'form' => [
        'name' => '',
        'description' => '',
        'price' => '',
        'stock' => 0,
        'category_id' => '',
        'status' => true,
    ],
]);

rules([
    'form.name' => 'required|min:3',
    'form.price' => 'required|numeric|min:0',
    'form.stock' => 'required|integer|min:0',
    'form.category_id' => 'required|exists:categories,id',
]);

mount(function (?Product $product) {
    $this->categories = Category::all();
    
    if ($product->exists) {
        $this->product = $product;
        $this->form = $product->only([
            'name',
            'description',
            'price',
            'stock',
            'category_id',
            'status',
        ]);
    }
});

$save = function () {
    $this->validate();
    
    if ($this->product) {
        $this->product->update($this->form);
    } else {
        Product::create($this->form);
    }
    
    session()->flash('success', 'Prodotto salvato con successo.');
    return redirect()->route('cms.products.index');
};
?>

<x-layouts.cms>
    <div class="max-w-2xl mx-auto">
        <form wire:submit="save" class="space-y-6">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-medium mb-6">
                    {{ $product ? 'Modifica Prodotto' : 'Nuovo Prodotto' }}
                </h2>

                <div class="space-y-4">
                    <x-cms::input-field
                        wire:model="form.name"
                        label="Nome"
                        :error="$errors->first('form.name')"
                    />

                    <x-cms::textarea-field
                        wire:model="form.description"
                        label="Descrizione"
                    />

                    <div class="grid grid-cols-2 gap-4">
                        <x-cms::input-field
                            wire:model="form.price"
                            type="number"
                            step="0.01"
                            label="Prezzo"
                            :error="$errors->first('form.price')"
                        />

                        <x-cms::input-field
                            wire:model="form.stock"
                            type="number"
                            label="Stock"
                            :error="$errors->first('form.stock')"
                        />
                    </div>

                    <x-cms::select-field
                        wire:model="form.category_id"
                        :options="$categories"
                        label="Categoria"
                        :error="$errors->first('form.category_id')"
                    />

                    <x-cms::toggle-field
                        wire:model="form.status"
                        label="Attivo"
                    />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-cms::button-link
                        href="{{ route('cms.products.index') }}"
                        variant="secondary"
                    >
                        Annulla
                    </x-cms::button-link>

                    <x-cms::button type="submit">
                        Salva
                    </x-cms::button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.cms>
```

## Ottimizzazioni

### 1. Cache dei Prodotti
```php
// Implementazione del caching per la lista prodotti
$products = computed(function () {
    $cacheKey = "products.{$this->search}.{$this->sortField}.{$this->sortDirection}.{$this->perPage}";
    
    return cache()->remember($cacheKey, now()->addMinutes(5), function () {
        return Product::query()
            ->when($this->search, fn($query) => 
                $query->where('name', 'like', "%{$this->search}%")
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    });
});
```

### 2. Lazy Loading delle Immagini
```php
// Componente per il caricamento lazy delle immagini prodotto
class ProductImage extends Component
{
    public string $src;
    public string $alt;
    
    public function render()
    {
        return view('cms::components.product-image', [
            'placeholder' => asset('images/placeholder.png'),
        ]);
    }
}
```

```blade
<div wire:init="loadImage">
    <img 
        src="{{ $loaded ? $src : $placeholder }}"
        alt="{{ $alt }}"
        class="w-full h-48 object-cover"
        loading="lazy"
    >
</div>
```

## Validazione e Sicurezza

### 1. Form Request Personalizzata
```php
namespace Modules\Cms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', Rule::unique('products')->ignore($this->product)],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
```

### 2. Policy di Autorizzazione
```php
namespace Modules\Cms\Policies;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view products');
    }
    
    public function update(User $user, Product $product): bool
    {
        return $user->can('edit products');
    }
}
```

## Testing

### 1. Feature Tests
```php
namespace Tests\Feature\Products;

use Tests\TestCase;
use Modules\Cms\Models\Product;

class ProductManagementTest extends TestCase
{
    /** @test */
    public function it_can_list_products()
    {
        $products = Product::factory()->count(5)->create();
        
        $this->get(route('cms.products.index'))
            ->assertSuccessful()
            ->assertSee($products->first()->name);
    }
    
    /** @test */
    public function it_can_create_product()
    {
        $this->post(route('cms.products.store'), [
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 10,
            'category_id' => $category->id,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
        
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
        ]);
    }
}
```

### 2. Browser Tests
```php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductTest extends DuskTestCase
{
    /** @test */
    public function it_can_filter_products()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cms/products')
                   ->type('@search-input', 'Test')
                   ->waitForText('Test Product')
                   ->assertSee('Test Product')
                   ->assertDontSee('Other Product');
        });
    }
}
```

## Best Practices

### 1. Gestione degli Eventi
```php
// Notifica quando lo stock è basso
class LowStockNotification extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Stock Basso')
            ->line("Il prodotto {$this->product->name} ha stock basso.");
    }
}

// Nel modello Product
protected static function booted()
{
    static::updated(function ($product) {
        if ($product->stock <= $product->min_stock) {
            Notification::send(
                User::role('manager')->get(),
                new LowStockNotification($product)
            );
        }
    });
}
```

### 2. Query Optimization
```php
// Eager loading delle relazioni
$products = computed(function () {
    return Product::query()
        ->with(['category', 'images'])
        ->when($this->search, fn($query) => 
            $query->where('name', 'like', "%{$this->search}%")
        )
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);
});
```

## Risorse Utili

### Documentation
- [Laravel Volt](https://livewire.laravel.com/docs/volt)
- [Laravel Folio](https://laravel.com/docs/folio)
- [Filament Forms](https://filamentphp.com/docs/forms) 

## Collegamenti tra versioni di product-management.md
* [product-management.md](laravel/Modules/Cms/docs/product-management.md)
* [product-management.md](laravel/Modules/Cms/docs/components/product-management.md)

