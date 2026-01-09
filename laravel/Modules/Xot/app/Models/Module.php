<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Database\Factories\ModuleFactory;
use Nwidart\Modules\Facades\Module as ModuleFacade;
use Nwidart\Modules\Module as NModule;
use function Safe\json_encode;
use Sushi\Sushi;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $status
 * @property int|null $priority
 * @property string|null $path
 * @property string|null $icon
 * @property array<array-key, mixed>|null $colors
 *
 * @method static Builder<static>|Module newModelQuery()
 * @method static Builder<static>|Module newQuery()
 * @method static Builder<static>|Module query()
 * @method static Builder<static>|Module whereColors($value)
 * @method static Builder<static>|Module whereDescription($value)
 * @method static Builder<static>|Module whereIcon($value)
 * @method static Builder<static>|Module whereId($value)
 * @method static Builder<static>|Module whereName($value)
 * @method static Builder<static>|Module wherePath($value)
 * @method static Builder<static>|Module wherePriority($value)
 * @method static Builder<static>|Module whereStatus($value)
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 *
 * @method static ModuleFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
final class Module extends BaseModel
{
    use Sushi;

    protected $fillable = [
        'name',
        // 'alias',
        // 'description',
        'status',
        'priority',
        'path',
        'icon',
        'colors',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $modules = ModuleFacade::all();
        $modules = Arr::map($modules, function (NModule $module): array {
            $config = config('tenant::config');
            if (! is_array($config)) {
                $config = [];
            }
            $colors = Arr::get($config, 'colors', []);

            return [
                'name' => $module->getName(),
                // 'alias' => $module->getAlias(),
                'description' => $module->getDescription(),
                'status' => $module->isEnabled(),
                'priority' => $module->get('priority'),
                'path' => $module->getPath(),
                'icon' => Arr::get($config, 'icon', 'heroicon-o-question-mark-circle'),
                'colors' => json_encode($colors),
            ];
        });

        /** @var array<int, array<string, mixed>> */
        return array_values($modules);
    }

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'status' => 'boolean',
            'priority' => 'integer',
            'path' => 'string',
            'icon' => 'string',
            'colors' => 'array',
        ];
    }
}
