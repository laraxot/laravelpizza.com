<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Ptv\Database\Factories\StabiDirigenteFactory;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Repart;
use Modules\Xot\Actions\Factory\GetFactoryAction;
use Modules\Xot\Traits\Updater;
use Override;

/**
 * Modules\Incentivi\Models\StabiDirigente.
 *
 * @property-read string|null $nome_diri
 * @property-read string|null $nome_stabi
 * @property-read Repart|null $repart
 * @method static StabiDirigenteFactory factory($count = null, $state = [])
 * @method static Builder|StabiDirigente newModelQuery()
 * @method static Builder|StabiDirigente newQuery()
 * @method static Builder|StabiDirigente query()
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $nome_diri_plus
 * @property string|null $budget
 * @property int|null $valutatore_id
 * @property int|null $anno
 * @property string|null $post_type
 * @property int|null $post_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static Builder|StabiDirigente whereAnno($value)
 * @method static Builder|StabiDirigente whereBudget($value)
 * @method static Builder|StabiDirigente whereCreatedAt($value)
 * @method static Builder|StabiDirigente whereCreatedBy($value)
 * @method static Builder|StabiDirigente whereEnte($value)
 * @method static Builder|StabiDirigente whereId($value)
 * @method static Builder|StabiDirigente whereMatr($value)
 * @method static Builder|StabiDirigente whereNomeDiri($value)
 * @method static Builder|StabiDirigente whereNomeDiriPlus($value)
 * @method static Builder|StabiDirigente whereNomeStabi($value)
 * @method static Builder|StabiDirigente wherePostId($value)
 * @method static Builder|StabiDirigente wherePostType($value)
 * @method static Builder|StabiDirigente whereRepar($value)
 * @method static Builder|StabiDirigente whereStabi($value)
 * @method static Builder|StabiDirigente whereUpdatedAt($value)
 * @method static Builder|StabiDirigente whereUpdatedBy($value)
 * @method static Builder|StabiDirigente whereValutatoreId($value)
 * @property int $n_diritto_excellence
 * @method static Builder<static>|StabiDirigente whereNDirittoExcellence($value)
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @mixin \Eloquent
 */
class StabiDirigente extends BaseModel
{
    use \Modules\Xot\Models\Traits\HasXotFactory;
    use Updater;

    protected $table = 'stabi_dirigente';

    protected $fillable = [
        'stabi', 'repar', 'nome_stabi',
        'ente', 'matr', 'nome_diri', 'nome_diri_plus',
        'budget',
        'valutatore_id',
        'anno',
        // 'quadrimestre',
        // 'email',
    ];

    #[Override]
    public function casts(): array
    {
        return [
            'created_at' => 'datetime', 'updated_at' => 'datetime',
        ];
    }

    // ----- relationship ---
    public function repart(): HasOne
    {
        return $this->hasOne(Repart::class, 'stabi', 'stabi')
            ->where('repar', $this->repar)
            ->where('ente', 90);
    }

    /*
    public function schede():\Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Scheda::class, 'valutatore_id', 'id');
    }

    public function benificiariProgressione(): void {
        return $this->schede()->where('benificiario_progressione', 1);
    }
    */

    // --- mutators --
    
   
    /**
     * Get nome_stabi attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    public function getNomeStabiAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if ($value !== null) {
            return $value;
        }
        
        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->getNomeStabi();
    }

    /**
     * Calcola il nome_stabi.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function getNomeStabi(): ?string
    {
        if (! $this->repart instanceof Repart) {
            return null;
        }

        return $this->repart->dest1;
    }

    /**
     * Get stabi attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE con ActivityLog-Safe
     */
    public function getStabiAttribute(?int $value): ?int
    {
        $recordKey = $this->getKey();

        if (($value !== null && $value != 0) || $recordKey === null) {
            return $value;
        }

        $value = $this->getStabi();

        static::withoutEvents(function () use ($value): void {
            $this->update(['stabi' => $value]);
        });

        return $value;
    }

    /**
     * Calcola lo stabi.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function getStabi(): ?int
    {
        $rep00f = Rep00f::where('ente', $this->ente)
            ->where('matr', $this->matr)
            ->whereRaw('repann=""')
            ->ofYear($this->anno ?? 0)
            ->latest('rep2kd')
            ->first();

        $value = $rep00f?->repst1;
        if ($value == 0 && $rep00f?->repst2 != 0) {
            $value = $rep00f->repst2;
        }

        return $value;
    }

    /**
     * Get repar attribute.
     */
    public function getReparAttribute(?int $value): ?int
    {
        $recordKey = $this->getKey();

        if (($value !== null) || $recordKey === null) {
            return $value;
        }

        $value = 0;

        static::withoutEvents(function () use ($value): void {
            $this->update(['repar' => $value]);
        });

        return $value;
    }

