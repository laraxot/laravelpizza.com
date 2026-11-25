<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Contract for relations that expose MorphToOne-style create().
 *
 * Optional runtime implementation may come from fidum/laravel-eloquent-morph-to-one.
 */
interface MorphToOneRelationContract
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Model;
}
