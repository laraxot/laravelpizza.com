<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Models\Log;
use Illuminate\Support\Facades\Config;

uses(TestCase::class);

it('resolves model types correctly', function (): void {
    Config::set('morph_map', ['log' => Log::class]);
    
    $classAction = app(GetModelClassByModelTypeAction::class);
    expect($classAction->execute('log'))->toBe(Log::class);
    
    $modelAction = app(GetModelByModelTypeAction::class);
    $result = $modelAction->execute('log', null);
    expect($result)->toBeInstanceOf(Log::class);
    
    $typeAction = app(GetModelTypeByModelAction::class);
    // Log should become log
    expect($typeAction->execute($result))->toBe('log');
});
