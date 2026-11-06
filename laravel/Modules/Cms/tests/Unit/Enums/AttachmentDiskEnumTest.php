<?php

declare(strict_types=1);

use Modules\Cms\Enums\AttachmentDiskEnum;
use PHPUnit\Framework\Assert;

test('AttachmentDiskEnum has all cases', function () {
    $cases = AttachmentDiskEnum::cases();

    Assert::assertCount(3, $cases);
});

test('AttachmentDiskEnum cases have correct values', function () {
    Assert::assertSame('public_html', AttachmentDiskEnum::public_html->value);
    Assert::assertSame('videos', AttachmentDiskEnum::videos->value);
    Assert::assertSame('local', AttachmentDiskEnum::local->value);
});

test('AttachmentDiskEnum getLabel returns a translated label for every case', function () {
    foreach (AttachmentDiskEnum::cases() as $enum) {
        Assert::assertNotSame('', $enum->getLabel());
        Assert::assertStringStartsNotWith('fix:', $enum->getLabel());
    }
});

test('AttachmentDiskEnum getColor returns a translated color for every case', function () {
    foreach (AttachmentDiskEnum::cases() as $enum) {
        Assert::assertNotSame('', $enum->getColor());
        Assert::assertStringStartsNotWith('fix:', $enum->getColor());
    }
});

test('AttachmentDiskEnum getIcon returns a translated icon for every case', function () {
    foreach (AttachmentDiskEnum::cases() as $enum) {
        Assert::assertNotSame('', $enum->getIcon());
        Assert::assertStringStartsNotWith('fix:', $enum->getIcon());
    }
});

test('AttachmentDiskEnum getDescription returns a translated description for every case', function () {
    foreach (AttachmentDiskEnum::cases() as $enum) {
        Assert::assertNotSame('', $enum->getDescription());
        Assert::assertStringStartsNotWith('fix:', $enum->getDescription());
    }
});
