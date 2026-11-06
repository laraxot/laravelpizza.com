<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Spatie\Permission\Models\Permission;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetPermissionModelAction
{
    use QueueableAction;

    /**
     * @return class-string
     */
    public function execute(): string
    {
        Assert::string($res = config('permission.models.permission', Permission::class));
        Assert::classExists($res);

        return $res;
    }
}
