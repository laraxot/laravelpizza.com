<?php

declare(strict_types=1);

uses(\Modules\Notify\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\NotificationType;

describe('NotificationType Business Logic', function () {
    test('notification type extends eloquent model', function () {
        expect(is_subclass_of(NotificationType::class, Model::class))->toBeTrue();
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

        expect($property->getValue($reflection->newInstanceWithoutConstructor()))->toEqual($expectedFillable);
    });

    test('notification type model structure is correct', function () {
        // Verify class exists and extends Model
        expect(class_exists(NotificationType::class))->toBeTrue();
        expect(is_subclass_of(NotificationType::class, Model::class))->toBeTrue();
    });
});
