<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Traits\Fixtures;

use Modules\User\Models\Traits\HasRoles;
use Modules\Xot\Models\BaseModel;

/** PHPStan fixture: keeps custom HasRoles trait in analysed graph. */
final class HasRolesTraitFixture extends BaseModel
{
    use HasRoles;

    protected $table = 'model_has_roles';
}
