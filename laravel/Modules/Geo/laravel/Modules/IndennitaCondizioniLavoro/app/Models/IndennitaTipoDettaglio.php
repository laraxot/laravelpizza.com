<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;

/**
 * Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio.
 *
 * @property int $id
 * @property int|null $indennita_tipo_id
 * @property string|null $nome
 * @property int|null $dal
 * @property int|null $al
 * @property string|null $euro_giorno
 * @property string|null $only_disci1
 * @property string|null $only_codqua
 * @property string|null $except_disci1
 * @property string|null $except_codqua
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read IndennitaTipo|null $indennitaTipo
 * @property-read CondizioniLavoroIndennitaTipoDettaglioPivot|null $pivot
 * @method static Builder|IndennitaTipoDettaglio newModelQuery()
 * @method static Builder|IndennitaTipoDettaglio newQuery()
 * @method static Builder|IndennitaTipoDettaglio query()
 * @method static Builder|IndennitaTipoDettaglio whereAl($value)
 * @method static Builder|IndennitaTipoDettaglio whereCreatedAt($value)
 * @method static Builder|IndennitaTipoDettaglio whereCreatedBy($value)
 * @method static Builder|IndennitaTipoDettaglio whereDal($value)
 * @method static Builder|IndennitaTipoDettaglio whereEuroGiorno($value)
 * @method static Builder|IndennitaTipoDettaglio whereExceptCodqua($value)
 * @method static Builder|IndennitaTipoDettaglio whereExceptDisci1($value)
 * @method static Builder|IndennitaTipoDettaglio whereId($value)
 * @method static Builder|IndennitaTipoDettaglio whereIndennitaTipoId($value)
 * @method static Builder|IndennitaTipoDettaglio whereNome($value)
 * @method static Builder|IndennitaTipoDettaglio whereOnlyCodqua($value)
 * @method static Builder|IndennitaTipoDettaglio whereOnlyDisci1($value)
 * @method static Builder|IndennitaTipoDettaglio whereUpdatedAt($value)
 * @method static Builder|IndennitaTipoDettaglio whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class IndennitaTipoDettaglio extends BaseModel
{
    protected $table = 'indennita_tipo_dettaglio';

    protected $fillable = [
        'indennita_tipo_id', 'nome', 'dal', 'al', 'euro_giorno',
        'only_disci1', 'only_codqua', 'except_disci1', 'except_codqua',
    ];

    // /--- relationship ---
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo, $this>
     */
    public function indennitaTipo(): HasOne
    {
        return $this->hasOne(IndennitaTipo::class, 'id', 'indennita_tipo_id');
    }
}
