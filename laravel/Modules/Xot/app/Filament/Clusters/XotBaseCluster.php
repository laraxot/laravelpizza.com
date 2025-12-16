<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Clusters;

use Filament\Clusters\Cluster as FilamentCluster;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

class XotBaseCluster extends FilamentCluster
{
    use NavigationLabelTrait;

    /*
     * public static function getNavigationGroup(): ?string
     * {
     *
     * return 'ZZZZZZZZZZZZZZZZZZ';
     * }
     */

    public function getTitle(): Htmlable|string
    {
        $key = static::getKeyTransFunc(__FUNCTION__);
        $res = static::transFunc(__FUNCTION__);
        dddx([
            'key' => $key,
            'res' => $res,
        ]);

        // return Lang::get('broker::cliente.navigation_group');
        return 'AAAAAAAAA';
    }

    /*
     * protected static ?string $navigationIcon = 'heroicon-o-users';
     *
     * public static function getNavigationLabel(): string
     * {
     * //return Lang::get('broker::cliente.cluster.label');
     * return 'ZZZZZZZZZZZZZZZZZZ';
     * }
     *
     *
     *
     * public static function getNavigationSort(): ?int
     * {
     * //return (int) Lang::get('broker::cliente.navigation_sort');
     * return 1;
     * }
     *
     * public static function getNavigationBadge(): ?string
     * {
     * return null;
     * }
     *
     * public static function getPages(): array
     * {
     * return [
     * 'index' => Pages\ListClientes::route('/'),
     * 'brain' => Pages\ListaBrain::route('/brain'),
     * ];
     * }
     */
}
