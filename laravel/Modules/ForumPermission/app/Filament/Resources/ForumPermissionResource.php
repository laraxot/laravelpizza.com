<?php

namespace Modules\ForumPermission\Filament\Resources;

use Modules\ForumPermission\Filament\Resources\ForumPermissionResource\Pages;
use Modules\ForumPermission\App\Models\ForumPermission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\App\Models\Role;

class ForumPermissionResource extends Resource
{
    protected static ?string $model = ForumPermission::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Forum';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('forum_id')
                    ->relationship('forum', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('role_id')
                    ->relationship('role', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Toggle::make('can_create_post'),
                Forms\Components\Toggle::make('can_edit_post'),
                Forms\Components\Toggle::make('can_delete_post'),
                Forms\Components\Toggle::make('can_create_thread'),
                Forms\Components\Toggle::make('can_edit_thread'),
                Forms\Components\Toggle::make('can_delete_thread'),
                Forms\Components\Toggle::make('can_reply'),
                Forms\Components\Toggle::make('can_edit_reply'),
                Forms\Components\Toggle::make('can_delete_reply'),
                Forms\Components\Toggle::make('can_moderate'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('forum.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('can_create_post')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_edit_post')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_delete_post')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_create_thread')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_edit_thread')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_delete_thread')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_reply')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_edit_reply')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_delete_reply')
                    ->boolean(),
                Tables\Columns\IconColumn::make('can_moderate')
                    ->boolean(),
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
            'index' => Pages\ListForumPermissions::route('/'),
            'create' => Pages\CreateForumPermission::route('/create'),
            'edit' => Pages\EditForumPermission::route('/{record}/edit'),
        ];
    }
}