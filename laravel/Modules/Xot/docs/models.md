# Modelli

## Configurazione Base

### Model
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

### Data Object
```php
namespace App\Data;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            name: $user->name,
            email: $user->email,
        );
    }
}
```

## Modelli Base

### Model con Relazioni
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
```

### Model con Scope
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'status',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeExpensive(Builder $query): Builder
    {
        return $query->where('price', '>', 100);
    }
}
```

## Best Practices

### 1. Struttura
- Organizzare per dominio
- Utilizzare i trait
- Documentare i modelli
- Gestire le relazioni

### 2. Performance
- Ottimizzare le query
- Utilizzare il caching
- Implementare il lazy loading
- Monitorare i modelli

### 3. Sicurezza
- Validare i dati
- Proteggere i modelli
- Implementare il logging
- Gestire i fallimenti

### 4. Manutenzione
- Monitorare i modelli
- Gestire le versioni
- Implementare alerting
- Documentare i modelli

## Esempi di Utilizzo

### Model con Eventi
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    protected static function booted()
    {
        static::created(function ($order) {
            // Logica dopo la creazione
        });

        static::updated(function ($order) {
            // Logica dopo l'aggiornamento
        });

        static::deleted(function ($order) {
            // Logica dopo l'eliminazione
        });
    }
}
```

### Model con Accessor e Mutator
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    public function getFormattedPriceAttribute(): string
    {
        return '€' . number_format($this->price, 2);
    }

    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = $value * 100;
    }
}
```

## Strumenti Utili

### Comandi Artisan
```bash
# Creare un modello
php artisan make:model Product

# Creare un modello con migrazione
php artisan make:model Product -m

# Creare un modello con controller
php artisan make:model Product -c
```

### Factory
```php
namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
```

## Gestione degli Errori

### Errori di Model
```php
try {
    $product = Product::create([
        'name' => 'Test Product',
        'price' => 100,
    ]);
} catch (\Exception $e) {
    Log::error('Errore nella creazione del prodotto', [
        'error' => $e->getMessage(),
    ]);
    
    throw $e;
}
```

### Logging
```php
use Illuminate\Support\Facades\Log;

protected static function booted()
{
    static::created(function ($model) {
        Log::info('Modello creato', [
            'model' => get_class($model),
            'id' => $model->id,
        ]);
    });
}
```

## Modelli Avanzati

### Model con Soft Delete
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
}
```

### Model con Polimorfismo
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
``` 