<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * @see docs/contracts/resolve-tenant-model-instance-action.md
 *
 * @contract docs/contracts/resolve-tenant-model-instance-action.md
 */
class ResolveTenantModelInstanceAction
{
    use QueueableAction;

    public function execute(string $name): Model
    {
        $class = app(ResolveTenantModelClassAction::class)->execute($name);

        $model = app($class);
        Assert::isInstanceOf($model, Model::class);

        return $model;
    }
}
