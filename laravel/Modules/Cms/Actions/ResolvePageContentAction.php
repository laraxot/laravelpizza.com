<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Models\Page as PageModel;
use Spatie\QueueableAction\QueueableAction;

class ResolvePageContentAction
{
    use QueueableAction;

    /**
     * Resolves page content based on container and slug.
     *
     * @param string $container0 The container identifier (e.g., 'events').
     * @param string $slug0      The content slug (e.g., 'laravel-beginners-pizza-night').
     *
     * @return array{content: mixed, contentType: ?string, view: ?string, pageSlug: string}
     */
    public function execute(string $container0, string $slug0): array
    {
        $fullSlug = $container0.'.'.$slug0;

        // Priority 1: Check if exact CMS page exists (e.g., events.laravel-beginners-pizza-night)
        $pageSlug = '';
        $page = PageModel::firstWhere('slug', $fullSlug);
        if (null !== $page) {
            $pageSlug = $fullSlug;
        }

        // Priority 2: Fallback to container.view (e.g., events.view)
        if ('' === $pageSlug) {
            $viewSlug = $container0.'.view';
            $viewPage = PageModel::firstWhere('slug', $viewSlug);
            if (null !== $viewPage) {
                $pageSlug = $viewSlug;
            }
        }

        // Priority 3: Last resort - use exact slug
        if ('' === $pageSlug) {
            $pageSlug = $fullSlug;
        }

        return [
            'content' => null,
            'contentType' => null,
            'view' => null,
            'pageSlug' => $pageSlug,
        ];
    }
}
