<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

// use Laravel\Scout\Searchable;
use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'ptv'; // this will use the specified database connection
}
