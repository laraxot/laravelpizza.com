<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

it('renders the public profile route using the localized profile page', function (): void {
    $user = User::factory()->create([
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.test',
        'lang' => 'it',
    ]);

    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/it/profile/'.$user->getKey());

    $response->assertOk()
        ->assertSee('Mario Rossi')
        ->assertSee(__('pub_theme::profile.badges.public_profile.label'))
        ->assertSee('ProfilePage', false);
});
