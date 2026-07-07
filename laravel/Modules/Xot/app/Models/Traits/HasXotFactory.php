<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory as EloquentHasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Factory\GetFactoryAction;

/** @template-covariant TFactory of Factory */
trait HasXotFactory
{
    /** @use EloquentHasFactory<TFactory> */
    use EloquentHasFactory {
        newFactory as parentNewFactory;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return TFactory
     */
    protected static function newFactory()
    {
        /** @var TFactory $factory */
        $factory = app(GetFactoryAction::class)->execute(static::class);

        return $factory;
    }
}
