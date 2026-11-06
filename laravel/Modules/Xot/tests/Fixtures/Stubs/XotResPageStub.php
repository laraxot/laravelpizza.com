<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

use Modules\Xot\Filament\Resources\Pages\XotBasePage as ResourceXotBasePage;
use Modules\Xot\Models\Cache as CacheModel;

final class XotResPageStub extends ResourceXotBasePage
{
    protected string $view = 'xot::filament.pages.stub';

    public static ?string $model = CacheModel::class;
}
