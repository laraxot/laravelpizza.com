<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Incentivi\Database\Factories\EmployeeFactory;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Tqu00f;
use Modules\Xot\Enums\GenderEnum;
use Override;

/**
 * @property int $id
 * @property string $matricola
 * @property string $cognome
 * @property string $nome
 * @property GenderEnum $sesso
 * @property string $codice_fiscale
 * @property string $posizione_inail
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Collection<int, Activity> $activities
 * @property int|null $activities_count
 * @property Profile|null $creator
 * @property Profile|null $updater
 * @property Collection<int, Workgroup> $workgroups
 * @property int|null $workgroups_count
 * @property string $tipologia
 * @property EmployeeWorkgroup|ActivityEmployee|null $pivot
 * @property string|null $full_name
 * @method static EmployeeFactory factory($count = null, $state = [])
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
 * @method static Builder|Employee whereCodiceFiscale($value)
 * @method static Builder|Employee whereCognome($value)
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereCreatedBy($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereMatricola($value)
 * @method static Builder|Employee whereNome($value)
 * @method static Builder|Employee wherePosizioneInail($value)
 * @method static Builder|Employee whereSesso($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @method static Builder|Employee whereUpdatedBy($value)
 * @method static Builder<static>|Employee ofWorkgroupId(int $workgroup_id)
 * @method static Builder<static>|Employee whereTipologia($value)
 * @property-read string|null $tqu00f_desc1
 * @property-read string|null $tqu00f_desc2
 * @property-read Collection<int, Project> $projects
 * @property-read int|null $projects_count
 * @property-read Profile|null $deleter
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @method static Builder<static>|Employee whereTqu00fDesc1($value)
 * @method static Builder<static>|Employee whereTqu00fDesc2($value)
 * @mixin \Eloquent
 */
class Employee extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'matricola',
        'cognome',
        'nome',
        'sesso',
        'codice_fiscale',
        'posizione_inail',
        'tipologia',
        'tqu00f_desc1',
        'tqu00f_desc2',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = ['full_name'];

    /**
     * Casts the model's attributes.
     */
    #[Override]
    public function casts(): array
    {
        return [
            'sesso' => GenderEnum::class,
        ];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToManyX(Project::class);
    }

    /**
     * Get the activities for the employee.
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToManyX(Activity::class);
    }

    /**
     * Get the workgroups for the employee.
     */
    public function workgroups(): BelongsToMany
    {
        return $this->belongsToManyX(Workgroup::class);
    }

    /**
     * Scope a query to only include employees of a given workgroup.
     *
     * @param  Builder  $query
     */
    public function scopeOfWorkgroupId($query, int $workgroup_id): void
    {
        // $query->where('type', $type);
    }

    /**
     * Get the employee's full name.
     */
    public function getFullNameAttribute(?string $value): ?string
    {
        return "$this->cognome $this->nome";
    }

    public function getTqu00fDesc1Attribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }
        /** @var Qua00f|null $qua2kd */
        $qua2kd = $this->qua00f()->latest('qua2kd')->first();
        if ($qua2kd === null) {
            return null;
        }
        /** @var Tqu00f|null $tqu00f */
        $tqu00f = $qua2kd->tqu00f;
        $desc1 = $tqu00f?->desc1;
        $desc2 = $tqu00f?->desc2;
        $this->update([
            'tqu00f_desc1' => $desc1,
            'tqu00f_desc2' => $desc2,
        ]);

        return $desc1;
    }

    public function getTqu00fDesc2Attribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }
        /** @var Qua00f|null $qua2kd */
        $qua2kd = $this->qua00f()->latest('qua2kd')->first();
        if ($qua2kd === null) {
            return null;
        }
        /** @var Tqu00f|null $tqu00f */
        $tqu00f = $qua2kd->tqu00f;
        $desc1 = $tqu00f?->desc1;
        $desc2 = $tqu00f?->desc2;
        $this->update([
            'tqu00f_desc1' => $desc1,
            'tqu00f_desc2' => $desc2,
        ]);

        return $desc2;
    }

    public function qua00f(): HasMany
    {
        return $this->hasMany(Qua00f::class, 'matr', 'matricola')
            ->where('ente', 90)
            ->whereRaw('quaann=""');
    }
}
