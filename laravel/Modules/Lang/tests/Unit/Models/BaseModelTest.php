<?php

declare(strict_types=1);

uses(Modules\Lang\Tests\TestCase::class);

use Modules\Lang\Models\BaseModel;

describe('BaseModel', function () {
    test('has correct connection', function () {
        $model = new class extends BaseModel {
            protected $table = 'test';
        };
        
        expect($model->getConnectionName())->toBe('lang');
    });

    test('casts id as string', function () {
        $model = new class extends BaseModel {
            protected $table = 'test';
        };
        
        $casts = $model->getCasts();
        expect($casts['id'])->toBe('string');
    });

    test('casts uuid as string', function () {
        $model = new class extends BaseModel {
            protected $table = 'test';
        };
        
        $casts = $model->getCasts();
        expect($casts['uuid'])->toBe('string');
    });

    test('casts datetime fields', function () {
        $model = new class extends BaseModel {
            protected $table = 'test';
        };
        
        $casts = $model->getCasts();
        expect($casts['published_at'])->toBe('datetime');
        expect($casts['created_at'])->toBe('datetime');
        expect($casts['updated_at'])->toBe('datetime');
    });
});
