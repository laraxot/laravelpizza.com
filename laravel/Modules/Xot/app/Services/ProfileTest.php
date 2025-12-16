<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

/**
 * Class ProfileTest.
 */
class ProfileTest
{
    public function hello(): void
    {
        echo 'ciao';
    }

    public function hasArea(): bool
    {
        return true;
    }

    public function isSuperAdmin(): bool
    {
        return true;
    }
}
