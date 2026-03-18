<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Panel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Nwidart\Modules\Laravel\Module;
use Webmozart\Assert\Assert;

/**
 * Class Modules\Xot\Filament\Pages\MainDashboard.
 */
class MainDashboard extends XotBaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'xot::filament.pages.dashboard';

    // protected static string $routePath = 'main';

    protected static ?string $title = 'Main Dashboard';

    protected static ?int $navigationSort = 1;

    /**
     * Use the canonical slug so Filament resolves the home link to this page
     * at route name `filament.{panel}.pages.dashboard`.
     */
    public static function getSlug(?Panel $panel = null): string
    {
        return 'dashboard';
    }

    public function mount(): void
    {
        $user = Auth::user();
        Assert::notNull($user, '['.__LINE__.']['.class_basename($this).']');
        // Usa roles() come metodo invece della magic property per type safety
        $modules = $user->getModules();

        if (0 === count($modules)) {
            $url = '/'.app()->getLocale();
            redirect($url);

            return;
        }

        if (1 === count($modules)) {
            $module_first = Arr::first($modules);
            Assert::isInstanceOf($module_first, Module::class);
            $module_name = $module_first->getLowerName();
            $url = '/'.$module_name.'/admin';
            redirect($url);

            return;
        }

        // In tutti gli altri casi, mostra il dashboard con i link ai moduli
    }

    /**
     * Ottiene i widget da visualizzare nella dashboard.
     *
     * @return array<int, string>
     */
    public function getWidgets(): array
    {
        return [
            // Widget per mostrare i moduli disponibili
            // Modules\Xot\Filament\Widgets\ModulesOverviewWidget::class,
        ];
    }

    /**
     * Ottiene il numero di colonne per i widget.
     *
     * @return int|array<string, int|string|null>
     */
    public function getColumns(): int|array
    {
        return 1;
    }
}
