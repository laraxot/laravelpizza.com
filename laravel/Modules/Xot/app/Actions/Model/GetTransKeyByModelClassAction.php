<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/model-get-trans-key-by-model-class-action.md
 *
 * @contract docs/contracts/model-get-trans-key-by-model-class-action.md
 */
class GetTransKeyByModelClassAction
{
    use QueueableAction;

    public function execute(string $modelClass): string
    {
        $moduleName = Str::between($modelClass, 'Modules\\', '\Models');
        $modelName = Str::after($modelClass, '\Models\\');

        return Str::lower($moduleName).'::'.Str::kebab($modelName);
    }
}
