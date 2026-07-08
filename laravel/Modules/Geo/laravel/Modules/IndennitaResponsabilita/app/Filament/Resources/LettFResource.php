<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Components\Component;
// Corrected Component import
use Filament\Schemas\Components\Grid; // Corrected Section import
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Pages\CreateLettF;
use Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Pages\EditLettF;
use Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Pages\ListLettFs;
use Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Pages\ViewLettF;
use Modules\IndennitaResponsabilita\Models\LettF;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class LettFResource extends XotBaseResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = LettF::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 2;

    /**
     * Get the form schema definition.
     *
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'section_anagrafica' => /** @var Section $section */ Section::make('Anagrafica')
                ->columnSpanFull()
                ->schema([
                    'ente_anno_matr_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'ente' => TextInput::make('ente')
                                ->numeric()
                                ->required()
                                ->default(1),

                            'matr' => TextInput::make('matr')
                                ->required(),

                            'anno' => TextInput::make('anno')
                                ->numeric()
                                ->required()
                                ->minValue(2000)
                                ->maxValue(2100)
                                ->default((int) date('Y')),
                        ]),

                    'cognome_nome_email_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'cognome' => TextInput::make('cognome')
                                ->maxLength(255),

                            'nome' => TextInput::make('nome')
                                ->maxLength(255),

                            'email' => TextInput::make('email')
                                ->email()
                                ->required(),
                        ]),

                    'stabi_repar_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'stabi' => TextInput::make('stabi')
                                ->numeric(),

                            'repar' => TextInput::make('repar')
                                ->numeric(),
                        ]),
                ]),

            'section_periodo' => /** @var Section $section */ Section::make('Periodo')
                ->columnSpanFull()
                ->schema([
                    'dal_al_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'dal' => DatePicker::make('dal')
                                ->required()
                                ->native(false),

                            'al' => DatePicker::make('al')
                                ->required()
                                ->native(false),
                        ]),

                    'dalf_alf_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'dalf' => DatePicker::make('dalf')
                                ->native(false),

                            'alf' => DatePicker::make('alf')
                                ->native(false),
                        ]),
                ]),

            'section_valutazione' => /** @var Section $section */ Section::make('Valutazione')
                ->columnSpanFull()
                ->schema([
                    'posizione_lavoro' => Textarea::make('posizione_lavoro')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),

                    'valutazione_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'complessita' => TextInput::make('complessita')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(40)
                                ->step(1)
                                ->default(0),

                            'coordinamento' => TextInput::make('coordinamento')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(30)
                                ->step(1)
                                ->default(0),

                            'responsabilita' => TextInput::make('responsabilita')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(30)
                                ->step(1)
                                ->default(0),
                        ]),
                ]),

            'section_importi' => /** @var Section $section */ Section::make('Importi')
                ->columnSpanFull()
                ->schema([
                    'importi_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'tot' => TextInput::make('tot')
                                ->numeric()
                                ->disabled(),

                            'valore_economico_calcolato' => TextInput::make('valore_economico_calcolato')
                                ->numeric()
                                ->disabled()
                                ->step(0.01),

                            'valore_economico_attribuito' => TextInput::make('valore_economico_attribuito')
                                ->numeric()
                                ->disabled()
                                ->step(0.01),
                        ]),
                ]),

            'section_classificazione' => /** @var Section $section */ Section::make('Classificazione')
                ->columnSpanFull()
                ->schema([
                    'classificazione_grid' => /** @var Grid $grid */ Grid::make(3)
                        ->schema([
                            'propro' => TextInput::make('propro')
                                ->numeric(),

                            'posfun' => TextInput::make('posfun')
                                ->numeric(),

                            'categoria_eco' => TextInput::make('categoria_eco')
                                ->maxLength(255),
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
            'index' => ListLettFs::route('/'),
            'create' => CreateLettF::route('/create'),
            'view' => ViewLettF::route('/{record}'),
            'edit' => EditLettF::route('/{record}/edit'),
        ];
    }

    /**
     * Get the Eloquent query builder.
     *
     * @return Builder<LettF>
     */
    public static function getEloquentQuery(): Builder
    {
        /** @var Builder<LettF> $query */
        $query = parent::getEloquentQuery();

        return $query
            ->orderBy('anno', 'desc')
            ->orderBy('matr');
    }
}
