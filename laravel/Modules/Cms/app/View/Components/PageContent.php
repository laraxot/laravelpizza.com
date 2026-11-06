<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Xot\Datas\XotData;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

class PageContent extends Component
{
    /** @var array<int, BlockData> */
    public array $blocks = [];

    public function __construct(public string $slug)
    {
        Assert::isInstanceOf(
            $page = PageModel::firstOrCreate(['slug' => $this->slug], ['title' => $this->slug, 'content_blocks' => []]),
            PageModel::class,
            '['.__LINE__.']['.__FILE__.']',
        );
        $blocks = $page->content_blocks;
        if (is_array($blocks)) {
            $locale = app()->getLocale();
            $localeKeys = ['it', 'en', 'fr', 'de', 'es', XotData::make()->primary_lang];
            if (count(array_intersect(array_keys($blocks), $localeKeys)) > 0) {
                $blocks = $page->getTranslation('content_blocks', $locale, false);
                if (! is_array($blocks)) {
                    $blocks = $page->getTranslation('content_blocks', XotData::make()->primary_lang, false);
                }
            }
        } else {
            $blocks = $page->getTranslation('content_blocks', XotData::make()->primary_lang, false);
        }

        if (! is_array($blocks)) {
            $blocks = [];
        }
        $collected = BlockData::collect($blocks);
        /** @var array<int, BlockData> $indexedBlocks */
        $indexedBlocks = array_values($collected instanceof DataCollection ? $collected->all() : (array) $collected);
        $this->blocks = $indexedBlocks;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): Factory|ViewContract
    {
        $view = 'cms::components.page-content';
        $view_params = [];

        return view($view, $view_params);
    }
}
