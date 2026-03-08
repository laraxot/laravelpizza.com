<?php

declare(strict_types=1);

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->widget = new UserOverview();
    $this->user = User::factory()->create([
        'type' => UserType::MasterAdmin,
        'email' => 'admin-'.Str::lower(Str::random(10)).'@example.com',
    ]);
});

test('user overview widget extends correct base class', function (): void {
    expect($this->widget)->toBeInstanceOf(Widget::class);
});

test('user overview widget has correct view', function (): void {
    $reflection = new ReflectionClass(UserOverview::class);
    $viewProperty = $reflection->getProperty('view');
    $viewProperty->setAccessible(true);

    expect($viewProperty->getValue($this->widget))
        ->toBe('user::filament.resources.user-resource.widgets.user-overview');
});

test('user overview widget has record property', function (): void {
    expect($this->widget)->toHaveProperty('record');
    expect($this->widget->record)->toBeNull();
});

test('user overview widget can set record', function (): void {
    $this->widget->record = $this->user;

    expect($this->widget->record)->toBe($this->user);
    expect($this->widget->record)->toBeInstanceOf(Model::class);
});

test('user overview widget record property is nullable', function (): void {
    $reflection = new ReflectionClass(UserOverview::class);
    $recordProperty = $reflection->getProperty('record');

    expect($recordProperty->getType()->allowsNull())->toBeTrue();
});

test('user overview widget has correct namespace', function (): void {
    expect(UserOverview::class)->toContain('Modules\User\Filament\Resources\UserResource\Widgets');
});

test('user overview widget can be instantiated', function (): void {
    expect($this->widget)->toBeInstanceOf(UserOverview::class);
});

test('user overview widget has correct static properties', function (): void {
    $reflection = new ReflectionClass(UserOverview::class);
    $viewProperty = $reflection->getProperty('view');
    $viewProperty->setAccessible(true);

    expect($viewProperty->isStatic())->toBeFalse();
});

test('user overview widget view path is correct', function (): void {
    $reflection = new ReflectionClass(UserOverview::class);
    $viewProperty = $reflection->getProperty('view');
    $viewProperty->setAccessible(true);

    $viewPath = $viewProperty->getValue($this->widget);
    expect($viewPath)->toContain('user::');
    expect($viewPath)->toContain('widgets.user-overview');
});
