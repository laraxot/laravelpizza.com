<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Traits;

use Carbon\Carbon;
use Request;

// @phpstan-ignore-next-line trait.unused (used dynamically via FunctionTrait)
trait MutatorTrait
{
    public function getFromFieldAttribute(?string $_value): string
    {
        return 'dal';
    }

    public function getToFieldAttribute(?string $_value): string
    {
        return 'al';
    }

    public function getDalAttribute()
    {
        // if(is_object($value)) return $value;
        // if($value!=null) return Carbon::parse($value);

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $dt = Carbon::create($this->anno, 1, 1, 0);
        $value = clone ($dt)->addQuarters($this->trimestre - 1);
        $this->dal = $value;

        $this->update([
            'dal' => $value,
        ]);

        return $value;
    }

    public function getAlAttribute()
    {
        // if(is_object($value)) return $value;
        // if($value!=null) return Carbon::parse($value);

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $dt = Carbon::create($this->anno, 1, 1, 0);
        $value = clone ($dt)->addQuarters($this->trimestre)->subDay();

        $this->al = $value;
        $this->update([
            'al' => $value,
        ]);

        return $value;
    }

    public function getGgPresenzaPeriodoAttribute(?int $value): ?int
    {
        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        // devo esplicitare quando e' stata aggiornata la tabella wstr01lx o non ha senso
        if (! Request::input('refresh', false)) {
            if ($value !== null && ! request()->input('refresh', false)) {
                return $value;
            }

            if ($this->dal === null) {
                return 0;
            }

            if ($this->al === null) {
                return 0;
            }
        }

        $dal = $this->dal->format('Ymd');
        $al = $this->al->format('Ymd');

        $gg = $this->wstr01lx()->select('wtdata')->distinct('wtdata')
            ->where('wtdata', '>=', $dal)
            ->where('wtdata', '<=', $al)
            ->get()->count();
        $this->gg_presenza_periodo = $gg;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return $gg;
        }

        $this->update([
            'gg_presenza_periodo' => $gg,
        ]);

        return $gg;
    }
}
