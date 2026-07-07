<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\BaseModel;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

it('base model is abstract', function (): void {
    $reflection = new \ReflectionClass(BaseModel::class);
    Assert::assertTrue($reflection->isAbstract());
});

it('base model uses activity connection', function (): void {
    // Test via reflection that the connection property is set to 'activity'
    $reflection = new \ReflectionClass(BaseModel::class);
    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    // Since BaseModel is abstract, we need to check the default value
    $default = $property->getDefaultValue();
    Assert::assertEquals('activity', $default);
});
