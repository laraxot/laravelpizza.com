<?php

declare(strict_types=1);

namespace Modules\User\Actions\Shield;

use Spatie\Permission\Models\Permission;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * @see docs/contracts/shield-get-permission-model-action.md
 * @contract docs/contracts/shield-get-permission-model-action.md
 */
final class GetPermissionModelAction
{
    use QueueableAction;

    public function execute(): string
    {
        Assert::string($res = config('permission.models.permission', Permission::class));

        return $res;
    }
}
