<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Tmf00l1.
 *
 * @property int $id
 * @property string|null $vocfis
 * @property string|null $cont
 * @property string|null $tipco
 * @property string|null $rapp
 * @property string|null $ruolo
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $anz
 * @property string|null $tmfdal
 * @property string|null $tmfal
 * @property string|null $tmfimp
 * @property string|null $tmfeur
 * @property string|null $tmfdes
 * @property string|null $tmfliv
 * @property string|null $tmfann
 *
 * @method static Builder|Tmf00l1 newModelQuery()
 * @method static Builder|Tmf00l1 newQuery()
 * @method static Builder|Tmf00l1 query()
 * @method static Builder|Tmf00l1 whereAnz($value)
 * @method static Builder|Tmf00l1 whereCont($value)
 * @method static Builder|Tmf00l1 whereId($value)
 * @method static Builder|Tmf00l1 wherePosfun($value)
 * @method static Builder|Tmf00l1 wherePropro($value)
 * @method static Builder|Tmf00l1 whereRapp($value)
 * @method static Builder|Tmf00l1 whereRuolo($value)
 * @method static Builder|Tmf00l1 whereTipco($value)
 * @method static Builder|Tmf00l1 whereTmfal($value)
 * @method static Builder|Tmf00l1 whereTmfann($value)
 * @method static Builder|Tmf00l1 whereTmfdal($value)
 * @method static Builder|Tmf00l1 whereTmfdes($value)
 * @method static Builder|Tmf00l1 whereTmfeur($value)
 * @method static Builder|Tmf00l1 whereTmfimp($value)
 * @method static Builder|Tmf00l1 whereTmfliv($value)
 * @method static Builder|Tmf00l1 whereVocfis($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Tmf00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Tmf00l1 extends BaseModel
{
    protected $table = 'tmf00l1';
}
