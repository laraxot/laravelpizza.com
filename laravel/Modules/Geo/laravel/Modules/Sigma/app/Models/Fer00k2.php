<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Fer00k2.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $ferano
 * @property string|null $ferdal
 * @property string|null $feral
 * @property string|null $fersta
 * @property string|null $fertip
 * @property string|null $fercod
 * @property string|null $fercon
 * @property string|null $ferrap
 * @property string|null $fertor
 * @property string|null $ferngi
 * @property string|null $ferngr
 * @property string|null $ferngd
 * @property string|null $ferlim
 * @property string|null $fercx
 * @property string|null $fernx
 * @property string|null $fergod
 * @property string|null $ferum
 * @property string|null $ferann
 * @property string|null $fer2kn
 * @property string|null $fer2kd
 * @property string|null $fer2ka
 * @property string|null $fer001
 * @property string|null $fer002
 * @property string|null $fer003
 * @property string|null $fer004
 * @property string|null $fer005
 *
 * @method static Builder|Fer00k2 newModelQuery()
 * @method static Builder|Fer00k2 newQuery()
 * @method static Builder|Fer00k2 query()
 * @method static Builder|Fer00k2 whereEnte($value)
 * @method static Builder|Fer00k2 whereFer001($value)
 * @method static Builder|Fer00k2 whereFer002($value)
 * @method static Builder|Fer00k2 whereFer003($value)
 * @method static Builder|Fer00k2 whereFer004($value)
 * @method static Builder|Fer00k2 whereFer005($value)
 * @method static Builder|Fer00k2 whereFer2ka($value)
 * @method static Builder|Fer00k2 whereFer2kd($value)
 * @method static Builder|Fer00k2 whereFer2kn($value)
 * @method static Builder|Fer00k2 whereFeral($value)
 * @method static Builder|Fer00k2 whereFerann($value)
 * @method static Builder|Fer00k2 whereFerano($value)
 * @method static Builder|Fer00k2 whereFercod($value)
 * @method static Builder|Fer00k2 whereFercon($value)
 * @method static Builder|Fer00k2 whereFercx($value)
 * @method static Builder|Fer00k2 whereFerdal($value)
 * @method static Builder|Fer00k2 whereFergod($value)
 * @method static Builder|Fer00k2 whereFerlim($value)
 * @method static Builder|Fer00k2 whereFerngd($value)
 * @method static Builder|Fer00k2 whereFerngi($value)
 * @method static Builder|Fer00k2 whereFerngr($value)
 * @method static Builder|Fer00k2 whereFernx($value)
 * @method static Builder|Fer00k2 whereFerrap($value)
 * @method static Builder|Fer00k2 whereFersta($value)
 * @method static Builder|Fer00k2 whereFertip($value)
 * @method static Builder|Fer00k2 whereFertor($value)
 * @method static Builder|Fer00k2 whereFerum($value)
 * @method static Builder|Fer00k2 whereId($value)
 * @method static Builder|Fer00k2 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Fer00k2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Fer00k2 extends BaseModel
{
    protected $table = 'fer00k2';
}
