<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Datas\RatingData;
use Modules\Rating\Enums\SupportedLocale;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('applica i default del costruttore', function (): void {
    $data = new RatingData;

    Assert::assertSame('', $data->title);
    Assert::assertSame('', $data->description);
    Assert::assertFalse($data->disabled);
    Assert::assertSame(0, $data->position);
    Assert::assertSame(SupportedLocale::IT, $data->locale);
    Assert::assertNull($data->image_url);
});

test('fromArray legge un payload completo', function (): void {
    $data = RatingData::fromArray([
        'title' => 'Gradimento',
        'description' => 'Scala da 0 a 5',
        'disabled' => true,
        'position' => 3,
        'locale' => 'en',
        'image_url' => 'https://example.test/r.png',
    ]);

    Assert::assertSame('Gradimento', $data->title);
    Assert::assertSame('Scala da 0 a 5', $data->description);
    Assert::assertTrue($data->disabled);
    Assert::assertSame(3, $data->position);
    Assert::assertSame(SupportedLocale::EN, $data->locale);
    Assert::assertSame('https://example.test/r.png', $data->image_url);
});

test('fromArray su array vuoto ricade sui default', function (): void {
    $data = RatingData::fromArray([]);

    Assert::assertSame('', $data->title);
    Assert::assertSame('', $data->description);
    Assert::assertFalse($data->disabled);
    Assert::assertSame(0, $data->position);
    Assert::assertSame(SupportedLocale::IT, $data->locale);
    Assert::assertNull($data->image_url);
});

test('fromArray normalizza gli scalari non stringa', function (): void {
    $data = RatingData::fromArray([
        'title' => 42,
        'description' => 3.5,
        'disabled' => 0,
        'position' => '7',
        'locale' => 'xx',
        'image_url' => 99,
    ]);

    Assert::assertSame('42', $data->title);
    Assert::assertSame('3.5', $data->description);
    Assert::assertFalse($data->disabled);
    Assert::assertSame(7, $data->position);
    Assert::assertSame(SupportedLocale::IT, $data->locale, 'un locale sconosciuto ricade su IT');
    Assert::assertNull($data->image_url, 'un image_url non stringa diventa null');
});

test('fromArray scarta i valori non scalari', function (): void {
    $data = RatingData::fromArray([
        'title' => ['non', 'scalare'],
        'description' => ['neppure'],
        'position' => 'non-numerico',
    ]);

    Assert::assertSame('', $data->title);
    Assert::assertSame('', $data->description);
    Assert::assertSame(0, $data->position);
});

test('è serializzabile come Spatie Data', function (): void {
    $array = RatingData::fromArray(['title' => 'Gradimento', 'position' => 2])->toArray();

    Assert::assertSame('Gradimento', $array['title']);
    Assert::assertSame(2, $array['position']);
});
