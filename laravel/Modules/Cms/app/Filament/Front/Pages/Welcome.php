<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Front\Pages;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Pages\XotBasePage;

class Welcome extends XotBasePage
{
    public string $view_type = 'home';

    /** @var array<string, mixed> */
    public array $containers = [];

    /** @var array<string, mixed> */
    public array $items = [];

    public ?Model $instanceModel = null;

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
        $primaryView = $this->view;
        if (! view()->exists($primaryView)) {
            $this->view = 'cms::filament.front.pages.welcome';
        }
    }
}
