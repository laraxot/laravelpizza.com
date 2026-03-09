<?php

declare(strict_types=1);

// app/Filament/Components/TranslationEditor.php

namespace Modules\Lang\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class TranslationEditor extends Field
{
    protected string $view = 'lang::filament.forms.components.translation-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (TranslationEditor $component, $state): void {
            $component->state($state ?? []);
        });
    }

    public function getDefaultChildComponents(?string $key = null): array
    {
        $components = [];
        $state = $this->getState() ?? [];
        if (! is_iterable($state)) {
            return $components;
        }

        foreach ($state as $key => $value) {
            $keyStr = (string) $key;
            if (is_array($value)) {
                $components[] = Section::make($keyStr)->schema([
                    TranslationEditor::make($keyStr)->label('')->state($value),
                ]);
            } else {
                $valueStr = is_string($value) ? $value : (string) $value;
                $label = str_replace('_', ' ', $keyStr);
                $components[] = TextInput::make($keyStr)->label($label)->default($valueStr);
            }
        }

        return $components;
    }
}
