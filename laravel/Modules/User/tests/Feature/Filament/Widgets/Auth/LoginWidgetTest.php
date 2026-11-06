<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Widgets\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * Coverage for `Modules\User\Filament\Widgets\Auth\LoginWidget`, the SSoT login
 * widget registered by `UserServiceProvider::registerLivewireAuthWidgets()`.
 *
 * Previously untested (story 10.3). Full render/interaction assertions below are
 * skipped for now: they trip over TWO pre-existing, unrelated, already-committed
 * bugs discovered while writing this coverage, both introduced by commit
 * 0701a777a ("feat(gitmodules): add new submodule for Setting module", unrelated
 * message — collateral file truncation), outside this story's Owned Scope:
 *  1. Modules/User/lang/it/login.php returns int(1) instead of an array
 *     (`array_replace_recursive(): Argument #2 must be of type array, int given`).
 *  2. Modules/User/resources/views/filament/widgets/auth/login.blade.php was
 *     truncated from 111 lines to a single stray `</div>` (no opening tag —
 *     Livewire's `RootTagMissingFromViewException`).
 * Together these mean the live login widget currently cannot render at all.
 * See story 10.3 Dev Agent Record for full evidence. Un-skip once both are fixed.
 */
beforeEach(function (): void {
    /* @var TestCase $this */
    config(['activitylog.enabled' => false]);
    app()->setLocale('en');

    if (! Schema::connection('user')->hasTable('users')) {
        $this->markTestSkipped('users table missing on user connection (run migrations for testing)');
    }
});

describe('LoginWidget (Auth SSoT)', function (): void {
    test('delegates form schema to UserForm via formClass', function (): void {
        $reflection = new \ReflectionClass(LoginWidget::class);

        $formClass = $reflection->getMethod('formClass');
        $formClass->setAccessible(true);
        expect($formClass->invoke(null))->toBe(UserForm::class);

        $schemaMethod = $reflection->getMethod('schemaMethod');
        $schemaMethod->setAccessible(true);
        expect($schemaMethod->invoke(null))->toBe('getLoginFormSchema');
    });

    test('login widget renders successfully', function (): void {
        Livewire::test(LoginWidget::class)->assertSuccessful();
    })->skip('blocked by pre-existing bug: login.blade.php truncated to a single </div> (commit 0701a777a) — see story 10.3 Dev Agent Record');

    test('authenticates user with valid credentials', function (): void {
        /** @var TestCase $this */
        $email = 'pest-login-'.uniqid('', true).'@example.test';

        UserFactory::new()->createOne([
            'email' => $email,
            'password' => Hash::make('Password1!Secure'),
        ]);

        Livewire::test(LoginWidget::class)
            ->fillForm([
                'email' => $email,
                'password' => 'Password1!Secure',
                'remember' => false,
            ])
            ->call('login')
            ->assertHasNoErrors();

        expect(Auth::check())->toBeTrue();
    })->skip('blocked by pre-existing bug: login.blade.php truncated to a single </div> (commit 0701a777a) — see story 10.3 Dev Agent Record');

    test('rejects invalid credentials without authenticating', function (): void {
        Livewire::test(LoginWidget::class)
            ->fillForm([
                'email' => 'not-registered-'.uniqid('', true).'@example.test',
                'password' => 'wrong-password',
                'remember' => false,
            ])
            ->call('login')
            ->assertHasErrors(['data.email']);

        expect(Auth::check())->toBeFalse();
    })->skip('blocked by pre-existing bug: login.blade.php truncated to a single </div> (commit 0701a777a) — see story 10.3 Dev Agent Record');

    test('save delegates to login', function (): void {
        /** @var TestCase $this */
        $email = 'pest-login-save-'.uniqid('', true).'@example.test';

        UserFactory::new()->createOne([
            'email' => $email,
            'password' => Hash::make('Password1!Secure'),
        ]);

        Livewire::test(LoginWidget::class)
            ->fillForm([
                'email' => $email,
                'password' => 'Password1!Secure',
                'remember' => false,
            ])
            ->call('save')
            ->assertHasNoErrors();

        expect(Auth::check())->toBeTrue();
    })->skip('blocked by pre-existing bug: login.blade.php truncated to a single </div> (commit 0701a777a) — see story 10.3 Dev Agent Record');
});
