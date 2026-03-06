<?php

declare(strict_types=1);

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\UI\Database\Factories\ComponentFactory;

/**
 * Component model for UI module.
 *
 * @property string               $id
 * @property string               $name
 * @property string               $theme_id
 * @property bool                 $is_active
 * @property string|null          $version
 * @property array|null           $dependencies
 * @property string|null          $template
 * @property bool                 $is_cacheable
 * @property int|null             $cache_ttl
 * @property array|null           $validation_rules
 * @property string|null          $view_path
 * @property array|null           $data_schema
 * @property array|null           $responsive_breakpoints
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 *
 * @property Theme                $theme
 *
 * @method static ComponentFactory             factory($count = null, $state = [])
 * @method static Builder<static>|Component newModelQuery()
 * @method static Builder<static>|Component newQuery()
 * @method static Builder<static>|Component query()
 *
 * @mixin \Eloquent
 */
class Component extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'theme_id',
        'is_active',
        'version',
        'dependencies',
        'template',
        'is_cacheable',
        'cache_ttl',
        'validation_rules',
        'view_path',
        'data_schema',
        'responsive_breakpoints',
        'supports_lazy_loading',
        'lazy_loading_threshold',
        'cache_strategy',
        'cache_duration',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_cacheable' => 'boolean',
            'dependencies' => 'array',
            'validation_rules' => 'array',
            'data_schema' => 'array',
            'responsive_breakpoints' => 'array',
            'supports_lazy_loading' => 'boolean',
            'lazy_loading_threshold' => 'float',
            'cache_duration' => 'integer',
        ];
    }

    /**
     * Get the theme that owns the component.
     */
    public function theme(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
