<?php

declare(strict_types=1);

namespace Modules\Xot\States;

use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Xot\Contracts\StateContract;
use Modules\Xot\Filament\Traits\TransTrait;
use Override;
use Spatie\ModelStates\State;

/**
 * Abstract base class for appointment state management.
 *
 * Defines the state machine configuration and required methods
 * that must be implemented by each concrete state class.
 *
 * @property string $name Il nome dello stato
 * @property string $value Il valore dello stato nel database
 */
abstract class XotBaseState extends State implements StateContract
{
    use TransTrait;

    public static string $name;

    public static function getName(): string
    {
        /* @phpstan-ignore-next-line */
        return static::$name ?? Str::of(class_basename(static::class))->snake()->toString();
    }

    #[Override]
    public function label(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.label');

        // return 'Annullato';
    }

    #[Override]
    public function color(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.color');
    }

    #[Override]
    public function bgColor(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.bg_color');

        // return 'info';
    }

    #[Override]
    public function icon(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.icon');

        // return 'heroicon-o-x-circle';
    }

    #[Override]
    public function modalHeading(): string
    {
        return static::transClass(static::class, 'states.'.static::getName().'.modal_heading');

        // return 'Annulla Appuntamento';
    }

    #[Override]
    public function modalDescription(): string
    {
        $appointment = $this->getModel();

        return static::transClass(static::class, 'states.'.static::getName().'.modal_description');

        // return 'Sei sicuro di voler annullare questo appuntamento?';
    }

    #[Override]
    public function modalFormSchema(): array
    {
        return [
            'message' => Textarea::make('message')->required()->maxLength(255),
        ];
    }

    /**
     * Fill form data for modal.
     *
     * @param  array<string, mixed>  $arguments
     * @param  array<string, mixed>  $data
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
    #[Override]
    public function modalFillFormByRecord(Model $record): array
    {
        return [];
    }

    /**
     * Execute modal action.
     *
     * @param  array<string, mixed>  $arguments
     * @param  array<string, mixed>  $data
     */
    public function modalAction(array $arguments, array $data): void
    {
        $this->processStateAction($arguments, $data);
    }

    /**
     * Process state action.
     *
     * @param  array<string, mixed>  $arguments
     * @param  array<string, mixed>  $data
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
        $record = $this->getModel();
        /* @phpstan-ignore-next-line */
        $record->state->transitionTo($stateClass, $message);
    }

    /**
     * Execute modal action by record.
     *
     * @param  array<string, mixed>  $data
     */
    #[Override]
    public function modalActionByRecord(Model $record, array $data): void
    {
        $this->processStateActionByRecord($record, $data);
    }

    /**
     * Process state action by record.
     *
     * @param  array<string, mixed>  $data
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
        /* @phpstan-ignore-next-line */
        $record->state->transitionTo($stateClass, $message);
    }

    public function isMessageRequired(): bool
    {
        return false;
    }

    public static function getOptions(): array
    {
        $states = static::getStateMapping()->toArray();

        $states = Arr::map($states, fn ($_stateClass, $state) => static::transClass(
            static::class,
            'states.'.(is_string($state) ? $state : (string) $state).'.label',
        ));

        return $states;
    }
}
