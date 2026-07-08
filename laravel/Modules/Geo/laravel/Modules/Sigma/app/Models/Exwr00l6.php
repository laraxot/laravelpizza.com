<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Exwr00l6.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $etannu
 * @property string|null $etsens
 * @property string|null $etindi
 * @property string|null $etbadg
 * @property string|null $etdata
 * @property string|null $etorat
 * @property string|null $ezorat
 * @property string|null $etmatr
 * @property string|null $etcaus
 * @property string|null $etcau1
 * @property string|null $etcomp
 * @property string|null $etteor
 * @property string|null $etcom1
 * @property string|null $etcom2
 *
 * @method static Builder|Exwr00l6 newModelQuery()
 * @method static Builder|Exwr00l6 newQuery()
 * @method static Builder|Exwr00l6 query()
 * @method static Builder|Exwr00l6 whereEnteap($value)
 * @method static Builder|Exwr00l6 whereEtannu($value)
 * @method static Builder|Exwr00l6 whereEtbadg($value)
 * @method static Builder|Exwr00l6 whereEtcau1($value)
 * @method static Builder|Exwr00l6 whereEtcaus($value)
 * @method static Builder|Exwr00l6 whereEtcom1($value)
 * @method static Builder|Exwr00l6 whereEtcom2($value)
 * @method static Builder|Exwr00l6 whereEtcomp($value)
 * @method static Builder|Exwr00l6 whereEtdata($value)
 * @method static Builder|Exwr00l6 whereEtindi($value)
 * @method static Builder|Exwr00l6 whereEtmatr($value)
 * @method static Builder|Exwr00l6 whereEtorat($value)
 * @method static Builder|Exwr00l6 whereEtsens($value)
 * @method static Builder|Exwr00l6 whereEtteor($value)
 * @method static Builder|Exwr00l6 whereEzorat($value)
 * @method static Builder|Exwr00l6 whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Exwr00l6Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Exwr00l6 extends BaseModel
{
    protected $table = 'exwr00l6';
}
