<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Database\Factories\ModuleFactory;
use Nwidart\Modules\Facades\Module as ModuleFacade;
use Nwidart\Modules\Module as NModule;
use Sushi\Sushi;

use function Safe\json_encode;

/**
 * @property string $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $version
 * @property bool $status
 * @property bool $enabled
 * @property bool $is_active
 * @property int $priority
 * @property string|null $path
 * @property string|null $icon
 * @property array<array-key, mixed>|null $colors
 * @property array<array-key, mixed>|null $dependencies
 * @property array<array-key, mixed>|null $config
 * @property array<array-key, mixed>|null $metadata
 * @property array<array-key, mixed>|null $update_history
 * @property string|null $laravel_version
 * @property string|null $php_version
 * @property array<array-key, mixed>|null $permissions
 * @property array<array-key, mixed>|null $routes
 * @property array<array-key, mixed>|null $assets
 * @property array<array-key, mixed>|null $settings
 * @property \Illuminate\Support\Carbon|null $installed_at
 * @property \Illuminate\Support\Carbon|null $activation_date
 * @property \Illuminate\Support\Carbon|null $deactivation_date
 * @property array<array-key, mixed>|null $error_log
 * @property array<array-key, mixed>|null $usage_statistics
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
        'slug',
        'description',
        'version',
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
        'update_history',
        'laravel_version',
        'php_version',
        'permissions',
        'routes',
        'assets',
        'settings',
        'installed_at',
        'activation_date',
        'deactivation_date',
        'error_log',
        'usage_statistics',
    ];

    /** @var array<string, string> */
    protected $schema = [
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'version' => 'string',
        'status' => 'boolean',
        'enabled' => 'boolean',
        'is_active' => 'boolean',
        'priority' => 'integer',
        'path' => 'string',
        'icon' => 'string',
        'colors' => 'json',
        'dependencies' => 'json',
        'config' => 'json',
        'metadata' => 'json',
        'update_history' => 'json',
        'laravel_version' => 'string',
        'php_version' => 'string',
        'permissions' => 'json',
        'routes' => 'json',
        'assets' => 'json',
        'settings' => 'json',
        'installed_at' => 'datetime',
        'activation_date' => 'datetime',
        'deactivation_date' => 'datetime',
        'error_log' => 'json',
        'usage_statistics' => 'json',
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
                'slug' => $module->getLowerName(), // Use getLowerName as slug/alias
                'description' => $module->getDescription(),
                'version' => '1.0.0', // Placeholder
                'status' => $module->isEnabled(),
                'enabled' => $module->isEnabled(),
                'is_active' => $module->isEnabled(),
                'priority' => (int) $module->get('priority'),
                'path' => $module->getPath(),
                'icon' => (string) Arr::get($config, 'icon', 'heroicon-o-question-mark-circle'),
                'colors' => json_encode($colors),
                'dependencies' => json_encode([]),
                'config' => json_encode([]),
                'metadata' => json_encode([]),
                'update_history' => json_encode([]),
                'laravel_version' => null,
                'php_version' => null,
                'permissions' => json_encode([]),
                'routes' => json_encode([]),
                'assets' => json_encode([]),
                'settings' => json_encode([]),
                'installed_at' => null,
                'activation_date' => null,
                'deactivation_date' => null,
                'error_log' => json_encode([]),
                'usage_statistics' => json_encode([]),
            ];
        });

        /** @var array<int, array<string, mixed>> */
        return array_values($modules);
    }

    public function isEnabled(): bool
    {
        return (bool) $this->enabled;
    }

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'slug' => 'string',
            'description' => 'string',
            'version' => 'string',
            'status' => 'boolean',
            'enabled' => 'boolean',
            'is_active' => 'boolean',
            'priority' => 'integer',
            'path' => 'string',
            'icon' => 'string',
            'colors' => 'array',
            'dependencies' => 'array',
            'config' => 'array',
            'metadata' => 'array',
            'update_history' => 'array',
            'laravel_version' => 'string',
            'php_version' => 'string',
            'permissions' => 'array',
            'routes' => 'array',
            'assets' => 'array',
            'settings' => 'array',
            'installed_at' => 'datetime',
            'activation_date' => 'datetime',
            'deactivation_date' => 'datetime',
            'error_log' => 'array',
            'usage_statistics' => 'array',
        ];
    }
}
