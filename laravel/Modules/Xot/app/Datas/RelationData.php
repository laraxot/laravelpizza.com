<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\LaravelData\Data;

// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Undocumented class.
 */
class RelationData extends Data
{
    public Relation $rows;

    /** @var array<string, mixed> */
    public array $data = [];

    public string $name;

    public string $relationship_type;

    public Model $related;
}
