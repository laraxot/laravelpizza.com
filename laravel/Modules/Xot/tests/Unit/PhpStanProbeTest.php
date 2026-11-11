<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('probe mixed', function (): void {
    /** @var mixed $mixed */
    $mixed = null;

    Assert::assertNull($mixed);
});
