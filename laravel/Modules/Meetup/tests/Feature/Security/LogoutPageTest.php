<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Security;

use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

/*
 * security-audit S-11: la pagina GET di logout eseguiva dd('a').
 */

test('the logout page renders without dumping debug output', function (): void {
    $this->get('/it/auth/logout')
        ->assertOk()
        ->assertSee(__('pub_theme::auth.logout.in_progress'));
});

test('the logout post route keeps its own name', function (): void {
    expect(route('logout', [], false))->not->toContain('/auth/logout')
        ->and(route('auth.logout', [], false))->toContain('auth/logout');
});
