<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Spatie\Permission\Models\Role;
use Spatie\QueueableAction\QueueableAction;
use Modules\User\Models\User; // Assuming User model is the one calling this action

class AssignModuleRoleAction
{
    use QueueableAction;

    public function execute(User $user, string $module): void
    {
        $role_name = $module.'::admin';
        $role = Role::firstOrCreate(['name' => $role_name]);
        $user->assignRole($role);
    }
}
