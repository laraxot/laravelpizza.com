<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class PageContent extends Component
{
    public array $blocks = [];

    public function __construct(public string $slug)
    {
        Assert::isInstanceOf(
            $page = PageModel::firstOrCreate(['slug' => $this->slug], ['title' => $this->slug, 'content_blocks' => []]),
            PageModel::class,
            '['.__LINE__.']['.__FILE__.']',
        );
        $blocks = $page->content_blocks;
        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            /* @phpstan-ignore-next-line method.notFound */
            $blocks = $page->getTranslation('content_blocks', $primary_lang);
        }

        if (! is_array($blocks)) {
            $blocks = [];
        }
        $this->blocks = BlockData::collect($blocks);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        /*
         * $comps=Blade::getClassComponentAliases();
         * $paths = Blade::getAnonymousComponentPaths();
         * $filtered=Arr::where($comps,function ($value,$key){
         * return Str::startsWith($key,'blocks.');
         * });
         * dddx([
         * 'filtered'=>$filtered
         * ,'paths'=>$paths
         * ]);
         */
        $view = 'cms::components.page-content';
        $view_params = [];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
