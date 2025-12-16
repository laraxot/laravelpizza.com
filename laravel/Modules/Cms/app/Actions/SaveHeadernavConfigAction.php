<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\HeadernavData;
use Modules\Tenant\Services\TenantService;

class SaveHeadernavConfigAction
{
    public function execute(HeadernavData $data): void
    {
        $config = ['headernav' => $data->toArray()];
        TenantService::saveConfig('appearance', $config);
    }
}
