<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

/**
 * Figlio STI di {@see RatingsHostStub}, con la stessa semantica di Parental
 * (`HasParent::getMorphClass()`): il morph class e' quello del padre, alias o FQCN.
 *
 * Riproduce `SchedaDip` su `IndennitaResponsabilita`: `static::class` e' la classe
 * figlia, che in `rating_morph.model_type` non e' mai stata scritta.
 */
class RatingsHostStiChildStub extends RatingsHostStub
{
    public function getMorphClass(): string
    {
        return (new RatingsHostStub)->getMorphClass();
    }
}
