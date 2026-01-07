<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;

abstract class BaseTreeModel extends BaseModel implements HasRecursiveRelationshipsContract
{
    use HasRecursiveRelationships;
}
