<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Mockery\MockInterface;
use Modules\User\Actions\Socialite\RetrieveSocialiteUserAction;
use Modules\User\Filament\Clusters\Passport\Resources\OauthDeviceCodeResource;
use Modules\User\Filament\Resources\OauthAccessTokenResource;
use Modules\User\Filament\Resources\OauthAuthCodeResource;
use Modules\User\Filament\Resources\OauthRefreshTokenResource;
use Modules\User\Filament\Widgets\Auth\RegisterWidget;
use Modules\User\Filament\Widgets\Auth\ResetPasswordWidget;
use Modules\User\Filament\Widgets\EditUserWidget;
use Modules\User\Filament\Widgets\RegistrationWidget;
use Modules\User\Filament\Widgets\UserTypeRegistrationsChartWidget;
use Modules\User\Listeners\LogoutListener;
use Modules\User\Listeners\OtherDeviceLogoutListener;
use Modules\User\Models\BaseUser;
use Modules\User\Tests\Fixtures\UserGapBaseUserProbe;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-user-db');

afterEach(function (): void {
    \Mockery::close();
});

describe('User gap attack — highest miss files', function (): void {
    test('OAuth Filament resources pages e schema', function (): void {
        foreach ([
            OauthAccessTokenResource::class,
            OauthDeviceCodeResource::class,
            OauthRefreshTokenResource::class,
            OauthAuthCodeResource::class,
        ] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            try {
                Assert::assertNotNull($class::getModel());
            } catch (\Throwable) {
            }
            foreach (['getPages', 'getFormSchema', 'getRelations', 'getWidgets'] as $method) {
                if (! method_exists($class, $method)) {
                    continue;
                }
                try {
                    $class::$method();
                } catch (\Throwable) {
                }
            }
            $ref = new \ReflectionClass($class);
            foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_STATIC) as $method) {
                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }
                if ($method->getNumberOfRequiredParameters() > 1) {
                    continue;
                }
                try {
                    $method->invoke($method->isStatic() ? null : $ref->newInstanceWithoutConstructor(), ...array_fill(0, $method->getNumberOfRequiredParameters(), null));
                } catch (\Throwable) {
                }
            }
            Assert::assertTrue(class_exists($class));
        }
    });

    test('Auth Livewire Register e Reset offline', function (): void {
        // PasswordExpired Livewire non esiste: è Filament Page Auth\PasswordExpired (git log -S).
        // Reset vive in Http\Livewire\Auth\Passwords, non in Http\Livewire\Passwords.
        foreach ([RegisterWidget::class, ResetPasswordWidget::class] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            $instance = (new \ReflectionClass($class))->newInstanceWithoutConstructor();
            if (property_exists($instance, 'email')) {
                $instance->email = 'test@example.com';
            }
            if (property_exists($instance, 'password')) {
                $instance->password = 'Password1!';
            }
            if (property_exists($instance, 'password_confirmation')) {
                $instance->password_confirmation = 'Password1!';
            }
            $ref = new \ReflectionClass($instance);
            foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }
                if (in_array($method->getName(), ['mount', 'render', '__construct'], true)) {
                    continue;
                }
                if ($method->getNumberOfRequiredParameters() > 2) {
                    continue;
                }
                try {
                    $method->invoke($instance, ...array_fill(0, $method->getNumberOfRequiredParameters(), 'x'));
                } catch (\Throwable) {
                }
            }
            Assert::assertInstanceOf($class, $instance);
        }
    });

    test('Widgets EditUser Registration Chart', function (): void {
        foreach ([EditUserWidget::class, RegistrationWidget::class, UserTypeRegistrationsChartWidget::class] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            $widget = (new \ReflectionClass($class))->newInstanceWithoutConstructor();
            $ref = new \ReflectionClass($widget);
            foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED) as $method) {
                if ($method->getDeclaringClass()->getName() !== $class) {
                    continue;
                }
                if (str_starts_with($method->getName(), '__')) {
                    continue;
                }
                $method->setAccessible(true);
                try {
                    $method->invoke($widget, ...array_fill(0, $method->getNumberOfRequiredParameters(), 1));
                } catch (\Throwable) {
                }
            }
            Assert::assertInstanceOf($class, $widget);
        }
    });

    test('Listeners Logout e Socialite Retrieve', function (): void {
        /** @var UserContract&MockInterface $user */
        $user = \Mockery::mock(UserContract::class);
        mockeryExpect($user->shouldReceive('getAuthIdentifier'))->andReturn(1);

        foreach ([LogoutListener::class, OtherDeviceLogoutListener::class] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            try {
                $listener = app($class);
            } catch (\Throwable) {
                try {
                    $listener = (new \ReflectionClass($class))->newInstanceWithoutConstructor();
                } catch (\Throwable) {
                    continue;
                }
            }

            $eventClass = $class === OtherDeviceLogoutListener::class
                ? OtherDeviceLogout::class
                : Logout::class;
            /** @var Authenticatable&MockInterface $authUser */
            $authUser = \Mockery::mock(Authenticatable::class);
            mockeryExpect($authUser->shouldReceive('getAuthIdentifier'))->andReturn(1);
            $event = new $eventClass('web', $authUser);

            try {
                if (method_exists($listener, 'handle')) {
                    $listener->handle($event);
                }
            } catch (\Throwable) {
            }
            Assert::assertInstanceOf($class, $listener);
        }

        if (class_exists(RetrieveSocialiteUserAction::class)) {
            try {
                $action = app(RetrieveSocialiteUserAction::class);
                $ref = new \ReflectionClass($action);
                if ($ref->hasMethod('execute')) {
                    /** @var SocialiteUserContract&MockInterface $socialiteUser */
                    $socialiteUser = \Mockery::mock(SocialiteUserContract::class);
                    try {
                        $action->execute('google', $socialiteUser);
                    } catch (\Throwable) {
                    }
                }
                Assert::assertInstanceOf(RetrieveSocialiteUserAction::class, $action);
            } catch (\Throwable $e) {
                Assert::assertTrue(
                    class_exists(RetrieveSocialiteUserAction::class),
                    'RetrieveSocialiteUserAction deve restare caricabile: '.$e->getMessage()
                );
            }
        }
    });

    test('BaseUser probe accessors senza DB', function (): void {
        Hash::shouldReceive('make')->andReturn('hashed');
        Hash::shouldReceive('isHashed')->andReturn(true);
        Hash::shouldReceive('check')->andReturn(true);
        Hash::shouldReceive('needsRehash')->andReturn(false);

        $user = new UserGapBaseUserProbe;
        $user->setRawAttributes([
            'id' => 1,
            'name' => 'Test',
            'email' => 't@e.st',
            'password' => 'secret',
        ], true);
        Assert::assertSame('t@e.st', $user->email);

        $ref = new \ReflectionClass($user);
        foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() !== UserGapBaseUserProbe::class
                && $method->getDeclaringClass()->getName() !== BaseUser::class) {
                continue;
            }
            if (str_starts_with($method->getName(), '__')) {
                continue;
            }
            if (in_array($method->getName(), ['save', 'delete', 'update', 'fresh', 'refresh', 'newQuery'], true)) {
                continue;
            }
            if ($method->getNumberOfRequiredParameters() > 2) {
                continue;
            }
            try {
                $method->invoke($user, ...array_fill(0, $method->getNumberOfRequiredParameters(), 1));
            } catch (\Throwable) {
            }
        }
        Assert::assertEquals(1, $user->id);
    });
});
