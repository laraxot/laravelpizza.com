<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Request;
use Route;

use function Safe\date;

/**
 * Modules\IndennitaCondizioniLavoro\Models\IndennitaTipo.
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $svocfi
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, IndennitaTipoDettaglio> $dettaglio
 * @property-read int|null $dettaglio_count
 * @method static Builder|IndennitaTipo newModelQuery()
 * @method static Builder|IndennitaTipo newQuery()
 * @method static Builder|IndennitaTipo query()
 * @method static Builder|IndennitaTipo whereCreatedAt($value)
 * @method static Builder|IndennitaTipo whereCreatedBy($value)
 * @method static Builder|IndennitaTipo whereId($value)
 * @method static Builder|IndennitaTipo whereNome($value)
 * @method static Builder|IndennitaTipo whereSvocfi($value)
 * @method static Builder|IndennitaTipo whereUpdatedAt($value)
 * @method static Builder|IndennitaTipo whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @property-read string $description
 * @mixin \Eloquent
 */
class IndennitaTipo extends BaseModel
{
    protected $table = 'indennita_tipo';

    protected $fillable = ['id', 'nome', 'svocfi' /* , 'anno' */];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio, $this>
     */
    public function dettaglio(): HasMany
    {
        $route_current = Route::current();
        $params = [];
        if (isset($route_current)) {
            $params = $route_current->parameters();
        }

        // $sql='(find_in_set('.$this->codqua.',only_codqua) or only_codqua="")';
        extract($params);
        if (! isset($anno)) {
            $anno = Request::input('year', date('Y'));
        }

        $safeAnno = is_numeric($anno) ? (int) $anno : (int) date('Y');

        return $this->hasMany(IndennitaTipoDettaglio::class, 'indennita_tipo_id', 'id')
            ->whereRaw('? between dal and al', [$safeAnno]);
        // ->whereRaw($this->anno.' between dal and al')
    }

    /**
     * Get the description attribute.
     */
    public function getDescriptionAttribute(): string
    {
        return $this->nome.' between dal and al';
    }
}
