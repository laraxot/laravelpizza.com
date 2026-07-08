<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Modules\Incentivi\Models\DefaultActivity;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class DefaultActivityResource extends XotBaseResource
{
    protected static ?string $model = DefaultActivity::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|\UnitEnum|null $navigationGroup = 'Impostazioni';

    protected static ?int $navigationSort = 5;

    /**
     * @return array<int|string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        // Multiple @var tags removed - types inferred by Filament v4
        return [
            'nome' => TextInput::make('nome')
                ->string()
                ->required()
                ->maxLength(255),
            'tipo' => Select::make('tipo')
                ->required()
                ->options([
                    'Lavori' => 'Lavori',
                    'Servizi' => 'Servizi',
                    'Misti' => 'Misti',
                ]),
            'appartiene_a_liquidazione_a_fasi' => Radio::make('appartiene_a_liquidazione_a_fasi')
                ->boolean()
                ->required()
                ->inline()
                ->inlineLabel(false)
                ->live(),
            Select::make('liquidazione_fasi')
                ->options([
                    'Prima' => 'Prima fase',
                    'Seconda' => 'Seconda fase',
                    'Entrambe' => 'Entrambe',
                ])
                ->hidden(fn (Get $get): bool => ! $get('appartiene_a_liquidazione_a_fasi')),
            TextInput::make('quota_percentuale')
                ->required()
                ->suffix('%'),
            TextInput::make('importo')
                ->required()
                ->suffix('€')
                ->disabled()
                ->placeholder('DA ASSEGNARE'),
            TextInput::make('anno_competenza')
                ->required()
                ->maxLength(4),
        ];
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
        $pages = parent::getPages();
        unset($pages['create']);

        return $pages;
    }
}
