<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Livewire\Page;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Modules\Cms\Models\Page;
use Modules\Xot\Services\ThemeService;

class Show extends Component
{
    public string $slug;
    public bool $cache = true;
    public ?string $theme = null;
    public bool $debug = false;
    public array $pageContent = [];

    public function mount(): void
    {
        $this->loadPageContent();
    }

    public function render(): View
    {
        return view('cms::livewire.page.show', [
            'pageContent' => $this->pageContent,
            'theme' => $this->theme ?? ThemeService::getTheme(),
        ]);
    }

    protected function rules(): array
    {
        return [
            'slug' => 'required|string',
            'cache' => 'boolean',
            'theme' => 'nullable|string',
            'debug' => 'boolean',
        ];
    }

    protected function loadPageContent(): void
    {
        $cacheKey = 'page_content_'.$this->slug.'_'.($this->theme ?? ThemeService::getTheme());

        if ($this->cache) {
            $this->pageContent = Cache::remember($cacheKey, now()->addHours(24), function () {
                return $this->fetchPageContent();
            });
        } else {
            $this->pageContent = $this->fetchPageContent();
        }
    }

    protected function fetchPageContent(): array
    {
        try {
            $page = Page::where('slug', $this->slug)->first();

            if (! $page instanceof Page) {
                return ['error' => 'Page not found', 'slug' => $this->slug];
            }

            $title = is_scalar($page->title) ? (string) $page->title : $this->slug;
            $content = is_scalar($page->content) ? (string) $page->content : '';

            return [
                'title' => $title,
                'subtitle' => null,
                'content' => $content,
                'meta' => [
                    'description' => is_scalar($page->description) ? (string) $page->description : null,
                    'keywords' => null,
                ],
                'blocks' => is_array($page->content_blocks) ? $page->content_blocks : [],
                'layout' => 'default',
            ];
        } catch (\Exception $e) {
            if ($this->debug) {
                return [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
            }

            return ['error' => 'An error occurred while loading the page'];
        }
    }
}
