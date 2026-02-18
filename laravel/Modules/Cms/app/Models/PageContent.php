<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Cms\Database\Factories\PageContentFactory;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\Translatable\HasTranslations;

/**
 * Modules\Cms\Models\PageContent.
 *
 * @property string $id
 * @property array<array-key, mixed>|null $name
 * @property string|null $slug
 * @property array<array-key, mixed>|null $blocks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property ProfileContract|null $creator
 * @property mixed $translations
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|PageContent newModelQuery()
 * @method static Builder<static>|PageContent newQuery()
 * @method static Builder<static>|PageContent query()
 * @method static Builder<static>|PageContent whereBlocks($value)
 * @method static Builder<static>|PageContent whereCreatedAt($value)
 * @method static Builder<static>|PageContent whereCreatedBy($value)
 * @method static Builder<static>|PageContent whereId($value)
 * @method static Builder<static>|PageContent whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|PageContent whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|PageContent whereLocale(string $column, string $locale)
 * @method static Builder<static>|PageContent whereLocales(string $column, array $locales)
 * @method static Builder<static>|PageContent whereName($value)
 * @method static Builder<static>|PageContent whereSlug($value)
 * @method static Builder<static>|PageContent whereUpdatedAt($value)
 * @method static Builder<static>|PageContent whereUpdatedBy($value)
 * @method static int count()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static PageContentFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class PageContent extends BaseModel
{
    use HasTranslations;
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'name',
        'blocks',
    ];

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'blocks',
    ];

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
     * @return array<string, mixed>
     */
    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * @return array<string, mixed>
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'name' => 'string',
            'slug' => 'string',
            'blocks' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
