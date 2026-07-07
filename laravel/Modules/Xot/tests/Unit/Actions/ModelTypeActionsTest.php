<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\Config;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Contracts\ModelContract;
use Modules\Xot\Models\Log;
use PHPUnit\Framework\Assert;

it('resolves model types correctly', function (): void {
    Config::set('morph_map', ['log' => Log::class]);

    $classAction = app(GetModelClassByModelTypeAction::class);
    Assert::assertSame(Log::class, $classAction->execute('log'));

    $typeAction = app(GetModelTypeByModelAction::class);
    $result = $typeAction->execute(new class extends Log implements ModelContract {
    });
    Assert::assertIsString($result);
});
