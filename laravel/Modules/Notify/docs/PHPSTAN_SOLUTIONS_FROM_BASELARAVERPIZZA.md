# PHPStan Solutions from base_laravelpizza - 2026-03-02

## Overview
Documentazione completa delle soluzioni PHPStan studiate da `base_laravelpizza` per risolvere i 138 errori rimanenti in `base_fixcity_fila5`.

## Pattern Chiave Identificati

### 1. Metodo getOptions() per Filament Select Fields

**Problema**: 13 errori `staticMethod.notFound` in Geo module
```
Call to an undefined static method Modules\Geo\Models\Region::getOptions()
Call to an undefined static method Modules\Geo\Models\Province::getOptions()
Call to an undefined static method Modules\Geo\Models\Locality::getOptions()
```

**Soluzione da base_laravelpizza**:
```php
class Province extends BaseModel
{
    public static function getOptions(Get $get): array
    {
        $region = $get('administrative_area_level_1') ?? $get('region');

        return self::where('region_id', $region)
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
```

**Implementazione per Fixcity**:
```php
class Ticket extends BaseModel
{
    /**
     * Get ticket status options for Filament select
     */
    public static function getOptions(): array
    {
        return self::query()
            ->select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status', 'status')
            ->toArray();
    }
}
```

### 2. Annotazione @mixin \Eloquent per Metodi Mancanti

**Problema**: Metodi Eloquent non riconosciuti in modelli che estendono classi base

**Soluzione da base_laravelpizza**:
```php
/**
 * @property int $id
 * @property string $name
 * @property Region|null $region
 * @property Collection<int, Locality> $localities
 * @method static Builder<static>|Province newModelQuery()
 * @method static Builder<static>|Province newQuery()
 * @method static Builder<static>|Province query()
 * @method static Builder<static>|Province whereId($value)
 * @method static Builder<static>|Province whereName($value)
 * @method static ProvinceFactory factory($count = null, $state = [])
 * @mixin \Eloquent  // ← CRITICAL!
 */
class Province extends BaseModel
{
    use HasXotFactory;
}
```

### 3. Relazioni Eloquent con Tipi Generici Completi

**Problema**: `Unable to resolve the template type TRelatedModel`

**Soluzione da base_laravelpizza**:
```php
/**
 * @return BelongsTo<Region, $this>
 */
public function region(): BelongsTo
{
    return $this->belongsTo(Region::class);
}

/**
 * @return HasMany<Locality, $this>
 */
public function localities(): HasMany
{
    return $this->hasMany(Locality::class);
}
```

### 4. Relazioni con withTrashed()

**Problema**: `Call to an undefined method ::withTrashed()`

**Soluzione**:
```php
/**
 * @return BelongsTo<Ticket, $this>
 */
public function ticket(): BelongsTo
{
    return $this->belongsTo(Ticket::class);
}

// Quando serve withTrashed, usare direttamente sul risultato:
$ticket = $this->ticket()->withTrashed()->first();
```

### 5. Metodi Mancanti nel Modello

**Problema**: `Call to an undefined method Ticket::setStatus()`

**Soluzione**: Aggiungere i metodi mancanti
```php
class Ticket extends BaseModel
{
    /**
     * Set ticket status
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        $this->save();

        return $this;
    }

    /**
     * Get ticket comments
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }

    /**
     * Get ticket activities
     */
    public function activities(): HasMany
    {
        return $this->hasMany(TicketActivity::class);
    }
}
```

### 6. Anonymous Functions con Return Type

**Problema**: `Anonymous function should return Modules\Fixcity\Models\Ticket but returns mixed`

**Soluzione da base_laravelpizza**:
```php
// PRIMA
$factory = fn($ticket) => $this->createTicket($ticket);

// DOPO
$factory = static fn(array $ticket): Ticket => 
    Ticket::query()->create($ticket);
```

### 7. Collection::map() con Return Type Esplicito

**Problema**: `Return type contains unresolvable type`

**Soluzione da base_laravelpizza**:
```php
// PRIMA
$comuni = $query->get();
return $comuni->map(fn($c) => ['value' => $c->id, 'label' => $c->name])->toArray();

// DOPO
/** @var Collection<int, Comune> $comuni */
$comuni = $query->get();
return $comuni->map(fn(Comune $c): array => 
    ['value' => $c->id, 'label' => $c->name]
)->toArray();
```

### 8. Accesso a Proprietà Non Definite

**Problema**: `Access to an undefined property Ticket::$assignee`

**Soluzione**: Aggiungere proprietà al modello o PHPDoc
```php
/**
 * @property int|null $assignee_id
 * @property User|null $assignee
 */
class Ticket extends BaseModel
{
    /**
     * Get ticket assignee
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
```

### 9. Parametri Array in Filament

**Problema**: `Parameter $components expects non-empty-array given`

**Soluzione**:
```php
// PRIMA
$widget->schema($schema);

// DOPO
if (empty($schema)) {
    $schema = [];
}
$widget->schema($schema);
```

### 10. Credential Array per Auth::attempt()

**Problema**: `Parameter $credentials of Auth::attempt() expects array, array|null given`

**Soluzione**:
```php
// PRIMA
$credentials = $this->form->getState();
Auth::attempt($credentials);

// DOPO
$credentials = $this->form->getState();
if (!is_array($credentials)) {
    $credentials = [];
}
Auth::attempt($credentials);
```

