<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\BaseModel;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BaseModelTest extends TestCase
{
    #[Test]
    public function base_model_is_abstract(): void
    {
        $reflection = new \ReflectionClass(BaseModel::class);
        $this->assertTrue($reflection->isAbstract());
    }

    #[Test]
    public function base_model_extends_xot_base_model(): void
    {
        $this->assertTrue(is_subclass_of(BaseModel::class, \Modules\Xot\Models\XotBaseModel::class));
    }

    #[Test]
    public function base_model_uses_activity_connection(): void
    {
        // Test via reflection that the connection property is set to 'activity'
        $reflection = new \ReflectionClass(BaseModel::class);
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);

        // Since BaseModel is abstract, we need to check the default value
        $default = $property->getDefaultValue();
        $this->assertEquals('activity', $default);
    }

    #[Test]
    public function base_model_has_casts_method(): void
    {
        // Test that casts() method exists
        $this->assertTrue(method_exists(BaseModel::class, 'casts'));
    }
}
