<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Modules\Meetup\Actions\Event\UpdateEventAction;
use Modules\Meetup\Filament\Resources\EventResource as EventResourceClass;
use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Webmozart\Assert\Assert;

class EditEvent extends XotBaseEditRecord
{
    protected static string $resource = EventResourceClass::class;

    /**
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => EventResourceClass::configureDeleteAction(Actions\DeleteAction::make()),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Assert::isInstanceOf($record, Event::class);

        return app(UpdateEventAction::class)->execute($record, $data);
    }
}
