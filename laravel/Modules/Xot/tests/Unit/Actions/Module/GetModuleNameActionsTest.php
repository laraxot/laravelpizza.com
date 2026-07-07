<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Module\GetModuleNameByClassAction;
use Modules\Xot\Actions\Module\GetModuleNameByModelAction;
use Modules\Xot\Actions\Module\GetModuleNameByModelClassAction;
use PHPUnit\Framework\Assert;

it('extracts module name from class and model class', function (): void {
    $byClass = app(GetModuleNameByClassAction::class)->execute('Modules\\Cms\\Models\\Page');
    $byModelClass = app(GetModuleNameByModelClassAction::class)->execute('Modules\\Xot\\Models\\Module');

    Assert::assertSame('Cms', $byClass);
    Assert::assertSame('Xot', $byModelClass);
});

it('returns extracted fragment for non-module class signatures', function (): void {
    $byClass = app(GetModuleNameByClassAction::class)->execute('App\\Models\\User');
    $byModelClass = app(GetModuleNameByModelClassAction::class)->execute('App\\Models\\User');

    Assert::assertSame('App', $byClass);
    Assert::assertSame('App', $byModelClass);
});

it('delegates model instance class to model class action', function (): void {
    $model = new class extends Model {
        protected $table = 'test';
    };
    $delegate = Mockery::mock(GetModuleNameByModelClassAction::class);
    $delegate->allows(['execute' => 'Delegated']);
    app()->instance(GetModuleNameByModelClassAction::class, $delegate);

    $result = app(GetModuleNameByModelAction::class)->execute($model);

    Assert::assertSame('Delegated', $result);
});
