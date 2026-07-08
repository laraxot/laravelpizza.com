<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\MaxCatecoPosfunAnnoFactory;
use Modules\Ptv\Models\Profile;

/**
 * @property int $id
 * @property string|null $cateco
 * @property string|null $posfun
 * @property int $anno
 * @property string $max_gg_tot_pond
 * @property int $aventi_diritto
 * @property int $aventi_diritto_perc
 * @property int $aventi_diritto_eff
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property-read Collection<int, Scheda> $schede
 * @property-read int|null $schede_count
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static MaxCatecoPosfunAnnoFactory factory($count = null, $state = [])
 * @method static Builder<static>|MaxCatecoPosfunAnno query()
 *
 * @mixin \Eloquent
 */
class MaxCatecoPosfunAnno extends BaseModel
{
    protected $table = 'cateco_posfun_max_tot_pond';

    /** @var array<int, string> */
    public array $xls_fields = ['id', 'cateco', 'posfun', 'anno', 'max_gg_tot_pond'];

    /** @var list<string> */
    protected $fillable = ['cateco', 'posfun', 'anno', 'max_gg_tot_pond', 'aventi_diritto', 'aventi_diritto_perc', 'aventi_diritto_eff'];

    /** @return HasMany<Scheda, $this> */
    public function schede(): HasMany
    {
        return $this->hasMany(Scheda::class, 'categoria_ecoval', 'cateco')
            ->where('posfunval', $this->posfun)
            ->where('anno', $this->anno);
    }

    public function getAventiDirittoAttribute(?int $value): int
    {
        $aventiDiritto = $this->schede()->select('matr')->where('ha_diritto', 1)->distinct()->count();
        $this->aventi_diritto = $aventiDiritto;

        if ($this->getKey() !== null) {
            $this->update(['aventi_diritto' => $aventiDiritto]);
        }

        return $aventiDiritto;
    }

    public function getAventiDirittoEffAttribute(?int $value): int
    {
        $num = $this->aventi_diritto * $this->aventi_diritto_perc / 100;
        $aventiDirittoEff = $num - floor($num) > 0.5 ? (int) round($num, 0) : (int) floor($num);
        $this->aventi_diritto_eff = $aventiDirittoEff;

        if ($this->getKey() !== null) {
            $this->update(['aventi_diritto_eff' => $aventiDirittoEff]);
        }

        return $aventiDirittoEff;
    }
}