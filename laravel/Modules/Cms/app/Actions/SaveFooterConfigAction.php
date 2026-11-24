<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Modules\Cms\Datas\FooterData;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Salva il piede del sito nella config appearance del tenant.
 *
 * @contract docs/contracts/save-footer-config-action.md
<<<<<<< .merge_file_rz9Yfj
<<<<<<< .merge_file_tTjRYw
 *
=======
>>>>>>> .merge_file_on5uXm
=======
>>>>>>> .merge_file_70UsYP
 * @see docs/contracts/save-footer-config-action.md
 */
class SaveFooterConfigAction
{
    use QueueableAction;

    /** @see docs/contracts/save-footer-config-action.md */
    public function execute(FooterData $data): void
    {
        $config = ['footer' => $data->toArray()];
        app(SaveTenantConfigAction::class)->execute('appearance', $config);
    }
}
