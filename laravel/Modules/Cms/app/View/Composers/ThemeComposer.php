<?php

declare(strict_types=1);

namespace Modules\Cms\View\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Page;
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

        /** @var array<string, mixed> $normalized */
        $normalized = [];
        foreach ($items as $key => $value) {
            $normalized[(string) $key] = $value;
        }

        return $normalized;
    }

    public function getMenuUrl(array $menu): string
    {
        if ([] === $menu) {
            return '#';
        }
        $lang = app()->getLocale();
        if ('internal' === $menu['type']) {
            return route('page_slug.view', ['lang' => $lang, 'slug' => $menu['url']]);
        }
        if ('external' === $menu['type']) {
            Assert::string($url = $menu['url'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));

            return $url;
        }
        if ('route_name' === $menu['type']) {
            Assert::string($url = $menu['url'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));

            return route($url, ['lang' => $lang]);
        }

        return '#';
    }

    public function showPageContent(string $slug): View
    {
        Assert::isInstanceOf(
            $page = Page::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]),
            Page::class,
            '['.__LINE__.']['.__FILE__.']',
        );

        $blocks = $page->content_blocks;

        if (! is_array($blocks)) {
            $blocks = [];
        }
        $blocksComponent = new Blocks(
            view: 'ui::components.render.blocks.v1',
            blocks: $blocks,
            model: $page
        );

        return $blocksComponent->render();
    }

    /*
     * @deprecated
     *
     * @return Renderable

    public function showPageSidebarContent(string $slug): View
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
            view: 'ui::components.render.blocks.v1',
            blocks: $blocks,
            model: $page
        );

        return $blocksComponent->render();
    }

    public function showContent(string $slug): View
    {
        Assert::isInstanceOf(
            $page = PageContent::firstOrCreate(['slug' => $slug], ['blocks' => []]),
            PageContent::class,
            '['.__LINE__.']['.__FILE__.']',
        );

        $blocks = $page->blocks ?? [];
        if (! is_array($blocks)) {
            $blocks = [];
        }

        $blocksComponent = new Blocks(
            view: 'ui::components.render.blocks.v1',
            blocks: $blocks,
            model: $page
        );

        return $blocksComponent->render();
    }
    */
    public function getPages(): Collection
    {
        /* @var Collection<int, Page> $pages */
        return Page::all();
    }

    public function getPageModel(string $slug): ?Page
    {
        /* @var Page|null $page */
        return Page::where('slug', $slug)->first();
    }

    public function getUrlPage(string $slug): string
    {
        $page = $this->getPageModel($slug);
        if ($page instanceof Page) {
            return '/'.app()->getLocale().'/'.$slug;
        }

        return '#';
    }

    /*
     * @deprecated
     *
     * public function headernav(): Renderable
     * {
     * $headernav = HeadernavData::make();
     *
     * return $headernav->view();
     * }
     */
    /*
     * @deprecated
     *
     * @return Renderable
     *
     * public function footer(): Renderable
     * {
     * $footer = FooterData::make();
     *
     * return $footer->view();
     * }
     */
}
