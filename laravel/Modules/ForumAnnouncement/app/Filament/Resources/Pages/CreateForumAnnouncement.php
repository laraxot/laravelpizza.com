<?php

namespace Modules\ForumAnnouncement\Filament\Resources\Pages;

use Modules\ForumAnnouncement\Filament\Resources\ForumAnnouncementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumAnnouncement extends CreateRecord
{
    protected static string $resource = ForumAnnouncementResource::class;
}