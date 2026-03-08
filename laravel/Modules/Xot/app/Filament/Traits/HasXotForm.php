<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;

/**
 * Trait HasXotForm.
 *
 * Provides enhanced form functionality for Filament components.
 */
trait HasXotForm
{
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public array $data = [];

    /**
     * Get the form schema.
     */
    abstract public function getFormSchema(): array;

    /**
     * Define the form.
     */
    final public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->columns(2)
            ->statePath('data');
    }
}
