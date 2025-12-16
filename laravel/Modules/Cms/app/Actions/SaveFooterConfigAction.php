<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\FooterData;
use Modules\Tenant\Services\TenantService;
use Spatie\QueueableAction\QueueableAction;

class SaveFooterConfigAction
{
    use QueueableAction;

    public function execute(FooterData $data): void
    {
        $config = ['footer' => $data->toArray()];
        TenantService::saveConfig('appearance', $config);
    }
}
