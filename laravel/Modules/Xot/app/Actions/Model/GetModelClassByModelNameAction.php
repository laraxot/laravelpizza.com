<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

namespace Modules\Xot\Actions\Model;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * @see docs/contracts/get-model-class-by-model-name-action.md
 *
 * @contract docs/contracts/get-model-class-by-model-name-action.md
 */
class GetModelClassByModelNameAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $modelName): string
    {
        Assert::isArray($morph_map = config('morph_map'));
        $modelClass = collect($morph_map)->get($modelName);
        if ($modelClass === null) {
            return app(GetFirstModelClassByModelNameAction::class)->execute($modelName);
        }
        Assert::string($modelClass, __FILE__.':'.__LINE__.' - '.class_basename(self::class));

        return $modelClass;
    }
}
