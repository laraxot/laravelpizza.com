<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Models\Traits\HasRecursiveRelationshipsMethods;
use Modules\Xot\Models\Traits\TypedHasRecursiveRelationships;

abstract class BaseTreeModel extends BaseModel implements HasRecursiveRelationshipsContract
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
}
