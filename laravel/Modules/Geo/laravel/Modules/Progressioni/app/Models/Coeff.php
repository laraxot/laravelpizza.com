<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\CoeffFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Progressioni\Models\Coeff.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @property string|null $guid
 *
 * @method static CoeffFactory factory($count = null, $state = [])
 * @method static Builder|Coeff newModelQuery()
 * @method static Builder|Coeff newQuery()
 * @method static Builder|Coeff query()
 * @method static Builder|Coeff whereAnno($value)
 * @method static Builder|Coeff whereCreatedAt($value)
 * @method static Builder|Coeff whereCreatedBy($value)
 * @method static Builder|Coeff whereCreatedIp($value)
 * @method static Builder|Coeff whereDeletedAt($value)
 * @method static Builder|Coeff whereDeletedBy($value)
 * @method static Builder|Coeff whereDeletedIp($value)
 * @method static Builder|Coeff whereGuid($value)
 * @method static Builder|Coeff whereId($value)
 * @method static Builder|Coeff whereName($value)
 * @method static Builder|Coeff whereUpdatedAt($value)
 * @method static Builder|Coeff whereUpdatedBy($value)
 * @method static Builder|Coeff whereUpdatedIp($value)
 * @method static Builder|Coeff whereValue($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Coeff extends BaseModel
{
    protected $fillable = ['id', 'name', 'value', 'anno'];

    protected $table = 'coeff_progressione';

    // end search
    // -------------------------
}
