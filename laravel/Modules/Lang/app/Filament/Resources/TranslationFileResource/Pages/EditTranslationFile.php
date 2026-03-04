<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Lang\Filament\Resources\TranslationFileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditTranslationFile extends XotBaseEditRecord
{
    protected static string $resource = TranslationFileResource::class;

    /**
     * @return array<string>
     */
    public function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }

    #[\Override]
    public function getFormSchema(): array
    {
        return [
            Section::make('content')->schema(function ($record): array {
                if (is_object($record) && isset($record->content)) {
                    $content = is_array($record->content) ? $record->content : [];
                } else {
                    $content = [];
                }

                return $this->makeFromArray($content, 'content');
            }),
        ];
    }

    public function makeFromArray(array $array, string $prefix = ''): array
    {
        $fields = [];

        foreach ($array as $key => $value) {
            $fullKey = $prefix === '' ? $key : ($prefix.'.'.$key);

            if (is_array($value)) {
                /** @var array<string, mixed> $childArray */
                $childArray = $value;
                /** @var array<Htmlable|string> $childSchema */
                $childSchema = self::makeFromArray($childArray, $fullKey);
                $fields[] = Section::make($key)
                    ->label($fullKey)
                    ->schema($childSchema)
                    ->columns(2);
            } else {
                $fields[] = TextInput::make($fullKey)
                    // ->label($fullKey)
                    ->label($key)
                    ->default($value);
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
        /*
         * // Salva le traduzioni nel file
         * try {
         * $this->record->saveTranslations($data['content']);
         *
         * Notification::make()
         * ->title('Traduzioni salvate con successo')
         * ->success()
         * ->send();
         *
         * } catch (\Exception $e) {
         * Notification::make()
         * ->title('Errore durante il salvataggio')
         * ->body($e->getMessage())
         * ->danger()
         * ->send();
         *
         * // Previeni il salvataggio se c'è un errore
         * $this->halt();
         * }
         */
        $record = $this->record;
        if (is_object($record) && isset($record->key)) {
            $key = is_string($record->key) ? $record->key : (string) $record->key;
            /** @var array<string, mixed>|Htmlable|int|string|null $content */
            $content = $data['content'] ?? null;
            app(SaveTransAction::class)->execute($key, $content);
        }

        // dddx(['record'=>$this->record,'data'=>$data]);
        return $data;
    }

    protected function afterSave(): void
    {
        // Ricarica il record per aggiornare i dati
        if (is_object($this->record)) {
            $this->record->refresh();
        }
    }
}
