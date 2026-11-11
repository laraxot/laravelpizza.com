<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Feature;

use Modules\Seo\Adapters\MetatagFacadeAdapter;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('can set title', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);
    $adapter->setTitle('Test Title');
    Assert::assertSame('Test Title', $adapter->get()->getTitle());
});

it('can set description', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);
    $adapter->setDescription('Test Description');
    Assert::assertSame('Test Description', $adapter->get()->getDescription());
});

it('can set keywords', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);
    $adapter->setKeywords('seo, test, laravel');
    Assert::assertSame('seo, test, laravel', $adapter->get()->getKeywords());
});

it('can set robots', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);
    $adapter->setRobots('index, follow');
    Assert::assertSame('index, follow', $adapter->get()->getRobots());
});

it('can set canonical url', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);
    $adapter->setCanonical('https://example.com');
    Assert::assertSame('https://example.com', $adapter->get()->getCanonical());
});

it('can set colors', function (): void {
    $adapter = app(MetatagFacadeAdapter::class);
    $colors = ['primary' => '#000000', 'secondary' => '#ffffff'];
    $adapter->setColors($colors);
    Assert::assertSame($colors, $adapter->get()->getColors());
});
