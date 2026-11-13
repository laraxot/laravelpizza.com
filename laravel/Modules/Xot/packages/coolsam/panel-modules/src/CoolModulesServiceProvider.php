<?php

declare(strict_types=1);

namespace Coolsam\FilamentModules;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Nwidart\Modules\LaravelModulesServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CoolModulesServiceProvider extends PackageServiceProvider
{
    /**
     * Traccia i panel che hanno già gli hook registrati.
     *
     * @var array<string, bool>
     */
    private static array $processedPanels = [];

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */

        $package->name('cool-modules');
    }

    public function register(): void
    {
        $this->app->register(LaravelModulesServiceProvider::class);

        $this->app->afterResolving('filament', function (): void {
            $panels = Filament::getPanels();

            foreach ($panels as $panel) {
                $id = Str::of($panel->getId());
                $panelId = $panel->getId();

                // Controlla se questo panel è già stato processato
                if (isset(self::$processedPanels[$panelId])) {
                    continue;
                }

                if ($id->contains('::')) {
                    $panel->renderHook(
                        'panels::sidebar.nav.start',
                        static fn (): HtmlString => new HtmlString("<h2 class='m-2 p-2 font-black text-xl'>".e(self::sidebarTitle($panelId)).'</h2>'),
                    )->renderHook(
                        'panels::sidebar.nav.end',
                        static fn (): HtmlString => self::mainPanelLink(),
                    );

                    // Marca questo panel come processato
                    self::$processedPanels[$panelId] = true;
                }
            }
        });

        parent::register();
    }

    /**
     * `roosko::customer` -> "Roosko · Area clienti": il nome del modulo piu' il tipo di pannello tradotto
     * (`xot::panel.sidebar_types.{tipo}`); senza traduzione resta il titolo ricavato dall'id.
     */
    private static function sidebarTitle(string $panelId): string
    {
        $module = Str::of($panelId)->before('::')->replace('-', ' ')->title()->toString();
        $type = Str::of($panelId)->after('::')->toString();
        $key = 'xot::panel.sidebar_types.'.$type;
        $translated = __($key);

        return $module.' · '.(\is_string($translated) && $translated !== $key ? $translated : Str::of($type)->replace('-', ' ')->title()->toString());
    }

    /**
     * Link di ritorno al pannello principale `/admin`, solo per chi puo' entrarci: nell'area clienti
     * (e per chiunque non abbia accesso a `/admin`) il link portava a una pagina vietata. Testo tradotto.
     */
    private static function mainPanelLink(): HtmlString
    {
        $user = Filament::auth()->user();
        $main = Filament::getPanel('admin', isStrict: false);
        if (! $main instanceof Panel || ! $user instanceof FilamentUser || ! $user->canAccessPanel($main)) {
            return new HtmlString('');
        }

        $label = e(__('xot::panel.back_to_main_panel'));
        $url = e($main->getUrl());

        return new HtmlString('<a href="'.$url.'" class="fi-sidebar-item-btn">'
            .'<svg class="fi-icon fi-size-lg fi-sidebar-item-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">'
            .'<path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>'
            .$label.'</a>');
    }
}
