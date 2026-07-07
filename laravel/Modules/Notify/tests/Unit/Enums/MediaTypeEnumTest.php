<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Enums;

use Modules\Notify\Enums\MediaTypeEnum;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

it('has correct cases', function (): void {
    Assert::assertCount(4, MediaTypeEnum::cases());

    Assert::assertSame('image', MediaTypeEnum::IMAGE->value);
    Assert::assertSame('video', MediaTypeEnum::VIDEO->value);
    Assert::assertSame('document', MediaTypeEnum::DOCUMENT->value);
    Assert::assertSame('audio', MediaTypeEnum::AUDIO->value);
});

it('options returns correct array', function (): void {
    $options = MediaTypeEnum::options();
    Assert::assertCount(4, $options);
    Assert::assertSame('Image', $options['image']);
    Assert::assertSame('Video', $options['video']);
    Assert::assertSame('Document', $options['document']);
    Assert::assertSame('Audio', $options['audio']);
});

it('labels returns localized array', function (): void {
    $labels = MediaTypeEnum::labels();
    Assert::assertCount(4, $labels);
    Assert::assertArrayHasKey('image', $labels);
    Assert::assertArrayHasKey('video', $labels);
    Assert::assertArrayHasKey('document', $labels);
    Assert::assertArrayHasKey('audio', $labels);
});

it('is supported returns true for valid types', function (): void {
    Assert::assertTrue(MediaTypeEnum::isSupported('image'));
    Assert::assertTrue(MediaTypeEnum::isSupported('video'));
    Assert::assertTrue(MediaTypeEnum::isSupported('document'));
    Assert::assertTrue(MediaTypeEnum::isSupported('audio'));
});

it('is supported returns false for invalid types', function (): void {
    Assert::assertFalse(MediaTypeEnum::isSupported('invalid'));
    Assert::assertFalse(MediaTypeEnum::isSupported(''));
    Assert::assertFalse(MediaTypeEnum::isSupported('IMAGE'));
    Assert::assertFalse(MediaTypeEnum::isSupported('Image'));
});

it('get default returns image', function (): void {
    $default = MediaTypeEnum::getDefault();

    Assert::assertInstanceOf(MediaTypeEnum::class, $default);
    Assert::assertSame(MediaTypeEnum::IMAGE, $default);
    Assert::assertSame('image', $default->value);
});

it('each case has unique value', function (): void {
    $values = array_map(static fn ($case) => $case->value, MediaTypeEnum::cases());
    $uniqueValues = array_unique($values);

    Assert::assertCount(count($values), $uniqueValues, 'All enum cases should have unique values');
});

it('cases returns all enum instances', function (): void {
    $cases = MediaTypeEnum::cases();
    Assert::assertCount(4, $cases);

    foreach ($cases as $case) {
        Assert::assertInstanceOf(MediaTypeEnum::class, $case);
    }
});
