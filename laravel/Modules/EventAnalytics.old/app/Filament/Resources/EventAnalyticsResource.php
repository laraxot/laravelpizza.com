<?php

namespace Modules\EventAnalytics\App\Filament\Resources;

use Modules\EventAnalytics\App\Models\EventAnalytics;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventAnalyticsResource extends Resource
{
    protected static ?string $model = EventAnalytics::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name')
                    ->required(),
                Forms\Components\TextInput::make('metric_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('metric_value')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('recorded_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metric_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('metric_value')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recorded_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \Modules\EventAnalytics\Filament\Resources\EventAnalyticsResource\Pages\ListEventAnalytics::route('/'),
            'create' => \Modules\EventAnalytics\Filament\Resources\EventAnalyticsResource\Pages\CreateEventAnalytics::route('/create'),
            'edit' => \Modules\EventAnalytics\Filament\Resources\EventAnalyticsResource\Pages\EditEventAnalytics::route('/{record}/edit'),
        ];
    }
}