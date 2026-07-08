<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Support\Carbon;
use Modules\Activity\Models\BaseModel;

/**
 * Classe concreta di test per BaseModel.
 * Usata per testare BaseModel senza classi anonime.
 *
 * @property string|null $uuid
 * @property string|null $name
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $published_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @coversNothing
 */
class TestActivityModel extends BaseModel
{
    /** @var string */
    protected $table = 'test_models';

    /** @var list<string> */
    protected $fillable = ['name', 'value', 'uuid', 'published_at', 'created_by', 'updated_by', 'deleted_by'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            // Module-specific casts only
        ]);
    }
}
