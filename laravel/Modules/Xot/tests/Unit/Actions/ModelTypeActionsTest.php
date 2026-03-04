<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\GetModelByModelTypeAction;
use Modules\Xot\Actions\GetModelClassByModelTypeAction;
use Modules\Xot\Actions\GetModelTypeByModelAction;
use Modules\Xot\Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Support\Facades\Config;

uses(TestCase::class);

it('resolves model class by model type from morph map', function (): void {
    Config::set('morph_map', ['user' => User::class]);
    
    $action = app(GetModelClassByModelTypeAction::class);
    expect($action->execute('user'))->toBe(User::class);
});

it('throws when morph map config is not an array', function (): void {
    Config::set('morph_map', null);
    $action = app(GetModelClassByModelTypeAction::class);
    expect(fn() => $action->execute('user'))->toThrow(\Exception::class);
});

it('throws when model type key is missing in morph map', function (): void {
    Config::set('morph_map', ['other' => 'SomeClass']);
    $action = app(GetModelClassByModelTypeAction::class);
    expect(fn() => $action->execute('user'))->toThrow(\InvalidArgumentException::class);
});

it('instantiates model by type when id is null', function (): void {
    Config::set('morph_map', ['user' => User::class]);
    
    $action = app(GetModelByModelTypeAction::class);
    $result = $action->execute('user', null);
    
    expect($result)->toBeInstanceOf(User::class);
    expect($result->exists)->toBeFalse();
});

it('loads model by id when record exists', function (): void {
    Config::set('morph_map', ['user' => User::class]);
    $user = User::factory()->create();
    
    $action = app(GetModelByModelTypeAction::class);
    $result = $action->execute('user', (string) $user->id);
    
    expect($result)->toBeInstanceOf(User::class);
    expect($result->id)->toBe($user->id);
});

it('throws when model id is provided but record is missing', function (): void {
    Config::set('morph_map', ['user' => User::class]);
    $action = app(GetModelByModelTypeAction::class);
    
    expect(fn() => $action->execute('user', '99999'))->toThrow(\Exception::class);
});

it('returns snake model type from model contract instance', function (): void {
    $user = new User();
    $action = app(GetModelTypeByModelAction::class);
    
    expect($action->execute($user))->toBe('user');
});
