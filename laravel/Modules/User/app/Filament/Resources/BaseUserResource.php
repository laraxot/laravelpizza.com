<?php

declare(strict_types=1);
/**
 * @see https://github.com/ryangjchandler/filament-user-resource/blob/main/src/resources/UserResource.php
 * @see https://github.com/3x1io/filament-user/blob/main/src/resources/UserResource.php
 */

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class BaseUserResource extends XotBaseResource
{
    // protected static ?string $model = \Modules\Xot\Datas\XotData::make()->getUserClass();

    // Static property Modules\User\Filament\Resources\UserResource::$enablePasswordUpdates is never read, only written.
    // private static bool|\Closure $enablePasswordUpdates = true;

    public static function getWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }

    // public static function extendForm(\Closure $callback): void
    // {
    //    static::$extendFormCallback = $callback;
    // }

    // public static function enablePasswordUpdates(bool|Closure $condition = true): void
    // {
    //     static::$enablePasswordUpdates = $condition;
    // }

    /*
     * public static function getModel(): string
     * {
     * return config('filament-user-resource.model');
     * }
     */

    #[\Override]
    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
