<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
<<<<<<< .merge_file_AHF5es
<<<<<<< .merge_file_dxJC7e
<<<<<<< .merge_file_AstLHC
<<<<<<< .merge_file_NPvVmJ
 * RestoreActivityAction.
 *
 * @see docs/contracts/restore-activity-action.md
=======
 * Riporta un record ai valori precedenti registrati in un'attivita' (properties.old).
>>>>>>> .merge_file_i2PsfK
=======
 * Riporta un record ai valori precedenti registrati in un'attivita' (properties.old).
>>>>>>> .merge_file_NCbyB8
=======
 * Riporta un record ai valori precedenti registrati in un'attivita' (properties.old).
>>>>>>> .merge_file_RLF14c
=======
 * Riporta un record ai valori precedenti registrati in un'attivita' (properties.old).
>>>>>>> .merge_file_kIP47e
 *
 * @contract docs/contracts/restore-activity-action.md
 */
class RestoreActivityAction
{
    use QueueableAction;

    /**
     * Esegue il ripristino di un record basandosi sui dati di un'attività.
     *
     * @param  array<string, mixed>  $oldProperties
     */
    public function execute(Model $record, array $oldProperties): void
    {
        Assert::notEmpty($oldProperties, 'Old properties cannot be empty');

        try {
            $record->update($oldProperties);
        } catch (Exception $e) {
            throw new Exception('Restore failed: '.$e->getMessage(), (int) $e->getCode(), $e);
        }
    }
}
