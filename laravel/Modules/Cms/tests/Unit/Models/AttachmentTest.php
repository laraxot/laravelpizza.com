<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Attachment;

test('Attachment model can be instantiated', function () {
    $attachment = new Attachment;

    expect($attachment)->toBeInstanceOf(Attachment::class);
});

test('Attachment model has expected fillable fields', function () {
    $attachment = new Attachment;

    $fillable = $attachment->getFillable();

    expect($fillable)->toContain('title')
        ->and($fillable)->toContain('description')
        ->and($fillable)->toContain('slug')
        ->and($fillable)->toContain('disk')
        ->and($fillable)->toContain('attachment');
});

test('Attachment model has expected casts', function () {
    $attachment = new Attachment;

    $casts = $attachment->getCasts();

    expect($casts)->toHaveKey('attachment')
        ->and($casts['attachment'])->toBe('array');
});

test('Attachment model implements HasMedia interface', function () {
    $attachment = new Attachment;

    expect($attachment)->toBeInstanceOf(Spatie\MediaLibrary\HasMedia::class);
});
