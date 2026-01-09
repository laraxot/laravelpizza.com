<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\ModelStates\HasStatesContract;
use Spatie\ModelStates\State;

class SelectStateColumn extends SelectColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        //  $this->selectablePlaceholder(false);
        $this->options(function (Model&HasStatesContract $record, mixed $state): array {
            $name = $this->getName();
            if (null === $state) {
                // Record implements HasStatesContract which provides getDefaultStateFor()
                $defaultStates = $record->getDefaultStateFor($name);
                $states = Arr::wrap($defaultStates);
                /** @var array<int|string, mixed> $states */
                $states = is_array($states) ? $states : [];
                $statesValues = array_map(fn ($v) => is_string($v) ? $v : (string) $v, array_values($states));
                $statesKeys = array_map(fn ($k) => is_string($k) ? $k : (string) $k, array_keys($states));
                $combined = array_combine($statesKeys, $statesValues);

                /* @var array<int|string, int|string> $result */
                return $combined ? $combined : [];
            }

            $states = [];
            try {
                if (is_object($state) && method_exists($state, 'transitionableStates')) {
                    $transitionableStates = $state->transitionableStates();
                    if (is_iterable($transitionableStates)) {
                        $states = is_array($transitionableStates) ? $transitionableStates : iterator_to_array($transitionableStates);
                    }
                }
            } catch (\Exception $e) {
                // Record implements HasStatesContract which provides getStatesFor()
                $fetchedStates = $record->getStatesFor($name);
                $statesArray = $fetchedStates->toArray();
                $states = $statesArray;
            }

            /** @var array<int|string, mixed> $states */
            if (is_object($state)) {
                $stateClass = $state::class;
                if (class_exists($stateClass)) {
                    $stateNameProperty = null;
                    // ✅ Usa Reflection invece di property_exists per maggiore affidabilità
                    try {
                        $reflection = new \ReflectionClass($stateClass);
                        if ($reflection->hasProperty('name')) {
                            $nameProperty = $reflection->getStaticPropertyValue('name');
                            $stateNameProperty = is_string($nameProperty) ? $nameProperty : null;
                        }
                    } catch (\ReflectionException) {
                        // Property non esiste, $stateNameProperty rimane null
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
            $statesFiltered = array_filter($states, function (mixed $item): bool {
                return is_string($item) || is_int($item);
            });

            /** @var array<int|string> $statesKeys */
            $statesKeys = array_map(fn ($k) => is_string($k) ? $k : (string) $k, array_keys($statesFiltered));
            /** @var array<int|string> $statesValues */
            $statesValues = array_map(fn ($v) => is_string($v) ? $v : (string) $v, array_values($statesFiltered));
            $combined = array_combine($statesKeys, $statesValues);
            /** @var array<int|string, int|string> $combinedTyped */
            $combinedTyped = $combined ? $combined : [];

            /** @var array<int|string> $statesKeys */
            $statesKeys = array_map(fn ($k) => is_string($k) ? $k : (string) $k, array_keys($statesFiltered));
            /** @var array<int|string> $statesValues */
            $statesValues = array_map(fn ($v) => is_string($v) ? $v : (string) $v, array_values($statesFiltered));
            $combined = array_combine($statesKeys, $statesValues);

            /* @var array<int|string, int|string> $combinedTyped */
            return $combined ? $combined : [];
        });

        $this->beforeStateUpdated(function (Model&HasStatesContract $record, mixed $stateRaw): void {
            // Type narrowing per $state: deve essere State|string
            if (! is_string($stateRaw) && ! ($stateRaw instanceof State)) {
                return;
            }

            $state = is_string($stateRaw) ? $stateRaw : $stateRaw;
            $message = '';

            if (! isset($record->state) || ! is_object($record->state)) {
                return;
            }

            if (! ($record->state instanceof State)) {
                return;
            }

            /** @var State $stateObj */
            $stateObj = $record->state;
            $stateObj->transitionTo($state, $message);
        });
    }
}
