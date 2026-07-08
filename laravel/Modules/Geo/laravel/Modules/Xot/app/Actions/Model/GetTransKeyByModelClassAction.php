<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

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
