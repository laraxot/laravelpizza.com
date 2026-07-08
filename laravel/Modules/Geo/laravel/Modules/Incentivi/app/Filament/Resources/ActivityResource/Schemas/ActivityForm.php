<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Models\Activity;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ActivityForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'informazioni_group' => Group::make()
                ->schema([
                    Section::make('Informazioni')
                        ->schema([
                            'nome' => TextInput::make('nome')
                                ->string()
                                ->required()
                                ->columnSpan(6)
                                ->maxLength(255),
                            'tipo' => Select::make('tipo')
                                ->required()
                                ->columnSpan(1)
                                ->options([
                                    'Lavori' => 'Lavori',
                                    'Servizi' => 'Servizi',
                                    'Misti' => 'Misti',
                                ]),
                            'quota_percentuale' => TextInput::make('quota_percentuale')
                                ->required()
                                ->columnSpan(1)
                                ->suffix('%')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?Model $record) {
                                    if ($record === null || ! ($record instanceof Activity) || ! $record->project) {
                                        return;
                                    }

                                    $currentAssociatedProject = $record->project;
                                    $componenteIncentivante = is_numeric($currentAssociatedProject->componente_incentivante)
                                        ? floatval($currentAssociatedProject->componente_incentivante)
                                        : 0.0;

                                    $stateFloat = is_numeric($state) ? floatval($state) : 0.0;
                                    $set('importo', (float) ($componenteIncentivante * ($stateFloat / 100)));
                                }),
                            'importo' => TextInput::make('importo')
                                ->required()
                                ->suffix('€')
                                ->disabled()
                                ->dehydrated()
                                ->columnSpan(1),
                            'anno_competenza' => TextInput::make('anno_competenza')
                                ->required()
                                ->columnSpan(1)
                                ->maxLength(4),
                            'project_id' => TextInput::make('project_id')
                                ->required()
                                ->columnSpan(1)
                                ->readOnly(),
                        ])
                        ->columns(6),
                ])
                ->columnSpan(['lg' => 2]),
        ];
    }
}
