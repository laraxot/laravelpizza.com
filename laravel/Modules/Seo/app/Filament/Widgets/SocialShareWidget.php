<?php

declare(strict_types=1);

namespace Modules\Seo\Filament\Widgets;

use Modules\Seo\Actions\GenerateSocialShareLinksAction;
use Modules\Seo\Data\SocialShareData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Filament widget for social sharing.
 */
class SocialShareWidget extends XotBaseWidget
{
    /**
     * The view for the widget.
     */
    protected string $view = 'seo::filament.widgets.social-share';

    /**
     * Dati del form.
     *
     * @var array<string, mixed>
     */
    public ?array $data = [];

    /**
     * Get the form schema.
     *
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Get the data for the view.
     *
     * @return array<string, mixed>
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
