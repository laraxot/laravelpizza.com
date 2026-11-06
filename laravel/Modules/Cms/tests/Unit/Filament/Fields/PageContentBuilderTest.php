<?php

declare(strict_types=1);

use Modules\Cms\Filament\Fields\PageContentBuilder;
use PHPUnit\Framework\Assert;

test('PageContentBuilder can be instantiated', function () {
    $field = PageContentBuilder::make('content');

    Assert::assertSame('content', $field->getName());
});
