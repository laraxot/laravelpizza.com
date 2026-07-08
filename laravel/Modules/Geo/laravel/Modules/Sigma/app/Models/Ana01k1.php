<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana01k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $anvdal
 * @property string|null $anval
 * @property string|null $codvo
 * @property string|null $imp
 * @property string|null $impoeu
 * @property string|null $codimp
 * @property string|null $tipm
 * @property string|null $anvann
 * @property string|null $seq
 * @property string|null $anv2kd
 * @property string|null $anv2ka
 * @property string|null $an1001
 * @property string|null $an2002
 * @property string|null $an3003
 * @property string|null $an4004
 * @property string|null $an5005
 *
 * @method static Builder|Ana01k1 newModelQuery()
 * @method static Builder|Ana01k1 newQuery()
 * @method static Builder|Ana01k1 query()
 * @method static Builder|Ana01k1 whereAn1001($value)
 * @method static Builder|Ana01k1 whereAn2002($value)
 * @method static Builder|Ana01k1 whereAn3003($value)
 * @method static Builder|Ana01k1 whereAn4004($value)
 * @method static Builder|Ana01k1 whereAn5005($value)
 * @method static Builder|Ana01k1 whereAnv2ka($value)
 * @method static Builder|Ana01k1 whereAnv2kd($value)
 * @method static Builder|Ana01k1 whereAnval($value)
 * @method static Builder|Ana01k1 whereAnvann($value)
 * @method static Builder|Ana01k1 whereAnvdal($value)
 * @method static Builder|Ana01k1 whereCodimp($value)
 * @method static Builder|Ana01k1 whereCodvo($value)
 * @method static Builder|Ana01k1 whereEnte($value)
 * @method static Builder|Ana01k1 whereId($value)
 * @method static Builder|Ana01k1 whereImp($value)
 * @method static Builder|Ana01k1 whereImpoeu($value)
 * @method static Builder|Ana01k1 whereMatr($value)
 * @method static Builder|Ana01k1 whereSeq($value)
 * @method static Builder|Ana01k1 whereTipm($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana01k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana01k1 extends BaseModel
{
    protected $table = 'ana01k1';
}
