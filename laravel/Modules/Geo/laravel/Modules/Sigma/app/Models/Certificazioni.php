<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Certificazioni.
 *
 * @property int $id
 * @property string|null $codicefor
 * @property string|null $nominativo
 * @property string|null $data_di_nascita
 * @property string|null $field1
 * @property string|null $f1
 * @property string|null $codice_fiscale
 * @property string|null $partita_iva
 * @property string|null $via
 * @property string|null $cap
 * @property string|null $comune
 * @property string|null $impfatt
 * @property string|null $imponibile
 * @property string|null $somme_non_soggette
 * @property string|null $ritenute_fatt
 * @property string|null $ritliquid
 * @property string|null $ritmandato
 * @property string|null $tipo_documento
 * @property string|null $anno
 * @property string|null $mese
 * @property string|null $n_mand
 * @property string|null $atto
 *
 * @method static Builder|Certificazioni newModelQuery()
 * @method static Builder|Certificazioni newQuery()
 * @method static Builder|Certificazioni query()
 * @method static Builder|Certificazioni whereAnno($value)
 * @method static Builder|Certificazioni whereAtto($value)
 * @method static Builder|Certificazioni whereCap($value)
 * @method static Builder|Certificazioni whereCodiceFiscale($value)
 * @method static Builder|Certificazioni whereCodicefor($value)
 * @method static Builder|Certificazioni whereComune($value)
 * @method static Builder|Certificazioni whereDataDiNascita($value)
 * @method static Builder|Certificazioni whereF1($value)
 * @method static Builder|Certificazioni whereField1($value)
 * @method static Builder|Certificazioni whereId($value)
 * @method static Builder|Certificazioni whereImpfatt($value)
 * @method static Builder|Certificazioni whereImponibile($value)
 * @method static Builder|Certificazioni whereMese($value)
 * @method static Builder|Certificazioni whereNMand($value)
 * @method static Builder|Certificazioni whereNominativo($value)
 * @method static Builder|Certificazioni wherePartitaIva($value)
 * @method static Builder|Certificazioni whereRitenuteFatt($value)
 * @method static Builder|Certificazioni whereRitliquid($value)
 * @method static Builder|Certificazioni whereRitmandato($value)
 * @method static Builder|Certificazioni whereSommeNonSoggette($value)
 * @method static Builder|Certificazioni whereTipoDocumento($value)
 * @method static Builder|Certificazioni whereVia($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\CertificazioniFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Certificazioni extends BaseModel
{
    protected $table = 'certificazioni';
}
