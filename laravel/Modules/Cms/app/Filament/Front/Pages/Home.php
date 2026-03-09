<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Front\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class Home extends XotBasePage
{
    public string $view_type = 'home';
    public array $containers = [];
    public array $items = [];

    protected string $view = 'pub_theme::home';
    protected static string $layout = 'pub_theme::components.layouts.app';

    public function mount(): void
    {
        $this->initView();
    }

    public function getViewData(): array
    {
        return [];
    }

    public function initView(): void
    {
        $this->view_type = 'home';
        if (view()->exists($this->view)) {
            return;
        }
        $this->view = 'cms::filament.front.pages.welcome';
    }
}
