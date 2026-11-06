<?php

declare(strict_types=1);

use Modules\User\Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

it('renders the english login calls to action from the user translation catalog', function (): void {
    get('/en/auth/login')
        ->assertOk()
        ->assertSee("Don't have an account yet?")
        ->assertSee('Create an account')
        ->assertSee('Forgot your password?')
        ->assertSee('Reset it')
        ->assertSee('/en/auth/register')
        ->assertSee('/en/auth/password/reset')
        ->assertDontSee('user::login.no_account')
        ->assertDontSee('user::login.forgot_password_text');
});
