<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Lang\Filament\Resources\TranslationFileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditTranslationFile extends XotBaseEditRecord
{
    protected static string $resource = TranslationFileResource::class;

    public function getFormSchema(): array
    {
        return [
            Section::make('content')->schema(function ($record): array {
                $content = (is_object($record) && isset($record->content)) ? (array) $record->content : [];

                return $this->makeFromArray($content, 'content');
            }),
        ];
    }

    public function makeFromArray(array $array, string $prefix = ''): array
    {
        $fields = [];
        foreach ($array as $key => $value) {
            $fullKey = '' === $prefix ? $key : ($prefix.'.'.$key);
            if (is_array($value)) {
                $fields[] = Section::make($key)
                    ->schema($this->makeFromArray($value, $fullKey))
                    ->columns(2);
            } else {
                $fields[] = TextInput::make($fullKey)->label($key)->default((string) $value);
            }
        }

        return $fields;
    }

    protected function getHeaderActions(): array
    {
        return array_merge(
            ['locale-switcher' => LocaleSwitcherRefresh::make('lang')],
            parent::getHeaderActions(),
        );
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();
        if (is_object($record) && isset($record->key)) {
            $key = (string) $record->key;
            app(SaveTransAction::class)->execute($key, $data['content'] ?? []);
        }

        return $data;
    }
}
