<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Certificazioni2009.
 *
 * @property int $id
 * @property string|null $codicefor
 * @property string|null $nominativo
 * @property string|null $data_di_nascita
 * @property string|null $field
 * @property string|null $field1
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
 * @property string|null $nmand
 * @property string|null $atto
 *
 * @method static Builder|Certificazioni2009 newModelQuery()
 * @method static Builder|Certificazioni2009 newQuery()
 * @method static Builder|Certificazioni2009 query()
 * @method static Builder|Certificazioni2009 whereAnno($value)
 * @method static Builder|Certificazioni2009 whereAtto($value)
 * @method static Builder|Certificazioni2009 whereCap($value)
 * @method static Builder|Certificazioni2009 whereCodiceFiscale($value)
 * @method static Builder|Certificazioni2009 whereCodicefor($value)
 * @method static Builder|Certificazioni2009 whereComune($value)
 * @method static Builder|Certificazioni2009 whereDataDiNascita($value)
 * @method static Builder|Certificazioni2009 whereField($value)
 * @method static Builder|Certificazioni2009 whereField1($value)
 * @method static Builder|Certificazioni2009 whereId($value)
 * @method static Builder|Certificazioni2009 whereImpfatt($value)
 * @method static Builder|Certificazioni2009 whereImponibile($value)
 * @method static Builder|Certificazioni2009 whereMese($value)
 * @method static Builder|Certificazioni2009 whereNmand($value)
 * @method static Builder|Certificazioni2009 whereNominativo($value)
 * @method static Builder|Certificazioni2009 wherePartitaIva($value)
 * @method static Builder|Certificazioni2009 whereRitenuteFatt($value)
 * @method static Builder|Certificazioni2009 whereRitliquid($value)
 * @method static Builder|Certificazioni2009 whereRitmandato($value)
 * @method static Builder|Certificazioni2009 whereSommeNonSoggette($value)
 * @method static Builder|Certificazioni2009 whereTipoDocumento($value)
 * @method static Builder|Certificazioni2009 whereVia($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Certificazioni2009Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Certificazioni2009 extends BaseModel
{
    protected $table = 'certificazioni2009';
}
