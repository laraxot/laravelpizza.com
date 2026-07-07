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
     *
     * @var bool
     */
    public static $snakeAttributes = true;

    /** @var bool */
    public $incrementing = true;

    /** @var bool */
    public $timestamps = true;

    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $connection = 'lang';

    /** @var list<string> */
    protected $fillable = ['id'];

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string */
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
