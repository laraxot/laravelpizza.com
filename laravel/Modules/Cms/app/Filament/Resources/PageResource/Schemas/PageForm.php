<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\PageResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class PageForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->required()
                ->lazy()
                ->afterStateUpdated(static function (Set $set, Get $get, string $state): void {
                    if ($get('slug')) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),
            'slug' => TextInput::make('slug')
                ->required()
                ->afterStateUpdated(static fn (Set $set, string $state) => $set('slug', Str::slug($state))),
            'content' => Section::make('Content')->schema([
                PageContentBuilder::make('content_blocks')->columnSpanFull(),
            ]),
            'sidebar' => Section::make('Sidebar')->schema([
                PageContentBuilder::make('sidebar_blocks')->columnSpanFull(),
            ]),
            'footer' => Section::make('Footer')->schema([
                PageContentBuilder::make('footer_blocks')->columnSpanFull(),
            ]),
        ];
    }
}
