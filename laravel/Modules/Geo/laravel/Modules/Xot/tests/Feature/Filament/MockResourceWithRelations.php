<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Filament;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Models\Cache;

class MockResourceWithRelations extends XotBaseResource
{
    protected static ?string $model = Cache::class;

    public static function getFormSchema(): array
    {
        return [];
    }
}
