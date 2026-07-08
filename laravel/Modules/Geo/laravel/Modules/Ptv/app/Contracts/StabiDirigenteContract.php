<?php

declare(strict_types=1);

namespace Modules\Ptv\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface StabiDirigenteContract
{
    /**
     * @param  array<string, mixed>  $attributes
     * @return static
     */
    public static function firstOrCreate(array $attributes): self;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(array $attributes): bool;

    /**
     * @param  array<string, mixed>  $conditions
     * @return Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function where(array $conditions): Builder;
}
