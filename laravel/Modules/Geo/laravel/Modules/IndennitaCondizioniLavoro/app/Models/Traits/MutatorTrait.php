<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models\Traits;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrAnnoMutator;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrDateRangeMutator;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrMutator;

// use Laravel\Scout\Searchable;
// ----- models------
// use Modules\IndennitaCondizioniLavoro\Models\IndennitaResponsabilita;
// ------ ext models---

// ----- services -----

// ------ traits ---

/**
 * Trait MutatorTrait.
 *
 * @SuppressWarnings("PMD.ShortVariable")
 * @SuppressWarnings("PMD.StaticAccess")
 * @SuppressWarnings("PMD.UnusedFormalParameter")
 */
trait MutatorTrait
{
    use EnteMatrAnnoMutator;
    use EnteMatrDateRangeMutator;
    use EnteMatrMutator;

    public function getFromFieldAttribute(?string $_value): string
    {
        return 'dal';
    }

    public function getToFieldAttribute(?string $_value): string
    {
        return 'al';
    }

    public function getQuadrimestreDal(): Carbon
    {
        $annoRaw = $this->anno ?? null;
        $quadrimestreRaw = $this->quadrimestre ?? null;

        $anno = is_int($annoRaw) || is_string($annoRaw) ? (int) $annoRaw : (int) date('Y');
        $quadrimestre = is_int($quadrimestreRaw) || is_string($quadrimestreRaw) ? (int) $quadrimestreRaw : 1;

        $startMonth = 1 + (($quadrimestre - 1) * 4);

        $startDate = Carbon::create($anno, $startMonth, 1);
        if (! $startDate instanceof Carbon) {
            throw new InvalidArgumentException('Invalid date creation');
        }

        return $startDate->startOfDay();
    }

    public function getQuadrimestreAl(): Carbon
    {
        $annoRaw = $this->anno ?? null;
        $quadrimestreRaw = $this->quadrimestre ?? null;

        $anno = is_int($annoRaw) || is_string($annoRaw) ? (int) $annoRaw : (int) date('Y');
        $quadrimestre = is_int($quadrimestreRaw) || is_string($quadrimestreRaw) ? (int) $quadrimestreRaw : 1;

        $startMonth = 1 + (($quadrimestre - 1) * 4);

        $startDate = Carbon::create($anno, $startMonth, 1);
        if (! $startDate instanceof Carbon) {
            throw new InvalidArgumentException('Invalid date creation');
        }

        return $startDate
            ->addMonths(4)
            ->subDay()
            ->endOfDay();
    }

    /**
     * @param  string|Carbon|null  $value
     */
    public function getDalAttribute($value): ?Carbon
    {
        if ($this->getKey() == null) {
            return null;
        }
        $value = $this->getQuadrimestreDal();
        $this->update(['dal' => $value]);

        return $value;
    }

    /**
     * @param  string|Carbon|null  $value
     */
    public function getAlAttribute($value): ?Carbon
    {
        if ($this->getKey() == null) {
            return null;
        }
        $value = $this->getQuadrimestreAl();
        $this->update(['al' => $value]);

        return $value;
    }

    public function getGgPresenzaPeriodoAttribute(?int $_value): ?int
    {
        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        // devo esplicitare quando e' stata aggiornata la tabella wstr01lx o non ha senso
        /*
        if (! \Request::input('refresh', false)) {
            if (null !== $value && ! request()->input('refresh', false)) {
                return $value;
            }
            if (null === $this->dal) {
                return 0;
            }
            if (null === $this->al) {
                return 0;
            }
        }
        */
        $dal = $this->dal;
        $al = $this->al;
        $anno = is_int($this->anno) || is_string($this->anno) ? (int) $this->anno : null;
        if ($anno !== null && $anno >= 2023) {
            $q = is_int($this->quadrimestre) || is_string($this->quadrimestre) ? (int) $this->quadrimestre : null;
            if ($q !== null) {
                $dal = Carbon::parse($anno.'-01-01')->addMonths(4 * ($q - 1));
                $al = Carbon::parse($anno.'-01-01')->addMonths(4 * $q)->subDays(1);
            }
            // dddx(['dal'=>$dal,'al'=>$al,'q'=>$q,'anno'=>$this->anno,'this'=>$this]);
        }

        if (! ($dal instanceof Carbon) || ! ($al instanceof Carbon)) {
            return 0;
        }

        $dal = (int) $dal->format('Ymd');
        $al = (int) $al->format('Ymd');
        // dddx([$dal,$al]);
        $gg = $this->wstr01lx()
            ->select('wtdata')
            ->distinct('wtdata')
            ->where('wtdata', '>=', $dal)
            ->where('wtdata', '<=', $al)
            ->get();
        // dddx([$gg->pluck('wtdata'),'al'=>$al]);
        $gg = $gg->count();

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        // getKey() è già stato controllato sopra, quindi non può essere null qui
        $this->update(['gg_presenza_periodo' => $gg]);

        return $gg;
    }
}
