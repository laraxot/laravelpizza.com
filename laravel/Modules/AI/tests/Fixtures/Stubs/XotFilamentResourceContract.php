<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Models\Cache;

final class XotFilamentResourceContract extends XotBaseResource
{
    protected static ?string $model = Cache::class;
}
