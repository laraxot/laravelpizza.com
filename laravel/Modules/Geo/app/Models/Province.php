<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Modules\Geo\Database\Factories\ProvinceFactory;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Sushi\Sushi;

/**
 * @property int|null $region_id
 * @property int $id
 * @property string|null $name
 * @property ProfileContract|null $creator
 * @property Collection<int, Locality> $localities
 * @property int|null $localities_count
 * @property Region|null $region
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|Province newModelQuery()
 * @method static Builder<static>|Province newQuery()
 * @method static Builder<static>|Province query()
 * @method static Builder<static>|Province whereId($value)
 * @method static Builder<static>|Province whereName($value)
 * @method static Builder<static>|Province whereRegionId($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @method static ProvinceFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Province extends BaseModel
{
    use HasXotFactory;
    use Sushi;

    /** @var array<string, string> */
    protected array $schema = [
        'region_id' => 'integer',
        'id' => 'integer',
        'name' => 'string',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        if (! file_exists($path)) {
            return [];
        }

        $items = File::json($path);
        if (! is_array($items)) {
            return [];
        }

        /** @var array<string, array{region_id: mixed, id: mixed, name: string}> $unique */
        $unique = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $regione = $item['regione'] ?? null;
            $provincia = $item['provincia'] ?? null;
            if (! is_array($regione) || ! is_array($provincia)) {
                continue;
            }

            $regionId = $regione['codice'] ?? null;
            $id = $provincia['codice'] ?? null;
            $name = $provincia['nome'] ?? null;
            if ($regionId === null || $id === null || $name === null) {
                continue;
            }

            $key = SafeStringCastAction::cast($id);
            if (! isset($unique[$key])) {
                $unique[$key] = [
                    'region_id' => $regionId,
                    'id' => $id,
                    'name' => SafeStringCastAction::cast($name),
                ];
            }
        }

        $rows = array_values($unique);
        usort(
            $rows,
            static fn (array $a, array $b): int => strcmp(
                SafeStringCastAction::cast($a['name'] ?? ''),
                SafeStringCastAction::cast($b['name'] ?? ''),
            ),
        );

        return $rows;
    }

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

    /**
     * @return array<string, string>
     */
    public static function getOptions(Get $get): array
    {
        $region = $get('administrative_area_level_1') ?? $get('region');

        $keys = [];
        $values = [];

        foreach (self::where('region_id', $region)->orderBy('name')->get() as $item) {
            $keys[] = SafeStringCastAction::cast($item->id);
            $values[] = SafeStringCastAction::cast($item->name ?? '');
        }

        return array_combine($keys, $values) ?: [];
    }
}
