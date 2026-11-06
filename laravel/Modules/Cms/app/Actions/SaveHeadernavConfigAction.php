<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\HeadernavData;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Spatie\QueueableAction\QueueableAction;

class SaveHeadernavConfigAction
{
    use QueueableAction;

    public function execute(HeadernavData $data): void
    {
        $config = ['headernav' => $data->toArray()];
        app(SaveTenantConfigAction::class)->execute('appearance', $config);
    }
}
