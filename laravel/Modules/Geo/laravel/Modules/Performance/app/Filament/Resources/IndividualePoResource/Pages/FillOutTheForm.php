<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePoResource\Pages;

use Modules\Performance\Filament\Resources\IndividualePoResource;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\FillOutTheForm as BaseFillOutTheForm;
use Modules\Xot\Actions\GetTransKeyAction;

class FillOutTheForm extends BaseFillOutTheForm
{
    protected static string $resource = IndividualePoResource::class;

    /*
    public function getView(): string
    {

        $view = app(GetTransKeyAction::class)->execute();

        return $view;
    }
    */
}
