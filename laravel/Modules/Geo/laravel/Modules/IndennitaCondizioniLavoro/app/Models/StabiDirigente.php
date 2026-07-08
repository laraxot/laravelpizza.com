<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\IndennitaCondizioniLavoro\Database\Factories\StabiDirigenteFactory;
use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\StabiDirigente as PtvStabiDirigenteModel;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Repart;

/**
 * Modules\IndennitaCondizioniLavoro\Models\StabiDirigente.
 *
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $anno
 * @property string|null $nome_stabi
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $nome_diri
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @property string|null $nome_diri_plus
 * @property string|null $budget
 * @property int|null $valutatore_id
 * @property-read Repart|null $repart
 * @method static StabiDirigenteFactory factory($count = null, $state = [])
 * @method static Builder|StabiDirigente newModelQuery()
 * @method static Builder|StabiDirigente newQuery()
 * @method static Builder|StabiDirigente query()
 * @method static Builder|StabiDirigente whereAnno($value)
 * @method static Builder|StabiDirigente whereBudget($value)
 * @method static Builder|StabiDirigente whereCreatedAt($value)
 * @method static Builder|StabiDirigente whereCreatedBy($value)
 * @method static Builder|StabiDirigente whereCreatedIp($value)
 * @method static Builder|StabiDirigente whereDeletedAt($value)
 * @method static Builder|StabiDirigente whereDeletedBy($value)
 * @method static Builder|StabiDirigente whereDeletedIp($value)
 * @method static Builder|StabiDirigente whereEnte($value)
 * @method static Builder|StabiDirigente whereId($value)
 * @method static Builder|StabiDirigente whereMatr($value)
 * @method static Builder|StabiDirigente whereNomeDiri($value)
 * @method static Builder|StabiDirigente whereNomeDiriPlus($value)
 * @method static Builder|StabiDirigente whereNomeStabi($value)
 * @method static Builder|StabiDirigente whereRepar($value)
 * @method static Builder|StabiDirigente whereStabi($value)
 * @method static Builder|StabiDirigente whereUpdatedAt($value)
 * @method static Builder|StabiDirigente whereUpdatedBy($value)
 * @method static Builder|StabiDirigente whereUpdatedIp($value)
 * @method static Builder|StabiDirigente whereValutatoreId($value)
 * @property int $n_diritto_excellence
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @method static Builder<static>|StabiDirigente whereNDirittoExcellence($value)
 * @property int|null $quadrimestre
 * @property string|null $email
 * @property-read Profile|null $deleter
 * @method static Builder<static>|StabiDirigente whereEmail($value)
 * @method static Builder<static>|StabiDirigente whereQuadrimestre($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Progressioni\Models\Scheda> $benificiariProgressione
 * @property-read int|null $benificiari_progressione_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Progressioni\Models\Scheda> $scheda
 * @property-read int|null $scheda_count
 * @mixin \Eloquent
 */
class StabiDirigente extends PtvStabiDirigenteModel
{
    protected $connection = 'indennita_condizioni_lavoro'; // this will use the specified database connection

    protected $fillable = [
        'stabi', 'repar', 'nome_stabi',
        'ente', 'matr', 'nome_diri', 'nome_diri_plus',
        'budget',
        'valutatore_id',
        'anno',
        'quadrimestre',
        'email',
    ];

    public function getStabiAttributeTest(?int $value): ?int
    {
        if ($value > 500) {
            return $value;
        }
        if ($this->getKey() == null) {
            return $value;
        }

        /*
        $rep=Rep00f::where('ente',$this->ente)
            //->where('anno',$this->anno)
            ->where('matr',$this->matr)
            ->ofFourMonthPeriod($this->quadrimestre,$this->anno)
            ->get();
        */

        return $value;
    }
}
