<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Facades;

use Modules\Seo\Facades\Metatag;
use Modules\Seo\Services\MetatagService;
use Tests\TestCase;

uses(TestCase::class);

it('resolves metatag service through facade accessor', function (): void {
    $service = app(MetatagService::class);

    Metatag::setTitle('Facade Title');
    Metatag::setDescription('Facade Description');

    expect($service->get()->getTitle())->toBe('Facade Title')
        ->and($service->get()->getDescription())->toBe('Facade Description');
});
