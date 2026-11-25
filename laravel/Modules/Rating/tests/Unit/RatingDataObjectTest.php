<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Modules\Rating\Datas\RatingData;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('costruisce un blocco rating', function (): void {
    $data = new RatingData(title: 'Ottimo', position: 5, description: 'Nota');

    Assert::assertSame('Ottimo', $data->title);
    Assert::assertSame(5, $data->position);
    Assert::assertSame('Nota', $data->description);
});

test('description e image_url sono opzionali', function (): void {
    $data = new RatingData(title: 'Base');

    Assert::assertSame('', $data->description);
    Assert::assertNull($data->image_url);
});

test('fromArray legge i campi del blocco', function (): void {
    $data = RatingData::fromArray([
        'title' => 'Da array',
        'position' => 4,
        'description' => 'Descrizione',
    ]);

    Assert::assertSame('Da array', $data->title);
    Assert::assertSame(4, $data->position);
    Assert::assertSame('Descrizione', $data->description);
});

test('fromArray normalizza scalari e valori assenti', function (): void {
    $data = RatingData::fromArray([
        'title' => 7,
        'position' => '3',
    ]);

    Assert::assertSame('7', $data->title);
    Assert::assertSame(3, $data->position);
    Assert::assertSame('', $data->description);
});

test('fromArray azzera title non scalare e score non numerico', function (): void {
    $data = RatingData::fromArray([
        'title' => ['non', 'scalare'],
        'position' => 'non-numerico',
        'description' => ['non stringa'],
        'user_id' => 12,
    ]);

    Assert::assertSame('', $data->title);
    Assert::assertSame(0, $data->position);
    Assert::assertSame('', $data->description);
});
