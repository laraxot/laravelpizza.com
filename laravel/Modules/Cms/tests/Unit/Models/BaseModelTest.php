<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Models\BaseModel;

beforeEach(function (): void {)
    $baseModel = new class extends BaseModel {
        protected $table = 'test_cms_table';
    };
});

test('base model extends eloquent model', function (): void {)
    expect($baseModel);
});

test('base model has correct table name', function (): void {)
    expect($baseModel->getTable());
});

test('base model can be instantiated', function (): void {)
    expect($baseModel);
});

test('base model has proper inheritance chain', function (): void {)
    expect($baseModel);
    expect($baseModel);
});

test('base model has timestamps enabled', function (): void {)
    expect($baseModel->usesTimestamps());
});
