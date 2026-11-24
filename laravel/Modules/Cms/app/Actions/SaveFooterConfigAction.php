<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\FooterData;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Spatie\QueueableAction\QueueableAction;

<<<<<<< HEAD
=======
/**
 * Salva il piede del sito nella config appearance del tenant.
 *
 * @contract docs/contracts/save-footer-config-action.md
 * @see docs/contracts/save-footer-config-action.md
 */
>>>>>>> laraxot/dev
class SaveFooterConfigAction
{
    use QueueableAction;

<<<<<<< HEAD
=======
    /** @see docs/contracts/save-footer-config-action.md */
>>>>>>> laraxot/dev
    public function execute(FooterData $data): void
    {
        $config = ['footer' => $data->toArray()];
        app(SaveTenantConfigAction::class)->execute('appearance', $config);
    }
}
