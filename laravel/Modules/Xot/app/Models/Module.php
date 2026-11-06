<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Database\Factories\ModuleFactory;
use Modules\Xot\Models\Traits\ModuleStatus;
use Nwidart\Modules\Facades\Module as ModuleFacade;
use Nwidart\Modules\Module as NModule;
use Sushi\Sushi;

use function Safe\json_encode;

/**
 * Registry Sushi dei moduli nwidart: espone name/slug/status/path per Filament e query.
 * Non esiste un campo `alias` (nwidart alias → `slug` / `name`); i timestamp seguono BaseModel.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $version
 * @property string|null $description
 * @property bool|null $status
 * @property bool|null $enabled
 * @property bool|null $is_active
 * @property int|null $priority
 * @property string|null $path
 * @property string|null $icon
 * @property array<array-key, mixed>|null $colors
 * @property array<array-key, mixed>|null $dependencies
 * @property array<array-key, mixed>|null $config
 * @property array<array-key, mixed>|null $metadata
 * @property Carbon|null $activation_date
 * @property Carbon|null $deactivation_date
 * @property Carbon|null $installation_date
 * @property array<array-key, mixed>|null $update_history
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
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
 * @method static Builder<static>|Module whereSlug($value)
 * @method static Builder<static>|Module whereEnabled($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 *
 * @method static ModuleFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
final class Module extends BaseModel
{
    use ModuleStatus;
    use Sushi;

    protected $fillable = [
        'name',
        'slug',
        'version',
        'description',
        'status',
        'enabled',
        'is_active',
        'priority',
        'path',
        'icon',
        'colors',
        'dependencies',
        'config',
        'metadata',
        'activation_date',
        'deactivation_date',
        'installation_date',
        'update_history',
    ];

    /**
     * @var string
     */
    protected $connection = 'xot';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $rows = [];

        foreach (ModuleFacade::all() as $module) {
            if (! $module instanceof NModule) {
                continue;
            }

            $config = config('tenant::config');
            if (! is_array($config)) {
                $config = [];
            }
            $colors = Arr::get($config, 'colors', []);

            $rows[] = [
                'name' => $module->getName(),
                // 'alias' => $module->getAlias(),
                'description' => $module->getDescription(),
                'status' => $module->isEnabled(),
                'priority' => $module->get('priority'),
                'path' => $module->getPath(),
                'icon' => Arr::get($config, 'icon', 'heroicon-o-question-mark-circle'),
                'colors' => json_encode($colors),
            ];
        }

        return $rows;
    }

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'status' => 'boolean',
            'enabled' => 'boolean',
            'priority' => 'integer',
            'path' => 'string',
            'icon' => 'string',
            'colors' => 'array',
        ];
    }
}
