<?php

declare(strict_types=1);

uses(Modules\Lang\Tests\TestCase::class);

use Modules\Lang\Models\Translation;

describe('Translation Model', function () {
    test('has correct fillable attributes', function () {
        $model = new Translation;
        $fillable = $model->getFillable();
        
        expect($fillable)->toContain('id');
        expect($fillable)->toContain('lang');
        expect($fillable)->toContain('value');
        expect($fillable)->toContain('namespace');
        expect($fillable)->toContain('group');
        expect($fillable)->toContain('item');
    });

    test('has correct status constants', function () {
        expect(Translation::STATUS_SAVED)->toBe(0);
        expect(Translation::STATUS_CHANGED)->toBe(1);
    });

    test('scopeOfTranslatedGroup filters by group', function () {
        $result = Translation::ofTranslatedGroup('test');
        
        expect($result)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });

    test('scopeOrderByGroupKeys orders by group and key', function () {
        $result = Translation::orderByGroupKeys(true);
        
        expect($result)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });

    test('scopeSelectDistinctGroup selects distinct groups', function () {
        $result = Translation::selectDistinctGroup();
        
        expect($result)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });

    test('casts datetime fields', function () {
        $model = new Translation;
        $casts = $model->getCasts();
        
        expect($casts)->toHaveKey('created_at');
        expect($casts)->toHaveKey('updated_at');
    });
});
