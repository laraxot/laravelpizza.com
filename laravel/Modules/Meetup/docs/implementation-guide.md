# Guida Implementazione - Laravel Pizza Replica

## 🎯 Panoramica Implementazione

Basandoci sull'analisi approfondita di laravelpizza.com, questa guida fornisce istruzioni dettagliate per implementare tutte le funzionalità identificate.

## 📋 Fasi di Implementazione

### Fase 1: Setup Base (Settimana 1)

#### 1.1 Database Schema
```sql
-- Tabelle Core
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE ingredients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    price_modifier DECIMAL(8,2) DEFAULT 0.00,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE pizzas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    base_price DECIMAL(8,2) NOT NULL,
    category_id BIGINT UNSIGNED,
    image_path VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE pizza_ingredient (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pizza_id BIGINT UNSIGNED NOT NULL,
    ingredient_id BIGINT UNSIGNED NOT NULL,
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id),
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id),
    UNIQUE KEY unique_pizza_ingredient (pizza_id, ingredient_id)
);

CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255),
    customer_phone VARCHAR(50),
    delivery_address TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'preparing', 'ready', 'delivered', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    pizza_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(8,2) NOT NULL,
    total_price DECIMAL(8,2) NOT NULL,
    custom_ingredients JSON,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id)
);
```

#### 1.2 Modelli Eloquent
```php
<?php

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pizza extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'base_price',
        'category_id', 'image_path', 'is_available'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'pizza_ingredient')
            ->withPivot('is_default')
            ->withTimestamps();
    }

    public function defaultIngredients(): BelongsToMany
    {
        return $this->ingredients()->wherePivot('is_default', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }
}

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'customer_email',
        'customer_phone', 'delivery_address', 'total_amount', 'status', 'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = static::generateOrderNumber();
        });
    }

    protected static function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }
}
```

### Fase 2: Frontend & UI (Settimana 2)

#### 2.1 Layout Base
```php
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Pizza')</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="font-sans bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-orange-500 rounded-full"></div>
                    <span class="text-xl font-bold text-gray-900">Laravel Pizza</span>
                </div>

                <!-- Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-500 font-medium">Home</a>
                    <a href="{{ route('menu') }}" class="text-gray-700 hover:text-orange-500 font-medium">Menu</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-orange-500 font-medium">Chi Siamo</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-500 font-medium">Contatti</a>
                </div>

                <!-- Cart & Actions -->
                <div class="flex items-center space-x-4">
                    <button id="cartButton" class="relative p-2 text-gray-700 hover:text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span id="cartCount" class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-orange-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500">Accedi</a>
                        <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">Registrati</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <!-- Footer content -->
        </div>
    </footer>

    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="fixed top-0 right-0 h-full w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
        <!-- Cart content -->
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
```

#### 2.2 Componenti Livewire
```php
<?php

namespace Modules\Meetup\Http\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public $items = [];
    public $isOpen = false;

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->items = session('cart', []);
    }

    public function addItem($pizzaId, $pizzaName, $price, $customIngredients = [])
    {
        $cart = session('cart', []);

        $itemKey = $pizzaId . '_' . md5(serialize($customIngredients));

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity']++;
        } else {
            $cart[$itemKey] = [
                'pizza_id' => $pizzaId,
                'pizza_name' => $pizzaName,
                'quantity' => 1,
                'unit_price' => $price,
                'custom_ingredients' => $customIngredients,
                'total_price' => $price
            ];
        }

        session(['cart' => $cart]);
        $this->emit('cartUpdated');
    }

    public function removeItem($itemKey)
    {
        $cart = session('cart', []);
        unset($cart[$itemKey]);
        session(['cart' => $cart]);
        $this->emit('cartUpdated');
    }

    public function getTotalProperty()
    {
        return collect($this->items)->sum('total_price');
    }

    public function render()
    {
        return view('meetup::livewire.cart');
    }
}
```

### Fase 3: Business Logic (Settimana 3)

#### 3.1 Actions
```php
<?php

namespace Modules\Meetup\Actions;

use Modules\Meetup\Models\Order;
use Modules\Meetup\Models\OrderItem;
use Modules\Meetup\Datas\OrderData;

class CreateOrderAction
{
    public function execute(OrderData $orderData): Order
    {
        return \DB::transaction(function () use ($orderData) {
            // Calcola totale
            $totalAmount = $this->calculateTotal($orderData);

            // Crea ordine
            $order = Order::create([
                'user_id' => $orderData->user_id,
                'customer_name' => $orderData->customer_name,
                'customer_email' => $orderData->customer_email,
                'customer_phone' => $orderData->customer_phone,
                'delivery_address' => $orderData->delivery_address,
                'total_amount' => $totalAmount,
                'notes' => $orderData->notes,
                'status' => 'pending'
            ]);

            // Crea elementi ordine
            foreach ($orderData->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'pizza_id' => $item['pizza_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
                    'custom_ingredients' => $item['custom_ingredients'] ?? [],
                    'notes' => $item['notes'] ?? ''
                ]);
            }

            // Invia notifica
            $this->sendOrderConfirmation($order);

            return $order;
        });
    }

    private function calculateTotal(OrderData $orderData): float
    {
        $total = 0;

        foreach ($orderData->items as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        // Aggiungi costo consegna
        $deliveryFee = $this->calculateDeliveryFee($orderData->delivery_address);
        $total += $deliveryFee;

        return $total;
    }

    private function sendOrderConfirmation(Order $order): void
    {
        // Integrazione con modulo Notify
        // Email/SMS di conferma
    }
}
```

