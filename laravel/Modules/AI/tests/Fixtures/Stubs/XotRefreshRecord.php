<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

use Modules\Xot\Models\Cache as CacheModel;

final class XotRefreshRecord extends CacheModel
{
    public function getTitle(): string
    {
        return 'T';
    }

    protected function getSecret(): string
    {
        return 'secret';
    }
}
