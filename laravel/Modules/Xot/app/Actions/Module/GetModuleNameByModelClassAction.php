<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Module;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-module-name-by-model-class-action.md
 *
 * @contract docs/contracts/get-module-name-by-model-class-action.md
 */
class GetModuleNameByModelClassAction
{
    use QueueableAction;

    public function execute(string $model_class): string
    {
        $module = Str::between($model_class, 'Modules\\', '\Models\\');

        return is_string($module) ? $module : ((string) $module);
    }
}
