<?php

namespace Modules\ForumAnnouncement\Filament\Resources\Pages;

use Modules\ForumAnnouncement\Filament\Resources\ForumAnnouncementResource;
use Filament\Resources\Pages\ListRecords;

class ListForumAnnouncements extends ListRecords
{
    protected static string $resource = ForumAnnouncementResource::class;
}