<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Clusters\Test\Pages;

use Modules\Ptv\Actions\GetValutatoriOptions;
use Modules\Ptv\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;

class TestPage extends XotBasePage
{
    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $anno = 2025;
        $opts = app(GetValutatoriOptions::class)
            ->execute('IndennitaResponsabilita', $anno);
        dddx($opts);
    }
}
