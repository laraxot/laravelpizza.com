<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class SectionForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'info' => Section::make('info')->schema([
                'name' => TextInput::make('name')->translateLabel()->required(),
                'slug' => TextInput::make('slug')->translateLabel()->required(),
            ]),
            'blocks' => Section::make('blocks')->schema([
                PageContentBuilder::make('blocks')->columnSpanFull(),
            ]),
        ];
    }
}
