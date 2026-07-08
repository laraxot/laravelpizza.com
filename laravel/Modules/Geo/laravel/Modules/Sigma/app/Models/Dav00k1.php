<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Dav00k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $voce
 * @property string|null $davanz
 * @property string|null $davini
 * @property string|null $davfin
 * @property string|null $davann
 * @property string|null $dav2kz
 * @property string|null $dav2ki
 * @property string|null $dav2kf
 * @property string|null $dav001
 * @property string|null $dav002
 * @property string|null $dav003
 * @property string|null $dav004
 * @property string|null $dav005
 *
 * @method static Builder|Dav00k1 newModelQuery()
 * @method static Builder|Dav00k1 newQuery()
 * @method static Builder|Dav00k1 query()
 * @method static Builder|Dav00k1 whereDav001($value)
 * @method static Builder|Dav00k1 whereDav002($value)
 * @method static Builder|Dav00k1 whereDav003($value)
 * @method static Builder|Dav00k1 whereDav004($value)
 * @method static Builder|Dav00k1 whereDav005($value)
 * @method static Builder|Dav00k1 whereDav2kf($value)
 * @method static Builder|Dav00k1 whereDav2ki($value)
 * @method static Builder|Dav00k1 whereDav2kz($value)
 * @method static Builder|Dav00k1 whereDavann($value)
 * @method static Builder|Dav00k1 whereDavanz($value)
 * @method static Builder|Dav00k1 whereDavfin($value)
 * @method static Builder|Dav00k1 whereDavini($value)
 * @method static Builder|Dav00k1 whereEnte($value)
 * @method static Builder|Dav00k1 whereId($value)
 * @method static Builder|Dav00k1 whereMatr($value)
 * @method static Builder|Dav00k1 whereVoce($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Dav00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Dav00k1 extends BaseModel
{
    protected $table = 'dav00k1';
}
