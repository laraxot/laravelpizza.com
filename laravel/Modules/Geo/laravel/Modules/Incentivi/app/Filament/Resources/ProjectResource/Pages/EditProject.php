<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Support\Enums\Size;
use Illuminate\Support\Facades\Auth;
use Modules\Incentivi\Actions\UpdateProjectActivitiesAction;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Filament\Resources\ProjectResource\Actions\GeneratePDFProjectReportAction;
use Modules\Incentivi\Filament\Resources\ProjectResource\Actions\GeneratePDFWorkgroupCompositionAction;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditProject extends XotBaseEditRecord
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $navigationLabel = 'Modifica Progetto';

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
            // GeneratePDFProjectReportAction::make(),

            // Array of actions
            'pdf_group' => ActionGroup::make([
                // GeneratePDFWorkgroupCompositionAction::make(),
                GeneratePDFProjectReportAction::make()
                    // ->visible(fn (): bool => Auth::user() !== null && Auth::user()->hasRole('super-admin'))
                    ,
            ])
                ->label('SCARICA PDF')
                ->icon('heroicon-m-ellipsis-vertical')
                ->size(Size::Small)
                ->color('success')
                ->button(),
        ];
    }

    protected function afterSave(): void
    {
        if ($this->record instanceof Project) {
            $this->updateProjectActivities();
            $this->attachRUPAndDEC();
        }
    }

    // Aggiorna le attività del progetto
    protected function updateProjectActivities(): void
    {
        if ($this->record instanceof Project) {
            app(UpdateProjectActivitiesAction::class)->execute($this->record ?? null);
        }
    }

    // Aggiunge il RUP e il DEC al progetto
    protected function attachRUPAndDEC(): void
    {
        if ($this->record instanceof Project) {
            $rupId = $this->record->rup;
            if ($rupId && ! $this->record->employees()->where('employee_id', $rupId)->where('project_id', $this->record->id)->exists()) {
                $this->record->employees()->attach($rupId, ['type' => 'employee_project']);
            }

            $decId = $this->record->dec;
            if ($decId && ! $this->record->employees()->where('employee_id', $decId)->where('project_id', $this->record->id)->exists()) {
                $this->record->employees()->attach($decId, ['type' => 'employee_project']);
            }
        }
    }
}
