<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Forms\Components\XotBaseRepeater;

use function Safe\preg_match;

/**
 * Componente riutilizzabile per la gestione di indirizzi multipli.
 *
 * Questo componente incapsula la logica complessa per gestire:
 * - Indirizzi multipli attraverso un Repeater
 * - Visibilità condizionale del campo 'name' (solo con più di 1 indirizzo)
 * - Gestione esclusiva del campo 'is_primary' (solo uno può essere primario)
 * - Utilizzo dello schema completo dell'AddressResource
 *
 * @example
 * AddressesField::make('addresses')
 *     ->relationship('addresses')
 *     ->minItems(1)
 *     ->addActionLabel('Aggiungi Indirizzo')
 */
class AddressesField extends XotBaseRepeater
{
    // protected string $view = 'geo::filament.forms.components.addresses-field';

    /**
     * @return list<array<string, mixed>>
     */
    private static function repeaterAddresses(Get $get): array
    {
        $addresses = $get('../../addresses');

        if (! is_array($addresses)) {
            return [];
        }

        /** @var list<array<string, mixed>> $normalized */
        $normalized = [];

        foreach ($addresses as $address) {
            if (! is_array($address)) {
                continue;
            }

            $normalized[] = self::normalizeAddressRow($address);
        }

        return $normalized;
    }

    /**
     * @param  array<mixed>  $address
     * @return array<string, mixed>
     */
    private static function normalizeAddressRow(array $address): array
    {
        /** @var array<string, mixed> $normalized */
        $normalized = [];

        foreach ($address as $key => $value) {
            if (! is_string($key)) {
                continue;
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema($this->getAddressFormSchema());
        $this->columnSpanFull()
            ->defaultItems(1)
            ->live()
            ->addActionLabel('Aggiungi Indirizzo');
    }

    /**
     * Schema form personalizzato per gli indirizzi con logica condizionale per i campi name e is_primary.
     *
     * @return array<int|string, Component>
     */
    protected function getAddressFormSchema(): array
    {
        $baseSchema = app(AddressResource::class)->getFormSchema();

        // Campo name: visibile solo con più di 1 elemento
        $baseSchema['name'] = TextInput::make('name')
            ->maxLength(255)
            ->visible(fn (Get $get): bool => count(self::repeaterAddresses($get)) > 1)
            ->live();

        // Campo is_primary: logica complessa per esclusività
        $baseSchema['is_primary'] = Toggle::make('is_primary')
            ->visible(fn (Get $get): bool => count(self::repeaterAddresses($get)) > 1)
            ->default(fn (Get $get): bool => count(self::repeaterAddresses($get)) <= 1)
            ->afterStateUpdated(function (mixed $state, Set $set, Get $get, Component $component): void {
                // Se questo diventa primary, disattiva tutti gli altri
                if ($state === true) {
                    $addresses = self::repeaterAddresses($get);

                    // Estrae l'indice dal path del componente (es. "addresses.0.is_primary")
                    $path = $component->getStatePath();
                    preg_match('/addresses\.(\d+)\.is_primary/', $path ?? '', $matches);
                    $currentIndex = $matches[1] ?? null;

                    if ($currentIndex !== null) {
                        // Disattiva is_primary negli altri elementi
                        foreach ($addresses as $index => $address) {
                            $indexStr = app(SafeStringCastAction::class)->execute($index);
                            $currentIndexStr = app(SafeStringCastAction::class)
                                ->execute($currentIndex);
                            if ($indexStr !== $currentIndexStr) {
                                $set('../../addresses.'.$indexStr.'.is_primary', false);
                            }
                        }
                    }
                }
            })
            ->live()
            ->dehydrateStateUsing(function (mixed $state, Get $get): bool {
                // Se c'è un solo elemento, forza sempre true
                if (count(self::repeaterAddresses($get)) <= 1) {
                    return true;
                }

                return (bool) $state;
            });

        return $baseSchema;
    }
}
