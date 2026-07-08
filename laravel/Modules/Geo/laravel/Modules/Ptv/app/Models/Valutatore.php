<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Progressioni\Models\Scheda;
use Modules\Sigma\Models\Repart;
use Webmozart\Assert\Assert;

/**
 * Modules\Ptv\Models\Valutatore.
 *
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $nome_stabi
 * @property string|null $stabi_txt
 * @property string|null $repar_txt
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $anno
 * @property string|null $nome_diri
 * @property string|null $nome_diri_plus
 * @property string|null $budget
 * @property int|null $valutatore_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @property-read Collection<int, Scheda> $benificiariProgressione
 * @property-read int|null $benificiari_progressione_count
 * @property-read Valutatore|null $boss
 * @property-read Repart|null $repart
 * @property-read Collection<int, Scheda> $schede
 * @property-read int|null $schede_count
 *
 * @method static mixed factory($count = null, $state = [])
 * @method static Builder|Valutatore newModelQuery()
 * @method static Builder|Valutatore newQuery()
 * @method static Builder|Valutatore query()
 * @method static Builder|Valutatore whereAnno($value)
 * @method static Builder|Valutatore whereBudget($value)
 * @method static Builder|Valutatore whereCreatedAt($value)
 * @method static Builder|Valutatore whereCreatedBy($value)
 * @method static Builder|Valutatore whereCreatedIp($value)
 * @method static Builder|Valutatore whereDeletedAt($value)
 * @method static Builder|Valutatore whereDeletedBy($value)
 * @method static Builder|Valutatore whereDeletedIp($value)
 * @method static Builder|Valutatore whereEnte($value)
 * @method static Builder|Valutatore whereId($value)
 * @method static Builder|Valutatore whereMatr($value)
 * @method static Builder|Valutatore whereNomeDiri($value)
 * @method static Builder|Valutatore whereNomeDiriPlus($value)
 * @method static Builder|Valutatore whereNomeStabi($value)
 * @method static Builder|Valutatore whereRepar($value)
 * @method static Builder|Valutatore whereReparTxt($value)
 * @method static Builder|Valutatore whereStabi($value)
 * @method static Builder|Valutatore whereStabiTxt($value)
 * @method static Builder|Valutatore whereUpdatedAt($value)
 * @method static Builder|Valutatore whereUpdatedBy($value)
 * @method static Builder|Valutatore whereUpdatedIp($value)
 * @method static Builder|Valutatore whereValutatoreId($value)
 *
 * @property int $n_diritto_excellence
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|Valutatore whereNDirittoExcellence($value)
 *
 * @property string|null $post_type
 * @property int|null $post_id
 * @property-read Profile|null $deleter
 *
 * @method static Builder<static>|Valutatore wherePostId($value)
 * @method static Builder<static>|Valutatore wherePostType($value)
 *
 * @mixin \Eloquent
 */
class Valutatore extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'stabi',
        'repar',
        'nome_stabi',
        'stabi_txt',
        'repar_txt',
        'ente',
        'matr',
        'anno',
        'nome_diri',
        'nome_diri_plus',
        'budget',
        'valutatore_id',
    ];

    // this will use the specified database connection
    protected $table = 'stabi_dirigente';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ----- relationship ---
    /**
     * @return HasOne<Repart, $this>
     */
    public function repart(): HasOne
    {
        return $this->hasOne(Repart::class, 'stabi', 'stabi')->where('repar', $this->repar)->where('ente', 90);
    }

    /**
     * @return HasMany<Model, $this>
     */
    public function schede(): HasMany
    {
        $schedaClass = Str::of(static::class)
            ->beforeLast('\\')
            ->append('\\Scheda')
            ->toString();

        $modelClass = class_exists($schedaClass) ? $schedaClass : Scheda::class;
        Assert::classExists($modelClass);
        Assert::subclassOf($modelClass, Model::class);

        /** @var class-string<Model> $modelClass */
        return $this->hasMany($modelClass, 'valutatore_id', 'id');
    }

    /**
     * @return HasOne<self, $this>
     */
    public function boss(): HasOne
    {
        return $this->hasOne(self::class, 'valutatore_id', 'id');
    }

    /**
     * @return HasMany<Model, $this>
     */
    public function benificiariProgressione(): HasMany
    {
        return $this->schede()->where('benificiario_progressione', 1);
    }

    // --- mutators --

    /**
     * getNomeStabiAttribute.
     *
     * @param  string|null  $value
     */
    public function getNomeStabiAttribute($value): ?string
    {
        if ($value !== null) {
            return $value;
        }
        if (! $this->repart instanceof Repart) {
            return $value;
        }

        return $this->repart->dest1;
    }

    /**
     * getNomeDiriAttribute.
     *
     * @param  string|null  $value
     */
    public function getNomeDiriAttribute($value): ?string
    {
        return $value;
    }
}
