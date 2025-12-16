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

    #[\Override]
    public function getInfolistSchema(): array
    {
        // $view='pub_theme::components.sections.'.$this->record->slug;
        $view = 'cms::sections.preview';
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('View '.$view.' not found');
        }

        return [
            Section::make('Anteprima')->schema([
                ViewEntry::make('preview')->view($view, [
                    'section' => $this->record,
                ]),
            ]),
        ];
    }

    /*
     * protected function getHeaderActions(): array
     * {
     * return [
     * Actions\EditAction::make()
     * ->translateLabel(),
     * Actions\DeleteAction::make()
     * ->translateLabel(),
     * Actions\Action::make('preview')
     * ->translateLabel()
     * ->url(fn () => route('cms.sections.preview', $this->record))
     * ->openUrlInNewTab(),
     * ];
     * }
     */
}
