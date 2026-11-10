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
                            'draft' => __('meetup::event_form.fields.status.options.draft'),
                            'published' => __('meetup::event_form.fields.status.options.published'),
                            'cancelled' => __('meetup::event_form.fields.status.options.cancelled'),
                        ])
                        ->default('draft')
                        ->required(),
                    // Contatore denormalizzato gestito solo dalle Action di iscrizione: mai modificabile a mano.
                    'attendees_count' => TextInput::make('attendees_count')->numeric()->default(0)->disabled()->dehydrated(false),
                    // PRD FR-1: un evento non si salva senza una capienza valida.
                    'max_attendees' => TextInput::make('max_attendees')->numeric()->integer()->minValue(1)->required()->default(100),
                    'cover_image' => FileUpload::make('cover_image')->image(),
                ])
                ->columns(2),
        ];
    }
}
