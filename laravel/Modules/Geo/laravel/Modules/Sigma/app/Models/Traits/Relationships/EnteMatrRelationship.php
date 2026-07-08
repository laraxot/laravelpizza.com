<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Wstr01lx;

/**
 * @property int|null $anno
 */
trait EnteMatrRelationship
{
    /**
     * @return HasMany<Wstr01lx, $this>
     */
    public function wstr01lx(): HasMany
    {
        $enteField = $this->enteField();
        $matrField = $this->matrField();

        return $this->hasMany(Wstr01lx::class, 'wtmatr', $matrField)
            ->where('enteap', $this->{$enteField})
            ->where('wtannu', '');
    }

    /**
     * @return HasMany<Wstr01lx, $this>
     */
    public function wstr01lxYear(): HasMany
    {
        $anno = $this->getAttribute('anno');
        if (! is_numeric($anno)) {
            return $this->wstr01lx()->whereRaw('1 = 0');
        }

        return $this->wstr01lx()
            ->whereRaw('year(wtdata) = ?', [(string) $anno]);
    }

    /**
     * @return HasOne<Anag, $this>
     */
    public function anag(): HasOne
    {
        return $this->hasOneByEnteMatr(Anag::class);
    }

    /**
     * @return HasMany<Ana02f, $this>
     */
    public function ana02f(): HasMany
    {
        return $this->hasManyByEnteMatr(Ana02f::class)
            ->whereRaw("anaann = '' ");
    }

    /**
     * @return HasOne<Ana10f, $this>
     */
    public function ana10f(): HasOne
    {
        return $this->hasOneByEnteMatr(Ana10f::class);
    }

    /**
     * @return HasMany<Qua00f, $this>
     */
    public function qua00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Qua00f::class);
    }

    /**
     * @return HasMany<Rep00f, $this>
     */
    public function rep00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Rep00f::class);
    }

    /**
     * @return HasMany<Sto00f, $this>
     */
    public function sto00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Sto00f::class);
    }

    /**
     * @return HasMany<Qua03f, $this>
     */
    public function qua03f(): HasMany
    {
        return $this->hasManyByEnteMatr(Qua03f::class);
    }

    /**
     * @return HasMany<Asz00f, $this>
     */
    public function asz00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Asz00f::class);
    }

    /**
     * @return HasMany<Asz00k1, $this>
     */
    public function asz00k1(): HasMany
    {
        return $this->hasManyByEnteMatr(Asz00k1::class);
    }

    /**
     * @return HasMany<Integparam, $this>
     */
    public function integParams(): HasMany
    {
        return $this->hasManyByEnteMatr(Integparam::class);
    }
}
