<?php

declare(strict_types=1);

use App\Livewire\Actions\Logout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\User\Models\User;

uses(Tests\TestCase::class, Modules\Xot\Tests\CreatesApplication::class);

/*
 * Logout reale invece dei mock di Auth e Session: il mock della facade Session rompeva redirect(),
 * che legge la sessione per il "flash" della richiesta precedente.
 */
test('logout action logs out the user, renews the session and goes home', function (): void {
    $user = User::factory()->create(['email' => 'logout-'.uniqid().'@example.test']);
    $this->actingAs($user);
    Session::start();
    $tokenBefore = Session::token();

    $result = (new Logout)();

    $this->assertGuest();
    expect($result)->toBeInstanceOf(RedirectResponse::class)
        ->and(rtrim($result->getTargetUrl(), '/'))->toBe(rtrim(url('/'), '/'))
        ->and(Session::token())->not->toBe($tokenBefore);

    $user->delete();
});
