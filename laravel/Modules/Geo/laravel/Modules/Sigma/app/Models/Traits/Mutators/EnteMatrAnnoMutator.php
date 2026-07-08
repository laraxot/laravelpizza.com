<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Illuminate\Database\Eloquent\Collection;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Qua00f;

trait EnteMatrAnnoMutator
{
    protected function getPercPTimeYearAttribute(mixed $_value): int|float
    {
        $rows = $this->qua00fYear();
        $array = $rows->get()->toArray();

        // echo '<pre>';print_r($array);echo '</pre>';

        $ore = 0.0;
        $giorni = 0;
        /** @var array<string, mixed> $v */
        foreach ($array as $v) {
            $oree = is_numeric($v['oree'] ?? null) ? (float) $v['oree'] : 0.0;
            $oret = is_numeric($v['oret'] ?? null) ? (float) $v['oret'] : 1.0;
            $giorniValue = is_numeric($v['giorni'] ?? null) ? (int) $v['giorni'] : 0;
            if ($oret !== 0.0) {
                $ore += ($oree / $oret) * $giorniValue;
            }
            $giorni += $giorniValue;
        }

        if ($giorni === 0) {
            return 0;
        }

        // echo '<h3>'.$ris.'</h3>';
        return $ore / $giorni;
    }

    protected function getPercParttimeAnnoAttribute(): ?float
    {
        $value = $this->attributes['perc_parttime_anno'] ?? null;
        if ($value !== null) {
            return is_numeric($value) ? (float) $value : null;
        }

        $date_max = ($this->anno * 10000) + 1231;
        $date_min = ($this->anno * 10000) + 101;
        $rows = $this->qua00f()
            ->getQuery()
            ->withDays($date_min, $date_max)
            ->withPercPtime()
            ->having('days', '>', 0)
            // ->sum(\DB::raw('order_product.price * order_product.quantity'));
            ->get();
        $perc = 0.0;
        $peso = 0;
        /** @var Qua00f $row */
        foreach ($rows as $row) {
            /** @var float|int|numeric-string|null $percPtime */
            $percPtime = $row->getAttribute('perc_ptime');
            /** @var float|int|numeric-string|null $days */
            $days = $row->getAttribute('days');
            $percPtimeFloat = $percPtime !== null ? (float) $percPtime : 0.0;
            $daysInt = $days !== null ? (int) $days : 0;
            $perc += $percPtimeFloat * $daysInt;
            $peso += $daysInt;
        }

        $value = 0.0;
        if ($peso !== 0) {
            $value = $perc / $peso;
        }

        // $value = number_format($value, 3);
        $this->perc_parttime_anno = $value;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return $value;
        }

        static::withoutEvents(function () use ($value): void {
            $this->update(['perc_parttime_anno' => $value]);
        });

        return $value;
    }

    protected function getGgParttimevertAnnoAttribute(): ?float
    {
        $value = $this->attributes['gg_parttimevert_anno'] ?? null;
        if ($value !== null) {
            return is_numeric($value) ? (float) $value : null;
        }
        $date_max = ($this->anno * 10000) + 1231;
        $date_min = ($this->anno * 10000) + 101;

        $aszRelation = $this->asz00k1();
        /** @var Collection<int, Asz00k1> $collection */
        $collection = $aszRelation
            ->getQuery()
            ->where('asztip', 505)
            ->where('aszcod', 97)
            ->withDays($date_min, $date_max)
            ->get();

        $value = 0.0;
        /** @var Asz00k1 $item */
        foreach ($collection as $item) {
            /** @var float|int|null $days */
            $days = $item->getAttribute('days');
            if (is_numeric($days)) {
                $value += (float) $days;
            }
        }
        // $value = number_format($value, 3);
        $this->gg_parttimevert_anno = $value;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return $value;
        }

        static::withoutEvents(function () use ($value): void {
            $this->update(['gg_parttimevert_anno' => $value]);
        });

        return $value;
    }

    /**
     * Get part-time vertical days for year.
     *
     * @param  mixed  $_value  Unused parameter (required by Laravel accessor pattern)
     */
    protected function getGgPTimeVertYearAttribute(mixed $_value): int|float
    {
        $aszRelation = $this->asz00k1Year();
        $asz = $aszRelation
            ->where('asztip', 505)
            ->where('aszcod', 97)
            ->get();
        $giorni = 0;
        /** @var Asz00k1 $v */
        foreach ($asz as $v) {
            $aszdur = is_numeric($v->aszdur) ? (int) $v->aszdur : 0;
            $giorni += $aszdur;
        }

        return $giorni;
    }

    protected function getGgParttimevertAttribute(?int $value): ?int
    {
        // *
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        // */
        $date_max = ($this->anno * 10000) + 1231;
        $date_min = ($this->anno * 10000) + 101;

        $aszRelation = $this->asz00k1();
        /** @var Collection<int, Asz00k1> $collection */
        $collection = $aszRelation
            ->getQuery()
            ->where('asztip', 505)
            ->where('aszcod', 97)
            ->withDays($date_min, $date_max)
            ->get();

        $value = 0.0;
        /** @var Asz00k1 $item */
        foreach ($collection as $item) {
            /** @var float|int|numeric-string|null $days */
            $days = $item->getAttribute('days');
            if (is_numeric($days)) {
                $value += (float) $days;
            }
        }
        // $value = number_format($value, 3);
        $this->gg_parttimevert = (int) $value;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return (int) $value;
        }

        static::withoutEvents(function () use ($value): void {
            $this->update(['gg_parttimevert' => $value]);
        });

        return (int) $value;
    }

    protected function getPercParttimeAttribute(?float $value): ?float
    {
        // *
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        // */
        $date_max = ($this->anno * 10000) + 1231;
        $date_min = ($this->anno * 10000) + 101;
        $rows = $this->qua00f()
            ->getQuery()
            ->withDays($date_min, $date_max)
            ->withPercPtime()
            ->having('days', '>', 0)
            // ->sum(\DB::raw('order_product.price * order_product.quantity'));
            ->get();
        $perc = 0.0;
        $peso = 0.0;
        /** @var Qua00f $row */
        foreach ($rows as $row) {
            // Proprietà dinamiche aggiunte da withDays() e withPercPtime()
            $percPtime = is_numeric($row->getAttribute('perc_ptime')) ? (float) $row->getAttribute('perc_ptime') : 0.0;
            $days = is_numeric($row->getAttribute('days')) ? (float) $row->getAttribute('days') : 0.0;
            $perc += $percPtime * $days;
            $peso += $days;
        }

        $value = $peso !== 0.0 ? ($perc / $peso) : 0.0;
        // $value = number_format($value, 3);
        $this->perc_parttime = $value;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return (float) $value;
        }

        static::withoutEvents(function () use ($value): void {
            $this->update(['perc_parttime' => $value]);
        });

        return (float) $value;
    }

    protected function serializeDate($date): string
    {
        return $date->format('Y-m-d');
    }
}
