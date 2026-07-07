<?php

declare(strict_types=1);

use Modules\Cms\Enums\AttachmentDiskEnum;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('AttachmentDiskEnum has all cases', function () {
    $cases = AttachmentDiskEnum::cases();

    Assert::assertCount(3, $cases);
});

test('AttachmentDiskEnum cases have correct values', function () {
    Assert::assertSame('public_html', AttachmentDiskEnum::public_html->value);
    Assert::assertSame('videos', AttachmentDiskEnum::videos->value);
    Assert::assertSame('local', AttachmentDiskEnum::local->value);
});

test('AttachmentDiskEnum getLabel method exists', function () {
    $enum = AttachmentDiskEnum::public_html;
});

test('AttachmentDiskEnum getColor method exists', function () {
    $enum = AttachmentDiskEnum::public_html;
});

test('AttachmentDiskEnum getIcon method exists', function () {
    $enum = AttachmentDiskEnum::public_html;
});

test('AttachmentDiskEnum getDescription method exists', function () {
    $enum = AttachmentDiskEnum::public_html;
});
