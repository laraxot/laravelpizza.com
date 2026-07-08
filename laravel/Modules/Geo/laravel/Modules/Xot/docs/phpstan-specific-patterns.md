# Pattern Specifici PHPStan Level 10

Questo documento raccoglie pattern specifici per risolvere errori PHPStan a livello 10, complementare alla guida generale.

## 🔧 Patterns di Correzione

### 1. Carbon createFromFormat (Carbon|null vs Carbon|false)
```php
// ✅ CORRETTO - L'estensione Carbon restituisce Carbon|null
$targetMonth = Carbon::createFromFormat('Y-m', $month);
if ($targetMonth === null) {
    $targetMonth = now()->startOfMonth();
} else {
    $targetMonth = $targetMonth->startOfMonth();
}
```

### 2. Type Narrowing con Assert
```php
use Webmozart\Assert\Assert;

// ✅ CORRETTO
if (is_array($data)) {
    Assert::isArray($data);
    $value = $data['key'] ?? null;
}
```

### 3. Cast Actions Centralizzate
```php
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// ✅ CORRETTO
$data = SafeArrayCastAction::cast($input);
$title = SafeStringCastAction::cast($mod->title);
```

### 4. Array Associativi Filament
```php
// ❌ ERRORE - array<int, Action>
public function getTableActions(): array
{
    return [EditAction::make(), DeleteAction::make()];
}

// ✅ CORRETTO - array<string, mixed>
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

### 5. Property Access su Mixed (Eloquent)
```php
// ❌ ERRORE - property_exists() NON funziona con magic attributes
if (property_exists($model, 'attribute')) {
    $value = $model->attribute;
}

// ✅ CORRETTO - usa isset() per magic attributes
if (isset($model->attribute)) {
    $value = $model->attribute;
}

// ✅ ANCHE CORRETTO - validazione multipla
if (is_object($model) && isset($model->attribute)) {
    $value = $model->attribute;
}
```

### 6. Casts Completi per Properties
```php
// ✅ CORRETTO - Tutte le properties usate DEVONO essere nei casts()
protected function casts(): array
{
    return [
        'auto_cleanup_num' => 'integer',
        'auto_cleanup_type' => 'string',
        'notification_email_address' => 'string',
    ];
}
```

### 7. HasXotFactory NON è Generico
```php
// ❌ ERRORE - HasXotFactory NON accetta generics
/** @use HasXotFactory<TFactory> */
use HasXotFactory;

// ✅ CORRETTO - Rimuovi generics
use HasXotFactory;
```

### 8. Notification via() Return Type
```php
// ❌ ERRORE - list<string>
public function via($notifiable): array
{
    return ['mail', 'nexmo'];
}

// ✅ CORRETTO - array<string, mixed>
/**
 * @return array<string, mixed>
 */
public function via($notifiable): array
{
    return [
        'mail' => 'mail',
        'nexmo' => 'nexmo',
    ];
}
```

### 9. Relazioni Eloquent con Generics
```php
// ✅ CORRETTO - Generics solo in PHPDoc
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @return HasMany<Post>
 */
public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}
```

### 10. Factory Typing
```php
// ✅ CORRETTO
/**
 * @var \Illuminate\Database\Eloquent\Factories\Factory<Model> $factory
 */
$factory = Model::factory();
Assert::object($factory);
Assert::methodExists($factory, 'create');
$result = $factory->create($data);
```

### 11. Builder Type Hints con PHPDoc
```php
// ✅ CORRETTO - Type hint per query builder
/**
 * @param  \Illuminate\Database\Eloquent\Builder<\Modules\Limesurvey\Models\SurveyResponse>  $query
 */
private function applyFilters(\Illuminate\Database\Eloquent\Builder $query): void
{
    $query->where('status', 'active');
}

// ✅ ANCHE CORRETTO - PHPDoc per variabile
/** @var \Illuminate\Database\Eloquent\Builder<\Modules\User\Models\User> $query */
$query = User::query()->where('active', true);
```
