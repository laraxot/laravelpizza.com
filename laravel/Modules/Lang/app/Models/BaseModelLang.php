<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

// //use Laravel\Scout\Searchable;
// ---------- traits
use Modules\Lang\Models\Traits\LinkedTrait;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModelLang.
 *
 * @property string|null $post_type
 */
abstract class BaseModelLang extends XotBaseModel
{
    use LinkedTrait;

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @see  https://laravel-news.com/6-eloquent-secrets
     */
    public static $snakeAttributes = true;

    public $incrementing = true;

    public $timestamps = true;

    protected $perPage = 30;

    protected $connection = 'lang';

    /** @var list<string> */
    protected $fillable = ['id'];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    /** @var list<string> */
    protected $hidden = [
        // 'password'
    ];

    // -----------
    /*
     * protected $id;
     * protected $post;
     * protected $lang;
     */

    /**
     * @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
