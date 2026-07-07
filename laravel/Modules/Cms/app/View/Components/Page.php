<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Spatie\LaravelData\DataCollection;

/**
 * CMS page shell: blocks loaded by slug. Route/context keys live only in {@see $data}.
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
final class Page extends Component
{
    public string $side;

    public string $slug = '';

    /** @var DataCollection<int, BlockData>|array<string, BlockData> */
    public DataCollection|array $blocks;

    /** @var array<string, mixed> */
    public array $data = [];

    /**
     * @param array<string, mixed> $data Opaque context bag (container0, slug0, models, …)
     */
    public function __construct(
        string $side = 'content',
        ?string $slug = null,
        ?string $type = null,
        array $data = [],
    ) {
        $this->side = $side;
        $this->data = $data;

        if (null === $slug && isset($data['slug'])) {
            $slug = (string) $data['slug'];
        }

        if (null === $slug) {
            $slug = '';
        }

        if (null !== $type) {
            $slug = $type.'-'.$slug;
        }

        $this->slug = $slug;

        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
    }

    public function render(): ViewContract
    {
        return view('cms::components.page', array_merge($this->data, [
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
        ]));
    }
}
