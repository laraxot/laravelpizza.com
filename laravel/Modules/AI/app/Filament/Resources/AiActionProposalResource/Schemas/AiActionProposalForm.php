<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiActionProposalResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\AI\Enums\AiActionProposalStatusEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form dedicato di AiActionProposalResource.
 *
 * Nessun ->label(): le etichette arrivano da `ai::action_proposal.fields.*.label`
 * per convenzione (vedi docs/wiki/rules/no-filament-labels.md). Le opzioni della
 * Select arrivano da AiActionProposalStatusEnum (HasLabel, chiavi lang dell'enum).
 */
class AiActionProposalForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'section' => Section::make()
                ->schema([
                    'type' => TextInput::make('type')
                        ->required(),

                    'status' => Select::make('status')
                        ->options(AiActionProposalStatusEnum::class)
                        ->required(),

                    'preview' => Textarea::make('preview')
                        ->columnSpanFull(),

                    'error' => Textarea::make('error')
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ];
    }
}
