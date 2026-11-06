<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class EventForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'event_details' => Section::make('Event Details')
                ->schema([
                    'title' => TextInput::make('title')->required()->maxLength(255),
                    'description' => Textarea::make('description')->maxLength(65535)->columnSpanFull(),
                    'start_date' => DateTimePicker::make('start_date')->required(),
                    'end_date' => DateTimePicker::make('end_date')->required(),
                    'location' => TextInput::make('location')->required()->maxLength(255),
                    'status' => Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default('draft')
                        ->required(),
                    'attendees_count' => TextInput::make('attendees_count')->numeric()->default(0),
                    'max_attendees' => TextInput::make('max_attendees')->numeric()->default(100),
                    'cover_image' => FileUpload::make('cover_image')->image(),
                ])
                ->columns(2),
        ];
    }
}
