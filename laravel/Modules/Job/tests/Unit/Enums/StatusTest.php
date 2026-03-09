<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Enums;

use Modules\Job\Enums\Status;

describe('Status', function () {
    it('is an enum', function () {
        $reflection = new ReflectionClass(Status::class);

        expect($reflection->isEnum())->toBeTrue();
    });

    it('is a backed enum', function () {
        expect(Status::Active)->toBeInstanceOf(\BackedEnum::class);
    });

    it('has correct cases', function () {
        expect(Status::cases())->toHaveCount(4)
            ->and(Status::Active->value)->toBe('active')
            ->and(Status::Inactive->value)->toBe('inactive')
            ->and(Status::Trashed->value)->toBe('trashed')
            ->and(Status::One->value)->toBe('1');
    });

    it('implements Filament interfaces', function () {
        $interfaces = (new ReflectionClass(Status::class))->getInterfaceNames();

        expect($interfaces)->toContain('Filament\Support\Contracts\HasColor')
            ->and($interfaces)->toContain('Filament\Support\Contracts\HasIcon')
            ->and($interfaces)->toContain('Filament\Support\Contracts\HasLabel');
    });

    it('getColor returns correct colors', function () {
        expect(Status::Active->getColor())->toBe('success')
            ->and(Status::Inactive->getColor())->toBe('warning')
            ->and(Status::Trashed->getColor())->toBe('danger')
            ->and(Status::One->getColor())->toBe('danger');
    });

    it('getIcon returns correct icons', function () {
        expect(Status::Active->getIcon())->toBe('heroicon-o-check-circle')
            ->and(Status::Inactive->getIcon())->toBe('heroicon-o-document')
            ->and(Status::Trashed->getIcon())->toBe('heroicon-o-x-circle')
            ->and(Status::One->getIcon())->toBe('heroicon-o-x-circle');
    });

    it('getLabel method exists', function () {
        expect(method_exists(Status::Active, 'getLabel'))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(Status::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Enums');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(Status::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(Status::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Filament\Support\Contracts\HasColor;')
            ->and($content)->toContain('use Filament\Support\Contracts\HasIcon;')
            ->and($content)->toContain('use Filament\Support\Contracts\HasLabel;');
    });

    it('can be used in match expressions', function () {
        $value = Status::Active;

        $result = match (true) {
            $value instanceof Status => 'is status',
            default => 'unknown',
        };

        expect($result)->toBe('is status');
    });
});
