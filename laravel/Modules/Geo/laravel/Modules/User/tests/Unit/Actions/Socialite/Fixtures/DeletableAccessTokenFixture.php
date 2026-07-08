<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\Socialite\Fixtures;

/**
 * Minimal access-token stub for logout action tests.
 */
final class DeletableAccessTokenFixture
{
    public bool $deleted = false;

    public function getKey(): string
    {
        return 'tok-1';
    }

    public function delete(): void
    {
        $this->deleted = true;
    }
}
