<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;

// ---- traits --
/**
 * Modules\IndennitaCondizioniLavoro\Models\Opzione.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @method static Builder|Opzione newModelQuery()
 * @method static Builder|Opzione newQuery()
 * @method static Builder|Opzione query()
 * @method static Builder|Opzione whereCreatedAt($value)
 * @method static Builder|Opzione whereId($value)
 * @method static Builder|Opzione whereName($value)
 * @method static Builder|Opzione whereUpdatedAt($value)
 * @method static Builder|Opzione whereValue($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Opzione extends BaseModel
{
    protected $table = 'opzioni';

    /**
     * @var list<string>
     */
    protected $fillable = ['id', 'name', 'value'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
