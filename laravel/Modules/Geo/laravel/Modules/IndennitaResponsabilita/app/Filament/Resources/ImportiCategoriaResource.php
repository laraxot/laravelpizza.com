<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource\Pages\CreateImportiCategoria;
use Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource\Pages\EditImportiCategoria;
use Modules\IndennitaResponsabilita\Filament\Resources\ImportiCategoriaResource\Pages\ListImportiCategorias;
use Modules\IndennitaResponsabilita\Models\ImportiCategoria;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class ImportiCategoriaResource extends XotBaseResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = ImportiCategoria::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-euro';

    protected static ?int $navigationSort = 10;

    /**
     * Get the form schema definition.
     *
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'main_section' => /** @var Section $section */ Section::make('Informazioni Principali')
                ->columnSpanFull()
                ->schema([
                    'ente_anno_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'ente' => TextInput::make('ente')
                                ->required()
                                ->numeric()
                                ->default(1),

                            'anno' => TextInput::make('anno')
                                ->required()
                                ->numeric()
                                ->default((int) date('Y')),
                        ]),

                    'categoria_lista_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'categoria' => TextInput::make('categoria')
                                ->required()
                                ->maxLength(255),

                            'lista_propro' => Textarea::make('lista_propro')
                                ->required()
                                ->rows(3),
                        ]),

                    'min_max_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'min' => TextInput::make('min')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->step(0.01),

                            'max' => TextInput::make('max')
                                ->required()
                                ->numeric()
                                ->default(0)
                                ->step(0.01),
                        ]),
                ]),
        ];
    }

    /**
     * Get the pages definition.
     *
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListImportiCategorias::route('/'),
            'create' => CreateImportiCategoria::route('/create'),
            'edit' => EditImportiCategoria::route('/{record}/edit'),
        ];
    }

    /**
     * Get the Eloquent query builder.
     *
     * @return Builder<ImportiCategoria>
     */
    #[Override]
    public static function getEloquentQuery(): Builder
    {
        /** @var Builder<ImportiCategoria> $query */
        $query = parent::getEloquentQuery();

        return $query
            ->orderBy('anno', 'desc')
            ->orderBy('categoria');
    }
}
