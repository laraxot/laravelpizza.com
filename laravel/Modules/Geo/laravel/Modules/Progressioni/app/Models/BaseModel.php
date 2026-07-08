<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Modules\Xot\Models\XotBaseModel;

// use Laravel\Scout\Searchable;
// ---------- traits

abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'progressione';
}
