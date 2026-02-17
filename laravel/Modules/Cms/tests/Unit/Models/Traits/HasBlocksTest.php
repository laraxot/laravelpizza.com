<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Traits\HasBlocks;

test('HasBlocks trait can be used', function () {
    // Create an anonymous class that uses the trait
    $model = new class extends Modules\Cms\Models\BaseModel
    {
        use HasBlocks;

        protected $table = 'pages'; // Use existing table
    };

    // Check if the trait methods exist
    expect(method_exists($model, 'getBlocks'))->toBeTrue()
        ->and(method_exists($model, 'compile'))->toBeTrue();
});

test('HasBlocks trait has static method getBlocksBySlug', function () {
    // Create an anonymous class that uses the trait
    $modelClass = new class extends Modules\Cms\Models\BaseModel
    {
        use HasBlocks;

        protected $table = 'pages'; // Use existing table
    };

    // Check if the static trait method exists on the trait itself
    expect(method_exists(HasBlocks::class, 'getBlocksBySlug'))->toBeTrue();
});
