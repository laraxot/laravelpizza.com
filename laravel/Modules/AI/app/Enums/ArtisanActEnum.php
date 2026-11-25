<?php

declare(strict_types=1);

namespace Modules\Xot\Enums;

use Modules\Xot\Actions\Artisan\HandleArtisanActRequestAction;

/**
 * Valori ammessi del parametro legacy `act` che
 * {@see HandleArtisanActRequestAction} traduce in comandi artisan.
 *
 * I valori backed sono ESATTAMENTE le stringhe accettate oggi: sono l'API di chi invoca `act`.
 */
enum ArtisanActEnum: string
{
    case Migrate = 'migrate';
    case RouteList = 'routelist';
    case RouteListView = 'routelist1';
    case RouteCache = 'routecache';
    case RouteClear = 'routeclear';
    case QueueFlush = 'queue:flush';
    case Optimize = 'optimize';
    case Clear = 'clear';
    case ClearCache = 'clearcache';
    case ConfigCache = 'configcache';
    case ViewClear = 'viewclear';
    case DebugbarClear = 'debugbar:clear';
    case ModuleList = 'module-list';
    case ModuleDisable = 'module-disable';
    case ModuleEnable = 'module-enable';
    case Error = 'error';
    case ErrorShow = 'error-show';
    case ErrorClear = 'error-clear';
}
