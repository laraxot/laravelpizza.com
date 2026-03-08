<?php

namespace Modules\ForumSubscriber\Filament\Resources\Pages;

use Modules\ForumSubscriber\Filament\Resources\ForumSubscriberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumSubscriber extends CreateRecord
{
    protected static string $resource = ForumSubscriberResource::class;
}