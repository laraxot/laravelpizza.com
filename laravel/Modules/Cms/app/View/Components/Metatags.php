<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Support\PageSchemaBuilder;
use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Datas\MetatagData;

class Metatags extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $metatag = MetatagData::make();
        $view = app(GetViewAction::class)->execute();
        $route = request()->route();
        $routeName = $route?->getName();
        /** @var array<string, mixed> $routeParameters */
        $routeParameters = [];
        if (is_object($route)) {
            /** @var array<string, mixed> $tmpRouteParameters */
            $tmpRouteParameters = $route->parameters();
            $routeParameters = $tmpRouteParameters;
        }
        $path = request()->path();

        $view_params = [
            'meta' => $metatag,
            'pageSchema' => app(PageSchemaBuilder::class)->build(
                meta: $metatag,
                routeName: $routeName,
                path: $path,
                routeParameters: $routeParameters,
                user: auth()->user(),
            ),
        ];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
