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
 * @property int|null $user_id
 * @property string|null $path
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $quadrimestre
 * @property int|null $anno
 * @method static Builder|Upload newModelQuery()
 * @method static Builder|Upload newQuery()
 * @method static Builder|Upload query()
 * @method static Builder|Upload whereAnno($value)
 * @method static Builder|Upload whereCreatedAt($value)
 * @method static Builder|Upload whereCreatedBy($value)
 * @method static Builder|Upload whereId($value)
 * @method static Builder|Upload whereNote($value)
 * @method static Builder|Upload wherePath($value)
 * @method static Builder|Upload whereQuadrimestre($value)
 * @method static Builder|Upload whereUpdatedAt($value)
 * @method static Builder|Upload whereUpdatedBy($value)
 * @method static Builder|Upload whereUserId($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Upload extends BaseModel
{
    protected $fillable = [
        'user_id',
        'path',
        'note',
        'quadrimestre',
        'anno',
    ];
}
