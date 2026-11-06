<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Support\Collection;

/**
 * User in-memory per GetUserDataAction — evita Mockery property.notFound.
 */
final class UiCoverageAuthUser extends AuthenticatableUser
{
    public ?object $profile = null;

    public function relationLoaded($key): bool
    {
        if (! is_string($key)) {
            return false;
        }

        return $key === 'profile' && $this->profile !== null;
    }

    /**
     * @return Collection<int, string>
     */
    public function getRoleNames(): Collection
    {
        return collect(['admin']);
    }
}
