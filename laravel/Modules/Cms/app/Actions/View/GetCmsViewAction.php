<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\View;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GetCmsViewAction
{
    use QueueableAction;

    /**
     * Resolves a CMS view name and ensures it exists.
     *
     * This action encapsulates the logic for validating a view name and asserting its existence,
     * specifically addressing PHPStan's `view-string` type requirement.
     *
     * @param string $viewName The name of the view to resolve (e.g., 'pub_theme::components.sections.home' or 'cms::components.section')
     *
     * @throws \Exception If the view does not exist
     *
     * @return view-string The resolved and existing view name
     */
    public function execute(string $viewName): string
    {
        Assert::stringNotEmpty($viewName, 'View name cannot be empty.');

        if (! view()->exists($viewName)) {
            throw new \Exception('View not found: '.$viewName);
        }

        return $viewName;
    }
}
