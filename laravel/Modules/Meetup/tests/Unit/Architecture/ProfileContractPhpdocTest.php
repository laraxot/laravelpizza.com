<?php

declare(strict_types=1);

it('uses ProfileContract for audit relation phpdoc in shared model metadata', function (): void {
    $files = [
        dirname(__DIR__, 4).'/app/Models/Feedback.php',
        dirname(__DIR__, 4).'/app/Models/Performer.php',
        dirname(__DIR__, 4).'/app/Models/Sponsor.php',
        dirname(__DIR__, 4).'/app/Models/Venue.php',
        dirname(__DIR__, 4).'/../Notify/app/Models/NotificationChannel.php',
        dirname(__DIR__, 4).'/../Notify/app/Models/NotificationLog.php',
        dirname(__DIR__, 4).'/../Tenant/app/Models/DatabaseConfig.php',
    ];

    foreach ($files as $file) {
        $contents = file_get_contents($file);

        expect($contents)->not->toContain('\\Modules\\Meetup\\Models\\Profile|null $creator');
        expect($contents)->not->toContain('\\Modules\\Meetup\\Models\\Profile|null $updater');
        expect($contents)->not->toContain('\\Modules\\Meetup\\Models\\Profile|null $deleter');
        expect($contents)->toContain('\\Modules\\Xot\\Contracts\\ProfileContract|null $creator');
        expect($contents)->toContain('\\Modules\\Xot\\Contracts\\ProfileContract|null $updater');
        expect($contents)->toContain('\\Modules\\Xot\\Contracts\\ProfileContract|null $deleter');
    }
});
