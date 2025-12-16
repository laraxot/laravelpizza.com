<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory as EloquentHasFactory;
use Modules\Xot\Actions\Factory\GetFactoryAction;

trait HasXotFactory
{
    use EloquentHasFactory {
        newFactory as parentNewFactory;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return app(GetFactoryAction::class)->execute(static::class);
    }
}
