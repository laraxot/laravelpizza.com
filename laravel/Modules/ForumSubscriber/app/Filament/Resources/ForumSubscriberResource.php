<?php

namespace Modules\ForumSubscriber\App\Filament\Resources;

use Modules\ForumSubscriber\App\Models\ForumSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ForumSubscriberResource extends Resource
{
    protected static ?string $model = ForumSubscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('forum_id')
                    ->relationship('forum', 'name')
                    ->required(),
                Forms\Components\Select::make('subscription_type')
                    ->options([
                        'email' => 'Email',
                        'digest' => 'Digest',
                        'none' => 'None',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('created_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('forum.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subscription_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => \Modules\ForumSubscriber\Filament\Resources\ForumSubscriberResource\Pages\ListForumSubscribers::route('/'),
            'create' => \Modules\ForumSubscriber\Filament\Resources\ForumSubscriberResource\Pages\CreateForumSubscriber::route('/create'),
            'edit' => \Modules\ForumSubscriber\Filament\Resources\ForumSubscriberResource\Pages\EditForumSubscriber::route('/{record}/edit'),
        ];
    }
}