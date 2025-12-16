<?php

/**
 * @see https://github.com/krlove/eloquent-model-generator
 * @see https://github.com/laracademy/generators
 */

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Spatie\QueueableAction\QueueableAction;

class GenerateModelByTableAction
{
    use QueueableAction;

    public function execute(): void
    {
        dddx('WIP');
    }
}
