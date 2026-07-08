<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Sushi\Sushi;

/**
 * @property int                       $id
 * @property string|null               $name
 * @property ProfileContract|null      $creator
 * @property Collection<int, Province> $provinces
 * @property int|null                  $provinces_count
 * @property ProfileContract|null      $updater
 *
 * @method static RegionFactory          factory($count = null, $state = [])
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
    /** @use HasXotFactory<\Illuminate\Database\Eloquent\Factories\Factory<static>> */
    use HasXotFactory;
    use Sushi;

    /**
     * The factory class for this model.
     *
     * @var class-string<Factory<Region>>
     */
    protected static $factory = RegionFactory::class;

    /**
     * The data type of the primary key ID.
     */
    protected $keyType = 'integer';

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
    ];

    /** @return array<mixed> */
    public function getRows(): array
    {
        $rows = Comune::select('regione->codice as id', 'regione->nome as name')
            ->distinct()
            ->orderBy('regione->nome')
            ->get();

        return $rows->toArray();
    }

    /** @return HasMany<Province, $this> */
    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

    /** @return array<mixed> */
    public static function getOptions(Get $get): array
    {
        return self::orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
