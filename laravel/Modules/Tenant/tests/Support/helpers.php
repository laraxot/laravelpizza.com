<?php

declare(strict_types=1);

use Mockery\Expectation;
use Mockery\MockInterface;
use PHPUnit\Framework\Assert;

function tenantMockExpectation(MockInterface $mock, string $method): Expectation
{
    $expectation = $mock->shouldReceive($method);
    Assert::assertInstanceOf(Expectation::class, $expectation);

    return $expectation;
}
