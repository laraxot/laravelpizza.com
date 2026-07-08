<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\WorkgroupResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\WorkgroupResource;
use Modules\Incentivi\Filament\Resources\WorkgroupResource\Actions\WorkgroupSeederAction;
use Modules\Incentivi\Models\Workgroup;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListWorkgroups extends XotBaseListRecords
{
    protected static string $resource = WorkgroupResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            'WorkgroupSeederAction' => WorkgroupSeederAction::make(),
        ];
    }

    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'denominazione' => TextColumn::make('denominazione')
                ->searchable(),
            'employees_cognome' => TextColumn::make('employees.cognome')
                ->label('Componenti')
                ->searchable()
                ->placeholder('Nessun componente presente.'),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        $parentActions = parent::getTableActions();

        return [
            ...$parentActions,
            'replicate' => ReplicateAction::make()
                ->beforeReplicaSaved(function (Workgroup $replica): void {
                    $replica->denominazione .= ' (copia)';
                })
                ->after(function (Workgroup $replica, Workgroup $record): void {
                    if ($record->employees()->exists()) {
                        $replica->employees()->attach($record->employees->pluck('id')->toArray());
                    }
                })
                ->modal(false)
                ->tooltip('duplica')
                // ->excludeAttributes(['matricola'])
                ->iconButton(),
        ];
    }

}
