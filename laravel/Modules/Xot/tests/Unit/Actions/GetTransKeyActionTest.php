<?php

declare(strict_types=1);

use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\Fixtures\TransKeyCaller;
use Tests\TestCase;

uses(TestCase::class);

it('builds key for action classes removing action suffix', function (): void {
    $result = app(GetTransKeyAction::class)->execute('Modules\\Xot\\Actions\\File\\AssetAction');

    expect($result)->toBe('xot::asset');
});

it('handles list prefix and singularizes resource names', function (): void {
    $result = app(GetTransKeyAction::class)->execute('Modules\\Cms\\Filament\\Resources\\Pages\\ListUsers');

    expect($result)->toBe('cms::user');
});

it('handles relation manager classes singularizing related name', function (): void {
    $result = app(GetTransKeyAction::class)->execute('Modules\\Cms\\Filament\\Resources\\RelationManagers\\PostsRelationManager');

    expect($result)->toBe('cms::post');
});

it('uses main module fallback for non-module class strings', function (): void {
    XotData::make()->update(['main_module' => 'Xot']);

    $result = app(GetTransKeyAction::class)->execute('App\\Http\\Controllers\\FooBarController');

    expect($result)->toBe('xot::foo_bar_controller');
});

it('supports empty class parameter by reading class from backtrace', function (): void {
    $result = app(TransKeyCaller::class)->executeWithoutClass();

    expect($result)->toBe('xot::trans_key_caller');
});

it('uses module object from backtrace when non-module class is passed', function (): void {
    $result = app(TransKeyCaller::class)->executeWithNonModuleClass();

    expect($result)->toBe('xot::user');
});

it('handles form schema suffix cleanup', function (): void {
    $result = app(GetTransKeyAction::class)->execute('Modules\\Xot\\Actions\\GetUserFormSchemaAction');

    expect($result)->toBe('xot::user');
});
