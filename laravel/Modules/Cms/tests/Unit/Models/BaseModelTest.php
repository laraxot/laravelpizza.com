<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Models\BaseModelLang;

describe('Cms BaseModel', function (): void {
    test('base model uses correct connection', function (): void {
        $model = new class extends \Modules\Cms\Models\BaseModel {
        };

        expect($model->getConnectionName())->toBe('cms');
    });

    test('base model has id cast', function (): void {
        $model = new class extends \Modules\Cms\Models\BaseModel {
        };

        $casts = $model->getCasts();

        expect($casts)->toHaveKey('id');
    });

    test('base model has uuid cast', function (): void {
        $model = new class extends \Modules\Cms\Models\BaseModel {
        };

        $casts = $model->getCasts();

        expect($casts)->toHaveKey('uuid');
    });

    test('base model has published_at cast', function (): void {
        $model = new class extends \Modules\Cms\Models\BaseModel {
        };

        $casts = $model->getCasts();

        expect($casts)->toHaveKey('published_at');
    });

    test('base model has created_at cast', function (): void {
        $model = new class extends \Modules\Cms\Models\BaseModel {
        };

        $casts = $model->getCasts();

        expect($casts)->toHaveKey('created_at');
    });

    test('base model has updated_at cast', function (): void {
        $model = new class extends \Modules\Cms\Models\BaseModel {
        };

        $casts = $model->getCasts();

        expect($casts)->toHaveKey('updated_at');
    });

    test('base model extends XotBaseModel', function (): void {
        $model = new class extends \Modules\Cms\Models\BaseModel {
        };

        expect($model)->toBeInstanceOf(\Modules\Xot\Models\XotBaseModel::class);
    });
});
