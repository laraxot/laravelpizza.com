<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Actions\Action;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\StateContract;
use Webmozart\Assert\Assert;

class IconStateGroupColumn extends ColumnGroup
{
    public string $stateClass = '';

    public string $modelClass = '';

    public array $data = [];

    protected function setUp(): void
    {
        // $this->label('');
    }

    public function stateClass(string $stateClass, string $modelClass): static
    {
        $this->stateClass = $stateClass;
        $this->modelClass = $modelClass;
        $statesRaw = [];

        if (class_exists($stateClass) && method_exists($stateClass, 'getStateMapping')) {
            $stateMapping = $stateClass::getStateMapping();
            if (is_object($stateMapping) && method_exists($stateMapping, 'toArray')) {
                $statesArray = $stateMapping->toArray();
                $statesRaw = is_array($statesArray) ? $statesArray : [];
            }
        }

        /** @var array<string, string> $states */
        $states = $statesRaw;
        $columns = [];

        foreach ($states as $stateKey => $stateClassItem) {
            if (! is_string($stateClassItem) || ! class_exists($stateClassItem)) {
                continue;
            }

            if (! is_string($stateKey)) {
                continue;
            }

            $stateInstance = new $stateClassItem($this->modelClass);
            Assert::isInstanceOf($stateInstance, StateContract::class);
            $visibleKey = $stateKey.'-visible';
            $this->data[$visibleKey] = true;

            $column = IconColumn::make($stateKey.'-icon')
                ->icon($stateInstance->icon(...))
                ->color($stateInstance->color(...))
                ->tooltip($stateInstance->label(...))
                ->extraAttributes([
                    'class' => 'w-auto min-w-0 px-0',
                    'style' => 'width: fit-content !important;',
                ])
                ->extraCellAttributes(['class' => 'px-1 py-1'])
                ->label('')
                ->default(function (Model $record) use ($stateClassItem, $stateKey): ?bool {
                    if (isset($record->state) && is_object($record->state) && method_exists($record->state, 'canTransitionTo')) {
                        $canTransition = $record->state->canTransitionTo($stateClassItem);
                        $res = is_bool($canTransition) ? $canTransition : false;
                    } else {
                        $res = false;
                    }
                    $visibleKey = $stateKey.'-visible';
                    $this->data[$visibleKey] = $res;
                    if (! $res) {
                        return null;
                    }

                    return true;
                });

            $column->action(
                Action::make($stateKey.'-action')
                    ->requiresConfirmation()
                    ->modalHeading(function (Model $record) use ($stateInstance) {
                        // StateContract provides modalHeading()
                        return $stateInstance->modalHeading();
                    })
                    ->modalDescription(function (Model $record) use ($stateInstance) {
                        // StateContract provides modalDescription()
                        return $stateInstance->modalDescription();
                    })
                    ->schema(function (Model $record) use ($stateInstance) {
                        // StateContract provides modalFormSchema()
                        return $stateInstance->modalFormSchema();
                    })
                    ->fillForm($stateInstance->modalFillFormByRecord(...))
                    ->action(function (Model $record, array $data) use ($stateInstance): void {
                        // Ensure data is treated as array<string, mixed> for PHPStan and StateContract
                        /** @var array<string, mixed> $typedData */
                        $typedData = $data;

                        $stateInstance->modalActionByRecord($record, $typedData);
                    })
            );

            $visibleValue = $this->data[$visibleKey] ?? false;
            $column->visible($visibleValue);
            $columns[] = $column;
        }

        $this->columns($columns);

        return $this;
    }
}
