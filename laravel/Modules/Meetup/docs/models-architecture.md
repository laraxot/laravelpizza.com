# Architettura Modelli - Modulo Meetup

## 📋 Panoramica

Questo documento descrive l'architettura dei modelli Eloquent per il modulo Meetup, seguendo le convenzioni Laraxot e i pattern del progetto.

## 🏗️ Gerarchia Modelli

### BaseModel

Tutti i modelli del modulo Meetup estendono `Modules\Xot\Models\XotBaseModel` seguendo il pattern Laraxot.

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    /** @var string */
    protected $connection = 'meetup';

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'created_by' => 'string',
            'updated_by' => 'string',
        ];
    }
}
```

## 📦 Modelli Principali

### Category Model

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Meetup\Database\Factories\CategoryFactory;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;

class Category extends BaseModel
{
    use HasXotFactory;
    use Updater;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'order',
        'is_active',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);
    }

    /**
     * Relazione con pizze.
     *
     * @return HasMany<Pizza>
     */
    public function pizzas(): HasMany
    {
        return $this->hasMany(Pizza::class, 'category_id');
    }

    /**
     * Scope per categorie attive.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope per ordinamento.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
```

### Pizza Model

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Meetup\Database\Factories\PizzaFactory;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;

class Pizza extends BaseModel
{
    use HasXotFactory;
    use Updater;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'image',
        'category_id',
        'is_active',
        'is_featured',
        'stock_quantity',
        'preparation_time',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'stock_quantity' => 'integer',
            'preparation_time' => 'integer',
        ]);
    }

    /**
     * Relazione con categoria.
     *
     * @return BelongsTo<Category>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relazione many-to-many con ingredienti.
     *
     * @return BelongsToMany<Ingredient>
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'meetup_pizza_ingredient')
            ->withPivot(['is_removable', 'is_extra', 'order'])
            ->withTimestamps()
            ->orderByPivot('order');
    }

    /**
     * Relazione con order items.
     *
     * @return HasMany<OrderItem>
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'pizza_id');
    }

    /**
     * Scope per pizze attive.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope per pizze in evidenza.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope per categoria.
     */
    public function scopeByCategory($query, string $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Verifica disponibilità stock.
     */
    public function isAvailable(int $quantity = 1): bool
    {
        if ($this->stock_quantity === null) {
            return $this->is_active;
        }

        return $this->is_active && $this->stock_quantity >= $quantity;
    }

    /**
     * Calcola prezzo totale con modificatori.
     */
    public function calculatePrice(array $addedIngredients = [], array $removedIngredients = []): float
    {
        $price = (float) $this->price;

        // Aggiungi costo ingredienti extra
        foreach ($addedIngredients as $ingredient) {
            if (isset($ingredient['price'])) {
                $price += (float) $ingredient['price'];
            }
        }

        return $price;
    }
}
```

### Ingredient Model

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Meetup\Database\Factories\IngredientFactory;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;

class Ingredient extends BaseModel
{
    use HasXotFactory;
    use Updater;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_modifier',
        'is_available',
        'is_allergen',
        'allergen_type',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'price_modifier' => 'decimal:2',
            'is_available' => 'boolean',
            'is_allergen' => 'boolean',
        ]);
    }

    /**
     * Relazione many-to-many con pizze.
     *
     * @return BelongsToMany<Pizza>
     */
    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class, 'meetup_pizza_ingredient')
            ->withPivot(['is_removable', 'is_extra', 'order'])
            ->withTimestamps();
    }

    /**
     * Scope per ingredienti disponibili.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope per allergeni.
     */
    public function scopeAllergens($query)
    {
        return $query->where('is_allergen', true);
    }
}
```

### Order Model

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Meetup\Database\Factories\OrderFactory;
use Modules\User\Models\User;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;

class Order extends BaseModel
{
    use HasXotFactory;
    use Updater;

    /** @var array<int, string> */
    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'total',
        'subtotal',
        'tax',
        'delivery_fee',
        'delivery_address',
        'delivery_phone',
        'delivery_notes',
        'payment_method',
        'payment_status',
        'estimated_delivery_time',
        'delivered_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'total' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'tax' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'estimated_delivery_time' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ]);
    }

    /**
     * Relazione con utente.
     *
     * @return BelongsTo<User|null>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relazione con order items.
     *
     * @return HasMany<OrderItem>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Genera numero ordine univoco.
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');
        $sequence = self::whereDate('created_at', today())
            ->count() + 1;

        return sprintf('%s%s-%04d', $prefix, $date, $sequence);
    }

    /**
     * Scope per stato.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope per utente.
     */
    public function scopeForUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }
}
```

### OrderItem Model

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Meetup\Database\Factories\OrderItemFactory;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;

class OrderItem extends BaseModel
{
    use HasXotFactory;
    use Updater;

    /** @var array<int, string> */
    protected $fillable = [
        'order_id',
        'pizza_id',
        'quantity',
        'unit_price',
        'total_price',
        'customizations',
        'notes',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'customizations' => 'array',
        ]);
    }

    /**
     * Relazione con ordine.
     *
     * @return BelongsTo<Order>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Relazione con pizza.
     *
     * @return BelongsTo<Pizza>
     */
    public function pizza(): BelongsTo
    {
        return $this->belongsTo(Pizza::class, 'pizza_id');
    }
}
```

## 🎯 Pattern e Convenzioni

### 1. Uso di Traits

Tutti i modelli usano:
- `HasXotFactory`: Factory pattern Laraxot
- `Updater`: Tracciamento `created_by`/`updated_by`

### 2. Type Hints

- Sempre `declare(strict_types=1)`
- Type hints espliciti per relazioni
- PHPDoc completo per IDE support

### 3. Scopes

Scopes riutilizzabili per query comuni:
- `active()`: Record attivi
- `featured()`: Record in evidenza
- `byCategory()`: Filtro per categoria
- `byStatus()`: Filtro per stato

### 4. Accessors e Mutators

Usare accessors per dati derivati:

```php
/**
 * Get full image URL.
 */
public function getImageUrlAttribute(): ?string
{
    if (!$this->image) {
        return null;
    }

    return asset('storage/' . $this->image);
}
```

## 🔗 Collegamenti

- [Schema Database](./database-schema.md)
- [Business Logic](./business-logic.md)
- [Documentazione Xot Base](../../xot/docs/models/model_architecture.md)

## Foundation Plan 01-01: Core Event Relations

Per la foundation del modulo Meetup, il modello `Event` deve mantenere queste relazioni minime:

- `venue(): BelongsTo<Venue, $this>` su colonna `venue_id` (nullable)
- `performers(): BelongsToManyX<Performer, $this>` via pivot `event_performer`
- `sponsors(): BelongsToManyX<Sponsor, $this>` via pivot `event_sponsor`
- `users(): BelongsToManyX<User, $this>` via pivot `event_user` (registrazioni)

Allineamento FK richiesto sui pivot:

- `event_performer`: `event_id`, `performer_id`
- `event_sponsor`: `event_id`, `sponsor_id`
- `event_user`: `event_id`, `user_id`

Nota: per relazioni many-to-many nel contesto Laraxot usare sempre `belongsToManyX()` e non `belongsToMany()`.
