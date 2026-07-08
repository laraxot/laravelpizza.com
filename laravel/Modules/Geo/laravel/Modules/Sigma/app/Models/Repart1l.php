<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repart1l.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $stabi
 * @property string|null $repar
 * @property string|null $dest1
 * @property string|null $dest2
 *
 * @method static Builder|Repart1l newModelQuery()
 * @method static Builder|Repart1l newQuery()
 * @method static Builder|Repart1l query()
 * @method static Builder|Repart1l whereDest1($value)
 * @method static Builder|Repart1l whereDest2($value)
 * @method static Builder|Repart1l whereEnte($value)
 * @method static Builder|Repart1l whereId($value)
 * @method static Builder|Repart1l whereRepar($value)
 * @method static Builder|Repart1l whereStabi($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repart1lFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repart1l extends BaseModel
{
    protected $table = 'repart1l';
}
