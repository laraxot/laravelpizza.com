<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Spy che registra le chiamate a saveMany() fatte da MorphManyAction.
 *
 * `calls` conta le invocazioni, `saved` conserva le righe ricevute nell'ultima chiamata.
 */
final class MorphManyRelationSpy
{
    public int $calls = 0;

    /** @var list<Model> */
    public array $saved = [];

    /**
     * @param  list<Model>  $models
     */
    public function saveMany(array $models): void
    {
        $this->calls++;
        $this->saved = $models;
    }
}
