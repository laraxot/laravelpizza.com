<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeDipResource\Pages;

use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Modules\Performance\Filament\Resources\IndividualeDipResource;
use Modules\Performance\Filament\Resources\IndividualeResource\Pages\FillOutTheForm as BaseFillOutTheForm;
use Modules\Xot\Actions\GetTransKeyAction;

/**
 * @property Schema $form
 * @property Model $record
 */
class FillOutTheForm extends BaseFillOutTheForm
{
    protected static string $resource = IndividualeDipResource::class;

    /*
    public function getView(): string
    {

        $view = app(GetTransKeyAction::class)->execute();

        return $view;
    }
    */
}
