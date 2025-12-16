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
     * By declaring `@return view-string` in the PHPDoc, we instruct PHPStan that the returned
     * string is a valid view path, adhering to the project's architectural pattern for
     * type-safe view resolution. This avoids direct PHPDoc hacks on local variables
     * and centralizes the "magic" needed for static analysis compliance.
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

        // The @return view-string PHPDoc on the method itself is the key
        // to satisfying PHPStan's type analysis for view paths in this project.
        return $viewName;
    }
}
