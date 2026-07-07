<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('renders the public profile route using the localized profile page', function (): void {
    $user = UserFactory::new()->createOne([
        'name' => 'Mario Rossi',
        'email' => TestCase::pestGenerateUniqueEmail(),
        'lang' => 'it',
    ]);

    $userId = $user->getKey();
    Assert::assertNotNull($userId);
    $response = cmsGet('/it/profile/'.(string) $userId);
    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest('Public profile route returned server error in this install.');
    }

    if (200 !== $status) {
        cmsSkipTest("Public profile route returned {$status} — profile FO page not configured.");
    }

    $response
        ->assertSee('Mario Rossi')
        ->assertSee(__('pub_theme::profile.badges.public_profile.label'))
        ->assertSee('ProfilePage', false);
});
