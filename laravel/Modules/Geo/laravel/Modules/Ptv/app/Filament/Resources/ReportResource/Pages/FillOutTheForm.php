<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\ReportResource\Pages;

use Modules\Performance\Filament\Resources\IndividualeDipResource;
use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class FillOutTheForm extends XotBasePage
{
    public static function getResource(): string
    {
        return IndividualeDipResource::class;
    }

    public function getView(): string
    {
        $resource = static::getResource();
        $view = app(GetViewAction::class)->execute();
        dddx($view);

        return 'aaa';
    }
}
