<?php

namespace Modules\ForumPermission\Filament\Resources\Pages;

use Modules\ForumPermission\Filament\Resources\ForumPermissionResource;
use Filament\Resources\Pages\ListRecords;

class ListForumPermissions extends ListRecords
{
    protected static string $resource = ForumPermissionResource::class;
}