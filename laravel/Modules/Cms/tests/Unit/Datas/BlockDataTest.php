<?php

declare(strict_types=1);

use Livewire\Wireable;
use Modules\Cms\Datas\BlockData;
use PHPUnit\Framework\Assert;

it('declares block data contract', function (): void {
    $reflection = new ReflectionClass(BlockData::class);

    Assert::assertSame(BlockData::class, $reflection->getName());
    Assert::assertTrue($reflection->implementsInterface(Wireable::class));
});
