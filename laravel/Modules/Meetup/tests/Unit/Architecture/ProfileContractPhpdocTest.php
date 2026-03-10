<?php

declare(strict_types=1);

it('uses ProfileContract for audit relation phpdoc in shared model metadata', function (): void {
    $files = [
        dirname(__DIR__, 3).'/app/Models/Feedback.php',
        dirname(__DIR__, 3).'/app/Models/Performer.php',
        dirname(__DIR__, 3).'/app/Models/Sponsor.php',
        dirname(__DIR__, 3).'/app/Models/Venue.php',
        dirname(__DIR__, 4).'/Notify/app/Models/NotificationChannel.php',
        dirname(__DIR__, 4).'/Notify/app/Models/NotificationLog.php',
        dirname(__DIR__, 4).'/Tenant/app/Models/DatabaseConfig.php',
    ];

    foreach ($files as $file) {
        $contents = file_get_contents($file);

        expect(str_contains($contents, '\\Modules\\Meetup\\Models\\Profile|null $creator'))->toBeFalse();
        expect(str_contains($contents, '\\Modules\\Meetup\\Models\\Profile|null $updater'))->toBeFalse();
        expect(str_contains($contents, '\\Modules\\Meetup\\Models\\Profile|null $deleter'))->toBeFalse();
        expect(str_contains($contents, '\\Modules\\Xot\\Contracts\\ProfileContract|null $creator'))->toBeTrue();
        expect(str_contains($contents, '\\Modules\\Xot\\Contracts\\ProfileContract|null $updater'))->toBeTrue();
        expect(str_contains($contents, '\\Modules\\Xot\\Contracts\\ProfileContract|null $deleter'))->toBeTrue();
    }
});
