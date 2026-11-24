<?php

declare(strict_types=1);
/**
 * @see https://github.com/krlove/eloquent-model-generator
 * @see https://github.com/laracademy/generators
 */

namespace Modules\Xot\Actions\Model;

use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/generate-model-by-table-action.md
 *
 * @contract docs/contracts/generate-model-by-table-action.md
 */
class GenerateModelByTableAction
{
    use QueueableAction;

    public function execute(): void
    {
        throw new \LogicException('GenerateModelByTableAction::execute() not implemented');
    }
}
