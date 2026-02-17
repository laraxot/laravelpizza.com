<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Cms\Database\Factories\ModuleFactory;
use Modules\Xot\Contracts\ProfileContract;
use Nwidart\Modules\Facades\Module as NwModule;
use Sushi\Sushi;

/**
 * Modules\Cms\Models\Module.
 *
 * @property string $id
 * @property string|null $name
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|Module newModelQuery()
 * @method static Builder<static>|Module newQuery()
 * @method static Builder<static>|Module query()
 * @method static Builder<static>|Module whereId($value)
 * @method static Builder<static>|Module whereName($value)
 * @method static int count()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static ModuleFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Module extends BaseModel
{
    use Sushi;

    /** @var list<string> */
    protected $fillable = [
        'id',
        'name',
    ];

    public function getRows(): array
    {
        $modules = NwModule::getByStatus(1);
        $rows = [];
        $i = 1;
        foreach ($modules as $module) {
            if (! is_object($module) || ! method_exists($module, 'getName')) {
                continue;
            }

            $tmp = [
                'id' => $i++,
                'name' => $module->getName(),
            ];
            $rows[] = $tmp;
        }

        return $rows;
    }

    /**
     * Undocumented function.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
