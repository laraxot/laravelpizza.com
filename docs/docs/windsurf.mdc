---
description:
globs:
alwaysApply: false
---
# Entità Geografiche - Windsurf

## Overview
Le entità geografiche sono state centralizzate nel modulo Geo per seguire i principi di DRY e Single Responsibility. Questo documento descrive come utilizzare queste entità in Windsurf.

## Modelli

### Region
```php
use Modules\Geo\Models\Region;

// Recupero di una regione
$region = Region::find(1);

// Recupero con relazioni
$region = Region::with('provinces.cities.caps')->find(1);

// Creazione
$region = Region::create([
    'name' => 'Lombardia',
    'code' => 'LO'
]);
```

### Province
```php
use Modules\Geo\Models\Province;

// Recupero di una provincia
$province = Province::find(1);

// Recupero con relazioni
$province = Province::with('region', 'cities.caps')->find(1);

// Creazione
$province = Province::create([
    'name' => 'Milano',
    'code' => 'MI',
    'region_id' => 1
]);
```

### City
```php
use Modules\Geo\Models\City;

// Recupero di una città
$city = City::find(1);

// Recupero con relazioni
$city = City::with('province.region', 'caps')->find(1);

// Creazione
$city = City::create([
    'name' => 'Milano',
    'province_id' => 1
]);
```

### Cap
```php
use Modules\Geo\Models\Cap;

// Recupero di un CAP
$cap = Cap::find(1);

// Recupero con relazioni
$cap = Cap::with('city.province.region')->find(1);

// Creazione
$cap = Cap::create([
    'code' => '20100',
    'city_id' => 1
]);
```

## Query Builder

### Ricerca per Nome
```php
$regions = Region::where('name', 'like', '%Lomb%')->get();
$provinces = Province::where('name', 'like', '%Mil%')->get();
$cities = City::where('name', 'like', '%Mil%')->get();
```

### Ricerca per Codice
```php
$region = Region::where('code', 'LO')->first();
$province = Province::where('code', 'MI')->first();
$cap = Cap::where('code', '20100')->first();
```

### Ricerca Gerarchica
```php
// Trova tutte le città di una regione
$cities = City::whereHas('province.region', function($query) {
    $query->where('code', 'LO');
})->get();

// Trova tutti i CAP di una provincia
$caps = Cap::whereHas('city.province', function($query) {
    $query->where('code', 'MI');
})->get();
```

## Relazioni

### One-to-Many
```php
// Da Region a Province
$provinces = $region->provinces;

// Da Province a City
$cities = $province->cities;

// Da City a Cap
$caps = $city->caps;
```

### Belongs-To
```php
// Da Province a Region
$region = $province->region;

// Da City a Province
$province = $city->province;

// Da Cap a City
$city = $cap->city;
```

## Eager Loading

### Caricamento Completo
```php
$regions = Region::with([
    'provinces.cities.caps',
    'provinces.cities' => function($query) {
        $query->orderBy('name');
    }
])->get();
```

### Caricamento Condizionale
```php
$regions = Region::with(['provinces' => function($query) {
    $query->where('code', 'MI');
}])->get();
```

## Validazione

### Rules
```php
$rules = [
    'name' => 'required|string|max:255',
    'code' => 'required|string|size:2|unique:regions,code',
    'region_id' => 'required|exists:regions,id'
];
```

### Custom Validation
```php
use Illuminate\Validation\Rule;

$rules = [
    'code' => [
        'required',
        'string',
        'size:2',
        Rule::unique('provinces')->where(function ($query) {
            return $query->where('region_id', $this->region_id);
        })
    ]
];
```

## Eventi

### Model Events
```php
Region::creating(function($region) {
    $region->code = strtoupper($region->code);
});

Province::saving(function($province) {
    $province->code = strtoupper($province->code);
});
```

### Observers
```php
class RegionObserver
{
    public function creating(Region $region)
    {
        $region->code = strtoupper($region->code);
    }
}
```

## Scopes

### Local Scopes
```php
public function scopeInRegion($query, $regionCode)
{
    return $query->whereHas('region', function($q) use ($regionCode) {
        $q->where('code', $regionCode);
    });
}
```

### Global Scopes
```php
protected static function booted()
{
    static::addGlobalScope('active', function ($query) {
        $query->where('active', true);
    });
}
```

## Collections

### Filtering
```php
$regions = Region::all()->filter(function($region) {
    return $region->provinces->count() > 5;
});
```

### Mapping
```php
$regionNames = Region::all()->map(function($region) {
    return [
        'id' => $region->id,
        'name' => $region->name,
        'province_count' => $region->provinces->count()
    ];
});
```

## API Resources

### Single Resource
```php
class RegionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'provinces' => ProvinceResource::collection($this->provinces)
        ];
    }
}
```

### Collection Resource
```php
class RegionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->collection->count()
            ]
        ];
    }
}
```

## Testing

### Unit Tests
```php
public function test_region_has_provinces()
{
    $region = Region::factory()->create();
    $province = Province::factory()->create(['region_id' => $region->id]);
    
    $this->assertTrue($region->provinces->contains($province));
}
```

### Feature Tests
```php
public function test_can_create_region_with_province()
{
    $response = $this->postJson('/api/regions', [
        'name' => 'Lombardia',
        'code' => 'LO',
        'provinces' => [
            ['name' => 'Milano', 'code' => 'MI']
        ]
    ]);
    
    $response->assertStatus(201);
    $this->assertDatabaseHas('regions', ['code' => 'LO']);
    $this->assertDatabaseHas('provinces', ['code' => 'MI']);
}
```

## Performance

### Indici
```php
Schema::table('provinces', function (Blueprint $table) {
    $table->index(['region_id', 'code']);
});
```

### Caching
```php
$regions = Cache::remember('regions', 3600, function () {
    return Region::with('provinces')->get();
});
```

### Chunking
```php
Region::chunk(100, function ($regions) {
    foreach ($regions as $region) {
        // Process
    }
});
```

## Security

### Mass Assignment
```php
protected $fillable = [
    'name',
    'code',
    'region_id'
];
```

### Hidden Attributes
```php
protected $hidden = [
    'created_at',
    'updated_at'
];
```

### Accessors & Mutators
```php
public function getFullNameAttribute()
{
    return "{$this->name} ({$this->code})";
}

public function setCodeAttribute($value)
{
    $this->attributes['code'] = strtoupper($value);
}
```
