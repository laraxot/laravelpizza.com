<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

class SelectStateColumn extends SelectColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->options(function (Model $record, mixed $state): array {
            $name = $this->getName();
            if (null === $state) {
                if (! method_exists($record, 'getDefaultStateFor')) {
                    return [];
                }
                $defaultStates = $record->getDefaultStateFor($name);
                $states = Arr::wrap($defaultStates);
                /** @var array<int|string, mixed> $states */
                $states = \is_array($states) ? $states : [];

                return $this->combineStateOptions($states);
            }

            $states = [];
            try {
                if (\is_object($state) && method_exists($state, 'transitionableStates')) {
                    $transitionableStates = $state->transitionableStates();
                    if (is_iterable($transitionableStates)) {
                        $states = \is_array($transitionableStates) ? $transitionableStates : iterator_to_array($transitionableStates);
                    }
                }
            } catch (\Exception) {
                if (! method_exists($record, 'getStatesFor')) {
                    return [];
                }
                $fetchedStates = $record->getStatesFor($name);
                $statesArray = \is_object($fetchedStates) && method_exists($fetchedStates, 'toArray')
                    ? $fetchedStates->toArray()
                    : [];
                $states = $statesArray;
            }

            /** @var array<int|string, mixed> $states */
            if (\is_object($state)) {
                $stateClass = $state::class;
                if (class_exists($stateClass)) {
                    $stateNameProperty = null;
                    try {
                        $reflection = new \ReflectionClass($stateClass);
                        if ($reflection->hasProperty('name')) {
                            $nameProperty = $reflection->getStaticPropertyValue('name');
                            $stateNameProperty = \is_string($nameProperty) ? $nameProperty : null;
                        }
                    } catch (\ReflectionException) {
                    }
                    if (null !== $stateNameProperty) {
                        $statesValues = array_values($states);
                        /** @var list<int|string> $statesValuesTyped */
                        $statesValuesTyped = $statesValues;
                        $states = [$stateNameProperty, ...$statesValuesTyped];
                    }
                }
            }

            /** @var array<int|string, mixed> $states */
            $statesFiltered = array_filter($states, static function (mixed $item): bool {
                return \is_string($item) || \is_int($item);
            });

            return $this->combineStateOptions($statesFiltered);
        });

        $this->beforeStateUpdated(static function (Model $record, mixed $stateRaw): void {
            if (! \is_string($stateRaw)) {
                return;
            }

            $state = $stateRaw;
            $message = '';

            $recordState = $record->getAttribute('state');
            if (! \is_object($recordState)) {
                return;
            }

            if (! method_exists($recordState, 'transitionTo')) {
                return;
            }

            $recordState->transitionTo($state, $message);
        });
    }

    /**
     * @param array<int|string, mixed> $states
     *
     * @return array<int|string, string>
     */
    private function combineStateOptions(array $states): array
    {
        $statesKeys = array_map(
            static fn ($key) => SafeStringCastAction::cast($key),
            array_keys($states),
        );
        $statesValues = array_map(
            static fn ($value) => SafeStringCastAction::cast($value),
            array_values($states),
        );
        $combined = array_combine($statesKeys, $statesValues);

        return $combined ? $combined : [];
    }
}
