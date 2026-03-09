<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Pages;

use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseViewRecord;

class ViewSection extends LangBaseViewRecord
{
    protected static string $resource = SectionResource::class;

    protected function getInfolistSchema(): array
    {
        $view = 'cms::sections.preview';

        return [
            'preview' => Section::make('Anteprima')->schema([
                ViewEntry::make('preview')->view($view, [
                    'section' => $this->getRecord(),
                ]),
            ]),
        ];
    }
}
