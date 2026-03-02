# Geo Module - Immediate PHPStan Fixes

## Analysis Date: 2026-03-02
**Remaining Errors**: 10+ errors
**Priority**: HIGH

## Critical Fixes Required

### 1. Missing Static Methods in Models (8 errors)

#### Fix 1.1: Add getOptions() to Region Model
**Files**:
- `app/Models/Region.php` (UPDATE)
- `app/Filament/Resources/AddressResource.php:50, 100` (AFFECTED)

**Error**: Call to undefined static method `Region::getOptions()`

**Solution**:

Update `app/Models/Region.php`:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Database\Factories\RegionFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property-read Collection<int, Province> $provinces
 * @method static \Modules\Geo\Database\Factories\RegionFactory factory()
 */
class Region extends BaseModel
{
    protected $fillable = ['name', 'code'];

    /**
     * Get all regions as options for select fields.
     *
     * @return array<int, array{value: int, label: string}>
     */
    public static function getOptions(): array
    {
        return self::query()
            ->orderBy('name')
            ->get()
            ->map(fn (Region $region) => [
                'value' => $region->id,
                'label' => $region->name,
            ])
            ->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Province, $this>
     */
    public function provinces(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Province::class);
    }

    /**
     * @return \Modules\Geo\Database\Factories\RegionFactory
     */
    protected static function newFactory(): \Modules\Geo\Database\Factories\RegionFactory
    {
        return \Modules\Geo\Database\Factories\RegionFactory::new();
    }
}
```

#### Fix 1.2: Add getOptions() to Province Model
**Files**:
- `app/Models/Province.php` (UPDATE)
- `app/Filament/Resources/AddressResource.php:61, 111` (AFFECTED)

**Error**: Call to undefined static method `Province::getOptions()`

**Solution**:

Update `app/Models/Province.php`:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Database\Factories\ProvinceFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $region_id
 * @property-read Region $region
 * @property-read Collection<int, Locality> $localities
 * @method static \Modules\Geo\Database\Factories\ProvinceFactory factory()
 */
class Province extends BaseModel
{
    protected $fillable = ['name', 'code', 'region_id'];

    /**
     * Get all provinces as options for select fields.
     *
     * @param int|null $regionId Optional region ID to filter by
     * @return array<int, array{value: int, label: string}>
     */
    public static function getOptions(?int $regionId = null): array
    {
        $query = self::query()->orderBy('name');

        if ($regionId !== null) {
            $query->where('region_id', $regionId);
        }

        return $query
            ->get()
            ->map(fn (Province $province) => [
                'value' => $province->id,
                'label' => $province->name,
            ])
            ->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Region, $this>
     */
    public function region(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Locality, $this>
     */
    public function localities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Locality::class);
    }

    /**
     * @return \Modules\Geo\Database\Factories\ProvinceFactory
     */
    protected static function newFactory(): \Modules\Geo\Database\Factories\ProvinceFactory
    {
        return \Modules\Geo\Database\Factories\ProvinceFactory::new();
    }
}
```

#### Fix 1.3: Add getOptions() and getPostalCodeOptions() to Locality Model
**Files**:
- `app/Models/Locality.php` (UPDATE)
- `app/Filament/Resources/AddressResource.php:73, 84, 126, 136` (AFFECTED)

**Error**: Call to undefined static methods `Locality::getOptions()` and `Locality::getPostalCodeOptions()`

**Solution**:

Update `app/Models/Locality.php`:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Database\Factories\LocalityFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $postal_code
 * @property int $province_id
 * @property-read Province $province
 * @method static \Modules\Geo\Database\Factories\LocalityFactory factory()
 */
class Locality extends BaseModel
{
    protected $fillable = ['name', 'postal_code', 'province_id'];

    /**
     * Get all localities as options for select fields.
     *
     * @param int|null $provinceId Optional province ID to filter by
     * @return array<int, array{value: int, label: string}>
     */
    public static function getOptions(?int $provinceId = null): array
    {
        $query = self::query()->orderBy('name');

        if ($provinceId !== null) {
            $query->where('province_id', $provinceId);
        }

        return $query
            ->get()
            ->map(fn (Locality $locality) => [
                'value' => $locality->id,
                'label' => $locality->name,
            ])
            ->all();
    }

    /**
     * Get all localities with postal codes as options.
     *
     * @param int|null $provinceId Optional province ID to filter by
     * @return array<int, array{value: int, label: string}>
     */
    public static function getPostalCodeOptions(?int $provinceId = null): array
    {
        $query = self::query()
            ->orderBy('postal_code')
            ->orderBy('name');

        if ($provinceId !== null) {
            $query->where('province_id', $provinceId);
        }

        return $query
            ->get()
            ->map(fn (Locality $locality) => [
                'value' => $locality->id,
                'label' => "{$locality->postal_code} - {$locality->name}",
            ])
            ->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Province, $this>
     */
    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * @return \Modules\Geo\Database\Factories\LocalityFactory
     */
    protected static function newFactory(): \Modules\Geo\Database\Factories\LocalityFactory
    {
        return \Modules\Geo\Database\Factories\LocalityFactory::new();
    }
}
```

### 2. Type Issues in Address Model (2 errors)

#### Fix 2.1: Fix Unresolvable Return Types in Address Model
**File**: `app/Models/Address.php:176, 198`
**Error**: Return type of call to method `Collection::map()` contains unresolvable type

**Solution**:

Update `app/Models/Address.php`:
```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $street
 * @property string $number
 * @property string|null $postal_code
 * @property int $locality_id
 * @property-read Locality $locality
 * @method static \Modules\Geo\Database\Factories\AddressFactory factory()
 */
class Address extends BaseModel
{
    protected $fillable = [
        'street',
        'number',
        'postal_code',
        'locality_id',
    ];

