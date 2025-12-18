<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Modules\Xot\Contracts\StateContract;
use Spatie\ModelStates\State;
use Webmozart\Assert\Assert;

/**
 * IconStateSplitColumn - Enhanced state transition column with compact grid layout.
 *
 * This column displays state transition icons in a compact grid layout with:
 * - Optimized space usage with responsive grid
 * - Enhanced tooltips and visual feedback
 * - Smooth animations and hover effects
 * - Proper error handling and notifications
 * - Mobile-friendly design
 */
class IconStateSplitColumn extends Column
{
    protected string $view = 'ui::filament.tables.columns.icon-state-split';

    protected string $stateClass = '';

    protected string $modelClass = '';

    /**
     * Configure the state class and model class for this column.
     *
     * @param string $stateClass The state machine class (e.g., AppointmentState::class)
     * @param string $modelClass The model class (e.g., Appointment::class)
     */
    public function stateClass(string $stateClass, string $modelClass): static
    {
        $this->stateClass = $stateClass;
        $this->modelClass = $modelClass;

        return $this;
    }

    /**
     * @return array<string, array{class: StateContract, icon: string, label: string, color: string, tooltip: string}>
     */
    public function getRecordStates(): array
    {
        $statesRaw = [];
        if (class_exists($this->stateClass) && method_exists($this->stateClass, 'getStateMapping')) {
            $stateMapping = $this->stateClass::getStateMapping();
            if (is_object($stateMapping) && method_exists($stateMapping, 'toArray')) {
                $statesArray = $stateMapping->toArray();
                $statesRaw = is_array($statesArray) ? $statesArray : [];
            }
        }

        /** @var array<string, string> $states */
        $states = $statesRaw;
        $record = $this->getRecord();

        $result = [];
        foreach ($states as $stateKey => $stateClassItem) {
            try {
                if (! is_string($stateClassItem) || ! class_exists($stateClassItem)) {
                    continue;
                }

                $stateInstance = new $stateClassItem($record);
                Assert::isInstanceOf($stateInstance, StateContract::class);

                // StateContract provides icon(), label(), color()
                $icon = $stateInstance->icon();
                $label = $stateInstance->label();
                $color = $stateInstance->color();

                // Type narrowing: questi metodi restituiscono string
                $iconString = (string) $icon;
                $labelString = (string) $label;
                $colorString = (string) $color;

                // $stateKey è già string dalla chiave dell'array

                $result[$stateKey] = [
                    'class' => $stateInstance,
                    'icon' => $iconString,
                    'label' => $labelString,
                    'color' => $colorString,
                    'tooltip' => $labelString,
                ];
            } catch (\Exception $e) {
                // Skip problematic states
                continue;
            }
        }

        return $result;
    }

    public function canTransitionTo(int|string $recordId, string $stateClass): bool
    {
        if (! class_exists($this->modelClass) || ! method_exists($this->modelClass, 'find')) {
            return false;
        }

        $recordRaw = $this->modelClass::find($recordId);

        if (! $recordRaw || ! is_object($recordRaw)) {
            return false;
        }

        /** @var Model $record */
        $record = $recordRaw;

        if (! isset($record->state) || ! is_object($record->state)) {
            return false;
        }

        if (! ($record->state instanceof State)) {
            return false;
        }

        /** @var State $state */
        $state = $record->state;

        return $state->canTransitionTo($stateClass);
    }

    /**
     * Metodo per testare le azioni.
     */
    public function prova(int|string $recordId): void
    {
        // Logica per testare l'azione
        Notification::make()
            ->title('Test Azione')
            ->body("Record ID: {$recordId}")
            ->success()
            ->send();
    }

    /**
     * Restituisce le azioni per gli stati.
     *
     * @return array<string, Action>
     */
    public function getStateActions(): array
    {
        $record = $this->getRecord();
        $states = $this->getRecordStates();

        $actions = [];

        // Aggiungi azione di test
        $actions['prova'] = Action::make('prova')
            ->icon('heroicon-m-plus')
            ->color('primary')
            ->tooltip('Test Prova')
            ->action(function () use ($record) {
                $recordId = $record && isset($record->id) ? ((string) $record->id) : 'N/A';
                Notification::make()
                    ->title('Prova funziona!')
                    ->body('Record ID: '.$recordId)
                    ->success()
                    ->send();
            });

        // Aggiungi azioni per gli stati
        foreach ($states as $stateKey => $state) {
            if (! is_array($state) || ! isset($state['class']) || ! isset($state['icon']) || ! isset($state['color']) || ! isset($state['label'])) {
                continue;
            }

            $stateClass = $state['class'];
            $stateIcon = $state['icon'];
            $stateColor = $state['color'];
            $stateLabel = $state['label'];

            if (! is_object($stateClass) || ! ($stateClass instanceof StateContract)) {
                continue;
            }

            $recordIdRaw = is_object($record) && isset($record->id) ? $record->id : null;
            if (null === $recordIdRaw || (! is_int($recordIdRaw) && ! is_string($recordIdRaw))) {
                continue;
            }

            $recordId = is_int($recordIdRaw) ? $recordIdRaw : (string) $recordIdRaw;
            $stateClassName = $stateClass::class;
            if (! $this->canTransitionTo($recordId, $stateClassName)) {
                continue;
            }

            // Type narrowing: questi sono già string dalla struttura array
            $iconString = (string) $stateIcon;
            $colorString = (string) $stateColor;
            $labelString = (string) $stateLabel;

            $actions["transition_to_{$stateKey}"] = Action::make(
                "transition_to_{$stateKey}",
            )
                ->icon($iconString)
                ->color($colorString)
                ->label($labelString)
                ->action(function () use ($recordId, $stateClassName): void {
                    // $recordId è già stato verificato come int|string sopra
                    $this->transitionState($recordId, $stateClassName);
                });
        }

        return $actions;
    }

    /**
     * Listener per l'evento table-action.
     */
    #[On('table-action')]
    public function handleTableAction(string $action, int|string $recordId): void
    {
        if ('prova' === $action) {
            $this->prova($recordId);
        }
    }

    /**
     * Metodo per eseguire la transizione di stato.
     */
    public function transitionState(int|string $recordId, string $stateClass): void
    {
        try {
            if (! class_exists($this->modelClass) || ! method_exists($this->modelClass, 'find')) {
                throw new \Exception('Model class not found or invalid');
            }

            $recordRaw = $this->modelClass::find($recordId);

            if (! $recordRaw || ! is_object($recordRaw)) {
                throw new \Exception('Record non trovato');
            }

            /** @var Model $record */
            $record = $recordRaw;

            if (! isset($record->state) || ! is_object($record->state)) {
                throw new \Exception('State transition method not available');
            }

            if (! ($record->state instanceof State)) {
                throw new \Exception('State is not a valid State instance');
            }

            // Esegui la transizione
            /** @var State $state */
            $state = $record->state;
            $state->transitionTo($stateClass);

            Notification::make()
                ->title('Transizione Completata')
                ->body('Lo stato è stato cambiato con successo.')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Errore Transizione')
                ->body('Si è verificato un errore: '.$e->getMessage())
                ->danger()
                ->send();
        }
    }
}
