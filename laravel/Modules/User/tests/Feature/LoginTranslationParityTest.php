<?php

declare(strict_types=1);

use Modules\User\Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

/*
 * La pagina /{locale}/auth/login la disegna il tema del progetto (Sixteen: components/pages/auth/login.blade.php)
 * con le chiavi del modulo principale (`fixcity::auth.login.*`); il form e' il LoginWidget di User. Le frasi esatte
 * ("Don't have an account?" e simili) sono del catalogo del progetto: qui si verifica che la pagina inglese mostri le
 * chiamate all'azione tradotte e che nessuna chiave grezza arrivi all'utente.
 */
it('renders the english login calls to action without raw translation keys', function (): void {
    get('/en/auth/login')
        ->assertOk()
        ->assertSee('Create an account')
        ->assertSee('Forgot your password?')
        ->assertSee('/en/auth/register')
        ->assertDontSee('user::login.')
        ->assertDontSee('user::auth.login.')
        ->assertDontSee('fixcity::auth.login.');
});
