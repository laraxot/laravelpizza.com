<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

// use Laravel\Scout\Searchable;
// ---------- traits

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'xot';

    /** @return array<string, class-string|string> */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
