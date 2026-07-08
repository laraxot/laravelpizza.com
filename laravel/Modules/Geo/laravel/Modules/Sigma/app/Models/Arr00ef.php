<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Arr00ef.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $datarr
 * @property string|null $tiparr
 * @property string|null $dat2kr
 * @property string|null $arranp
 * @property string|null $arr001
 * @property string|null $arr002
 * @property string|null $arr003
 * @property string|null $arr004
 *
 * @method static Builder|Arr00ef newModelQuery()
 * @method static Builder|Arr00ef newQuery()
 * @method static Builder|Arr00ef query()
 * @method static Builder|Arr00ef whereArr001($value)
 * @method static Builder|Arr00ef whereArr002($value)
 * @method static Builder|Arr00ef whereArr003($value)
 * @method static Builder|Arr00ef whereArr004($value)
 * @method static Builder|Arr00ef whereArranp($value)
 * @method static Builder|Arr00ef whereDat2kr($value)
 * @method static Builder|Arr00ef whereDatarr($value)
 * @method static Builder|Arr00ef whereEnte($value)
 * @method static Builder|Arr00ef whereId($value)
 * @method static Builder|Arr00ef whereMatr($value)
 * @method static Builder|Arr00ef whereTiparr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Arr00efFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Arr00ef extends BaseModel
{
    protected $table = 'arr00ef';
}
