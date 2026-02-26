<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\Pages;

use Filament\Actions\Action;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

abstract class LangBaseListRecords extends XotBaseListRecords
{
    use Translatable;

    protected static string $resource; // = SectionResource::class;

    #[\Override]
    protected function getHeaderActions(): array
    {
        $parentActions = parent::getHeaderActions();

        // Assicurarsi che tutte le azioni abbiano chiavi stringa
        $actions = [
            'locale_switcher' => LocaleSwitcher::make(),
        ];

        // Aggiungere le azioni parent con chiavi stringa
        foreach ($parentActions as $key => $action) {
            $actions['parent_'.(is_string($key) ? $key : ((string) $key))] = $action;
        }

        return $actions;
    }
}
