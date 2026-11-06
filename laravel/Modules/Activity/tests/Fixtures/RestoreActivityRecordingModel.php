<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Modello finto che registra gli attributi passati a update() (classe con nome, non anonima).
 */
final class RestoreActivityRecordingModel extends Model
{
    protected $table = 'stub_models';

    /** @var array<string, mixed> */
    public array $updatedAttributes = [];

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        $this->updatedAttributes = $attributes;

        return true;
    }
}
