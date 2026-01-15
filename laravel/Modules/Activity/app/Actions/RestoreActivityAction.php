<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

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
