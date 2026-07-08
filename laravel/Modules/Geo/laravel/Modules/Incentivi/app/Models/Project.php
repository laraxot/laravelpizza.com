<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Incentivi\Database\Factories\ProjectFactory;
use Modules\Incentivi\Enums\ProjectStatus;
use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\Traits\HasStabiDirigente;

/**
 * @property int $id
 * @property string $nome
 * @property string $tipo
 * @property ProjectStatus $stato
 * @property int $workgroup_id
 * @property string $data_aggiudicazione
 * @property string $data_inizio_esecuzione
 * @property string $data_fine_esecuzione
 * @property string $ente_finanziatore
 * @property string $oggetto
 * @property string $determina
 * @property string $percentuale_fondo
 * @property string $importo_totale
 * @property string $importo_effettivo_fondo
 * @property string $componente_incentivante
 * @property string $componente_innovazione
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Collection<int, Activity> $activities
 * @property int|null $activities_count
 * @property Profile|null $creator
 * @property Profile|null $updater
 * @property Workgroup|null $workgroup
 * @method static ProjectFactory factory($count = null, $state = [])
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereComponenteIncentivante($value)
 * @method static Builder|Project whereComponenteInnovazione($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereCreatedBy($value)
 * @method static Builder|Project whereDataAggiudicazione($value)
 * @method static Builder|Project whereDataFineEsecuzione($value)
 * @method static Builder|Project whereDataInizioEsecuzione($value)
 * @method static Builder|Project whereDetermina($value)
 * @method static Builder|Project whereEnteFinanziatore($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereImportoEffettivoFondo($value)
 * @method static Builder|Project whereImportoTotale($value)
 * @method static Builder|Project whereNome($value)
 * @method static Builder|Project whereOggetto($value)
 * @method static Builder|Project wherePercentualeFondo($value)
 * @method static Builder|Project whereStato($value)
 * @method static Builder|Project whereTipo($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereUpdatedBy($value)
 * @method static Builder|Project whereWorkgroupId($value)
 * @property string $settore
 * @property string $tipo_liquidazione
 * @property int|null $rup
 * @property int|null $dec
 * @property Collection<int, Employee> $employees
 * @property int|null $employees_count
 * @property Collection<int, Settlement> $settlements
 * @property int|null $settlements_count
 * @method static Builder<static>|Project whereSettore($value)
 * @method static Builder<static>|Project whereTipoLiquidazione($value)
 * @property-read EmployeeProject|null $pivot
 * @property-read Collection<int, Phase> $phases
 * @property-read int|null $phases_count
 * @property string $ditta_nome
 * @property string $ditta_sede
 * @property string $ditta_partitaiva
 * @property numeric $ditta_oneri_sicurezza
 * @property string $ditta_trattativa
 * @property int $department_id
 * @property-read Profile|null $deleter
 * @property-read Collection<int, \Modules\Incentivi\Models\StabiDirigente> $stabiDirigente
 * @property-read int|null $stabi_dirigente_count
 * @method static Builder<static>|Project whereDec($value)
 * @method static Builder<static>|Project whereDepartmentId($value)
 * @method static Builder<static>|Project whereDittaNome($value)
 * @method static Builder<static>|Project whereDittaOneriSicurezza($value)
 * @method static Builder<static>|Project whereDittaPartitaiva($value)
 * @method static Builder<static>|Project whereDittaSede($value)
 * @method static Builder<static>|Project whereDittaTrattativa($value)
 * @method static Builder<static>|Project whereRup($value)
 * @mixin \Eloquent
 */
class Project extends BaseModel
{
    use HasStabiDirigente;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'tipo',
        'stato',
        'data_aggiudicazione',
        'data_inizio_esecuzione',
        'data_fine_esecuzione',
        'ente_finanziatore',
        'oggetto',
        'determina',
        'percentuale_fondo',
        'importo_totale',
        'importo_effettivo_fondo',
        'componente_incentivante',
        'componente_innovazione',
        'rup',
        'dec',
        'ditta_nome',
        'ditta_sede',
        'ditta_partitaiva',
        'ditta_oneri_sicurezza',
        'ditta_trattativa',
        'department_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stato' => ProjectStatus::class,
        ];
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToManyX(Employee::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    // public function workgroup(): BelongsTo
    // {
    //     return $this->belongsTo(Workgroup::class);
    // }

    // public function employees(): HasManyThrough
    // {
    //     return $this->hasManyThrough(
    //         related: Employee::class,
    //         through: EmployeeWorkgroup::class,
    //         firstKey: 'workgroup_id', // foreign key on EmployeeWorkgroup
    //         secondKey: 'id', // foreign key on EmployeeWorkgroup
    //         localKey: 'workgroup_id', // local key on Project
    //         secondLocalKey: 'employee_id' // local key on EmployeeWorkgroup
    //     );
    // }

    public function phases(): HasMany
    {
        return $this->hasMany(Phase::class);
    }

    public function settlements(): HasMany
    {
        return $this->hasMany(Settlement::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('team', function (Builder $query) {
            $user = Auth::user();

            if (! $user) {
                return;
            }

            // Prendi tutti i team dell'utente
            $teamIds = $user->teams->modelKeys();

            // Filtra i Project per settore compreso nei team dell'utente
            $query->whereIn('department_id', $teamIds);
        });
    }
}
