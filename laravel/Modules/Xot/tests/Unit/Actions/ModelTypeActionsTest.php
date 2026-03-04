<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Models\Log;
use Modules\Xot\Contracts\ModelContract;
use Illuminate\Support\Facades\Config;
use Mockery;

uses(TestCase::class);

it('resolves model types correctly', function (): void {
    Config::set('morph_map', ['log' => Log::class]);
    
    $classAction = app(GetModelClassByModelTypeAction::class);
    expect($classAction->execute('log'))->toBe(Log::class);
    
    // Test GetModelTypeByModelAction with Mock
    $typeAction = app(GetModelTypeByModelAction::class);
    $mock = Mockery::mock(ModelContract::class);
    
    // class_basename of mock is something like "Mockery_0_Modules_Xot_Contracts_ModelContract"
    $result = $typeAction->execute($mock);
    expect($result)->toBeString();
    
    Mockery::close();
});
