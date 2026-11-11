<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Cms\Models\Section.
 *
 * @property string|null $id
 * @property array<array-key, mixed>|null $name
 * @property string|null $slug
 * @property array<array-key, mixed>|null $blocks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property ProfileContract|null $creator
 * @property array<int|string, mixed> $translatable_columns_from
 * @property array<string, array<string, mixed>> $translations
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|Section newModelQuery()
 * @method static Builder<static>|Section newQuery()
 * @method static Builder<static>|Section query()
 * @method static Builder<static>|Section whereBlocks($value)
 * @method static Builder<static>|Section whereCreatedAt($value)
 * @method static Builder<static>|Section whereCreatedBy($value)
 * @method static Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereJsonContainsLocales(string $column, array<int|string, mixed> $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereLocales(string $column, array<int|string, mixed> $locales)
 * @method static Builder<static>|Section whereName($value)
 * @method static Builder<static>|Section whereSlug($value)
 * @method static Builder<static>|Section whereUpdatedAt($value)
 * @method static Builder<static>|Section whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Section extends BaseModelLang
{
    use HasBlocks;
    use SushiToJsons;

    /** @var list<string> */
    public array $translatable = [
        'name',
        'blocks',
    ];

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'blocks',
    ];

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'json',
        'slug' => 'string',
        'blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'array',
            'slug' => 'string',
            'blocks' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
