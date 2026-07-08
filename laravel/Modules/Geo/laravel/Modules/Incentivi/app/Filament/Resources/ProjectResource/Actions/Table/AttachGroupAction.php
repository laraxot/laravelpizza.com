<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Actions\Table;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Workgroup;

class AttachGroupAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $workgroups = Workgroup::all();

        $this->translateLabel()
            ->label('Collega Gruppo')
            ->color('primary')
            ->icon('heroicon-s-user-group')
            ->modalContent(view('incentivi::filament.actions.attach-group', ['workgroups' => $workgroups]))
            ->schema(fn (Action $action): array => [
                Select::make('workgroup_id')
                    ->label('Gruppo')
                    ->options(Workgroup::all()->pluck('denominazione', 'id'))
                    ->searchable()
                    ->required(),
            ])
            ->after(function (Action $action, array $data, HasTable $livewire) {

                /** @var Workgroup|null $workgroup */
                $workgroup = Workgroup::find($data['workgroup_id']);

                // Type guard: ensure $livewire implements ManageRelatedRecords to access getOwnerRecord()
                if (! $livewire instanceof ManageRelatedRecords) {
                    return;
                }

                $project = $livewire->getOwnerRecord(); // Ottieni il progetto corrente

                if (! ($project instanceof Project) || $workgroup === null) {
                    return;
                }

                // Collega tutti gli Employee del Workgroup selezionato al Project corrente
                // $employees = $workgroup->employees;
                // $employees->each(function (Employee $employee) use ($project) {
                //     $employee->projects()->attach($project->id);
                // });

                $employees = $workgroup->employees;
                $employeeIds = array_map(static fn (mixed $id): string => (string) $id, $employees->pluck('id')->all());
                $alreadyAttached = array_map(
                    static fn (mixed $id): string => (string) $id,
                    $project->employees()
                        ->whereIn('employee_id', $employeeIds)
                        ->pluck('employee_id')
                        ->all(),
                );

                $newIds = array_diff($employeeIds, $alreadyAttached);

                if (! empty($newIds)) {
                    $project->employees()->syncWithoutDetaching($newIds);
                }

                if (! empty($alreadyAttached)) {
                    Notification::make()
                        ->title(count($alreadyAttached) . ' dipendente/i risultano già associati al progetto.')
                        ->body('I dipendenti già associati a questo progetto non sono stati duplicati. Quelli invece non ancora presenti sono stati aggiunti con successo.')
                        ->persistent()
                        ->success()
                        ->send();
                }



            });
    }

    public static function getDefaultName(): ?string
    {
        return 'AttachGroupAction';
    }
}
