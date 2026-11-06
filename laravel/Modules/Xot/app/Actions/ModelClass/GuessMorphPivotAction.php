<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\ModelClass;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class GuessMorphPivotAction
{
    use QueueableAction;

    /**
     * Guess the pivot class for a many-to-many relationship.
     *
     * @param  string|class-string<Model>  $related  The related model class name
     * @param  string|class-string<Model>  $class  The class
     */
    public function execute(string $related, string $class): MorphPivot
    {
        $pivot_name = class_basename($related).'Morph';

        $pivot_class = app(GuessPivotFullClassAction::class)->execute($pivot_name, $related, $class);
        $pivot = app($pivot_class);
        Assert::isInstanceOf($pivot, MorphPivot::class);

        return $pivot;
    }
}
