<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\CreateMessage;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\EditMessage;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\ListMessages;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

abstract class BaseMessageResource extends XotBaseResource
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'parent_id' => TextInput::make('parent_id'),
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
                            if (is_string($state) && $state !== '') {
                                $slugged = Str::slug($state, '_');
                                $set('new_type', $slugged);
                            }
                        }),
                ])
                ->createOptionUsing(function (array $data): string {
                    return isset($data['new_type']) && is_string($data['new_type']) ? $data['new_type'] : '';
                })
                ->createOptionModalHeading(__('ptv::message.actions.create_type.modal.heading')),
            'title' => TextInput::make('title'),
            'anno' => TextInput::make('anno'),
            'txt' => RichEditor::make('txt')->columnspan('full'),
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    protected static function getTypeOptions(): array
    {
        $model = static::getModel();
        $existingTypes = $model::distinct()
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->pluck('type')
            ->sort()
            ->mapWithKeys(function ($type): array {
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
