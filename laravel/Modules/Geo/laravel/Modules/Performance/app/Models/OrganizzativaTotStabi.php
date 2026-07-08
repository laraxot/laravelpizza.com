<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\OrganizzativaTotStabi.
 *
 * @property int $id
 * @property int|null $stabi
 * @property string|null $tot_budget_assegnato
 * @property string|null $tot_budget_assegnato_min_punteggio
 * @property string|null $tot_quota_effettiva
 * @property string|null $tot_quota_effettiva_min_punteggio
 * @property string|null $tot_resti
 * @property string|null $tot_resti_min_punteggio
 * @property string|null $delta
 * @property string|null $delta_min_punteggio
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OrganizzativaTotStabi newModelQuery()
 * @method static Builder|OrganizzativaTotStabi newQuery()
 * @method static Builder|OrganizzativaTotStabi query()
 * @method static Builder|OrganizzativaTotStabi whereAnno($value)
 * @method static Builder|OrganizzativaTotStabi whereCreatedAt($value)
 * @method static Builder|OrganizzativaTotStabi whereDelta($value)
 * @method static Builder|OrganizzativaTotStabi whereDeltaMinPunteggio($value)
 * @method static Builder|OrganizzativaTotStabi whereId($value)
 * @method static Builder|OrganizzativaTotStabi whereStabi($value)
 * @method static Builder|OrganizzativaTotStabi whereTotBudgetAssegnato($value)
 * @method static Builder|OrganizzativaTotStabi whereTotBudgetAssegnatoMinPunteggio($value)
 * @method static Builder|OrganizzativaTotStabi whereTotQuotaEffettiva($value)
 * @method static Builder|OrganizzativaTotStabi whereTotQuotaEffettivaMinPunteggio($value)
 * @method static Builder|OrganizzativaTotStabi whereTotResti($value)
 * @method static Builder|OrganizzativaTotStabi whereTotRestiMinPunteggio($value)
 * @method static Builder|OrganizzativaTotStabi whereUpdatedAt($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read Profile|null $deleter
 * @method static Builder<static>|OrganizzativaTotStabi whereCreatedBy($value)
 * @method static Builder<static>|OrganizzativaTotStabi whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class OrganizzativaTotStabi extends BaseModel
{
    protected $fillable = ['id', 'stabi', 'tot_budget_assegnato', 'tot_budget_assegnato_min_punteggio', 'tot_quota_effettiva', 'tot_quota_effettiva_min_punteggio', 'tot_resti', 'tot_resti_min_punteggio', 'delta', 'delta_min_punteggio', 'anno'];

    protected $table = 'tot_stabi_performance_organizzativa';

    /*
    use Updater;
    protected $connection = 'performance'; // this will use the specified database connection
    //public $timestamps= false;
    protected $dates = [
        'created_at',
        'updated_at',
        ];
    */

    // end search
    // -------------------------
}
