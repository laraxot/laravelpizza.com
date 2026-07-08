<?php

declare(strict_types=1);

namespace Modules\Xot\States;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\StateContract;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Abstract base class for appointment state management.
 *
 * Defines the state machine configuration and required methods
 * that must be implemented by each concrete state class.
 *
 * @property string $name  Il nome dello stato
 * @property string $value Il valore dello stato nel database
 */
abstract class XotBaseState implements StateContract
{
    use TransTrait;

    public static string $name;

    public static function getName(): string
    {
        return static::$name ?? Str::of(class_basename(static::class))->snake()->toString();
    }

    public function label(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.label');

        // return 'Annullato';
    }

    public function color(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.color');
    }

    public function bgColor(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.bg_color');

        // return 'info';
    }

    public function icon(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.icon');

        // return 'heroicon-o-x-circle';
    }

    public function modalHeading(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.modal_heading');

        // return 'Annulla Appuntamento';
    }

    public function modalDescription(): string
    {
        // $appointment non utilizzata - rimossa

        return static::transClass(static::class, 'states.'.static::getName().'.modal_description');

        // return 'Sei sicuro di voler annullare questo appuntamento?';
    }

    /**
     * @return array<string, Component>
     */
    public function modalFormSchema(): array
    {
        return [
            'message' => Textarea::make('message')->required()->maxLength(255),
        ];
    }

    /**
     * Fill form data for modal.
     *
     * @param array<string, mixed> $arguments
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function modalFillForm(array $arguments, array $data): array
    {
        return $data;
    }

    /**
     * Fill form data for modal by record.
     *
     * @return array<string, mixed>
     */
    public function modalFillFormByRecord(Model $record): array
    {
        return [];
    }

    /**
     * Execute modal action.
     *
     * @param array<string, mixed> $arguments
     * @param array<string, mixed> $data
     */
    public function modalAction(array $arguments, array $data): void
    {
        $this->processStateAction($arguments, $data);
    }

    /**
     * Process state action.
     *
     * @param array<string, mixed> $arguments
     * @param array<string, mixed> $data
     */
    public function processStateAction(array $arguments, array $data): void
    {
        $message = Arr::get($data, 'message');
        $stateClass = static::class;
        /*
         *
         * $appointmentId = $arguments['appointment'];
         * $appointment = Appointment::firstWhere('id',$appointmentId);
         *
         * $appointment?->state->transitionTo($stateClass,$message);
         */
        // Fallback safe-mode when model-states package is not available.
        // Transition by generic arguments is intentionally a no-op.
    }

    /**
     * Execute modal action by record.
     *
     * @param array<string, mixed> $data
     */
    public function modalActionByRecord(Model $record, array $data): void
    {
        $this->processStateActionByRecord($record, $data);
    }

    /**
     * Process state action by record.
     *
     * @param array<string, mixed> $data
     */
    public function processStateActionByRecord(Model $record, array $data): void
    {
        $message = Arr::get($data, 'message');
        $stateClass = static::class;
        /*
         *
         * $appointmentId = $arguments['appointment'];
         * $appointment = Appointment::firstWhere('id',$appointmentId);
         *
         * $appointment?->state->transitionTo($stateClass,$message);
         */
        if (isset($record->state) && \is_object($record->state) && method_exists($record->state, 'transitionTo')) {
            $record->state->transitionTo($stateClass, $message);
        }
    }

    public function isMessageRequired(): bool
    {
        return false;
    }

    /**
     * @return array<string, mixed>
     */
    public static function getOptions(): array
    {
        if (! method_exists(static::class, 'getStateMapping')) {
            return [];
        }

        $mapping = static::getStateMapping();
        if (! \is_object($mapping) || ! method_exists($mapping, 'toArray')) {
            return [];
        }
        $states = $mapping->toArray();
        if (! \is_array($states)) {
            return [];
        }

        $result = [];
        foreach (array_keys($states) as $state) {
            $stateName = SafeStringCastAction::cast($state);
            $result[$stateName] = static::transClass(
                static::class,
                'states.'.$stateName.'.label',
            );
        }

        return $result;
    }
}
