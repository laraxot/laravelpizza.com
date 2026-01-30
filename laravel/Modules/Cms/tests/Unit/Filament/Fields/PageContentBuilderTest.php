<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Filament\Fields\PageContentBuilder;

test('PageContentBuilder can be instantiated', function () {
    $field = PageContentBuilder::make('content');

    expect($field)->toBeObject();
});
