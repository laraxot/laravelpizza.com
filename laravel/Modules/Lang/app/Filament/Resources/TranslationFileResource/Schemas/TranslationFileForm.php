<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Lang\Models\TranslationFile;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Form del traduttore: in alto il file (sola lettura), sotto una casella per ogni testo.
 * Prima il form mostrava solo `name`: dal pannello non si poteva tradurre nulla.
 */
class TranslationFileForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'file' => Section::make()
                ->schema([
                    TextInput::make('name')->disabled()->dehydrated(false),
                    TextInput::make('key')->disabled()->dehydrated(false),
                ])
                ->columns(2),
            'content' => Section::make('content')
                ->schema(static fn (?TranslationFile $record): array => $record !== null && \is_array($record->content)
                    ? self::fieldsFromArray($record->content, 'content')
                    : []),
        ];
    }

    /**
     * Un gruppo per ogni sotto-array, una casella per ogni testo (chiave = percorso con i punti).
     *
     * @param  array<array-key, mixed>  $array
     * @return list<Component|TextInput|Textarea>
     */
    public static function fieldsFromArray(array $array, string $prefix): array
    {
        $fields = [];
        foreach ($array as $key => $value) {
            $path = $prefix.'.'.$key;
            if (\is_array($value)) {
                $fields[] = Section::make((string) $key)
                    ->description($path)
                    ->collapsible()
                    ->schema(self::fieldsFromArray($value, $path))
                    ->columns(2);

                continue;
            }

            $text = \is_scalar($value) ? (string) $value : '';
            $fields[] = mb_strlen($text) > 80
                ? Textarea::make($path)->label((string) $key)->rows(3)
                : TextInput::make($path)->label((string) $key);
        }

        return $fields;
    }
}
