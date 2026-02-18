<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Page as PageModel;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

class ResolvePageContentAction
{
    use QueueableAction;

    /**
     * Resolves page content based on container and slug.
     *
     * @param  string  $container0  The container identifier (e.g., 'events').
     * @param  string  $slug0  The content slug (e.g., 'laravel-beginners-pizza-night').
     * @return array{content: mixed, contentType: ?string, view: ?string, pageSlug: string}
     */
    public function execute(string $container0, string $slug0): array
    {
        $content = null;
        $contentType = null;
        $view = null;
        $pageSlug = '';

        $fullSlug = $container0.'.'.$slug0;

        // Priority 1: Try to load dynamic model (specific item)
        $knownMappings = [
            'events' => Event::class,
        ];

        if (isset($knownMappings[$container0]) && ! empty($slug0)) {
            $modelClass = $knownMappings[$container0];
            $item = $modelClass::where('slug', $slug0)->first();

            if ($item !== null) {
                $content = $item;
                $contentType = $container0;
                $view = 'blocks.'.$container0.'.detail';
            }
        }

        // Priority 2: Check if exact CMS page exists (e.g., events.laravel-beginners-pizza-night)
        if ($content === null) {
            $page = PageModel::firstWhere('slug', $fullSlug);

            if ($page !== null) {
                $pageSlug = $fullSlug;
            }
        }

        // Priority 3: Fallback to container.view (e.g., events.view)
        if ($content === null && $pageSlug === '') {
            $viewSlug = $container0.'.view';
            $viewPage = PageModel::firstWhere('slug', $viewSlug);

            if ($viewPage !== null) {
                $pageSlug = $viewSlug;
            }
        }

        // Priority 4: Last resort - use exact slug (will show 404 or placeholder)
        if ($content === null && $pageSlug === '') {
            $pageSlug = $fullSlug;
        }

        return [
            'content' => $content,
            'contentType' => $contentType,
            'view' => $view,
            'pageSlug' => $pageSlug,
        ];
    }
}
