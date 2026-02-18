<?php

declare(strict_types=1);

namespace Modules\UI\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\UI\Datas\UserData;
use Modules\User\Models\User;
use Spatie\Permission\Contracts\Permission;
use Spatie\QueueableAction\QueueableAction;

class GetUserDataAction
{
    use QueueableAction;

    public function execute(): ?UserData
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return null;
        }

        // PHPStan L10: tenancy() è helper function, ma PHPStan non la riconosce
        // Rimuoviamo questa logica se non è necessaria per GetUserDataAction
        // Se necessario, usare Filament::getTenant() invece

        // Get avatar from profile_photo_path or profile relation
        $avatarValue = null;
        if (isset($user->profile_photo_path) && is_string($user->profile_photo_path)) {
            $avatarValue = $user->profile_photo_path;
        } elseif ($user->relationLoaded('profile') && null !== $user->profile) {
            $profile = $user->profile;
            if (is_object($profile) && method_exists($profile, 'getAvatarUrl')) {
                $avatarValue = $profile->getAvatarUrl();
            } elseif (is_object($profile) && isset($profile->avatar) && is_string($profile->avatar)) {
                $avatarValue = $profile->avatar;
            }
        }

        // PHPStan L10: getRoleNames() restituisce Collection, ma PHPStan non lo riconosce dal trait
        /** @var Collection<int, string> $roleNames */
        $roleNames = $user->getRoleNames();
        $firstRole = $roleNames->isNotEmpty() ? $roleNames->first() : null;
        $roleValue = is_string($firstRole) ? $firstRole : null;

        // Get settings - could be in profile or extra attributes
        $settingsArray = [];
        if ($user->relationLoaded('profile') && null !== $user->profile) {
            $profile = $user->profile;
            if (is_object($profile) && isset($profile->extra)) {
                $extra = $profile->extra;
                $settingsArray = is_array($extra) ? $extra : [];
            }
        }

        // PHPStan L10: getAllPermissions() restituisce Collection, ma PHPStan non lo riconosce dal trait
        // method_exists() è sempre true perché User ha HasPermissions trait
        /** @var Collection<int, Permission> $allPermissions */
        $allPermissions = $user->getAllPermissions();
        /** @var array<string> $permissions */
        $permissions = $allPermissions->pluck('name')->toArray();

        return new UserData(
            id: (int) $user->id,
            name: (string) ($user->name ?? ''),
            email: (string) ($user->email ?? ''),
            avatar: null !== $avatarValue ? (string) $avatarValue : null,
            role: null !== $roleValue ? (string) $roleValue : null,
            permissions: $permissions ?? [],
            settings: $settingsArray,
        );
    }
}
