<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Modello finto minimo per i test di RestoreActivityAction (classe con nome, non anonima).
 */
final class RestoreActivityEmptyModel extends Model
{
    protected $table = 'stub_models';
}
