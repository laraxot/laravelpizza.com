<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ExtraContract;
use Modules\Xot\Database\Factories\ExtraFactory;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

/**
 * Model Extra.
 *
 * @property int $id
 * @property int|null $model_id
 * @property string|null $model_type
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra_attributes
 *
 * @method static Builder|BaseModel disableCache()
 * @method static ExtraFactory factory($count = null, $state = [])
 * @method static Builder|Extra newModelQuery()
 * @method static Builder|Extra newQuery()
 * @method static Builder|Extra query()
 * @method static Builder|BaseModel withCacheCooldownSeconds(?int $seconds = null)
 * @method static Builder|Extra withExtraAttributes()
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder|Extra whereCreatedAt($value)
 * @method static Builder|Extra whereCreatedBy($value)
 * @method static Builder|Extra whereDeletedAt($value)
 * @method static Builder|Extra whereDeletedBy($value)
 * @method static Builder|Extra whereExtraAttributes($value)
 * @method static Builder|Extra whereId($value)
 * @method static Builder|Extra whereModelId($value)
 * @method static Builder|Extra whereModelType($value)
 * @method static Builder|Extra whereUpdatedAt($value)
 * @method static Builder|Extra whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
abstract class BaseExtra extends BaseModel implements ExtraContract
{
    use SchemalessAttributesTrait;

    /** @var string */
    protected $connection = 'xot';

    protected $fillable = [
        'id',
        'model_id',
        'model_type',
        'extra_attributes',
    ];

    // ✅ CORRETTO: NON implementare scopeWithExtraAttributes() manualmente
    // Il trait SchemalessAttributesTrait lo fornisce automaticamente!

    /**
     * Il record a cui questi attributi extra appartengono.
     *
     * `model_type` e `model_id` sono dichiarati qui in `$fillable` da sempre, e
     * `HasExtraTrait::extra()` scrive su di loro con una `morphOne`, ma il lato
     * inverso non esisteva: chi partiva da un `Extra` non aveva modo di
     * risalire al record che lo possiede.
     *
     * Serve alle policy. Un `Extra` non ha un tenant proprio — lo prende da chi
     * lo possiede — quindi senza questa relazione l'unico controllo possibile
     * era un permesso, che vale per tutti i clienti insieme
     * (module_quaeris_fila5#34).
     *
     * Passare dalla relazione e non dal confronto di `model_type` a mano non e'
     * pignoleria: quella colonna puo' contenere l'alias della morph map oppure
     * il nome completo della classe, a seconda di quando la riga e' stata
     * scritta. Eloquent risolve entrambi, un `===` no.
     *
     * @return MorphTo<Model, $this>
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'extra_attributes' => SchemalessAttributes::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
