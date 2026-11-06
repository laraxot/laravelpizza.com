<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Modules\User\Models\BaseTenant;
use Modules\User\Models\Tenant;
use Modules\User\Tests\TestCase;
use Spatie\Sluggable\HasSlug;

uses(TestCase::class)->group('no-user-db');

it('loads BaseTenant with both HasUuids and HasSlug without a trait collision', function (): void {
    // Arrange
    $traits = class_uses_recursive(BaseTenant::class);

    // Act + Assert: un fatal in autoload per metodi duplicati farebbe fallire già la riga sopra
    expect($traits)->toHaveKey(HasUuids::class)
        ->and($traits)->toHaveKey(HasSlug::class);
});

it('keeps tenants.id a string key that gets a UUID when none is given', function (): void {
    // Arrange
    $tenant = new Tenant();

    // Act
    $generated = (string) $tenant->newUniqueId();

    // Assert
    expect($tenant->getIncrementing())->toBeFalse()
        ->and($tenant->getKeyType())->toBe('string')
        ->and($tenant->uniqueIds())->toBe(['id'])
        ->and(Str::isUuid($generated))->toBeTrue();
});

it('builds the slug from the name', function (): void {
    // Arrange
    $options = (new Tenant())->getSlugOptions();

    // Act + Assert
    expect($options->generateSlugFrom)->toBe(['name'])
        ->and($options->slugField)->toBe('slug');
});
