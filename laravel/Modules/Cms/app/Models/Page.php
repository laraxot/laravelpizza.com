<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Cms\Database\Factories\PageFactory;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Cms\Models\Page.
 *
 * @property string                       $id
 * @property array<array-key, mixed>|null $title
 * @property string|null                  $slug
 * @property array<array-key, mixed>|null $middleware
 * @property string|null                  $content
 * @property string|null                  $description
 * @property array<array-key, mixed>|null $content_blocks
 * @property array<array-key, mixed>|null $sidebar_blocks
 * @property array<array-key, mixed>|null $footer_blocks
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property ProfileContract|null         $creator
 * @property mixed                        $translations
 * @property ProfileContract|null         $updater
 *
 * @method static Builder<static>|Page    newModelQuery()
 * @method static Builder<static>|Page    newQuery()
 * @method static Builder<static>|Page    query()
 * @method static Builder<static>|Page    whereContent($value)
 * @method static Builder<static>|Page    whereContentBlocks($value)
 * @method static Builder<static>|Page    whereCreatedAt($value)
 * @method static Builder<static>|Page    whereCreatedBy($value)
 * @method static Builder<static>|Page    whereDescription($value)
 * @method static Builder<static>|Page    whereFooterBlocks($value)
 * @method static Builder<static>|Page    whereId($value)
 * @method static Builder<static>|Page    whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page    whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page    whereLocale(string $column, string $locale)
 * @method static Builder<static>|Page    whereLocales(string $column, array $locales)
 * @method static Builder<static>|Page    whereMiddleware($value)
 * @method static Builder<static>|Page    whereSidebarBlocks($value)
 * @method static Builder<static>|Page    whereSlug($value)
 * @method static Builder<static>|Page    whereTitle($value)
 * @method static Builder<static>|Page    whereUpdatedAt($value)
 * @method static Builder<static>|Page    whereUpdatedBy($value)
 * @method static Builder<static>|Page    where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static|null             first(array|string $columns = ['*'])
 * @method static static|null             firstWhere(string $column, mixed $operator = null, mixed $value = null)
 * @method static static                  firstOrCreate(array $attributes, array $values = [])
 * @method static static                  create(array $attributes = [])
 * @method static static                  updateOrCreate(array $attributes, array $values = [])
 * @method static Builder<static>|Page    delete()
 * @method static Builder<static>|Page    whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page    whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page    whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page    orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page    latest($column = 'created_at')
 * @method static Builder<static>|Page    oldest($column = 'created_at')
 * @method static Builder<static>|Page    limit($value)
 * @method static Builder<static>|Page    take($value)
 * @method static Builder<static>|Page    skip($value)
 * @method static Builder<static>|Page    offset($value)
 * @method static int                     count()
 * @method static int                     max($column)
 * @method static int                     min($column)
 * @method static int                     sum($column)
 * @method static float                   avg($column)
 * @method static mixed                   pluck($column, $key = null)
 * @method static Builder<static>|Page    join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page    with($relations)
 * @method static Builder<static>|Page    without($relations)
 * @method static Builder<static>|Page    withCount($relations)
 * @method static Builder<static>|Page    withSum($relation, $column)
 * @method static Builder<static>|Page    withAvg($relation, $column)
 * @method static Builder<static>|Page    withMin($relation, $column)
 * @method static Builder<static>|Page    withMax($relation, $column)
 * @method static Builder<static>|Page    findOrFail($id, $columns = ['*'])
 * @method static static                  findOrFail($id, $columns = ['*'])
 * @method static static                  firstOrFail($columns = ['*'])
 * @method static static                  firstOrCreate(array $attributes, array $values = [])
 * @method static static                  create(array $attributes = [])
 * @method static static                  updateOrCreate(array $attributes, array $values = [])
 * @method static static                  update($attributes)
 * @method static Builder<static>|Page    where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page    whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page    whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page    orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page    latest($column = 'created_at')
 * @method static Builder<static>|Page    oldest($column = 'created_at')
 * @method static Builder<static>|Page    limit($value)
 * @method static Builder<static>|Page    take($value)
 * @method static Builder<static>|Page    skip($value)
 * @method static Builder<static>|Page    offset($value)
 * @method static int                     count()
 * @method static int                     max($column)
 * @method static int                     min($column)
 * @method static int                     sum($column)
 * @method static float                   avg($column)
 * @method static mixed                   pluck($column, $key = null)
 * @method static Builder<static>|Page    join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page    with($relations)
 * @method static Builder<static>|Page    without($relations)
 * @method static Builder<static>|Page    withCount($relations)
 * @method static Builder<static>|Page    withSum($relation, $column)
 * @method static Builder<static>|Page    withAvg($relation, $column)
 * @method static Builder<static>|Page    withMin($relation, $column)
 * @method static Builder<static>|Page    withMax($relation, $column)
 * @method static Builder<static>|Page    findOrFail($id, $columns = ['*'])
 * @method static static                  findOrFail($id, $columns = ['*'])
 * @method static static                  firstOrFail($columns = ['*'])
 * @method static static                  firstOrCreate(array $attributes, array $values = [])
 * @method static static                  create(array $attributes = [])
 * @method static static                  updateOrCreate(array $attributes, array $values = [])
 * @method static static                  update($attributes)
 * @method static int                     increment($column, $amount = 1, $extra = [])
 * @method static int                     decrement($column, $amount = 1, $extra = [])
 * @method static bool                    truncate()
 * @method static static                  destroy($ids)
 * @method static static                  restore()
 * @method static static                  forceDelete()
 * @method static static                  onlyTrashed()
 * @method static static                  withTrashed()
 * @method static static                  withoutTrashed()
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static static|null             first($columns = ['*'])
 * @method static static|null             find($id, $columns = ['*'])
 *
 * @property ProfileContract|null $deleter
 *
 * @method static PageFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Page extends BaseModelLang
{
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'title',
        // 'description',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected $fillable = [
        'content',
        'description',
        'slug',
        'title',
        'middleware',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'middleware' => 'json',
        'content' => 'string',
        'description' => 'string',
        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    public static function getMiddlewareBySlug(string $slug): array
    {
        $page = self::where('slug', $slug)->first();

        if (! $page instanceof Page) {
            return [];
        }

        $middleware = $page->middleware;

        return is_array($middleware) ? $middleware : [];
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
            // 'images' => 'array',
            'date' => 'datetime',
            'published_at' => 'datetime',
            'active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'content_blocks' => 'array',
            'sidebar_blocks' => 'array',
            'footer_blocks' => 'array',
            'middleware' => 'array',
        ];
    }
}
