<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Figliperfasce.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $data_dal_anno_mese
 * @property string|null $data_al_anno_mese
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $data_di_nascita
 * @property string|null $codice_fiscale
 * @property string|null $irpper
 * @property string|null $irpinv
 * @property string|null $irptip
 *
 * @method static Builder|Figliperfasce newModelQuery()
 * @method static Builder|Figliperfasce newQuery()
 * @method static Builder|Figliperfasce query()
 * @method static Builder|Figliperfasce whereCodiceFiscale($value)
 * @method static Builder|Figliperfasce whereCognome($value)
 * @method static Builder|Figliperfasce whereDataAlAnnoMese($value)
 * @method static Builder|Figliperfasce whereDataDalAnnoMese($value)
 * @method static Builder|Figliperfasce whereDataDiNascita($value)
 * @method static Builder|Figliperfasce whereEnte($value)
 * @method static Builder|Figliperfasce whereId($value)
 * @method static Builder|Figliperfasce whereIrpinv($value)
 * @method static Builder|Figliperfasce whereIrpper($value)
 * @method static Builder|Figliperfasce whereIrptip($value)
 * @method static Builder|Figliperfasce whereMatr($value)
 * @method static Builder|Figliperfasce whereNome($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\FigliperfasceFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Figliperfasce extends BaseModel
{
    protected $table = 'figliperfasce';
}
