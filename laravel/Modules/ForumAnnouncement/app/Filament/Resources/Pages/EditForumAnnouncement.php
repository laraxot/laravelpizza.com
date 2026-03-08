<?php

namespace Modules\ForumAnnouncement\Filament\Resources\Pages;

use Modules\ForumAnnouncement\Filament\Resources\ForumAnnouncementResource;
use Filament\Resources\Pages\EditRecord;

class EditForumAnnouncement extends EditRecord
{
    protected static string $resource = ForumAnnouncementResource::class;
}