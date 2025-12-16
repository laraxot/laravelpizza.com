<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Panel;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

/**
 * Class Modules\Xot\Filament\Pages\MainDashboard.
 */
class MainDashboard extends XotBaseDashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

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
        Assert::notNull($user = auth()->user(), '['.__LINE__.']['.class_basename($this).']');
        $modules = $user->roles->filter(static fn ($item) => Str::endsWith($item->name, '::admin'));

        if ($modules->count() === 1) {
            Assert::notNull($module_first = $modules->first(), '['.__LINE__.']['.class_basename($this).']');
            $panel_name = $module_first->name;
            $module_name = Str::before($panel_name, '::admin');
            $url = '/'.$module_name.'/admin';
            redirect($url);
        }

        // Solo se non ha accesso a nessun modulo, redirect alla home locale
        if ($modules->count() === 0) {
            $url = '/'.app()->getLocale();
            redirect($url);
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
