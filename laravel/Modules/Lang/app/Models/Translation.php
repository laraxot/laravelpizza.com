<?php

declare(strict_types=1);

/**
 * @see https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Models/Translation.php
 */

namespace Modules\Lang\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Modules\Lang\Database\Factories\TranslationFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Lang\Models\Translation.
 *
 * @property string               $id
 * @property string|null          $lang
 * @property string|null          $key
 * @property string|null          $value
 * @property string|null          $created_by
 * @property string|null          $updated_by
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string               $namespace
 * @property string               $group
 * @property string|null          $item
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static TranslationFactory                  factory($count = null, $state = [])
 * @method static EloquentBuilder<static>|Translation newModelQuery()
 * @method static EloquentBuilder<static>|Translation newQuery()
 * @method static EloquentBuilder<static>|Translation ofTranslatedGroup(string $group)
 * @method static EloquentBuilder<static>|Translation orderByGroupKeys(bool $ordered)
 * @method static EloquentBuilder<static>|Translation query()
 * @method static EloquentBuilder<static>|Translation selectDistinctGroup()
 * @method static EloquentBuilder<static>|Translation whereCreatedAt($value)
 * @method static EloquentBuilder<static>|Translation whereCreatedBy($value)
 * @method static EloquentBuilder<static>|Translation whereGroup($value)
 * @method static EloquentBuilder<static>|Translation whereId($value)
 * @method static EloquentBuilder<static>|Translation whereItem($value)
 * @method static EloquentBuilder<static>|Translation whereKey($value)
 * @method static EloquentBuilder<static>|Translation whereLang($value)
 * @method static EloquentBuilder<static>|Translation whereNamespace($value)
 * @method static EloquentBuilder<static>|Translation whereUpdatedAt($value)
 * @method static EloquentBuilder<static>|Translation whereUpdatedBy($value)
 * @method static EloquentBuilder<static>|Translation whereValue($value)
 * @property ProfileContract|null $deleter
 * @property string|null          $locale
 * @property int|null             $user_id
 * @method static EloquentBuilder<static>|Translation whereLocale($value)
 * @method static EloquentBuilder<static>|Translation whereUserId($value)
 * @mixin \Eloquent
 */
class Translation extends BaseModel
{
    final public const STATUS_SAVED = 0;

    final public const STATUS_CHANGED = 1;

    protected $fillable = [
        'id',
        'lang',
        'value',
        'namespace',
        'group',
        'item',
    ];

    // protected $table = 'ltm_translations';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Undocumented function.
     */
    public function scopeOfTranslatedGroup(EloquentBuilder $query, string $group): QueryBuilder|EloquentBuilder
    {
        return $query->where('group', $group)->whereNotNull('value');
    }

    public function scopeOrderByGroupKeys(EloquentBuilder $query, bool $ordered): EloquentBuilder
    {
        if ($ordered) {
            $query->orderBy('group')->orderBy('key');
        }

        return $query;
    }

    public function scopeSelectDistinctGroup(EloquentBuilder $query): EloquentBuilder|QueryBuilder
    {
        $select = match (\DB::getDriverName()) {
            'mysql' => 'DISTINCT `group`',
            default => 'DISTINCT "group"',
        };

        return $query->select(\DB::raw($select));
    }

    /*
     * Get the current connection name for the model.
     *
     * @return string|null
     *
     * public function getConnectionName()
     * {
     * if ($connection = config('translation-manager.db_connection')) {
     * return $connection;
     * }
     *
     * return parent::getConnectionName();
     * }
     */
}
