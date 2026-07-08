<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Actions\Table;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Filament\Notifications\Notification;

class AttachSingleEmployeeAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Collega Dipendente')
            ->color('primary')
            ->icon('heroicon-s-user')
            ->schema(fn () => [
                Select::make('employee_id')
                    ->label('Dipendente')
                    ->options(Employee::all()->pluck('full_name', 'id'))
                    ->getOptionLabelFromRecordUsing(fn (Employee $record) => "{$record->full_name}")
                    ->searchable(['full_name'])
                    ->required(),
            ])
            ->after(function ($action, $data, HasTable $livewire) {
                // Type guard: ensure $livewire implements ManageRelatedRecords to access getOwnerRecord()
                if (! $livewire instanceof ManageRelatedRecords) {
                    return;
                }

                $project = $livewire->getOwnerRecord();
                if (! is_array($data) || ! isset($data['employee_id'])) {
                    return;
                }
                /** @var Employee|null $employee */
                $employee = Employee::find($data['employee_id']);

                if (! ($project instanceof Project) || $employee === null) {
                    return;
                }

                if ($employee->projects()->where('project_id', $project->id)->exists()) {
                    Notification::make()
                        ->title('Attenzione')
                        ->body('Il Dipendente selezionato è già associato a questo Progetto.')
                        ->warning()
                        ->send();
                    return;
                }

                $employee->projects()->attach($project->id);
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'AttachSingleEmployeeAction';
    }
}
