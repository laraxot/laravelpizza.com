<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\HeadernavData;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Spatie\QueueableAction\QueueableAction;

<<<<<<< HEAD
=======
/**
 * Salva la testata del sito nella config appearance del tenant.
 *
 * @contract docs/contracts/save-headernav-config-action.md
 * @see docs/contracts/save-headernav-config-action.md
 */
>>>>>>> laraxot/dev
class SaveHeadernavConfigAction
{
    use QueueableAction;

<<<<<<< HEAD
=======
    /** @see docs/contracts/save-headernav-config-action.md */
>>>>>>> laraxot/dev
    public function execute(HeadernavData $data): void
    {
        $config = ['headernav' => $data->toArray()];
        app(SaveTenantConfigAction::class)->execute('appearance', $config);
    }
}
