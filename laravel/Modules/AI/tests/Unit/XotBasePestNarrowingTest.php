<?php

declare(strict_types=1);
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('XotBasePest assertArray normalizza chiavi int in stringhe', function (): void {
    $normalized = XotBasePest::assertArray([0 => 'a', 'b' => 'c']);

    Assert::assertSame(['0' => 'a', 'b' => 'c'], $normalized);
});

test('XotBasePest assertArray accetta array vuoto', function (): void {
    Assert::assertSame([], XotBasePest::assertArray([]));
});
