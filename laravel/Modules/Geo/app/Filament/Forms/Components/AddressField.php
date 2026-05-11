<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Geo\Filament\Resources\AddressResource;

// use Squire\Models\Country;

class AddressField extends Section
{
    // protected string $view = 'filament-forms::components.group';

    protected bool $disableLiveUpdates = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->schema($this->getAddressFormSchema());
        $this->columns(2);
    }

    /**
     * Disabilita gli aggiornamenti live per evitare loop infiniti nei wizard di creazione.
     */
    public function disableLiveUpdates(bool $disable = true): static
    {
        $this->disableLiveUpdates = $disable;

        return $this;
    }

    /**
     * @return array<string, Component>
     */
    protected function getAddressFormSchema(): array
    {
        $baseSchema = AddressResource::getFormSchema();

        // Rimuovi campi non necessari per relazioni semplici
        unset($baseSchema['name'], $baseSchema['is_primary']);

        // Se i live updates sono disabilitati, rimuovi la reattività
        if ($this->disableLiveUpdates) {
            $baseSchema = $this->removeReactivityFromSchema($baseSchema);
        }

        return $baseSchema;
    }

    /**
     * Rimuove tutti i pattern reattivi dai campi per prevenire loop infiniti.
     *
     * @param array<string, Component> $schema
     *
     * @return array<string, Component>
     */
    protected function removeReactivityFromSchema(array $schema): array
    {
        foreach ($schema as $key => $field) {
            if (! $field instanceof Component) {
                continue;
            }

            $field->live(false);
            $field->afterStateUpdated(null);
            $field->disabled(false);

            $schema[$key] = $field;
        }

        return $schema;
    }

    /*
     * public function saveRelationships(): void
     * {
     *
     * $state = $this->getState();
     * $record = $this->getRecord();
     * $relationship = $record->{$this->getRelationship()}();
     *
     * if (null === $relationship) {
     * return;
     * }
     * if ($address = $relationship->first()) {
     * $address->update($state);
     * } else {
     * $relationship->updateOrCreate($state);
     * }
     *
     * $record->touch();
     * }
     */
}
