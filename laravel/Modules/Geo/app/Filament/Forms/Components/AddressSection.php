<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Schemas\Components\Component;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

// use Squire\Models\Country;

class AddressSection extends XotBaseSection
{
    // protected string $view = 'filament-forms::components.group';

    protected bool $disableLiveUpdates = false;

    /** @var array<int, Component> */
    protected array $extraComponents = [];

    protected function setUp(): void
    {
        parent::setUp();
        // Passiamo una Closure a schema() per rispettare la firma di Filament\Schemas
        $this->schema(fn (): array => array_merge($this->getFormSchema(), $this->extraComponents));
        $this->columns(3);
    }

    /**
     * @param  array<int, Component>  $components
     */
    public function extraComponents(array $components): static
    {
        $this->extraComponents = $components;

        return $this;
    }

    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        /*
        // @var array<string, \Filament\Schemas\Components\Component> $schema
        $schema = AddressResource::getFormSchema();
        unset($schema['name'], $schema['is_primary']);

        return $schema;
        */
        $schema = AddressItemEnum::getFormSchema();

        // Contact values belong to Notify\ContactSection, not to the address block.
        // 'notes' è esclusa perché i form che usano questa section definiscono
        // il proprio campo note canonico: senza, due input condividono lo
        // stesso state path. 'latitude'/'longitude' non sono più appiattite nei
        // campi: AddressItemEnum le fornisce come CoordinatesSection + mappa.
        return array_diff_key($schema, array_flip([
            'phone',
            'mobile',
            'fax',
            'pec',
            'whatsapp',
            'email',
            'notes',
        ]));
    }

    /*
    public function saveRelationships(): void
    {

        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record->{$this->getRelationship()}();

        if (null === $relationship) {
            return;
        }
        if ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record->touch();
    }
    */
}
