<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

// //use Laravel\Scout\Searchable;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    /** @var string */
    protected $connection = 'cms';

    /** @return array<string, string> */
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
