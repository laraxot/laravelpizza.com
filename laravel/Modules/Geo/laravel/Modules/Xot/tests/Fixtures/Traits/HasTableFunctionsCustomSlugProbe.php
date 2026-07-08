<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Traits;

use Modules\Xot\Traits\HasTableFunctionsTrait;

class HasTableFunctionsCustomSlugProbe
{
    use HasTableFunctionsTrait;

    protected function getResourceSlug(): string
    {
        return 'test-slug';
    }

    public function exposeResourceSlug(): string
    {
        return $this->getResourceSlug();
    }
}
