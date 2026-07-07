<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\User\Enums\UserType;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    $this->widget = new UserOverview();
    $this->user = User::factory()->create([
        'type' => UserType::MasterAdmin,
        'email' => 'admin-'.Str::lower(Str::random(10)).'@example.com',
    ]);
});

<<<<<<< HEAD
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
=======
describe('User Overview', function (): void {
    test('user overview widget extends correct base class', function (): void {
        /** @var TestCase $this */
        $widget = $this->requireWidget();
        Assert::assertInstanceOf(Widget::class, $widget);
    });

    test('user overview widget has correct view', function (): void {
        /** @var TestCase $this */
        $widget = $this->requireWidget();
        $reflection = new \ReflectionClass(UserOverview::class);
        $viewProperty = $reflection->getProperty('view');
        $viewProperty->setAccessible(true);

        Assert::assertSame('user::filament.resources.user-resource.widgets.user-overview', $viewProperty->getValue($widget));
    });

    test('user overview widget has record property', function (): void {
        /** @var TestCase $this */
        $widget = $this->requireWidget();
        Assert::assertInstanceOf(UserOverview::class, $widget);
        Assert::assertNull($widget->record);
    });

    test('user overview widget can set record', function (): void {
        /** @var TestCase $this */
        $widget = $this->requireWidget();
        Assert::assertInstanceOf(UserOverview::class, $widget);
        $user = $this->requireUser();
        $widget->record = $user;

        Assert::assertSame($user, $widget->record);
        Assert::assertInstanceOf(Model::class, $widget->record);
    });

    test('user overview widget record property is nullable', function (): void {
        $reflection = new \ReflectionClass(UserOverview::class);
        $recordProperty = $reflection->getProperty('record');

        Assert::assertTrue($recordProperty->getType()?->allowsNull() ?? false);
    });

    test('user overview widget has correct namespace', function (): void {
        Assert::assertStringContainsString((string) 'Modules\User\Filament\Resources\UserResource\Widgets', (string) UserOverview::class);
    });

    test('user overview widget can be instantiated', function (): void {
        /** @var TestCase $this */
        $widget = $this->requireWidget();
        Assert::assertInstanceOf(UserOverview::class, $widget);
    });

    test('user overview widget has correct static properties', function (): void {
        $reflection = new \ReflectionClass(UserOverview::class);
        $viewProperty = $reflection->getProperty('view');
        $viewProperty->setAccessible(true);

        Assert::assertFalse($viewProperty->isStatic());
    });

    test('user overview widget view path is correct', function (): void {
        /** @var TestCase $this */
        $widget = $this->requireWidget();
        $reflection = new \ReflectionClass(UserOverview::class);
        $viewProperty = $reflection->getProperty('view');
        $viewProperty->setAccessible(true);

        $viewPath = $viewProperty->getValue($widget);
        Assert::assertStringContainsString((string) 'user::', (string) $viewPath);
        Assert::assertStringContainsString((string) 'widgets.user-overview', (string) $viewPath);
    });
>>>>>>> 9fa499be (.)
});
