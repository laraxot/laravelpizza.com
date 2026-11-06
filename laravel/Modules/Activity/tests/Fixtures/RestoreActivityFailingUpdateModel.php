<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Modello finto la cui update() fallisce sempre (classe con nome, non anonima).
 */
final class RestoreActivityFailingUpdateModel extends Model
{
    protected $table = 'stub_models';

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        throw new Exception('db error');
    }
}
