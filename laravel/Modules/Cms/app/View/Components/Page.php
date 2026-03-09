<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;

class Page extends Component
{
    public string $side;

    public string $slug;

    /** @var array<string, BlockData> */
    public array $blocks;

    public array $data = [];

    public string $container0 = '';

    public string $slug0 = '';

    public function __construct(string $side, string $slug, ?string $type = null, array $data = [], string $container0 = '', string $slug0 = '')
    {
        $data = $data;
        $side = $side;
        if (null !== $type) {
            $slug = $type.'-'.$slug;
        }
        $slug = $slug;
        $container0 = $container0;
        $slug0 = $slug0;
        /* @phpstan-ignore staticMethod.notFound, assign.propertyType */
        $blocks = PageModel::getBlocksBySlug($slug, $side);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $view = 'cms::components.page';
        $view_params = [
            'blocks' => $blocks,
            'side' => $side,
            'slug' => $slug,
            'data' => $data,
            'container0' => $container0,
            'slug0' => $slug0,
        ];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
