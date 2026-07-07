<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Enums;
use Modules\Job\Enums\Status;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('Status', function () {
    it('is an enum', function () {
        $reflection = new \ReflectionClass(Status::class);

        Assert::assertTrue($reflection->isEnum());
    });

    it('is a backed enum', function () {
        Assert::assertInstanceOf(\BackedEnum::class, Status::Active);
    });

    it('has correct cases', function () {
        Assert::assertCount(4, Status::cases());
        Assert::assertSame('active', Status::Active->value);
        Assert::assertSame('inactive', Status::Inactive->value);
        Assert::assertSame('trashed', Status::Trashed->value);
        Assert::assertSame('1', Status::One->value);
    });

    it('implements Filament interfaces', function () {
        $interfaces = (new \ReflectionClass(Status::class))->getInterfaceNames();

        Assert::assertContains('Filament\Support\Contracts\HasColor', $interfaces);
        Assert::assertContains('Filament\Support\Contracts\HasIcon', $interfaces);
        Assert::assertContains('Filament\Support\Contracts\HasLabel', $interfaces);
    });

    it('getColor returns translation keys via EnumTrait', function () {
        Assert::assertSame('job::status.values.active.color', Status::Active->getColor());
        Assert::assertSame('job::status.values.inactive.color', Status::Inactive->getColor());
        Assert::assertSame('job::status.values.trashed.color', Status::Trashed->getColor());
        Assert::assertSame('job::status.values.1.color', Status::One->getColor());
    });

    it('getIcon returns translation keys via EnumTrait', function () {
        Assert::assertSame('job::status.values.active.icon', Status::Active->getIcon());
        Assert::assertSame('job::status.values.inactive.icon', Status::Inactive->getIcon());
        Assert::assertSame('job::status.values.trashed.icon', Status::Trashed->getIcon());
        Assert::assertSame('job::status.values.1.icon', Status::One->getIcon());
    });

    it('getLabel returns a non-empty string', function () {
        Assert::assertNotSame('', Status::Inactive->getLabel());
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(Status::class);

        Assert::assertSame('Modules\Job\Enums', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(Status::class);
        $filename = $reflection->getFileName();

        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has required imports', function () {
        $filename = (new \ReflectionClass(Status::class))->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);

        Assert::assertStringContainsString('use Filament\Support\Contracts\HasColor;', $content);
        Assert::assertStringContainsString('use Filament\Support\Contracts\HasIcon;', $content);
        Assert::assertStringContainsString('use Filament\Support\Contracts\HasLabel;', $content);
    });

    it('can be used in match expressions', function () {
        foreach (Status::cases() as $status) {
            $result = match ($status) {
                Status::Active => 'active',
                Status::Inactive => 'inactive',
                Status::Trashed => 'trashed',
                Status::One => 'one',
            };

            Assert::assertNotEmpty($result);
        }
    });
});
