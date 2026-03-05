<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;
use Spatie\ModelStates\HasStatesContract;

class SelectState extends XotBaseSelect
{
    protected function setUp(): void
    {
        parent::setUp();

        //  $this->selectablePlaceholder(false);
        $this->options(function ((Model&HasStatesContract)|null $record): array {
            $name = $this->getName();
            if (null === $record) {
                $model = $this->getModel();
                if (\is_string($model) && class_exists($model)) {
                    $instance = app($model);
                    if (\is_object($instance)) {
                        $methodExists = method_exists($instance, 'getDefaultStateFor');
                        if ($methodExists) {
                            $statesRaw = $instance->getDefaultStateFor($name);
                            if (! \is_array($statesRaw)) {
                                $statesRaw = Arr::wrap($statesRaw);
                            }
                            /** @var array<int|string, mixed> $statesRaw */
                            $states = $statesRaw;
                            $statesKeys = array_map(static fn ($v) => \is_string($v) ? $v : (string) $v, array_values($states));
                            $statesValues = array_map(static fn ($v) => \is_string($v) ? $v : (string) $v, array_values($states));

                            $combined = array_combine($statesKeys, $statesValues);
                            /** @var array<int|string, int|string> $combinedTyped */
                            $combinedTyped = $combined ? $combined : [];
                            $statesKeys = array_map(static fn ($v) => \is_string($v) ? $v : (string) $v, array_values($states));
                            $statesValues = array_map(static fn ($v) => \is_string($v) ? $v : (string) $v, array_values($states));

                            $combined = array_combine($statesKeys, $statesValues);
                            /** @var array<int|string, int|string> $combinedTyped */
                            $combinedTyped = $combined ? $combined : [];

                            return $combinedTyped;
                        }
                    }
                }

                return [];
            }

            // Record implements HasStatesContract which provides getStatesFor()
            $statesCollection = $record->getStatesFor($name);
            // getStatesFor() returns Collection which has toArray()
            $statesRaw = $statesCollection->toArray();
            /** @var array<int|string, mixed> $states */
            $states = $statesRaw;
            $statesKeys = array_map(static fn ($v) => \is_string($v) ? $v : (string) $v, array_values($states));
            $statesValues = array_map(static fn ($v) => \is_string($v) ? $v : (string) $v, array_values($states));

            $combined = array_combine($statesKeys, $statesValues);
            /** @var array<int|string, int|string> $combinedTyped */
            $combinedTyped = $combined ? $combined : [];

            return $combinedTyped;
        });
        $this->required();
    }
}
