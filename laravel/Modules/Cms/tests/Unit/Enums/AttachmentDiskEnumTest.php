<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
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

test('AttachmentDiskEnum implements HasLabel interface', function () {
    expect(AttachmentDiskEnum::public_html)->toBeInstanceOf(HasLabel::class);
});

test('AttachmentDiskEnum implements HasColor interface', function () {
    expect(AttachmentDiskEnum::public_html)->toBeInstanceOf(HasColor::class);
});

test('AttachmentDiskEnum implements HasIcon interface', function () {
    expect(AttachmentDiskEnum::public_html)->toBeInstanceOf(HasIcon::class);
});

test('AttachmentDiskEnum fromValue returns correct case', function () {
    expect(AttachmentDiskEnum::from('public_html'))->toBe(AttachmentDiskEnum::public_html)
        ->and(AttachmentDiskEnum::from('videos'))->toBe(AttachmentDiskEnum::videos)
        ->and(AttachmentDiskEnum::from('local'))->toBe(AttachmentDiskEnum::local);
});

test('AttachmentDiskEnum all cases are accessible', function () {
    $cases = AttachmentDiskEnum::cases();

    expect($cases)->toHaveCount(3)
        ->and($cases[0])->toBe(AttachmentDiskEnum::public_html)
        ->and($cases[1])->toBe(AttachmentDiskEnum::videos)
        ->and($cases[2])->toBe(AttachmentDiskEnum::local);
});

test('AttachmentDiskEnum values are correct strings', function () {
    expect(AttachmentDiskEnum::public_html->value)->toBeString()->toBe('public_html')
        ->and(AttachmentDiskEnum::videos->value)->toBeString()->toBe('videos')
        ->and(AttachmentDiskEnum::local->value)->toBeString()->toBe('local');
});
