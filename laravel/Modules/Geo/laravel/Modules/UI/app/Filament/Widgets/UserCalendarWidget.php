<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

class UserCalendarWidget extends XotBaseSchemaWidget
{
    public string $type;

    protected string $view = 'ui::filament.widgets.user-calendar';

    public function getActionName(string $function): string
    {
        $actionSuffix = Str::of($function)->studly()->append('Action')->toString();
        $resource = XotData::make()->getUserResourceClassByType($this->type);
        $model = $resource::getModel();
        $modelString = SafeStringCastAction::cast($model);

        return Str::of($modelString)
            ->replace('\Models\\', '\\Actions\\')
            ->append('\\Calendar\\'.$actionSuffix)
            ->toString();
    }

    /**
     * @param array<string, mixed> $fetchInfo
     * @param array<string, mixed> $fetchInfo
     *
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

        return self::normalizeEventsArray($actionInstance->execute($fetchInfo));
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
                return self::normalizeFormSchema($actionInstance->execute());
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
    /**
     * @param array<string, mixed>|null $view
     * @param array<string, mixed>|null $resource
     */
    public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
    {
        // TODO: Implementare la logica per la selezione della data
    }

    /**
     * Normalize dynamic calendar action output into typed event arrays.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function normalizeEventsArray(mixed $value): array
    {
        if (! \is_array($value)) {
            return [];
        }

        /** @var array<int, array<string, mixed>> $events */
        $events = [];
        foreach ($value as $event) {
            if (! \is_array($event)) {
                continue;
            }

            $normalizedEvent = [];
            foreach ($event as $key => $eventValue) {
                if (! \is_string($key)) {
                    continue 2;
                }

                $normalizedEvent[$key] = $eventValue;
            }

            $events[] = $normalizedEvent;
        }

        return $events;
    }

    /**
     * @phpstan-return array<int, TextInput|Grid>
     */
    private static function normalizeFormSchema(mixed $value): array
    {
        if (! \is_array($value)) {
            return [];
        }

        $schema = [];
        foreach ($value as $key => $item) {
            if (! \is_int($key)) {
                return [];
            }

            if (! ($item instanceof TextInput) && ! ($item instanceof Grid)) {
                return [];
            }

            $schema[] = $item;
        }

        return $schema;
    }
}
