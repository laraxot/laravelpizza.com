<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Cms\Models\Section;
use Modules\Lang\Filament\Resources\LangBaseResource;

class SectionResource extends LangBaseResource
{
    protected static ?string $model = Section::class;

    /**
     * @return array<string, \Filament\Support\Components\Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'info' => \Filament\Schemas\Components\Section::make('info')->schema([
                'name' => TextInput::make('name')->translateLabel()->required(),
                'slug' => TextInput::make('slug')->translateLabel()->required(),
            ]),
            'blocks' => \Filament\Schemas\Components\Section::make('blocks')->schema([
                PageContentBuilder::make('blocks')->columnSpanFull(),
            ]),
        ];
    }
}
