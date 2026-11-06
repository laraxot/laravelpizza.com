<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Facades;

use Modules\Seo\Adapters\MetatagFacadeAdapter;
use Modules\Seo\Facades\Metatag;
use PHPUnit\Framework\Assert;
uses(\Modules\Seo\Tests\TestCase::class);

it('resolves metatag adapter through facade accessor', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);

    Metatag::setTitle('Facade Title');
    Metatag::setDescription('Facade Description');

    Assert::assertSame('Facade Title', $adapter->get()->getTitle());
    Assert::assertSame('Facade Description', $adapter->get()->getDescription());
});
