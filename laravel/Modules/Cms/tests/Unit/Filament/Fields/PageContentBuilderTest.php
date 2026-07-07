<?php

declare(strict_types=1);

use Modules\Cms\Filament\Fields\PageContentBuilder;

uses(Modules\Cms\Tests\TestCase::class);
test('PageContentBuilder can be instantiated', function () {
    $field = PageContentBuilder::make('content');
});
