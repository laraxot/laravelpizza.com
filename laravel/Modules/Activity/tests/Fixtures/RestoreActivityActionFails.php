<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\RestoreActivityAction;

final class RestoreActivityActionFails extends RestoreActivityAction
{
    public function execute(Model $model, array $oldProperties): void
    {
        throw new Exception('restore boom');
    }
}
