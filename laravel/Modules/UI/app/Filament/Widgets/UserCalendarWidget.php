<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class UserCalendarWidget extends XotBaseWidget
{
    public string $type;

    protected string $view = 'ui::filament.widgets.user-calendar';

    public function getActionName(string $function): string
    {
        $action_suffix = Str::of($function)->studly()->append('Action')->toString();
        $resource = XotData::make()->getUserResourceClassByType($this->type);
        $model = $resource::getModel();
        $modelString = \is_string($model) ? $model : (string) $model;

        return Str::of($modelString)
            ->replace('\Models\\', '\\Actions\\')
            ->append('\\Calendar\\'.$action_suffix)
            ->toString();
    }

    /**
     * @param  array<string, mixed>  $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $action = $this->getActionName(__FUNCTION__);

        if (! class_exists($action)) {
            return [];
        }

        $actionInstance = app($action);
        if (! \is_object($actionInstance) || ! method_exists($actionInstance, 'execute')) {
            return [];
        }

        $resultRaw = $actionInstance->execute($fetchInfo);

        if (! self::isValidEventsArray($resultRaw)) {
            return [];
        }

        /** @var array<int, array<string, mixed>> $result */
        $result = $resultRaw;

        return $result;
    }

    /**
     * @return array<int, TextInput|Grid>
     */
    public function getFormSchema(): array
    {
        $action = $this->getActionName(__FUNCTION__);

        if (class_exists($action)) {
            $actionInstance = app($action);
            if (\is_object($actionInstance) && method_exists($actionInstance, 'execute')) {
                $resultRaw = $actionInstance->execute();
                if (self::isValidFormSchema($resultRaw)) {
                    /** @var array<int, TextInput|Grid> $result */
                    $result = $resultRaw;

                    return $result;
                }
            }
        }

        // Fallback schema
        return [
            TextInput::make('title'),
            Grid::make()
                ->schema([
                    DateTimePicker::make('starts_at'),
                    DateTimePicker::make('ends_at'),
                ]),
        ];
    }

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
    {
        // TODO: Implementare la logica per la selezione della data
    }

    /**
     * Validate that the given value is an array of events with string keys.
     */
    private static function isValidEventsArray(mixed $value): bool
    {
        if (! \is_array($value)) {
            return false;
        }

        foreach ($value as $event) {
            if (! \is_array($event)) {
                return false;
            }

            foreach (array_keys($event) as $key) {
                if (! \is_string($key)) {
                    return false;
                }
            }
        }

        return true;
    }

    private static function isValidFormSchema(mixed $value): bool
    {
        if (! \is_array($value)) {
            return false;
        }

        foreach ($value as $key => $item) {
            if (! \is_int($key)) {
                return false;
            }

            if (! ($item instanceof TextInput) && ! ($item instanceof Grid)) {
                return false;
            }
        }

        return true;
    }
}