    /**
     * Get ente attribute.
     */
    public function getEnteAttribute(?int $value): ?int
    {
        $recordKey = $this->getKey();

        if (($value !== null) || $recordKey === null) {
            return $value;
        }

        $value = 90;

        static::withoutEvents(function () use ($value): void {
            $this->update(['ente' => $value]);
        });

        return $value;
    }

    /**
     * Get nome_diri attribute.
     */
    public function getNomeDiriAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if ($value !== null) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->getNomeDiri();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($value !== null && $this->getKey() !== null) {
            
                    static::withoutEvents(function () use ($value): void {
                        $this->update(['nome_diri' => $value]);
                    });
                
                
                
        }

        return $value;
    }

    /**
     * Calcola il nome_diri.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function getNomeDiri(): ?string
    {
        /*
         * Se non c'e' il nome prendo quello dell'anno prima.
         */
        if (random_int(1, 10) > 7) {
            $prev = self::where('stabi', $this->stabi)
                ->where('repar', $this->repar)
                ->where('anno', $this->anno - 1)
                ->first();
            if (\is_object($prev)) {
                return $prev->nome_diri;
            }
        }

        // *
        /** @phpstan-ignore-next-line */
        if (empty($value) && $this->stabi !== '' && random_int(1, 10) > 8) {
            $conn = $this->getConnection();
            $sql = 'select concat(conome," ",nome) as nome_diri from generale.ana10f where matr=(
                select matr from generale.qua00f where (
                    ('.$this->anno.' between year(qua2kd) and year(qua2ka) ) or
                    ('.$this->anno.' >= year(qua2kd) and qua2ka=0 )
                ) and quaann=""
                and matr in
                (select matr from generale.rep00f where repst1="'.$this->stabi.'"
                 and repann=""
                and (
                    ('.$this->anno.' between year(rep2kd) and year(rep2ka) ) or
                    ('.$this->anno.' >= year(rep2kd) and rep2ka=0 )
                )
                order by rep2kd desc
                )
                and matr in
                (select matr from generale.sto00f where stann=""
                and (
                    ('.($this->anno + 1).' between year(st2kas) and year(st2kdi) ) or
                    ('.($this->anno + 1).' >= year(st2kas) and st2kdi=0 )
                )
                )
                order by propro desc,posfun desc
                limit 1)';

            $res = DB::select($sql);
            if (isset($res[0]) && is_object($res[0])) {
                /** @var object{nome_diri?: string} $firstResult */
                $firstResult = $res[0];
                $nomeDiri = isset($firstResult->nome_diri) ? (string) $firstResult->nome_diri : '';

                return ucwords(strtolower($nomeDiri));
            }
        }

        // */
        return null;
    }

    /*
    public function budgetAssegnato(): void {
        $beneficiari = $this->benificiariProgressione;
        $res = $beneficiari->sum('costo_fascia_up');

        return $res;
    }
    */
    // end budgetAssegnato
    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    // #[Override]
    // protected static function newFactory()
    // {
    //     return app(GetFactoryAction::class)->execute(static::class);
    // }

    /*
    public function getNomeDiriAttribute(): void {
       if (null !== $value) {
           return $value;
       }
       $row = StabiDirigente::where('stabi', $this->stabi)
           ->where('repar', $this->repar)
           ->first();

       if (is_object($row)) {
           $value = $row->nome_diri;
           $this->nome_diri = $value;

           // Guard: modello deve avere PK per salvare
           if (null != $this->getKey()) {
               $this->save();
           }
       }

       return $value;
    }
    */
    /*
    public function getNomeStabiAttribute(): void {
        if ($value !== null) {
            return $value;
        }

        $stabi = Repart::where('stabi', $this->stabi)
            ->where('repar', 0)
            ->where('ente', 90)
            ->first();

        $repart = Repart::where('stabi', $this->stabi)
            ->where('repar', $this->repar)
            ->where('ente', 90)
            ->first();
        if (\is_object($stabi) && \is_object($repart)) {
            $value = $stabi->dest1.' '.$stabi->dest2.' - '.$repart->dest1.' '.$repart->dest2;
            $this->nome_stabi = $value;

            // Guard: modello deve avere PK per salvare
            if (null != $this->getKey()) {
                $this->save();
            }
        }

        return $value;
    }
        */
}
