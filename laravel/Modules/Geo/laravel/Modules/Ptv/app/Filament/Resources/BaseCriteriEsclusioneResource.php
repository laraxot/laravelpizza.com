<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Support\Components\Component;
use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Schemas\BaseCriteriEsclusioneForm;
use Modules\Ptv\Models\CriteriEsclusione;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

abstract class BaseCriteriEsclusioneResource extends XotBaseResource
{
    protected static ?string $model = CriteriEsclusione::class;

    /**
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return BaseCriteriEsclusioneForm::getFormSchema();
    }
}
