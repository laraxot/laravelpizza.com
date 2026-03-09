<?php

declare(strict_types=1);

namespace Modules\Seo\Tests\Unit\Data;

use Modules\Seo\Data\MetatagData;
use Tests\TestCase;

uses(TestCase::class);

it('returns sane defaults for empty data', function (): void {
    $data = new MetatagData;

    expect($data->getTitle())->toBe('')
        ->and($data->getDescription())->toBe('')
        ->and($data->getKeywords())->toBe('')
        ->and($data->getRobots())->toBe('index, follow')
        ->and($data->getCanonical())->toBeNull()
        ->and($data->getImage())->toBeNull()
        ->and($data->getType())->toBe('website');
});

it('returns typed colors and falls back for invalid colors', function (): void {
    $data = new MetatagData([
        'colors' => [
            'primary' => '#111111',
            'secondary' => '#222222',
            10 => 123,
        ],
    ]);

    $colors = $data->getColors();

    expect($colors['primary'])->toBe('#111111')
        ->and($colors['secondary'])->toBe('#222222')
        ->and($colors['10'])->toBe('');

    $fallback = new MetatagData(['colors' => 'invalid']);
    expect($fallback->getColors())->toHaveKey('primary');
});

it('reads nested keys and has method works', function (): void {
    $data = new MetatagData([
        'og' => [
            'title' => 'OG Title',
        ],
    ]);

    expect($data->has('og.title'))->toBeTrue()
        ->and($data->get('og.title'))->toBe('OG Title')
        ->and($data->get('og.missing', 'default'))->toBe('default');
});

it('supports livewire serialization cycle', function (): void {
    $original = [
        'title' => 'Serializable',
        'locale' => 'it',
    ];

    $data = new MetatagData($original);
    $livewire = $data->toLivewire();
    $restored = MetatagData::fromLivewire($livewire);

    expect($restored->toArray())->toBe($original);
});

it('handles non array livewire payload and url fallback', function (): void {
    $restored = MetatagData::fromLivewire('invalid');
    expect($restored->toArray())->toBe([]);

    $data = new MetatagData(['url' => 123]);
    $url = $data->getUrl();
    expect($url)->toBeString();
});

it('falls back to en when app locale is not a string', function (): void {
    config(['app.locale' => ['it']]);

    $data = new MetatagData([]);

    expect($data->getLocale())->toBe('en');
});
