<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\RestoreActivityAction;

final class RestoreActivityActionNoOp extends RestoreActivityAction
{
    public function execute(Model $model, array $oldProperties): void
    {
        // success path senza persistenza
    }
}
