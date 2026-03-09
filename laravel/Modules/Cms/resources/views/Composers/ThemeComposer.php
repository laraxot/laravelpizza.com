<?php

declare(strict_types=1);

namespace Modules\Cms\View\Composers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Datas\HeadernavData;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\UI\View\Components\Render\Blocks;
use Webmozart\Assert\Assert;

class ThemeComposer
{
    /**
     * Get menu items by name.
     *
     * @return array<string, mixed>|null
     */
    public function getMenu(string $menu_name): ?array
    {
        $menu = Menu::firstOrCreate(['title' => $menu_name]);

        $items = $menu->items ?? [];

        if (! is_array($items)) {
            return null;
        }

        /* @var array<string, mixed> $items */
        return $items;
    }

    public function getMenuUrl(array $menu): string
    {
        if ([] === $menu) {
            return '#';
        }
        $lang = app()->getLocale();

        $type = $menu['type'] ?? null;
        $url = $menu['url'] ?? null;

        if (! is_string($type) || ! is_string($url)) {
            return '#';
        }

        if ('internal' === $type) {
            return route('page_slug.view', ['lang' => $lang, 'slug' => $url]);
        }
        if ('external' === $type) {
            return $url;
        }
        if ('route_name' === $type) {
            return route($url, ['lang' => $lang]);
        }

        return '#';
    }

    public function showPageContent(string $slug): Renderable
    {
        Assert::isInstanceOf(
            $page = Page::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]),
            Page::class,
            '['.__LINE__.']['.__FILE__.']',
        );
        // $page = Page::firstOrCreate(['slug' => $slug], ['content_blocks' => []]);
        $blocks = $page->content_blocks;
        if (! is_array($blocks)) {
            $blocks = [];
        }
        $blocksComponent = new Blocks(
            tpl: 'ui::components.render.blocks.v1',
            blocks: $blocks,
            model: $page,
        );

        return $blocksComponent->render();
    }

    public function showPageSidebarContent(string $slug): Renderable
    {
        Assert::isInstanceOf(
            $page = Page::firstOrCreate(['slug' => $slug], ['sidebar_blocks' => []]),
            Page::class,
            '['.__LINE__.']['.__FILE__.']',
        );
        // $page = Page::firstOrCreate(['slug' => $slug], ['content_blocks' => []]);
        $blocks = $page->sidebar_blocks;
        if (! is_array($blocks)) {
            $blocks = [];
        }

        $blocksComponent = new Blocks(
            tpl: 'ui::components.render.blocks.v1',
            blocks: $blocks,
            model: $page,
        );

        return $blocksComponent->render();
    }

    public function showContent(string $slug): Renderable
    {
        Assert::isInstanceOf(
            $page = PageContent::firstOrCreate(['slug' => $slug], ['blocks' => []]),
            PageContent::class,
            '['.__LINE__.']['.__FILE__.']',
        );

        $blocks = $page->blocks;
        if (! is_array($blocks)) {
            return view('ui::empty');
        }

        $blocksComponent = new Blocks(
            tpl: 'ui::components.render.blocks.v1',
            blocks: $blocks,
            model: $page,
        );

        return $blocksComponent->render();
    }

    public function getPages(): Collection
    {
        return Page::all();
    }

    public function getPageModel(string $slug): ?Page
    {
        return Page::where('slug', $slug)->first();
    }

    public function getUrlPage(string $slug): string
    {
        $page = $this->getPageModel($slug);
        if ($page instanceof Page) {
            return '/'.app()->getLocale().'/pages/'.$slug;
        }

        return '#';
    }

    public function headernav(): Renderable
    {
        $headernav = HeadernavData::make();

        return $headernav->view();
    }

    public function footer(): Renderable
    {
        $footer = FooterData::make();

        return $footer->view();
    }
}
