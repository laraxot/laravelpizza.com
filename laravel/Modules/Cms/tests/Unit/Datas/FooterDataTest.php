<?php

declare(strict_types=1);

use Livewire\Wireable;
use Modules\Cms\Datas\FooterData;
use PHPUnit\Framework\Assert;

it('declares footer data contract and rules', function (): void {
    $reflection = new ReflectionClass(FooterData::class);
    $rules = FooterData::rules();

    Assert::assertSame(FooterData::class, $reflection->getName());
    Assert::assertTrue($reflection->implementsInterface(Wireable::class));

    foreach (['background_color', 'background', 'overlay_color', 'view'] as $field) {
        Assert::assertArrayHasKey($field, $rules);
    }
});
