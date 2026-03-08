<?php

namespace Modules\ForumSubscriber\Filament\Resources\Pages;

use Modules\ForumSubscriber\Filament\Resources\ForumSubscriberResource;
use Filament\Resources\Pages\EditRecord;

class EditForumSubscriber extends EditRecord
{
    protected static string $resource = ForumSubscriberResource::class;
}