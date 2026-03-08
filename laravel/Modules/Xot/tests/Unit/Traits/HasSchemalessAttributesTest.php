<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Traits\HasSchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributes;

if (! class_exists(TestModel::class)) {
    class TestModel extends XotBaseModel
    {
        use HasSchemalessAttributes;

        public $extra_attributes;

        public bool $saved = false;

        public function save(array $options = [])
        {
            $saved = true;

            return true;
        }
    }
}

it('handles extra attributes scope', function (): void {
    $builder = \Mockery::mock(Builder::class);
    $schemaless = \Mockery::mock(SchemalessAttributes::class);

    $class = new TestModel();

    // Test without attributes
    expect($class->scopeWithExtraAttributes($builder))->toBe($builder);

    // Test with attributes
    $class->extra_attributes = $schemaless;
    $schemaless->shouldReceive('modelScope')->andReturn($builder);
    expect($class->scopeWithExtraAttributes($builder))->toBe($builder);

    \Mockery::close();
});

it('handles where extra attribute scope', function (): void {
    $builder = \Mockery::mock(Builder::class);
    $builder->shouldReceive('where')->with('extra_attributes->key', 'value')->andReturnSelf();

    $class = new TestModel();

    expect($class->scopeWhereExtraAttribute($builder, 'key', 'value'))->toBe($builder);

    \Mockery::close();
});

it('gets and sets extra attributes', function (): void {
    $class = new TestModel();

    // Default
    expect($class->getExtraAttribute('missing', 'default'))->toBe('default');

    // Set (initializes SchemalessAttributes)
    $class->setExtraAttribute('foo', 'bar');
    expect($class->getExtraAttribute('foo'))->toBe('bar');
    expect($class->hasExtraAttribute('foo'))->toBeTrue();
    expect($class->hasExtraAttribute('baz'))->toBeFalse();
});

it('returns all extra attributes as array', function (): void {
    $class = new TestModel();

    expect($class->getExtraAttributes())->toBeArray()->toBeEmpty();

    $class->setExtraAttribute('a', 1);
    expect($class->getExtraAttributes())->toBe(['a' => 1]);
});

it('removes extra attribute', function (): void {
    $class = new TestModel();

    $class->setExtraAttribute('temp', 'val');
    expect($class->hasExtraAttribute('temp'))->toBeTrue();

    $class->removeExtraAttribute('temp');
    expect($class->hasExtraAttribute('temp'))->toBeFalse();
});

it('syncs extra attributes calls save', function (): void {
    $testObject = new TestModel();

    $testObject->syncExtraAttributes();
    expect($testObject->saved)->toBeTrue();
});
