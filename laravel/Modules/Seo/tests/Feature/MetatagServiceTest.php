<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Feature;

use Modules\Seo\Services\MetatagService;

it('can set title', function () {
    $service = new MetatagService;
    $service->setTitle('Test Title');
    expect($service->get()->getTitle())->toBe('Test Title');
});

it('can set description', function () {
    $service = new MetatagService;
    $service->setDescription('Test Description');
    expect($service->get()->getDescription())->toBe('Test Description');
});

it('can set keywords', function () {
    $service = new MetatagService;
    $service->setKeywords('seo, test, laravel');
    expect($service->get()->getKeywords())->toBe('seo, test, laravel');
});

it('can set robots', function () {
    $service = new MetatagService;
    $service->setRobots('index, follow');
    expect($service->get()->getRobots())->toBe('index, follow');
});

it('can set canonical url', function () {
    $service = new MetatagService;
    $service->setCanonical('https://example.com');
    expect($service->get()->getCanonical())->toBe('https://example.com');
});

it('can set colors', function () {
    $service = new MetatagService;
    $colors = ['primary' => '#000000', 'secondary' => '#ffffff'];
    $service->setColors($colors);
    expect($service->get()->getColors())->toBe($colors);
});
