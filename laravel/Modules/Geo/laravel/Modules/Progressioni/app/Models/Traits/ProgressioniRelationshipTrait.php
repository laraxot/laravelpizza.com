<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Modules\Performance\Models\Individuale as PerformanceIndividuale;
use Modules\Progressioni\Models\Assenza;
use Modules\Progressioni\Models\Coeff;
use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\CriteriPrecedenza;
use Modules\Progressioni\Models\CriteriValutazione;
use Modules\Progressioni\Models\EsclusiExtra;
use Modules\Progressioni\Models\MaxCatecoPosfunAnno;
use Modules\Progressioni\Models\Message;
use Modules\Progressioni\Models\MyLog;
use Modules\Progressioni\Models\Pesi;
use Modules\Progressioni\Models\Scheda;
use Modules\Progressioni\Models\SchedaCriteri;
use Modules\Progressioni\Models\StabiDirigente;
use Modules\Progressioni\Models\StipendioTabellare;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;

use function Safe\date;

trait ProgressioniRelationshipTrait
{
    /** @return HasMany<Scheda, $this> */
    public function mails(): HasMany
    {
        $this->anno = request()->integer('anno', (int) date('Y'));

        return $this->hasMany(Scheda::class, 'anno', 'anno')
            ->where('valutatore_id', 1)
            ->where('ha_diritto', 1);
    }

    /** @return HasMany<CriteriEsclusione, $this> */
    public function criteriEsclusione(): HasMany
    {
        return $this->hasMany(CriteriEsclusione::class, 'anno', 'anno');
    }

    /** @return HasMany<static, $this> */
    public function criteriOptions(): HasMany
    {
        return $this->hasMany(static::class, 'anno', 'anno');
    }

    /** @return HasMany<Message, $this> */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'anno', 'anno');
    }

    /** @return HasOne<EsclusiExtra, $this> */
    public function esclusoExtra(): HasOne
    {
        return $this->hasOne(EsclusiExtra::class, 'anno', 'anno')
            ->where('ente', $this->ente)
            ->where('matr', $this->matr);
    }

    public function isEsclusoExtra(): bool
    {
        return $this->esclusoExtra()->exists();
    }

    /** @return HasMany<SchedaCriteri, $this> */
    public function schedaCriteri(): HasMany
    {
        return $this->hasMany(SchedaCriteri::class, 'anno', 'anno');
    }

    /** @return HasMany<CriteriValutazione, $this> */
    public function criteriValutazione(): HasMany
    {
        return $this->hasMany(CriteriValutazione::class, 'anno', 'anno');
    }

    /** @return HasMany<CriteriPrecedenza, $this> */
    public function criteriPrecedenza(): HasMany
    {
        return $this->hasMany(CriteriPrecedenza::class, 'anno', 'anno');
    }

    /** @return HasMany<Coeff, $this> */
    public function coeff(): HasMany
    {
        return $this->hasMany(Coeff::class, 'anno', 'anno');
    }

    /** @return HasMany<Asz00f, $this> */
    public function asz00fs(): HasMany
    {
        return $this->hasMany(Asz00f::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->where('aszann', '')
            ->ofYear((int) $this->anno);
    }

    /** @return HasMany<Scheda, $this> */
    public function righeDoppie(): HasMany
    {
        return $this->hasMany(Scheda::class, 'anno', 'anno')
            ->where('matr', $this->matr)
            ->orderBy('dal');
    }

    /** @return HasMany<PerformanceIndividuale, $this> */
    public function performanceIndividuale(): HasMany
    {
        return $this->hasMany(PerformanceIndividuale::class, 'matr', 'matr')
            ->where('ente', $this->ente);
    }

    /** @return HasOne<static, $this> */
    public function stipendioTabellare(): HasOne
    {
        return $this->hasOne(static::class, 'propro', 'propro')
            ->where('posfun', $this->posfunval)
            ->where('anno', $this->anno)
            ->orderBy('ptime', 'desc');
    }

    /** @return HasOne<StipendioTabellare, $this> */
    public function stipendioTabellareUp(): HasOne
    {
        return $this->hasOne(StipendioTabellare::class, 'propro', 'propro')
            ->where('posfun', (int) $this->posfunval + 1)
            ->where('anno', (int) $this->anno)
            ->orderBy('ptime', 'desc');
    }

    /**
     * @return MorphMany<MyLog, $this>
     * @phpstan-ignore-next-line method.childReturnType - $this vs static covariance issue
     */
    public function myLogs(): MorphMany
    {
        return $this->morphMany(MyLog::class, 'model');
    }

    /** @return MorphMany<MyLog, $this> */
    public function mailInviate(): MorphMany
    {
        return $this->myLogs()->where('note', 'sendMail');
    }

    /** @return HasOne<MaxCatecoPosfunAnno, $this> */
    public function maxCatecoPosfun(): HasOne
    {
        return $this->hasOne(MaxCatecoPosfunAnno::class, 'anno', 'anno')
            ->where('cateco', $this->categoria_ecoval)
            ->where('posfun', $this->posfunval);
    }

    /** @return Collection<int|string, string|null> */
    public function allStabiRepars(): Collection
    {
        return $this->hasMany(StabiDirigente::class, 'anno', 'anno')
            ->pluck('nome_diri', 'id')
            ->map(static fn (mixed $value): ?string => $value === null ? null : (string) $value);
    }

    /** @return HasOne<Pesi, $this> */
    public function pesi(): HasOne
    {
        return $this->hasOne(Pesi::class, 'anno', 'anno')
            ->whereRaw('find_in_set(?, lista_propro)', [(string) $this->propro]);
    }

    /** @return HasOne<Pesi, $this> */
    public function peso(): HasOne
    {
        return $this->pesi();
    }

    /** @return HasOne<StabiDirigente, $this> */
    public function valutatoreDefault(): HasOne
    {
        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', 0)
            ->where('anno', $this->anno);
    }

    /** @return HasMany<Assenza, $this> */
    public function assenze(): HasMany
    {
        return $this->hasMany(Assenza::class, 'anno', 'anno');
    }

    /** @return HasMany<Asz00k1, $this> */
    public function aszEff(): HasMany
    {
        $listaCodiciAspettative = $this->listaCodiciAspettative();

        return $this->asz()
            ->whereRaw('find_in_set(concat(asztip,"-",aszcod), ?)', [$listaCodiciAspettative]);
    }
}
