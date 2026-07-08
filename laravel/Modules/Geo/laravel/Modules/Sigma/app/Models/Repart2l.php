<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repart2l.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $stabi
 * @property string|null $repar
 * @property string|null $dest1
 * @property string|null $dest2
 *
 * @method static Builder|Repart2l newModelQuery()
 * @method static Builder|Repart2l newQuery()
 * @method static Builder|Repart2l query()
 * @method static Builder|Repart2l whereDest1($value)
 * @method static Builder|Repart2l whereDest2($value)
 * @method static Builder|Repart2l whereEnte($value)
 * @method static Builder|Repart2l whereId($value)
 * @method static Builder|Repart2l whereRepar($value)
 * @method static Builder|Repart2l whereStabi($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repart2lFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repart2l extends BaseModel
{
    protected $table = 'repart2l';
}
