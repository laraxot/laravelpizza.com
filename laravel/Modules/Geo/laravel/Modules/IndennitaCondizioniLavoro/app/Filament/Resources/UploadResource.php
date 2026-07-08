<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Pages\CreateUpload;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Pages\EditUpload;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Pages\ListUploads;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Pages\ViewUpload;
use Modules\IndennitaCondizioniLavoro\Models\Upload;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class UploadResource extends XotBaseResource
{
    // use ContextualResource;
    protected static ?string $model = Upload::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        $dir = 'indennitaCondizioniLavoro/'.auth()->id();

        // $dir='indennitaCondizioniLavoro';
        return [
            'path' => FileUpload::make('path')
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf'])
            // ->disk('cache')
                ->directory($dir)
                ->openable()
            // ->downloadable()
                ->moveFiles(),
            'quadrimestre' => Select::make('quadrimestre')->options(['1' => '1', '2' => '2', '3' => '3', '4' => '4'])->required(),
            'anno' => Select::make('anno')->options(['2023' => '2023'])->required(),
            'note' => TextInput::make('note'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('path'),
                TextColumn::make('quadrimestre'),
                TextColumn::make('anno'),
                TextColumn::make('note'),
                // TextColumn::make('user_id'),
                TextColumn::make('updated_at'),
                TextColumn::make('created_at'),
            ])
            ->filters([
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListUploads::route('/'),
            'create' => CreateUpload::route('/create'),
            'view' => ViewUpload::route('/{record}'),
            'edit' => EditUpload::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    #[Override]
    public static function getNavigationBadge(): ?string
    {
        return null;
    }
}
