<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Generic\Rector\Class_\GitMergeConflictResolverRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->importNames();
    $rectorConfig->paths([
        __DIR__ . '/laravel/Modules/Xot',
        __DIR__ . '/laravel/Modules/Cms',
        __DIR__ . '/laravel/Modules/User',
        __DIR__ . '/laravel/Modules/Geo',
        __DIR__ . '/laravel/Modules/Notify',
        __DIR__ . '/laravel/Modules/Meetup',
        __DIR__ . '/laravel/Themes/Meetup',
    ]);

    // Aggiungi una regola personalizzata per risolvere i conflitti Git (se disponibile)
    // Nota: Rector non ha una regola standard per i conflitti Git, quindi dobbiamo crearne una personalizzata
};