#### 3.2 Data Objects
```php
<?php

namespace Modules\Meetup\Datas;

use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public ?int $user_id,
        public string $customer_name,
        public string $customer_email,
        public string $customer_phone,
        public string $delivery_address,
        public array $items,
        public ?string $notes = null
    ) {}
}
```

### Fase 4: API & Integrazioni (Settimana 4)

#### 4.1 API Routes
```php
<?php

use Illuminate\Support\Facades\Route;
use Modules\Meetup\Http\Controllers\Api\PizzaController;
use Modules\Meetup\Http\Controllers\Api\OrderController;
use Modules\Meetup\Http\Controllers\Api\CartController;

Route::prefix('api')->group(function () {
    // Menu API
    Route::get('/menu', [PizzaController::class, 'index']);
    Route::get('/pizza/{slug}', [PizzaController::class, 'show']);
    Route::get('/categories', [PizzaController::class, 'categories']);

    // Cart API
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/update/{itemKey}', [CartController::class, 'update']);
    Route::delete('/cart/remove/{itemKey}', [CartController::class, 'remove']);

    // Orders API
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
    Route::get('/orders/track/{orderNumber}', [OrderController::class, 'track']);
});
```

#### 4.2 Service Provider
```php
<?php

namespace Modules\Meetup\Providers;

use Illuminate\Support\ServiceProvider;

class MeetupServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'meetup');

        // Registra Livewire components
        \Livewire\Livewire::component('meetup::cart', \Modules\Meetup\Http\Livewire\Cart::class);
        \Livewire\Livewire::component('meetup::pizza-filter', \Modules\Meetup\Http\Livewire\PizzaFilter::class);
    }

    public function register(): void
    {
        // Registra Actions
        $this->app->singleton(\Modules\Meetup\Actions\CreateOrderAction::class);
        $this->app->singleton(\Modules\Meetup\Actions\CalculatePriceAction::class);
    }
}
```

### Fase 5: Admin Panel (Settimana 5)

#### 5.1 Filament Resources
```php
<?php

namespace Modules\Meetup\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Modules\Meetup\Models\Pizza;

class PizzaResource extends Resource
{
    protected static ?string $model = Pizza::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('base_price')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->directory('pizzas'),
                Forms\Components\Toggle::make('is_available')
                    ->default(true),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('base_price')
                    ->money('EUR'),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_available'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
```

## 🧪 Testing Strategy

### Unit Tests
```php
<?php

namespace Modules\Meetup\Tests\Unit;

use Tests\TestCase;
use Modules\Meetup\Actions\CreateOrderAction;
use Modules\Meetup\Datas\OrderData;

class CreateOrderActionTest extends TestCase
{
    public function test_it_creates_order_with_valid_data()
    {
        $orderData = new OrderData(
            user_id: null,
            customer_name: 'Mario Rossi',
            customer_email: 'mario@example.com',
            customer_phone: '+39 123 456 7890',
            delivery_address: 'Via Roma 123, Roma',
            items: [
                [
                    'pizza_id' => 1,
                    'quantity' => 2,
                    'unit_price' => 8.50,
                    'custom_ingredients' => []
                ]
            ]
        );

        $action = app(CreateOrderAction::class);
        $order = $action->execute($orderData);

        $this->assertNotNull($order);
        $this->assertEquals('pending', $order->status);
        $this->assertCount(1, $order->items);
    }
}
```

## 🚀 Deployment Checklist

### Pre-Produzione
- [ ] Configurazione ambiente produzione
- [ ] Migrazioni database
- [ ] Seeder dati iniziali
- [ ] Configurazione cache
- [ ] Configurazione queue
- [ ] SSL certificate
- [ ] Domain configuration

### Post-Produzione
- [ ] Monitoraggio errori
- [ ] Backup automatici
- [ ] Performance monitoring
- [ ] Security scanning
- [ ] Analytics setup

---

Questa guida fornisce un percorso completo per implementare tutte le funzionalità di laravelpizza.com seguendo le best practices Laravel e garantendo un'architettura scalabile e manutenibile.
