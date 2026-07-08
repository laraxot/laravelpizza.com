<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Actions\Table;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Contracts\HasTable;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Enums\GenderEnum;

class AttachEsternoAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Aggiungi Consulente Esterno')
            ->color('gray')
            ->icon('heroicon-s-user-circle')
            ->schema(fn (): array => [
                TextInput::make('cognome')
                    ->required()->string(),
                TextInput::make('nome')
                    ->required()->string(),
                Select::make('sesso')
                    ->options(GenderEnum::class)
                    ->required(),
            ])
            ->after(function ($action, array $data, HasTable $livewire): void {
                if (! $livewire instanceof ManageRelatedRecords) {
                    return;
                }

                $project = $livewire->getOwnerRecord();
                if (! $project instanceof Project) {
                    return;
                }

                $cognome = is_string($data['cognome'] ?? null) ? $data['cognome'] : '';
                $nome = is_string($data['nome'] ?? null) ? $data['nome'] : '';
                $sesso = $data['sesso'] ?? null;

                $employee = Employee::create([
                    'matricola' => 1,
                    'cognome' => $cognome,
                    'nome' => $nome,
                    'sesso' => $sesso,
                    'tipologia' => 'E',
                    'codice_fiscale' => null,
                    'posizione_inail' => null,
                    'tqu00f_desc1' => null,
                    'tqu00f_desc2' => null,
                ]);

                $project->employees()->attach($employee->id);

                Notification::make()
                    ->title('Consulente Esterno aggiunto con successo')
                    ->success()
                    ->send();
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'AttachEsternoAction';
    }
}
