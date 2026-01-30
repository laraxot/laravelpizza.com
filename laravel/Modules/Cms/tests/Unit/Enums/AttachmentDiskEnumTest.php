<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Enums\AttachmentDiskEnum;

test('AttachmentDiskEnum has all cases', function () {
    $cases = AttachmentDiskEnum::cases();

    expect($cases)->toHaveCount(3);
    expect($cases)->each->toBeInstanceOf(AttachmentDiskEnum::class);
});

test('AttachmentDiskEnum cases have correct values', function () {
    expect(AttachmentDiskEnum::public_html->value)->toBe('public_html');
    expect(AttachmentDiskEnum::videos->value)->toBe('videos');
    expect(AttachmentDiskEnum::local->value)->toBe('local');
});

test('AttachmentDiskEnum getLabel method exists', function () {
    $enum = AttachmentDiskEnum::public_html;

    expect(method_exists($enum, 'getLabel'))->toBeTrue();
});

test('AttachmentDiskEnum getColor method exists', function () {
    $enum = AttachmentDiskEnum::public_html;

    expect(method_exists($enum, 'getColor'))->toBeTrue();
});

test('AttachmentDiskEnum getIcon method exists', function () {
    $enum = AttachmentDiskEnum::public_html;

    expect(method_exists($enum, 'getIcon'))->toBeTrue();
});

test('AttachmentDiskEnum getDescription method exists', function () {
    $enum = AttachmentDiskEnum::public_html;

    expect(method_exists($enum, 'getDescription'))->toBeTrue();
});
