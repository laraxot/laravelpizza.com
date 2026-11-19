<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiKnowledgeEntryResource\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form di AiKnowledgeEntryResource. Nessun ->label(): etichette da `ai::ai_knowledge_entry.fields.*`.
 */
class AiKnowledgeEntryForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'section' => Section::make()
                ->schema([
                    'collection' => TextInput::make('collection')
                        ->required()
                        ->maxLength(255),

                    'is_active' => Toggle::make('is_active')
                        ->default(true),

                    'question' => Textarea::make('question')
                        ->required()
                        ->columnSpanFull(),

                    'answer' => Textarea::make('answer')
                        ->required()
                        ->rows(6)
                        ->columnSpanFull(),

                    'tags' => TagsInput::make('tags')
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ];
    }
}
