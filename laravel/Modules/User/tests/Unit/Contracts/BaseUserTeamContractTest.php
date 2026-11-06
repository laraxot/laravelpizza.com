<?php

declare(strict_types=1);

use Modules\User\Contracts\HasTeamsContract;
use Modules\User\Models\BaseUser;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('BaseUser advertises the team capability provided by its HasTeams trait', function (): void {
    $reflection = new ReflectionClass(BaseUser::class);

    Assert::assertTrue($reflection->implementsInterface(HasTeamsContract::class));
});
