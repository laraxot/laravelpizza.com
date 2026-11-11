<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Sushi\Sushi;

/**
 * @property int $id
 * @property string|null $name
 * @property ProfileContract|null $creator
 * @property Collection<int, Province> $provinces
 * @property int|null $provinces_count
 * @property ProfileContract|null $updater
 *
 * @method static RegionFactory factory($count = null, $state = [])
 * @method static Builder<static>|Region newModelQuery()
 * @method static Builder<static>|Region newQuery()
 * @method static Builder<static>|Region query()
 * @method static Builder<static>|Region whereId($value)
 * @method static Builder<static>|Region whereName($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class Region extends BaseModel
{
    use HasXotFactory;
    use Sushi;

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /** @var array<string, string> */
    protected array $schema = [
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

        /** @var array<string, array{id: mixed, name: string}> $unique */
        $unique = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $regione = $item['regione'] ?? null;
            if (is_string($regione)) {
                $id = $regione;
                $name = $regione;
            } elseif (is_array($regione)) {
                $id = $regione['codice'] ?? null;
                $name = $regione['nome'] ?? null;
            } else {
                continue;
            }

            if ($id === null || $name === null) {
                continue;
            }

            $key = SafeStringCastAction::cast($id);
            if (! isset($unique[$key])) {
                $unique[$key] = [
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
     * @return HasMany<Province, $this>
     */
    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

    /**
     * @return array<string, string>
     */
    public static function getOptions(Get $get): array
    {
        $keys = [];
        $values = [];

        foreach (self::orderBy('name')->get() as $item) {
            $keys[] = SafeStringCastAction::cast($item->id);
            $values[] = SafeStringCastAction::cast($item->name ?? '');
        }

        return array_combine($keys, $values) ?: [];
    }
}
