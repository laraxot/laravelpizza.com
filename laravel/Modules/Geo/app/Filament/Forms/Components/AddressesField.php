<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

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
class AddressesField extends Repeater
{
    // protected string $view = 'geo::filament.forms.components.addresses-field';

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
     * @return array<string, Component>
     */
    protected function getAddressFormSchema(): array
    {
        $baseSchema = AddressResource::getFormSchema();

        // Campo name: visibile solo con più di 1 elemento
        $baseSchema['name'] = TextInput::make('name')
            ->maxLength(255)
            ->visible(function (Get $get): bool {
                $addresses = $get('../../addresses') ?? [];

                /* @phpstan-ignore argument.type */
                return count($addresses) > 1;
            })
            ->live();

        // Campo is_primary: logica complessa per esclusività
        $baseSchema['is_primary'] = Toggle::make('is_primary')
            ->visible(function (Get $get): bool {
                $addresses = $get('../../addresses') ?? [];

                /* @phpstan-ignore argument.type */
                return count($addresses) > 1;
            })
            ->default(function (Get $get): bool {
                $addresses = $get('../../addresses') ?? [];

                // Se è il primo elemento o c'è un solo elemento, default true
                /* @phpstan-ignore argument.type */
                return count($addresses) <= 1;
            })
            ->afterStateUpdated(function ($state, $set, Get $get, Component $component): void {
                // Se questo diventa primary, disattiva tutti gli altri
                if ($state === true) {
                    $addresses = $get('../../addresses') ?? [];

                    // Estrae l'indice dal path del componente (es. "addresses.0.is_primary")
                    $path = $component->getStatePath();
                    preg_match('/addresses\.(\d+)\.is_primary/', $path ?? '', $matches);
                    $currentIndex = $matches[1] ?? null;

                    if ($currentIndex !== null) {
                        // Disattiva is_primary negli altri elementi
                        /* @phpstan-ignore foreach.nonIterable */
                        foreach ($addresses as $index => $address) {
                            $indexStr = app(SafeStringCastAction::class)->execute($index);
                            $currentIndexStr = app(SafeStringCastAction::class)
                                ->execute($currentIndex);
                            if ($indexStr !== $currentIndexStr) {
                                /* @phpstan-ignore callable.nonCallable */
                                $set('../../addresses.'.$indexStr.'.is_primary', false);
                            }
                        }
                    }
                }
            })
            ->live()
            ->dehydrateStateUsing(function ($state, Get $get): bool {
                $addresses = $get('../../addresses') ?? [];
                // Se c'è un solo elemento, forza sempre true
                /* @phpstan-ignore argument.type */
                if (count($addresses) <= 1) {
                    return true;
                }

                return (bool) $state;
            });

        return $baseSchema;
    }
}
