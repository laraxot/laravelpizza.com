<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Corregf.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $form
 * @property string|null $nreg
 * @property string|null $prog
 * @property string|null $voxp
 * @property string|null $voxn
 * @property string|null $istx
 * @property string|null $valuni
 * @property string|null $rappt
 * @property string|null $condiz
 * @property string|null $dames
 * @property string|null $ames
 * @property string|null $stab
 * @property string|null $repa
 * @property string|null $codqc
 * @property string|null $pron
 * @property string|null $codql
 * @property string|null $limmen
 * @property string|null $limann
 * @property string|null $valamm
 *
 * @method static Builder|Corregf newModelQuery()
 * @method static Builder|Corregf newQuery()
 * @method static Builder|Corregf query()
 * @method static Builder|Corregf whereAmes($value)
 * @method static Builder|Corregf whereCodqc($value)
 * @method static Builder|Corregf whereCodql($value)
 * @method static Builder|Corregf whereCondiz($value)
 * @method static Builder|Corregf whereDames($value)
 * @method static Builder|Corregf whereEnte($value)
 * @method static Builder|Corregf whereForm($value)
 * @method static Builder|Corregf whereId($value)
 * @method static Builder|Corregf whereIstx($value)
 * @method static Builder|Corregf whereLimann($value)
 * @method static Builder|Corregf whereLimmen($value)
 * @method static Builder|Corregf whereNreg($value)
 * @method static Builder|Corregf whereProg($value)
 * @method static Builder|Corregf wherePron($value)
 * @method static Builder|Corregf whereRappt($value)
 * @method static Builder|Corregf whereRepa($value)
 * @method static Builder|Corregf whereStab($value)
 * @method static Builder|Corregf whereValamm($value)
 * @method static Builder|Corregf whereValuni($value)
 * @method static Builder|Corregf whereVoxn($value)
 * @method static Builder|Corregf whereVoxp($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\CorregfFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Corregf extends BaseModel
{
    protected $table = 'corregf';
}
