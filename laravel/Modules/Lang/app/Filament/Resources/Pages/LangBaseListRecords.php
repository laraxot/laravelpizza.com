<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

abstract class LangBaseListRecords extends XotBaseListRecords
{
    use Translatable;

    protected static string $resource; // = SectionResource::class;

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        $parentActions = parent::getHeaderActions();

        /** @var array<string, Action> $actions */
        $actions = [
            'locale_switcher' => LocaleSwitcher::make(),
        ];

        foreach ($parentActions as $key => $action) {
            // Espandiamo eventuali ActionGroup per mantenere il contratto di ritorno
            if ($action instanceof ActionGroup) {
                foreach ($action->getActions() as $index => $groupedAction) {
                    $actions['parent_'.$key.'_'.$index] = $groupedAction;
                }
                continue;
            }

            $actions['parent_'.(is_string($key) ? $key : (string) $key)] = $action;
        }

        return $actions;
    }
}
