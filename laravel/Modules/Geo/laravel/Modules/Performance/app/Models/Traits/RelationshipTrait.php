<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Traits;

// use Illuminate\Support\Str;
// ----- models------
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Performance\Models\CriteriMaggiorazione;
use Modules\Performance\Models\CriteriOption;
use Modules\Performance\Models\CriteriValutazione;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\IndividualeAssenze;
use Modules\Performance\Models\IndividualePesi;
use Modules\Performance\Models\IndividualeTotStabi;
use Modules\Performance\Models\MyLog;
use Modules\Performance\Models\Option;
use Modules\Performance\Models\StabiDirigente;

// ------ ext models---

// ----- services -----

// ------ traits ---

/**
 * Modules\Performance\Models\Traits\RelationshipTrait.
 *
 * @property int $ente
 * @property int $matr
 * @property int $propro
 * @property int $posfun
 * @property int $anno
 * @property int $stabi
 * @property int $repar
 */
trait RelationshipTrait
{
    /**
     * @return HasMany<CriteriOption, $this>
     */
    public function criteriOptions(): HasMany
    {
        return $this->hasMany(CriteriOption::class, 'anno', 'anno');
    }

    /**
     * @return HasMany<IndividualeAssenze, $this>
     */
    public function codiciAssenze(): HasMany
    {
        return $this->hasMany(IndividualeAssenze::class, 'anno', 'anno');
    }

    /**
     * @return HasOne<CriteriMaggiorazione, $this>
     */
    public function criteriMaggiorazione(): HasOne
    {
        return $this->hasOne(CriteriMaggiorazione::class, 'anno', 'anno');
    }

    /**
     * @return HasMany<CriteriEsclusione, $this>
     */
    public function criteriEsclusione(): HasMany
    {
        return $this->hasMany(CriteriEsclusione::class, 'anno', 'anno');
    }

    /**
     * @return HasMany<CriteriValutazione, $this>
     */
    public function criteriValutazioneOld(): HasMany
    {
        return $this->hasMany(CriteriValutazione::class, 'anno', 'anno')
            ->where('post_type', $this->type)
            ->ordered();

        /*
        ->withDefault(
            [
                'name'=>'no-set',
                'value'=>'andare a mettere in options',
            ]
        );
        */
    }

    /**
     * @return HasMany<Individuale, $this>
     */
    public function cards(): HasMany // traduzione di scheda
    {
        return $this->hasMany(Individuale::class, 'anno', 'anno')
            ->where('ente', $this->ente)
            ->where('matr', $this->matr);
    }

    /**
     * @return HasOne<IndividualePesi, $this>
     */
    public function peso(): HasOne
    {
        return $this->hasOne(IndividualePesi::class, 'anno', 'anno')
            ->whereRaw('find_in_set(?, lista_propro)', [(string) $this->propro])
            ->where('type', $this->type);
    }

    /**
     * @return HasOne<IndividualePesi, $this>
     */
    public function pesoPo(): HasOne
    {
        return $this->hasOne(IndividualePesi::class, 'anno', 'anno')->where('type', 'po');
        // ->whereRaw('find_in_set('.$this->propro.',lista_propro)');
    }

    // @phpstan-ignore-next-line
    public function otherWinnerRows(): HasMany
    {
        return $this->hasMany(static::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->where('anno', $this->anno)
            ->where('id', '!=', $this->getKey())
            // ->where('ha_diritto', '>', 0)
            ->whereRaw('(ha_diritto>0 or posfun>=100)');
    }

    /**
     * @return HasOne<StabiDirigente, $this>
     */
    public function stabiDirigente(): HasOne
    {
        $row = $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('anno', $this->anno);

        if ($row->count() > 0) {
            return $row;
        }

        StabiDirigente::firstOrCreate(
            [
                'stabi' => $this->stabi,
                'repar' => $this->repar,
                'anno' => $this->anno,
            ]
        );

        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('anno', $this->anno);
        // dddx('preso');
    }

    /**
     * @return HasMany<Option, $this>
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'year', 'anno')
            ->where('option_type', $this->type)
            ->orderBy('pos');
        /*
        ->withDefault(
            [
                'name'=>'no-set',
                'value'=>'andare a mettere in options',
            ]
        );
        */
    }

    /**
     * @return HasMany<MyLog, $this>
     */
    public function mailInviate(): HasMany
    {
        return $this->hasMany(MyLog::class, 'id_tbl', 'id')
            ->where('tbl', $this->getTable())
            ->where('note', 'sendMail');
    }

    /**
     * @return HasOne<IndividualeTotStabi, $this>
     */
    public function totStabi(): HasOne
    {
        // dddx(class_basename($this));// IndividualeDip per collegare sia organizzativa che individuale con le loro
        // relazioni

        return $this->hasOne(IndividualeTotStabi::class, 'stabi', 'stabi')
            ->where('anno', $this->anno);
    }
}
