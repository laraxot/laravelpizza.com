<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

// use GeneaLabs\LaravelModelCaching\Traits\Cachable;
// //use Laravel\Scout\Searchable;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'geo';

    protected $primaryKey = 'id';

    /** @var list<string> */
    protected $hidden = [
        // 'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ]);
    }
}
