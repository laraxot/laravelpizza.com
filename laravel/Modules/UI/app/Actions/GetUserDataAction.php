<?php

declare(strict_types=1);

namespace Modules\UI\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\UI\Datas\UserData;
use Modules\User\Models\Profile;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Contracts\UserContract;
use Spatie\Permission\Contracts\Permission;
use Spatie\QueueableAction\QueueableAction;

class GetUserDataAction
{
    use QueueableAction;

    public function execute(): ?UserData
    {
        $user = Auth::user();

        if (! $user instanceof UserContract) {
            return null;
        }

        $avatar = null;
        $profile = $user->relationLoaded('profile') ? $user->profile : null;
        if ($profile instanceof Profile) {
            $avatarUrl = $profile->getAvatarUrl();
            $avatar = $avatarUrl !== '' ? $avatarUrl : null;
        }

        if ($avatar === null) {
            $profilePhotoPath = $user->getAttribute('profile_photo_path');
            if (is_string($profilePhotoPath) && $profilePhotoPath !== '') {
                $avatar = $profilePhotoPath;
            }
        }

        /** @var Collection<int, string> $roleNames */
        $roleNames = $user->getRoleNames();
        $firstRole = $roleNames->isNotEmpty() ? $roleNames->first() : null;
        $roleValue = is_string($firstRole) ? $firstRole : null;

        /** @var array<string, mixed> $settingsArray */
        $settingsArray = [];
        if ($profile instanceof Profile && isset($profile->extra)) {
            $extra = $profile->extra;
            if (is_array($extra)) {
                /** @var array<string, mixed> $typedExtra */
                $typedExtra = $extra;
                $settingsArray = $typedExtra;
            }
        }

        /** @var Collection<int, Permission> $allPermissions */
        $allPermissions = $user->getAllPermissions();
        /** @var array<int, string> $permissions */
        $permissions = $allPermissions->pluck('name')->toArray();

        // getAttribute, non property_exists: name ed email sono attributi magici Eloquent, per cui
        // property_exists e' sempre false e UserData usciva con nome ed email vuoti.
        $userName = $user->getAttribute('name');
        $userEmail = $user->getAttribute('email');

        return new UserData(
            id: SafeIntCastAction::cast($user->id),
            name: is_string($userName) ? $userName : '',
            email: is_string($userEmail) ? $userEmail : '',
            avatar: is_string($avatar) ? $avatar : null,
            role: $roleValue,
            permissions: $permissions,
            settings: $settingsArray,
        );
    }
}
