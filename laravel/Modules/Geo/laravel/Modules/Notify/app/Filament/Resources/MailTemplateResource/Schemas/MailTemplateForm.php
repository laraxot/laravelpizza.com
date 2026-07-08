<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\View;
use Modules\Notify\Filament\Forms\Components\HtmlLayoutPathSelect;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class MailTemplateForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'mailable_slug_group' => Group::make()
                ->schema([
                    'mailable' => TextInput::make('mailable')
                        ->default('Modules\Notify\Emails\SpatieEmail')
                        ->required()
                        ->readonly()
                        ->maxLength(255),
                    'slug' => TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                ])
                ->columns(2),
            /*
            'name_slug_group' => Group::make()
                ->schema([
                    TextInput::make('name')
                        ->label('Nome Template')
                        ->required()
                        ->afterStateUpdated(function (string $state, Set $set): void {
                            $set('slug', Str::slug($state));
                        }),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                ])
                ->columns(2),
            */

            'subject' => TextInput::make('subject')
                ->required()
                ->maxLength(255),
            'html_layout_path' => HtmlLayoutPathSelect::make('html_layout_path')
                ->required(),
            'html_template' => RichEditor::make('html_template')
                ->required()
                ->columnSpanFull(),
            'params_display' => View::make('notify::filament.components.params-badges')
                ->viewData(fn ($record): array => [
                    'params' => is_object($record) && isset($record->params) ? $record->params : [],
                ])
                ->columnSpanFull()
                ->visible(fn ($record): bool => is_object($record) && isset($record->params) && ! empty($record->params)),
            'text_template' => Textarea::make('text_template')
                ->maxLength(65535)
                ->columnSpanFull(),
            'sms_template' => Textarea::make('sms_template')
                ->columnSpanFull(),
        ];

    }
}
