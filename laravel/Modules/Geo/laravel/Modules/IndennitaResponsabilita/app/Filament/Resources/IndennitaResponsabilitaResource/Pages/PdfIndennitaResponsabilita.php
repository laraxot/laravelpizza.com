<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class PdfIndennitaResponsabilita extends XotBasePage
{
    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'modules.indennita-responsabilita.filament.resources.indennita-responsabilita-resource.pages.pdf-indennita-responsabilita';
}
