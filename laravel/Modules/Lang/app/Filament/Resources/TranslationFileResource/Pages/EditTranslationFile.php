<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Lang\Actions\ResolveTranslatableLocalesAction;
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
        return app(ResolveTranslatableLocalesAction::class)->execute();
    }

    /**
     * Schema della pagina.
     *
     * Niente `#[\Override]`: il metodo del genitore si chiama `getFormSchemaOld()`
     * ed e' `protected`. Con l'attributo, PHP emetteva un fatal error
     * («has #[\Override] attribute, but no matching parent method exists») che
     * impediva perfino a PHPStan di analizzare il modulo.
     *
     * @return array<int, Section>
     */
    public function getFormSchema(): array
    {
        return [
            Section::make('content')->schema(fn (?object $record): array => $this->schemaFromRecord($record)),
        ];
    }

    /**
     * Costruisce i campi della sezione `content` a partire dal record.
     *
     * Estratto dalla closure di {@see getFormSchemaOld()} per renderlo verificabile:
     * dentro una closure passata a `Section::schema()` la logica e' raggiungibile solo
     * montando l'intera pagina Filament, e i tre casi che contano — record valido,
     * record assente, `content` non array — non si distinguono nell'output.
     *
     * @return array<int, Section|TextInput>
     */
    public function schemaFromRecord(?object $record): array
    {
        if ($record === null || ! isset($record->content) || ! \is_array($record->content)) {
            return [];
        }

        /** @var array<string, mixed> $content */
        $content = $record->content;

        return $this->makeFromArray($content, 'content');
    }

    /**
     * @param  array<string, mixed>  $array
     * @return array<int, Section|TextInput>
     */
    public function makeFromArray(array $array, string $prefix = ''): array
    {
        $fields = [];

        foreach ($array as $key => $value) {
            $keyStr = (string) $key;
            $fullKey = $prefix === '' ? $keyStr : ($prefix.'.'.$keyStr);

            if (is_array($value)) {
                /** @var array<string, mixed> $childArray */
                $childArray = $value;
                /** @var array<Htmlable|string> $childSchema */
                $childSchema = self::makeFromArray($childArray, $fullKey);
                $fields[] = Section::make($keyStr)
                    ->label($fullKey)
                    ->schema($childSchema)
                    ->columns(2);
            } else {
                $fields[] = TextInput::make($fullKey)
                    // ->label($fullKey)
                    ->label($keyStr)
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
            /** @var string|int|float|bool|null $recordKeyNarrowed */
            $recordKeyNarrowed = $record->key;
            $key = is_string($recordKeyNarrowed) ? $recordKeyNarrowed : (string) $recordKeyNarrowed;
            /** @var array<string, mixed>|string|int|Htmlable|null $contentNarrowed */
            $contentNarrowed = $data['content'] ?? null;
            app(SaveTransAction::class)->persist($key, $contentNarrowed);
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
