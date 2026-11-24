<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;
use Modules\Xot\Filament\Widgets\EnvWidget;

/**
 * Impostazioni dell'ambiente (.env) per il super-admin: la pagina mostra EnvWidget.
 * Prima usava la vista della dashboard, che chiama getColumns()/getVisibleWidgets() dei Dashboard: errore 500.
 */
<<<<<<< .merge_file_aRwu5z
=======

>>>>>>> .merge_file_IR3Beh
class EnvPage extends XotBasePage
{
    use NavigationLabelTrait;
    use SuperAdminOnlyTrait;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    /**
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [EnvWidget::class];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }
<<<<<<< .merge_file_aRwu5z
=======
    protected string $view = 'xot::filament.pages.dashboard';
>>>>>>> .merge_file_IR3Beh
}
