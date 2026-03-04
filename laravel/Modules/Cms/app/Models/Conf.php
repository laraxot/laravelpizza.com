<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Cms\Database\Factories\ConfFactory;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * Modules\Cms\Models\Conf.
 *
 * @property int $id
 * @property string|null $name
 *
 * @method static Builder<static>|Conf newModelQuery()
 * @method static Builder<static>|Conf newQuery()
 * @method static Builder<static>|Conf query()
 * @method static Builder<static>|Conf whereId($value)
 * @method static Builder<static>|Conf whereName($value)
 * @method static int count()
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 *
 * @method static ConfFactory factory($count = null, $state = [])
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
        /* @var array<int, array{id: int, name: string}> $configNames */
        return app(GetTenantConfigNamesAction::class)->execute();
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
