<?php

declare(strict_types=1);

namespace Tests\Modules\Seo\Unit\Data;

use Modules\Seo\Datas\MetatagData;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('returns sane defaults for empty data', function (): void {
    $data = new MetatagData;

    Assert::assertSame('', $data->getTitle());
    Assert::assertSame('', $data->getDescription());
    Assert::assertSame('', $data->getKeywords());
    Assert::assertSame('index, follow', $data->getRobots());
    Assert::assertNull($data->getCanonical());
    Assert::assertNull($data->getImage());
    Assert::assertSame('website', $data->getType());
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

    Assert::assertSame('#111111', $colors['primary']);
    Assert::assertSame('#222222', $colors['secondary']);

    $numericColor = null;
    foreach ($colors as $key => $value) {
        if ((string) $key === '10') {
            $numericColor = $value;
            break;
        }
    }
    Assert::assertSame('', $numericColor);

    $fallback = new MetatagData(['colors' => 'invalid']);
    Assert::assertArrayHasKey('primary', $fallback->getColors());
});

it('reads nested keys and has method works', function (): void {
    $data = new MetatagData([
        'og' => [
            'title' => 'OG Title',
        ],
    ]);

    Assert::assertTrue($data->has('og.title'));
    Assert::assertSame('OG Title', $data->get('og.title'));
    Assert::assertSame('default', $data->get('og.missing', 'default'));
});

it('supports livewire serialization cycle', function (): void {
    $original = [
        'title' => 'Serializable',
        'locale' => 'it',
    ];

    $data = new MetatagData($original);
    $livewire = $data->toLivewire();
    $restored = MetatagData::fromLivewire($livewire);

    Assert::assertSame($original, $restored->toArray());
});

it('handles non array livewire payload and url fallback', function (): void {
    $restored = MetatagData::fromLivewire('invalid');
    Assert::assertSame([], $restored->toArray());

    $data = new MetatagData(['url' => 123]);
    $url = $data->getUrl();
    Assert::assertIsString($url);
});

it('returns explicit locale from data payload', function (): void {
    $data = new MetatagData(['locale' => 'it']);

    Assert::assertSame('it', $data->getLocale());

    $data = new MetatagData(['url' => 123]);
    $url = $data->getUrl();
    expect($url)->toBeString();
});

it('falls back to en when app locale is not a string', function (): void {
    config(['app.locale' => ['it']]);

    $data = new MetatagData([]);

    Assert::assertSame('en', $data->getLocale());
});
