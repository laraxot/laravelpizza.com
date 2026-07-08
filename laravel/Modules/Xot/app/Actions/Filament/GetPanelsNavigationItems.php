<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Support\PanelModuleResolver;
use Spatie\QueueableAction\QueueableAction;

/**
 * Elementi di navigazione cross-panel per i moduli Filament.
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
                ->icon(PanelModuleResolver::navigationIcon($panel))
                ->group('Modules')
                ->label(PanelModuleResolver::navigationLabel($panel))
                ->sort(PanelModuleResolver::navigationSort($panel))
                ->visible(static function () use ($panel): bool {
                    /** @var FilamentUser|null $user */
                    $user = Auth::user();
                    if (null === $user) {
                        return false;
                    }

                    return (bool) $user->canAccessPanel($panel);
                });
        }

        return $navs;
    }
}
