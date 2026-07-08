<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\CreateRecord as FilamentCreateRecord;

abstract class XotBaseCreateRecord extends FilamentCreateRecord
{
    /**
     * Get default form data.
     *
     * @return array<string, mixed>
     */
    protected function getDefaultFormData(): array
    {
        return [];
    }
}
