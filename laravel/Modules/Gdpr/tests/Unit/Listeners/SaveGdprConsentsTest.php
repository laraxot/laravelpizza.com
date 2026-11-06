<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Listeners;

use Mockery;
use Modules\Gdpr\Actions\Consent\SaveRegistrationConsentsAction;
use Modules\Gdpr\Listeners\SaveGdprConsents;
use Modules\User\Events\UserRegistered;
use Modules\User\Models\User;

test('SaveGdprConsents delega a SaveRegistrationConsentsAction senza logica propria', function (): void {
    $user = new User();
    $formData = [
        'privacy_policy_accepted' => true,
        'marketing_consent' => false,
    ];

    $action = Mockery::mock(SaveRegistrationConsentsAction::class);
    $action->shouldReceive('execute')
        ->once()
        ->with($user, $formData, '10.0.0.1', 'PestTest/1.0');
    app()->instance(SaveRegistrationConsentsAction::class, $action);

    (new SaveGdprConsents())->handle(new UserRegistered($user, $formData, '10.0.0.1', 'PestTest/1.0'));
});
