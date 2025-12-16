<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Notify\Filament\Resources\NotificationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class EditNotification extends XotBaseEditRecord
{
    protected static string $resource = NotificationResource::class;
}
