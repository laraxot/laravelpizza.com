<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Meetup\Filament\Resources\EventResource\Pages;
use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Events';

    protected static ?string $modelLabel = 'Event';

    protected static ?string $pluralModelLabel = 'Events';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Event Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        
                        Forms\Components\DateTimePicker::make('start_date')
                            ->required(),
                        
                        Forms\Components\DateTimePicker::make('end_date')
                            ->required(),
                        
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('draft')
                            ->required(),
                        
                        Forms\Components\TextInput::make('attendees_count')
                            ->numeric()
                            ->default(0),
                        
                        Forms\Components\TextInput::make('max_attendees')
                            ->numeric()
                            ->default(100),
                        
                        Forms\Components\FileUpload::make('cover_image')
                            ->image(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('attendees_count')
                    ->numeric(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}