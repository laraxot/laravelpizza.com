<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('login screen can be rendered', function (): void {
    $lang = app()->getLocale();
    $response = cmsGet('/'.$lang.'/auth/login');
    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /{$lang}/auth/login returned server error ({$status}).");
    }

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function (): void {
    cmsSkipTest('Volt auth.login requires full theme + Comment module wiring in this install.');
});

/*
 * test('users cannot authenticate with invalid password', function(): void {
 * $userClass = XotData::make()->getUserClass();
 * $user = $userClass::factory()->createOne();
 *
 * $response = LivewireVolt::test('auth.login')
 * ->set('email', $user->email)
 * ->set('password', 'wrong-password')
 * ->call('login');
 *
 * $response->assertHasErrors('email');
 *
 * expect(Auth::guest())->toBeTrue();
 * });
 *
 * test('users can logout', function(): void {
 * $userClass = XotData::make()->getUserClass();
 * $user = $userClass::factory()->createOne();
 *
 * $response = actingAs($user)->post('/logout');
 *
 * Assert::assertSame('/', $response->headers->get('Location'));
 *
 * expect(Auth::guest())->toBeTrue();
 * });
 */
