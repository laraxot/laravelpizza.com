<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Models\XotBaseModel;
use Tests\TestCase;

uses(TestCase::class);

test('model type actions work', function () {
    config(['morph_map' => [
        'test_model' => XotBaseModel::class,
    ]]);
    
    $classAction = app(GetModelClassByModelTypeAction::class);
    expect($classAction->execute('test_model'))->toBe(XotBaseModel::class);
    
    $modelAction = app(GetModelByModelTypeAction::class);
    $model = $modelAction->execute('test_model', null);
    expect($model)->toBeInstanceOf(XotBaseModel::class);
    
    $typeAction = app(GetModelTypeByModelAction::class);
    // XotBaseModel should become xot_base_model
    expect($typeAction->execute($model))->toBe('xot_base_model');
});
