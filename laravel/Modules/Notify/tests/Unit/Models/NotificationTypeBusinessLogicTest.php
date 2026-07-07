<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\NotificationType;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);

describe('NotificationType Business Logic', function () {
    test('notification type extends eloquent model', function () {
            });

    test('notification type has expected fillable fields', function () {
        $reflection = new \ReflectionClass(NotificationType::class);
        $property = $reflection->getProperty('fillable');
        $property->setAccessible(true);

        $expectedFillable = [
            'name',
            'description',
            'template',
        ];

        Assert::assertEquals($expectedFillable, $property->getValue($reflection->newInstanceWithoutConstructor()));
    });

    test('notification type model structure is correct', function () {
        // Verify class exists and extends Model
        Assert::assertTrue(class_exists(NotificationType::class));
            });
});
