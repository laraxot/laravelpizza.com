<?php

namespace Modules\ForumTemplate\Filament\Resources\Pages;

use Modules\ForumTemplate\Filament\Resources\ForumTemplateResource;
use Filament\Resources\Pages\ListRecords;

class ListForumTemplates extends ListRecords
{
    protected static string $resource = ForumTemplateResource::class;
}