<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\StateContract as XotStateContract;

class IconStateColumn extends IconColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        // $this->getStateUsing(fn() => true); // the column requires a state to be passed to it

        $this->icon(function (XotStateContract $state) {
            return $state->icon();
        });

        $this->color(function (XotStateContract $state) {
            return $state->color();
        });

        $this->tooltip(function (XotStateContract $state) {
            return $state->label();
        });
        // $this->label('aaa');

        $this->action(
            Action::make('change-state')
                ->schema([
                    Select::make('state')
                        ->options(function (Model $record, string $_state): array {
                            $name = $this->getName();
                            $state = $record->getAttribute($name);
                            if (null === $state) {
                                if (! method_exists($record, 'getDefaultStateFor')) {
                                    return [];
                                }
                                $defaultStates = Arr::wrap($record->getDefaultStateFor($name));

                                /** @var array<string, string> $options */
                                $options = [];
                                foreach ($defaultStates as $defaultState) {
                                    if (! is_string($defaultState)) {
                                        continue;
                                    }

                                    $options[$defaultState] = $defaultState;
                                }

                                return $options;
                            }
                            if (! is_object($state) || ! method_exists($state, 'transitionableStates')) {
                                return [];
                            }

                            try {
                                /** @var array<int|string, mixed> $statesArray */
                                $statesArray = $state->transitionableStates();
                            } catch (\Exception $e) {
                                if (! method_exists($record, 'getStatesFor')) {
                                    return [];
                                }
                                $fetchedStates = $record->getStatesFor($name);
                                $statesArray = \is_object($fetchedStates) && method_exists($fetchedStates, 'toArray')
                                    ? $fetchedStates->toArray()
                                    : [];
                            }

                            if (! is_array($statesArray)) {
                                return [];
                            }

                            return Arr::mapWithKeys($statesArray, function (mixed $stateItem) use ($record): array {
                                if (! is_string($stateItem)) {
                                    return [];
                                }
                                $model = Str::of(class_basename($record))->slug()->toString();
                                /** @var string $label */
                                $label = __('pub_theme::'.$model.'_states.'.$stateItem.'.label');

                                return [$stateItem => $label];
                            });
                        })
                        ->required()
                        ->reactive(),
                    Textarea::make('message')->required(function (Get $get, Model $record): bool {
                        $newState = $get('state');
                        $name = $this->getName();
                        $state = $record->getAttribute($name);
                        if (! is_object($state) || ! method_exists($state, 'getStateMapping')) {
                            return false;
                        }

                        $states = $state::getStateMapping();
                        $statesArray = \is_object($states) && method_exists($states, 'toArray')
                            ? $states->toArray()
                            : [];
                        if (! is_array($statesArray)) {
                            return false;
                        }

                        $newStateClass = Arr::get($statesArray, SafeStringCastAction::cast($newState));
                        if (! is_string($newStateClass) || ! class_exists($newStateClass)) {
                            return false;
                        }

                        $newStateInstance = new $newStateClass($record);

                        return method_exists($newStateInstance, 'isMessageRequired')
                            ? (bool) $newStateInstance->isMessageRequired()
                            : false;
                    }),
                ])
                ->fillForm(function (Model $record): array {
                    $name = $this->getName();
                    $state = $record->getAttribute($name);
                    if (! is_object($state)) {
                        return [];
                    }
                    /** @var string $stateName */
                    // ✅ isset() invece di property_exists() - più sicuro e coerente
                    $stateName = isset($state->name) && is_string($state->name)
                        ? $state->name
                        : class_basename($state);

                    return [
                        'state' => $stateName,
                    ];
                })
                ->action(function ($record, $data): void {
                    /** @var array<string, mixed> $data */
                    if (! isset($data['state']) || ! is_string($data['state'])) {
                        throw new \Exception('State is required and must be a string');
                    }
                    $state = $data['state'];
                    /** @var Model $record */
                    if (! is_object($record)) {
                        throw new \Exception('Record must be an object');
                    }
                    $model = Str::of(class_basename($record))->slug()->toString();
                    /** @var string $label */
                    $label = __('pub_theme::'.$model.'_states.'.$state.'.label');

                    $currentState = $record->getAttribute($this->getName());
                    if (! is_object($currentState) || ! method_exists($currentState, 'transitionTo')) {
                        throw new \Exception('Current state is not a valid State instance');
                    }

                    /** @var string|null $message */
                    $message = isset($data['message']) && is_string($data['message']) ? $data['message'] : null;
                    $currentState->transitionTo($state, $message);

                    Notification::make()
                        ->title('Stato aggiornato a '.$label)
                        ->success()
                        ->send();
                }),
        );
    }
}
