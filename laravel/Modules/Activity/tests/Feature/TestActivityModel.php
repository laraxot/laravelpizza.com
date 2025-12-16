<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Modules\Activity\Models\BaseModel;

/**
 * Classe concreta di test per BaseModel.
 * Usata per testare BaseModel senza classi anonime.
 *
 * @internal
 *
 * @coversNothing
 */
class TestActivityModel extends BaseModel
{
    /** @var string */
    protected $table = 'test_models';

    /** @var list<string> */
    protected $fillable = ['name', 'value', 'uuid', 'published_at', 'created_by', 'updated_by', 'deleted_by'];

    /** @var array<string, string> */
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
