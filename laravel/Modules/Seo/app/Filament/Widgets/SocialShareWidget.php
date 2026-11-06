<?php

declare(strict_types=1);

namespace Modules\Seo\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Modules\Seo\Actions\GenerateSocialShareLinksAction;
use Modules\Seo\Datas\SocialShareData;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * Filament widget for social sharing.
 */
class SocialShareWidget extends XotBaseSchemaWidget
{
    /**
     * Dati del form.
     *
     * @var array<string, mixed>
     */
    public ?array $data = [];

    /**
     * The view for the widget.
     *
     * @var view-string
     */
    protected string $view;

    public function __construct()
    {
        /** @var view-string $view */
        $view = 'seo::filament.widgets.social-share';
        $this->view = $view;

        parent::__construct();
    }

    /**
     * Get the form schema.
     *
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Get the data for the view.
     *
     * @return array<string, mixed>
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    protected function getViewData(): array
    {
        /** @var array<string, mixed> $viewData */
        $viewData = $this->data ?? [];

        $shareData = SocialShareData::from([
            'url' => $viewData['url'] ?? url()->current(),
            'title' => $viewData['title'] ?? config('app.name'),
        ]);

        /** @var GenerateSocialShareLinksAction $action */
        $action = app(GenerateSocialShareLinksAction::class);

        return [
            'links' => $action->execute($shareData),
            'platforms' => $shareData->platforms,
            'data' => $shareData,
        ];
    }
}
