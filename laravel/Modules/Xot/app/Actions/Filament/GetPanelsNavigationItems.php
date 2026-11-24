<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Adapters\Filament\PanelModuleAdapter;
use Spatie\QueueableAction\QueueableAction;

/**
 * Elementi di navigazione cross-panel per i moduli Filament.
<<<<<<< .merge_file_l2RLqZ
 *
 * @see docs/contracts/get-panels-navigation-items.md
 *
=======
 * @see docs/contracts/get-panels-navigation-items.md
>>>>>>> .merge_file_hiScHy
 * @contract docs/contracts/get-panels-navigation-items.md
 */
class GetPanelsNavigationItems
{
    use QueueableAction;

    /**
     * @return array<int, NavigationItem>
     */
    public function execute(): array
    {
        $navs = [];

        foreach (Filament::getPanels() as $panel) {
            $navs[] = NavigationItem::make($panel->getId())
                ->url('/'.$panel->getPath())
                ->icon(PanelModuleAdapter::navigationIcon($panel))
                ->group('Modules')
                ->label(PanelModuleAdapter::navigationLabel($panel))
                ->sort(PanelModuleAdapter::navigationSort($panel))
                ->visible(static function () use ($panel): bool {
                    /** @var FilamentUser|null $user */
                    $user = Auth::user();
                    if ($user === null) {
                        return false;
                    }

                    return (bool) $user->canAccessPanel($panel);
                });
        }

        return $navs;
    }
}
