<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Spatie\LaravelData\DataCollection;

/**
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
final class Page extends Component
{
    public string $side;

    public string $slug;

    /** @var DataCollection<BlockData>|array */
    public DataCollection|array $blocks;

    /** @var array<string, mixed> */
    public array $data = [];

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(
        array $data = [],
        string $side = 'content',
        ?string $slug = null,
        ?string $type = null,
    ) {
        $this->side = $side;
        $this->data = $data;

        // Resolve slug from data if not passed explicitly
        if ($slug === null && isset($data['slug'])) {
            $slug = (string) $data['slug'];
        }

        // Fallback or composition
        if ($slug === null) {
            $slug = '';
        }

        if ($type !== null) {
            $slug = $type.'-'.$slug;
        }

        $this->slug = $slug;

        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $view = 'cms::components.page';
        $viewParams = [
            ...$this->data,
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
        ];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $viewParams);
    }
}
