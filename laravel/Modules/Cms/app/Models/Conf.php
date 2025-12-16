<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

/**
 * Modules\Cms\Models\Conf.
 *
 * @property int         $id
 * @property string|null $name
 *
 * @method static Builder<static>|Conf newModelQuery()
 * @method static Builder<static>|Conf newQuery()
 * @method static Builder<static>|Conf query()
 * @method static Builder<static>|Conf whereId($value)
 * @method static Builder<static>|Conf whereName($value)
 * @method static int                  count()
 *
 * <<<<<<< HEAD
 *
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $deleter
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 *                                                                =======
 * @property \Modules\TechPlanner\Models\Profile|null    $creator
 * @property \Modules\TechPlanner\Models\Profile|null    $deleter
 * @property \Modules\TechPlanner\Models\Profile|null    $updater
 *                                                                >>>>>>> 46d657c (.)
 *
 * @method static \Modules\Cms\Database\Factories\ConfFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Conf extends BaseModel
{
    use Sushi;

    /** @var list<string> */
    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * @return array<int, array{id: int, name: string}>
     */
    public function getRows(): array
    {
        //  local/ptvx
        /** @var array<int, array{id: int, name: string}> $configNames */
        $configNames = TenantService::getConfigNames();

        return $configNames;
    }

    /*
     * protected function sushiShouldCache() {
     * return false;
     * }
     */
    /**
     * Undocumented function.
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
