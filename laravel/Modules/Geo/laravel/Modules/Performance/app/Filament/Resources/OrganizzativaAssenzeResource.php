<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Pages\CreateOrganizzativaAssenze;
use Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Pages\EditOrganizzativaAssenze;
use Modules\Performance\Filament\Resources\OrganizzativaAssenzeResource\Pages\ListOrganizzativaAssenzes;
use Modules\Performance\Models\OrganizzativaAssenze;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class OrganizzativaAssenzeResource extends XotBaseResource
{
    protected static ?string $model = OrganizzativaAssenze::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'tipo' => TextInput::make('tipo')
                ->numeric(),
            'codice' => TextInput::make('codice')
                ->numeric(),
            'descr' => Textarea::make('descr')
                ->columnSpanFull(),
            'anno' => TextInput::make('anno')
                ->numeric(),

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'tipo' => TextColumn::make('tipo')
                ->numeric()
                ->sortable(),
            'codice' => TextColumn::make('codice')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),

        ];
    }

    /**
     * @return array<int, \Filament\Tables\Filters\SelectFilter>
     */
    public function getTableFilters(): array
    {
        return [
            app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),

        ];
    }

    /**
     * @return array<int, \Filament\Actions\EditAction>
     */
    public function getTableActions(): array
    {
        return [
            EditAction::make(),

        ];
    }

    /**
     * @return array<int, \Filament\Actions\DeleteBulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOrganizzativaAssenzes::route('/'),
            'create' => CreateOrganizzativaAssenze::route('/create'),
            'edit' => EditOrganizzativaAssenze::route('/{record}/edit'),
        ];
    }
}
