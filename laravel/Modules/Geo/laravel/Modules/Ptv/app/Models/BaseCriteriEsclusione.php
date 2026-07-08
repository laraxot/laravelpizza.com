<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Progressioni\Database\Factories\CriteriEsclusioneFactory;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Models\Contracts\CriteriEsclusioneContract;
use Webmozart\Assert\Assert;

/**
 * class Modules\Ptv\Models\CriteriEsclusione.
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
 * @method static Builder|CriteriEsclusione newModelQuery()
 * @method static Builder|CriteriEsclusione newQuery()
 * @method static Builder|CriteriEsclusione query()
 * @method static Builder|CriteriEsclusione whereAnno($value)
 * @method static Builder|CriteriEsclusione whereCreatedAt($value)
 * @method static Builder|CriteriEsclusione whereCreatedBy($value)
 * @method static Builder|CriteriEsclusione whereFieldName($value)
 * @method static Builder|CriteriEsclusione whereId($value)
 * @method static Builder|CriteriEsclusione whereName($value)
 * @method static Builder|CriteriEsclusione whereOp($value)
 * @method static Builder|CriteriEsclusione whereType($value)
 * @method static Builder|CriteriEsclusione whereUpdatedAt($value)
 * @method static Builder|CriteriEsclusione whereUpdatedBy($value)
 * @method static Builder|CriteriEsclusione whereValue($value)
 *
 * @property Profile|null $creator
 * @property EloquentCollection<int, CriteriOption> $criteriOptions
 * @property int|null $criteri_options_count
 * @property Profile|null $updater
 * @property-read Profile|null $deleter
 * @property-read EloquentCollection<int, Scheda> $schede
 * @property-read int|null $schede_count
 *
 * @mixin \Eloquent
 */
abstract class BaseCriteriEsclusione extends BaseModel implements CriteriEsclusioneContract
{
    protected $fillable = ['id', 'name', 'field_name', 'op', 'value', 'type', 'anno'];

    protected $table = 'criteri_esclusione';

    // -------------------------

    /**
     * @return HasMany<Model, Model>
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

        // Passed through a Model-typed parameter (rather than calling $this->hasMany()
        // directly) so the relation's declaring side matches the interface's
        // HasMany<Model, Model> contract: TDeclaringModel is invariant, and $this here
        // is dynamically resolved per-module (see Str::of(static::class) above).
        return self::buildSchedeRelation($this, $modelClass);
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @return HasMany<Model, Model>
     */
    private static function buildSchedeRelation(Model $declaringModel, string $modelClass): HasMany
    {
        return $declaringModel->hasMany($modelClass, 'anno', 'anno');
    }

    /**
     * @return EloquentCollection<int, Model>
     */
    public function getSchedaCollection(): EloquentCollection
    {
        return $this->schede()->get();
    }

    /**
     * @return HasMany<Model, $this>
     */
    public function criteriOptions(): HasMany
    {
        $class = Str::of(static::class)->beforeLast('\\')->append('\\CriteriOption')->toString();
        Assert::classExists($class);
        Assert::subclassOf($class, Model::class);

        /** @var class-string<Model> $class */
        return $this->hasMany($class, 'anno', 'anno');
    }

    public function criteriOptionsCollection(): Collection
    {
        $criteriOption = $this
            ->criteriOptions
            ->map(function ($item) {
                $value = '';
                /** @phpstan-ignore-next-line */
                switch ($item->type) {
                    case 'list':
                        /** @phpstan-ignore-next-line */
                        $value = explode(',', $item->value);
                        break;
                    case 'int':
                        $value = intval($value);
                        break;
                    case 'date':
                        $value = $item->value;
                        if ($value != null) {
                            $value = Carbon::parse($value);
                        }
                        break;
                    default:
                        /** @phpstan-ignore-next-line */
                        dddx($item->type);
                        break;
                }
                /** @phpstan-ignore-next-line */
                $item->value_real = $value;

                return $item;
            })
            ->pluck('value_real', 'name');

        return $criteriOption;
    }
} // end class
