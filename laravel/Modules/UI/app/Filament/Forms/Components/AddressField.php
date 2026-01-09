<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Webmozart\Assert\Assert;

// use Squire\Models\Country;

class AddressField extends Field
{
    /** @var string|callable|null */
    public $relationship;

    protected string $view = 'filament-schemas::components.grid';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (AddressField $_component, mixed $record) {
            $data = [
                'country' => null,
                'street' => null,
                'city' => null,
                'state' => null,
                'zip' => null,
            ];

            if (! ($record instanceof Model)) {
                return;
            }

            $relationship = $this->getRelationship();
            if ($relationship && $record->relationLoaded($relationship)) {
                $address = $record->getRelationValue($relationship);
                if ($address !== null && is_object($address) && method_exists($address, 'toArray')) {
                    $data = $address->toArray();
                }
            }

            // }
        });

        $this->dehydrated(false);
    }

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $rawState = $this->getState();
        if (! is_array($rawState)) {
            return;
        }

        /** @var array<string, mixed> $state */
        $state = $rawState;

        $record = $this->getRecord();
        if (! $record instanceof Model) {
            return;
        }

        $relationshipMethod = $this->getRelationship();
        if (! method_exists($record, $relationshipMethod)) {
            return;
        }

        $relationship = $record->{$relationshipMethod}();
        if (! $relationship instanceof HasOne
            && ! $relationship instanceof MorphOne
            && ! $relationship instanceof HasMany) {
            return;
        }

        /** @var Model|null $address */
        $address = $relationship->first();
        if ($address instanceof Model) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate([], $state);
        }

        $record->touch();
    }

    public function getDefaultChildComponents(?string $key = null): array
    {
        return [
            Grid::make()->schema([
                Select::make('country')->searchable(),
                // ->getSearchResultsUsing(fn (string $query) => Country::where('name', 'like', "%{$query}%")->pluck('name', 'id'))
                // ->getOptionLabelUsing(fn ($value): ?string => Country::firstWhere('id', $value)->getAttribute('name')),
            ]),
            TextInput::make('street')->maxLength(255),
            Grid::make(3)->schema([
                TextInput::make('city')->maxLength(255),
                TextInput::make('state')->maxLength(255),
                TextInput::make('zip')->maxLength(255),
            ]),
        ];
    }

    public function getRelationship(): string
    {
        Assert::string($res = $this->evaluate($this->relationship) ?? $this->getName());

        return $res;
    }
}
