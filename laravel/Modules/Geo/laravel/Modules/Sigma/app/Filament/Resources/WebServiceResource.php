<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Sigma\Filament\Resources\WebServiceResource\Pages\CreateWebService;
use Modules\Sigma\Filament\Resources\WebServiceResource\Pages\EditWebService;
use Modules\Sigma\Filament\Resources\WebServiceResource\Pages\ListWebServices;
use Modules\Sigma\Models\WebService;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class WebServiceResource extends XotBaseResource
{
    protected static ?string $model = WebService::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-server-stack';

    /**
     * @return array<string, TextInput>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'name' => TextInput::make('name'),
        ];
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListWebServices::route('/'),
            'create' => CreateWebService::route('/create'),
            'edit' => EditWebService::route('/{record}/edit'),
        ];
    }
}
