<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Components\Grid;
// Added this line
use Filament\Schemas\Components\Section; // Corrected Section import
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Pages\CreateLettI;
use Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Pages\EditLettI;
use Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Pages\ListLettIs;
use Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Pages\ViewLettI;
use Modules\IndennitaResponsabilita\Models\LettI;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

final class LettIResource extends XotBaseResource
{
    protected static string $resourceFile = __FILE__;

    protected static ?string $model = LettI::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-check';

    protected static ?int $navigationSort = 3;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'section_anagrafica' => /** @var Section $section */ Section::make('Anagrafica')
                ->columnSpanFull()
                ->schema([
                    'ente_matr_anno_grid' => /** @var Grid $grid */ Grid::make(3)
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
                                ->email(),
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

                    'dali_ali_grid' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'dali' => DatePicker::make('dali')
                                ->native(false),

                            'ali' => DatePicker::make('ali')
                                ->native(false),
                        ]),
                ]),

            'section_indennita' => /** @var Section $section */ Section::make('Indennità')
                ->columnSpanFull()
                ->schema([
                    'indennita_checkboxes_grid_1' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'archivista_informatico' => Checkbox::make('archivista_informatico')
                                ->inline(false),

                            'relazioni_pubblico' => Checkbox::make('relazioni_pubblico')
                                ->inline(false),
                        ]),

                    'indennita_checkboxes_grid_2' => /** @var Grid $grid */ Grid::make(2)
                        ->schema([
                            'protezione_civile' => Checkbox::make('protezione_civile')
                                ->inline(false),

                            'formatore_professionale' => Checkbox::make('formatore_professionale')
                                ->inline(false),
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
            'index' => ListLettIs::route('/'),
            'create' => CreateLettI::route('/create'),
            'view' => ViewLettI::route('/{record}'),
            'edit' => EditLettI::route('/{record}/edit'),
        ];
    }

    /**
     * Get the Eloquent query builder.
     *
     * @return Builder<LettI>
     */
    #[Override]
    public static function getEloquentQuery(): Builder
    {
        /** @var Builder<LettI> $query */
        $query = parent::getEloquentQuery();

        return $query
            ->orderBy('anno', 'desc')
            ->orderBy('matr');
    }
}
