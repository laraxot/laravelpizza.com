<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Modules\Xot\Traits\Updater;

/**
 * Class BaseMorphPivot.
 */
abstract class BaseMorphPivot extends MorphPivot
{
    use Updater;

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @see https://laravel-news.com/6-eloquent-secrets
     */
    public static $snakeAttributes = true;

    public $incrementing = true;

    public $timestamps = true;

    protected $perPage = 30;

    protected $connection = 'notify';

    /** @var list<string> */
    protected $appends = [];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'post_id',
        'post_type',
        'related_type',
        'user_id',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
