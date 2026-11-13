<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\Socialite\Fixtures;

use Laravel\Passport\Contracts\ScopeAuthorizable;

/**
 * Minimal access-token stub for logout action tests.
 *
 * `UserContract::token()` dichiara `?ScopeAuthorizable` (Passport 13): il mock del
 * contratto rifiuta un oggetto che non implementa l'interfaccia.
 */
final class DeletableAccessTokenFixture implements ScopeAuthorizable
{
    public bool $deleted = false;

    public bool $revoked = false;

    public function getKey(): string
    {
        return 'tok-1';
    }

    public function delete(): void
    {
        $this->deleted = true;
    }

    public function revoke(): bool
    {
        $this->revoked = true;

        return true;
    }

    public function can(string $scope): bool
    {
        return true;
    }

    public function cant(string $scope): bool
    {
        return false;
    }
}