    /**
     * Get the locality for this address.
     *
     * @return BelongsTo<Locality, $this>
     */
    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    /**
     * Get formatted address with comune name.
     *
     * @return string
     */
    public function getFormattedAddress(): string
    {
        return sprintf(
            '%s %s, %s',
            $this->street,
            $this->number,
            $this->locality->name ?? ''
        );
    }

    /**
     * Get available comuni for this address.
     *
     * @return array<int, array{value: int, label: string}>
     */
    public function getAvailableComuni(): array
    {
        $comuni = $this->locality?->province?->region?->localities ?? Collection::empty();

        return $comuni
            ->map(fn (Locality $comune): array => [
                'value' => $comune->id,
                'label' => $comune->name,
            ])
            ->all();
    }

    /**
     * Get available comuni with region filtering.
     *
     * @param int|null $regionId
     * @return array<int, array{value: int, label: string}>
     */
    public function getAvailableComuniByRegion(?int $regionId = null): array
    {
        $query = Locality::query()->orderBy('name');

        if ($regionId !== null) {
            $query->whereHas('province', fn ($q) => $q->where('region_id', $regionId));
        }

        /** @var Collection<int, Locality> $comuni */
        $comuni = $query->get();

        return $comuni
            ->map(fn (Locality $comune): array => [
                'value' => $comune->id,
                'label' => $comune->name,
            ])
            ->all();
    }

    /**
     * @return \Modules\Geo\Database\Factories\AddressFactory
     */
    protected static function newFactory(): \Modules\Geo\Database\Factories\AddressFactory
    {
        return \Modules\Geo\Database\Factories\AddressFactory::new();
    }
}
```

### 3. Update Filament Resource to Use Static Methods

#### Fix 3.1: Update AddressResource
**File**: `app/Filament/Resources/AddressResource.php`

**Solution**:

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Modules\Geo\Models\Address;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Tables\Forms\Form $form): Tables\Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('street')
                    ->required()
                    ->maxLength(255),

                TextInput::make('number')
                    ->required()
                    ->maxLength(20),

                TextInput::make('postal_code')
                    ->maxLength(10),

                Select::make('region_id')
                    ->label('Region')
                    ->options(\Modules\Geo\Models\Region::getOptions())
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('province_id', null)),

                Select::make('province_id')
                    ->label('Province')
                    ->options(function (callable $get) {
                        $regionId = $get('region_id');
                        return \Modules\Geo\Models\Province::getOptions($regionId);
                    })
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('locality_id', null)),

                Select::make('locality_id')
                    ->label('Locality')
                    ->options(function (callable $get) {
                        $provinceId = $get('province_id');
                        return \Modules\Geo\Models\Locality::getOptions($provinceId);
                    })
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('locality.name')
                    ->label('Locality')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('region')
                    ->relationship('locality.province.region', 'name')
                    ->options(\Modules\Geo\Models\Region::getOptions()),

                Tables\Filters\SelectFilter::make('province')
                    ->relationship('locality.province', 'name')
                    ->options(function () {
                        return \Modules\Geo\Models\Province::getOptions();
                    }),

                Tables\Filters\SelectFilter::make('locality')
                    ->relationship('locality', 'name')
                    ->options(function () {
                        return \Modules\Geo\Models\Locality::getOptions();
                    }),
            ]);
    }
}
```

## Implementation Order

### Day 1: Static Methods
1. Add getOptions() to Region model
2. Add getOptions() to Province model
3. Add getOptions() and getPostalCodeOptions() to Locality model

### Day 2: Type Fixes
4. Fix unresolvable return types in Address model
5. Update AddressResource to use static methods

### Day 3: Testing
6. Create tests for static methods
7. Test Filament resource functionality
8. Run PHPStan validation

## Testing Strategy

```php
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Locality;

test('region getOptions returns correct format', function () {
    Region::factory()->create(['name' => 'Test Region']);

    $options = Region::getOptions();

    expect($options)->toBeArray();
    expect($options[0])->toHaveKeys(['value', 'label']);
});

test('province getOptions filters by region', function () {
    $region = Region::factory()->create();
    $province = Province::factory()->for($region)->create();
    Province::factory()->create(); // Other province

    $options = Province::getOptions($region->id);

    expect($options)->toHaveCount(1);
    expect($options[0]['value'])->toBe($province->id);
});

test('locality getPostalCodeOptions includes postal code', function () {
    $locality = Locality::factory()->create(['postal_code' => '12345']);

    $options = Locality::getPostalCodeOptions();

    expect($options[0]['label'])->toContain('12345');
});

test('address getAvailableComuni returns correct format', function () {
    $address = Address::factory()->create();

    $comuni = $address->getAvailableComuni();

    expect($comuni)->toBeArray();
    expect($comuni[0])->toHaveKeys(['value', 'label']);
});
```

## Success Criteria

✅ All 10+ PHPStan errors resolved
✅ All static methods work correctly
✅ Filament resource functions properly
✅ All tests pass
✅ No regressions in other modules

## Notes

- Static methods should return arrays with `value` and `label` keys for Filament compatibility
- All methods should have proper type annotations
- Optional parameters should be nullable with proper default values
- Filament filters should use the same static methods for consistency

---

**Status**: Ready for Implementation
**Estimated Time**: 3 days
**Priority**: HIGH