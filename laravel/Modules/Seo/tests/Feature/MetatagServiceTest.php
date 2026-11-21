<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Feature;

use Modules\Seo\Adapters\MetatagManager;
use PHPUnit\Framework\Assert;

it('can set title', function (): void {
    $service = new MetatagManager();
    $service->setTitle('Test Title');
    Assert::assertSame('Test Title', $service->get()->getTitle());
});

it('can set description', function (): void {
    $service = new MetatagManager();
    $service->setDescription('Test Description');
    Assert::assertSame('Test Description', $service->get()->getDescription());
});

it('can set keywords', function (): void {
    $service = new MetatagManager();
    $service->setKeywords('seo, test, laravel');
    Assert::assertSame('seo, test, laravel', $service->get()->getKeywords());
});

it('can set robots', function (): void {
    $service = new MetatagManager();
    $service->setRobots('index, follow');
    Assert::assertSame('index, follow', $service->get()->getRobots());
});

it('can set canonical url', function (): void {
    $service = new MetatagManager();
    $service->setCanonical('https://example.com');
    Assert::assertSame('https://example.com', $service->get()->getCanonical());
});

it('can set colors', function (): void {
    $service = new MetatagManager();
    $colors = ['primary' => '#000000', 'secondary' => '#ffffff'];
    $service->setColors($colors);
    Assert::assertSame($colors, $service->get()->getColors());
});
