<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Rie00k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $rieaa
 * @property string|null $rietip
 * @property string|null $rieann
 * @property string|null $rie2kn
 * @property string|null $rie001
 * @property string|null $rie002
 * @property string|null $rie003
 * @property string|null $rie004
 * @property string|null $rie005
 *
 * @method static Builder|Rie00k1 newModelQuery()
 * @method static Builder|Rie00k1 newQuery()
 * @method static Builder|Rie00k1 query()
 * @method static Builder|Rie00k1 whereEnte($value)
 * @method static Builder|Rie00k1 whereId($value)
 * @method static Builder|Rie00k1 whereMatr($value)
 * @method static Builder|Rie00k1 whereRie001($value)
 * @method static Builder|Rie00k1 whereRie002($value)
 * @method static Builder|Rie00k1 whereRie003($value)
 * @method static Builder|Rie00k1 whereRie004($value)
 * @method static Builder|Rie00k1 whereRie005($value)
 * @method static Builder|Rie00k1 whereRie2kn($value)
 * @method static Builder|Rie00k1 whereRieaa($value)
 * @method static Builder|Rie00k1 whereRieann($value)
 * @method static Builder|Rie00k1 whereRietip($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Rie00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Rie00k1 extends BaseModel
{
    protected $table = 'rie00k1';
}
