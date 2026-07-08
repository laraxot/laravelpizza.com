<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Filament\Resources\IndividualePesiResource\Pages\CreateIndividualePesi;
use Modules\Performance\Filament\Resources\IndividualePesiResource\Pages\EditIndividualePesi;
use Modules\Performance\Filament\Resources\IndividualePesiResource\Pages\ListIndividualePesis;
use Modules\Performance\Models\IndividualePesi;
use Modules\Ptv\Enums\WorkerType;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class IndividualePesiResource extends XotBaseResource
{
    protected static ?string $model = IndividualePesi::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    /**
     * @return array<string, \Filament\Support\Components\Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'type' => Select::make('type')
                ->options(WorkerType::class),
            'lista_propro' => TextInput::make('lista_propro')
                ->maxLength(250),
            'descr' => TextInput::make('descr')
                ->maxLength(50),
            'peso_esperienza_acquisita' => TextInput::make('peso_esperienza_acquisita')
                ->numeric(),
            'peso_risultati_ottenuti' => TextInput::make('peso_risultati_ottenuti')
                ->numeric(),
            'peso_arricchimento_professionale' => TextInput::make('peso_arricchimento_professionale')
                ->numeric(),
            'peso_impegno' => TextInput::make('peso_impegno')
                ->numeric(),
            'peso_qualita_prestazione' => TextInput::make('peso_qualita_prestazione')
                ->numeric(),
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
            'type' => TextColumn::make('type')
                ->searchable()
                ->badge(),
            'lista_propro' => TextColumn::make('lista_propro')
                ->wrapHeader()
                ->searchable(),
            'descr' => TextColumn::make('descr')
                ->searchable(),
            'peso_esperienza_acquisita' => TextColumn::make('peso_esperienza_acquisita')
                ->wrapHeader()
                ->numeric()
                ->sortable(),
            'peso_risultati_ottenuti' => TextColumn::make('peso_risultati_ottenuti')
                ->wrapHeader()
                ->numeric()
                ->sortable(),
            'peso_arricchimento_professionale' => TextColumn::make('peso_arricchimento_professionale')
                ->wrapHeader()
                ->numeric()
                ->sortable(),
            'peso_impegno' => TextColumn::make('peso_impegno')
                ->wrapHeader()
                ->numeric()
                ->sortable(),
            'peso_qualita_prestazione' => TextColumn::make('peso_qualita_prestazione')
                ->wrapHeader()
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
            SelectFilter::make('type')
                ->options(WorkerType::class),

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
            'index' => ListIndividualePesis::route('/'),
            'create' => CreateIndividualePesi::route('/create'),
            'edit' => EditIndividualePesi::route('/{record}/edit'),
        ];
    }
}
