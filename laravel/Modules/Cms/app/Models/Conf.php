<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * Modules\Cms\Models\Conf.
 *
 * @property string               $id
 * @property string|null          $name
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|Conf newModelQuery()
 * @method static Builder<static>|Conf newQuery()
 * @method static Builder<static>|Conf query()
 * @method static Builder<static>|Conf whereId($value)
 * @method static Builder<static>|Conf whereName($value)
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
