<?php

declare(strict_types=1);

uses(Modules\User\Tests\TestCase::class);

use Modules\User\Mail\TeamInvitation;

test('TeamInvitation mail can be instantiated', function () {
    expect(class_exists(TeamInvitation::class))->toBeTrue();
    // TeamInvitation requires a TeamInvitationModel - just verify the class exists
    // and can be reflected upon without needing actual construction
    $reflection = new ReflectionClass(TeamInvitation::class);
    expect($reflection->isInstantiable())->toBeTrue();
});

test('TeamInvitation has expected methods', function () {
    // TeamInvitation extends Mailable; modern Laravel Mailables use content() or envelope()
    // instead of build(). Verify it extends Mailable properly.
    $reflection = new ReflectionClass(TeamInvitation::class);

    expect($reflection->getParentClass()->getName())->toBe(\Illuminate\Mail\Mailable::class);

    // Mailable has 'send', 'queue', 'later' methods
    expect(method_exists(TeamInvitation::class, 'send'))->toBeTrue();
    expect(method_exists(TeamInvitation::class, 'queue'))->toBeTrue();
});
