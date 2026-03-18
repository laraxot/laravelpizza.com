<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Filament\Fields;

use Modules\Cms\Filament\Fields\PageContentBuilder;

test('PageContentBuilder can be instantiated', function () {
    $field = PageContentBuilder::make('content');

    expect($field)->toBeObject();
});
