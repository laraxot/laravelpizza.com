<?php

declare(strict_types=1);

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\UI\Database\Factories\ThemeFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Theme model for UI module.
 *
 * @property string               $id
 * @property string               $name
 * @property string|null          $description
 * @property bool                 $is_active
 * @property array|null           $config
 * @property int|null             $parent_id
 * @property string|null          $source_path
 * @property string|null          $compiled_path
 * @property bool                 $needs_compilation
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 *
 * @property Theme|null           $parent
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static ThemeFactory             factory($count = null, $state = [])
 * @method static Builder<static>|Theme newModelQuery()
 * @method static Builder<static>|Theme newQuery()
 * @method static Builder<static>|Theme query()
 * @method static Builder<static>|Theme whereId($value)
 * @method static Builder<static>|Theme whereName($value)
 * @method static Builder<static>|Theme whereIsActive($value)
 *
 * @mixin \Eloquent
 */
class Theme extends BaseModel
{
    /** @var string */
    protected $connection = 'mysql';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'config',
        'parent_id',
        'source_path',
        'compiled_path',
        'needs_compilation',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'config' => 'array',
            'needs_compilation' => 'boolean',
        ];
    }

    /**
     * Get the parent theme.
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
