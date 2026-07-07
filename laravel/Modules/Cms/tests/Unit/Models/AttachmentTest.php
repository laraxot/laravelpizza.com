<?php

declare(strict_types=1);

use Modules\Cms\Models\Attachment;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('Attachment model can be instantiated', function () {
    $attachment = new Attachment();

    Assert::assertInstanceOf(Attachment::class, $attachment);
});

test('Attachment model has expected fillable fields', function () {
    $attachment = new Attachment();

    $fillable = $attachment->getFillable();

    Assert::assertContains('title', $fillable);

    Assert::assertContains('description', $fillable);

    Assert::assertContains('slug', $fillable);

    Assert::assertContains('disk', $fillable);

    Assert::assertContains('attachment', $fillable);
});

test('Attachment model has expected casts', function () {
    $attachment = new Attachment();

    $casts = $attachment->getCasts();

    Assert::assertArrayHasKey('attachment', $casts);

    Assert::assertSame('array', $casts['attachment']);
});

test('Attachment model implements HasMedia interface', function () {
    $attachment = new Attachment();

    Assert::assertInstanceOf(Spatie\MediaLibrary\HasMedia::class, $attachment);
});
