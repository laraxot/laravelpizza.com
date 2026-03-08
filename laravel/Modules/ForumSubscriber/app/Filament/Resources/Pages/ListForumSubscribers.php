<?php

namespace Modules\ForumSubscriber\Filament\Resources\Pages;

use Modules\ForumSubscriber\Filament\Resources\ForumSubscriberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForumSubscribers extends ListRecords
{
    protected static string $resource = ForumSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}