## Soluzioni per SushiToJson Trait

### Problema Principale
Il trait `SushiToJson` chiama metodi che non esistono nei modelli che lo usano:
```
Call to an undefined method Modules\Geo\Models\Comune::getJsonFile()
Call to an undefined method Modules\Geo\Models\Comune::loadExistingData()
Call to an undefined method Modules\Geo\Models\Comune::authId()
Call to an undefined method Modules\Geo\Models\Comune::saveToJson()
```

### Soluzione: Aggiungere metodi helper al modello o trait base

```php
trait SushiModelHelper
{
    /**
     * Get JSON file path
     */
    protected function getJsonFile(): string
    {
        $path = database_path('data/' . static::class . '.json');
        if (!file_exists($path)) {
            $path = database_path('data/' . class_basename(static::class) . '.json');
        }

        return $path;
    }

    /**
     * Load existing data from JSON
     */
    protected function loadExistingData(): array
    {
        if (!file_exists($this->getJsonFile())) {
            return [];
        }

        $content = file_get_contents($this->getJsonFile());
        if ($content === false) {
            return [];
        }

        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    /**
     * Get authentication ID
     */
    protected function authId(): ?string
    {
        return auth()->id()?->toString();
    }

    /**
     * Save data to JSON
     */
    protected function saveToJson(array $data): void
    {
        $this->ensureDirectoryExists();
        file_put_contents($this->getJsonFile(), json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Ensure directory exists
     */
    protected function ensureDirectoryExists(): void
    {
        $dir = dirname($this->getJsonFile());
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    /**
     * Find row index by ID
     */
    protected function findRowIndexById(int $id): int|false
    {
        $data = $this->loadExistingData();
        foreach ($data as $index => $row) {
            if (isset($row['id']) && (int)$row['id'] === $id) {
                return $index;
            }
        }

        return false;
    }
}
```

### Aggiungere trait ai modelli
```php
class Comune extends BaseModel
{
    use Sushi;
    use SushiModelHelper; // ← Aggiungere questo trait

    // ... resto del codice
}
```

## Soluzione per Collection Types

### Problema
```
Parameter #1 $items expects Arrayable|iterable, 
Modules\Fixcity\Models\Collection<int, Modules\Fixcity\Models\User> given
```

### Soluzione
```php
// PRIMA
$users = User::all();
return $collection->merge($users);

// DOPO
$users = User::all();
return $collection->merge($users->all()); // Chiama all() per ottenere Collection standard
```

## Soluzione per Filament Schema Components

### Problema
```
Parameter #1 $components expects array<Htmlable|string>|Closure, non-empty-array given
```

### Soluzione
```php
// PRIMA
public function schema(): array
{
    return $this->getFormSchema();
}

// DOPO
public function schema(): array
{
    $schema = $this->getFormSchema();
    return $schema ?: []; // Assicura che sia sempre un array
}
```

## Roadmap di Implementazione

### Fase 1: Aggiungere getOptions() ai moduli Geo (Immediata)
1. Aggiungere `getOptions()` a Region
2. Aggiungere `getOptions()` a Province
3. Aggiungere `getOptions()` a Locality
4. Aggiungere `getPostalCodeOptions()` a Locality

### Fase 2: Correggere relazioni in Fixcity (Settimana 1)
1. Aggiungere tipo generici a Ticket::belongsTo()
2. Aggiungere tipo generici a Ticket::belongsToMany()
3. Aggiungere metodo ticket() con tipo corretto
4. Aggiungere metodi mancanti: setStatus(), comments(), activities()

### Fase 3: Correggere SushiToJson (Settimana 2)
1. Creare trait SushiModelHelper
2. Aggiungere trait a tutti i modelli che usano Sushi
3. Testare salvataggio/caricamento JSON

### Fase 4: Correggere problemi di tipo misto (Settimana 2)
1. Aggiungere controlli di tipo in seeders
2. Aggiungere return type alle anonymous functions
3. Correggere Collection::map() con @var annotations

### Fase 5: Filament e altri problemi (Settimana 3)
1. Correggere schema components in Filament widgets
2. Correggere credential array in Login
3. Correggere property types in View Components

## Success Metrics

| Metrica | Before | After | Target |
|---------|--------|-------|--------|
| **Errori Totali** | 138 | 0 | 0 |
| **Static Methods** | 13 | 0 | 0 |
| **Relazioni** | 4 | 0 | 0 |
| **Metodi Mancanti** | 10+ | 0 | 0 |
| **Tipo Misto** | 15+ | 0 | 0 |

## Risorse Riferimento

### Documentazione base_laravelpizza
- `/var/www/_bases/base_laravelpizza/bashscripts/docs/phpstan_level10_fixes.md`
- `/var/www/_bases/base_laravelpizza/bashscripts/docs/phpstan_errors_corrections.md`
- `/var/www/_bases/base_laravelpizza/bashscripts/docs/phpstan-fixes-summary.md`

### Modelli Esempio
- `Modules/Geo/app/Models/Province.php` - getOptions() pattern
- `Modules/Xot/app/Models/HealthCheckResultHistoryItem.php` - @mixin pattern

---

**Status**: READY FOR IMPLEMENTATION
**Priority**: HIGH
**Estimated Time**: 3-4 weeks