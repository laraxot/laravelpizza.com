<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Lang\Filament\Resources\TranslationFileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListTranslationFiles extends XotBaseListRecords
{
    protected static string $resource = TranslationFileResource::class;

    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'key' => TextColumn::make('key')->searchable(['key', 'content']),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[\Override]
    protected function getHeaderActions(): array
    {
        $parentActions = parent::getHeaderActions();

        /** @var array<string, Action> $actions */
        $actions = [
            'locale_switcher' => LocaleSwitcherRefresh::make('lang'),
        ];

        foreach ($parentActions as $key => $action) {
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
