<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Module;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class GetModuleNameByModelAction
{
    use QueueableAction;

    public function execute(Model $model): string
    {
        return app(GetModuleNameByModelClassAction::class)->execute($model::class);
    }
}
