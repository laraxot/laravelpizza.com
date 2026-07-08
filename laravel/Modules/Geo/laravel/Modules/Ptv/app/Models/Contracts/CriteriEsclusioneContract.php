<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\CriteriEsclusioneFactory;

/**
 * Contratto per i criteri di esclusione Eloquent.
 *
 * @phpstan-require-extends Model
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $field_name
 * @property string|null $op
 * @property string|null $value
 * @property string|null $type
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static CriteriEsclusioneFactory factory($count = null, $state = [])
 * @method static Builder<Model> newModelQuery()
 * @method static Builder<Model> newQuery()
 * @method static Builder<Model> query()
 * @method static Builder<Model> whereAnno($value)
 * @method static Builder<Model> whereCreatedAt($value)
 * @method static Builder<Model> whereCreatedBy($value)
 * @method static Builder<Model> whereFieldName($value)
 * @method static Builder<Model> whereId($value)
 * @method static Builder<Model> whereName($value)
 * @method static Builder<Model> whereOp($value)
 * @method static Builder<Model> whereType($value)
 * @method static Builder<Model> whereUpdatedAt($value)
 * @method static Builder<Model> whereUpdatedBy($value)
 * @method static Builder<Model> whereValue($value)
 */
interface CriteriEsclusioneContract
{
    /**
     * Ottiene la relazione HasMany delle schede associate al criterio.
     */
    /**
     * @return HasMany<Model, Model>
     */
    public function schede(): HasMany;

    /**
     * Ottiene la collezione iterabile delle schede per la verifica criteri.
     */
    /**
     * @return Collection<int, Model>
     */
    public function getSchedaCollection(): Collection;

    /**
     * Ottiene la collezione delle opzioni dei criteri.
     *
     * @return \Illuminate\Support\Collection<string, mixed>
     */
    public function criteriOptionsCollection(): \Illuminate\Support\Collection;

    /**
     * Ottiene un attributo del modello (eredita da Eloquent Model).
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key);
}
