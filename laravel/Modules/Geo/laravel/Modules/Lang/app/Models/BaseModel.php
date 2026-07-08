<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

// use GeneaLabs\LaravelModelCaching\Traits\Cachable;
// use Laravel\Scout\Searchable;
// ---------- traits
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
<<<<<<< HEAD:laravel/Modules/Lang/app/Models/BaseModel.php
    /** @var string */
    protected $connection = 'lang';
=======
    protected $connection = 'geo';

    protected $primaryKey = 'id';

    /** @var list<string> */
    protected $hidden = [
        // 'password'
    ];
>>>>>>> 74bf6abe2 (.):app/Models/BaseModel.php

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
