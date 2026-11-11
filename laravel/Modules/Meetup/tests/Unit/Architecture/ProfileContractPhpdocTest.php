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
        $contents = (string) file_get_contents($file);

        // Il nome puo' essere qualificato o importato con `use` (dopo Pint): conta il tipo, non la forma.
        $usesContract = str_contains($contents, 'use Modules\\Xot\\Contracts\\ProfileContract;');

        foreach (['creator', 'updater', 'deleter'] as $relation) {
            expect($contents)->not->toContain('\\Modules\\Meetup\\Models\\Profile|null $'.$relation);

            $qualified = str_contains($contents, '\\Modules\\Xot\\Contracts\\ProfileContract|null $'.$relation);
            $imported = $usesContract && preg_match('/[\s(]ProfileContract\|null \$'.$relation.'\b/', $contents) === 1;

            expect($qualified || $imported)->toBeTrue($file.' $'.$relation);
        }
    }
});
