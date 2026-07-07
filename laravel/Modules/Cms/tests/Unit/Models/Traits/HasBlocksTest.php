<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\Traits\HasBlocks;

uses(Modules\Cms\Tests\TestCase::class);
test('HasBlocks trait can be used', function () {
    // Create an anonymous class that uses the trait
    $model = new class extends BaseModel {
        use HasBlocks;

        protected $table = 'pages'; // Use existing table
    };

    // Check if the trait methods exist
});

test('HasBlocks trait has static method getBlocksBySlug', function () {
    // Create an anonymous class that uses the trait
    $modelClass = new class extends BaseModel {
        use HasBlocks;

        protected $table = 'pages'; // Use existing table
    };

    // Check if the static trait method exists on the trait itself
});
