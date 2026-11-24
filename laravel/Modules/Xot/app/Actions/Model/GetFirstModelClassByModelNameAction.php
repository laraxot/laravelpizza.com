<?php

declare(strict_types=1);
/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

namespace Modules\Xot\Actions\Model;

use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * @see docs/contracts/get-first-model-class-by-model-name-action.md
 *
 * @contract docs/contracts/get-first-model-class-by-model-name-action.md
 */
class GetFirstModelClassByModelNameAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $modelName): string
    {
        /** @var array<string, class-string> $models */
        $models = app(GetAllModelsAction::class)->execute();
        Assert::keyExists(
            $models,
            $modelName,
            '['.__LINE__.']['.class_basename($this).']',
        );

        $modelClass = $models[$modelName];
        Assert::string(
            $modelClass,
            '['.__LINE__.']['.class_basename($this).']',
        );

        return $modelClass;
    }
}
