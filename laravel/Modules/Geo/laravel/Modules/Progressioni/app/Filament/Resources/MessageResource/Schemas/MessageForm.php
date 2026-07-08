<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MessageResource\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Str;
use Modules\Progressioni\Filament\Resources\MessageResource;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MessageForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'parent_id' => TextInput::make('parent_id'),
            // ParentSelect::make('parent_id'),
            'type' => Select::make('type')
                ->options(fn () => static::getTypeOptions())
                ->searchable()
                ->preload()
                ->allowHtml()
                ->createOptionForm([
                    TextInput::make('new_type')
                        ->required()
                        ->rules(['string', 'max:255', 'regex:/^[a-z0-9_\s]+$/i'])
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set): void {
                            // Type narrowing: ensure state is string
                            if (is_string($state) && $state !== '') {
                                $slugged = Str::slug($state, '_');
                                $set('new_type', $slugged);
                            }
                        }),
                ])
                ->createOptionUsing(function (array $data): string {
                    // Type narrowing: ensure new_type exists and is string
                    $newType = isset($data['new_type']) && is_string($data['new_type']) ? $data['new_type'] : '';

                    return $newType;
                })
                ->createOptionModalHeading(__('ptv::message.actions.create_type.modal.heading')),
            'title' => TextInput::make('title'),
            'anno' => TextInput::make('anno'), // ->default(fn($livewire)=>dddx($livewire->getTableFilters())),
            'txt' => RichEditor::make('txt')->columnspan('full'),
            // 'txt' => Textarea::make('txt')->columnspan('full'),
            // 'txt' => TiptapEditor::make('txt')
            //    ->columnSpan('full')
            //    ->output(TiptapOutput::Html),
        ];
    }

    /**
     * @return array<string, string>
     */
    protected static function getTypeOptions(): array
    {
        $model = MessageResource::getModel();
        $existingTypes = $model::query()
            ->distinct()
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->pluck('type')
            ->sort()
            ->mapWithKeys(function (mixed $type): array {
                if (! is_string($type)) {
                    return [];
                }

                $label = ucfirst(str_replace('_', ' ', $type));

                return [$type => $label];
            })
            ->toArray();

        /** @var array<string, string> $result */
        $result = $existingTypes;

        return $result;
    }
}
