<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Replaces Modules\Xot\Services\ArtisanService::showRouteList().
<<<<<<< .merge_file_XuvkC2
 *
 * @see docs/contracts/show-artisan-route-list-action.md
 *
=======
 * @see docs/contracts/show-artisan-route-list-action.md
>>>>>>> .merge_file_dC0p42
 * @contract docs/contracts/show-artisan-route-list-action.md
 */
class ShowArtisanRouteListAction
{
    use QueueableAction;

    public function execute(): string
    {
        $routeCollection = Route::getRoutes();

        $view = 'xot::acts.artisan.show_route_list';
        $view_params = [
            'view' => $view,
            'routeCollection' => $routeCollection,
            'lang' => app()->getLocale(),
        ];

        $result = view('xot::acts.artisan.show_route_list', $view_params);
        Assert::isInstanceOf($result, View::class);

        return $result->render();
    }
}
