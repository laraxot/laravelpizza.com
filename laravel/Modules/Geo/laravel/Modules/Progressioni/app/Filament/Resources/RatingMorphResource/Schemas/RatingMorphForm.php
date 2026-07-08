<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\RatingMorphResource\Schemas;

use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class RatingMorphForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            // Campi del form
        ];
    }
}
