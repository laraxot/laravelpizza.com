<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;

/**
 * @property string $id
 * @property string|null $matricola
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $dal
 * @property string|null $al
 * @property string|null $importo_forzato
 * @property string|null $importo_base
 * @property string|null $dal_importo_base
 * @property string|null $al_importo_base
 * @property string|null $voce
 * @property string|null $descrizione
 * @property string|null $istituto
 * @property string|null $tipo
 * @property string|null $ruolo
 * @property string|null $ruolo_txt
 * @property string|null $profilo
 * @property string|null $profilo_txt
 * @property string|null $posizione_funzionale
 * @property string|null $descrposizione_funzionale
 * @property string|null $stabilimento
 * @property string|null $stabi_txt
 * @property string|null $reparto
 * @property string|null $repar_txt
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Progressioni\Database\Factories\CedDiffFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereAl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereAlImportoBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereCognome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereDal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereDalImportoBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereDescrizione($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereDescrposizioneFunzionale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereImportoBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereImportoForzato($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereIstituto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereMatricola($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff wherePosizioneFunzionale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereProfilo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereProfiloTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereReparTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereReparto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereRuolo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereRuoloTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereStabiTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereStabilimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CedDiff whereVoce($value)
 *
 * @mixin \Eloquent
 */
class CedDiff extends BaseModel
{
    // protected $fillable = ['id', 'name', 'value', 'anno'];

    // /protected $table = 'coeff_progressione';

    // end search
    // -------------------------
}
