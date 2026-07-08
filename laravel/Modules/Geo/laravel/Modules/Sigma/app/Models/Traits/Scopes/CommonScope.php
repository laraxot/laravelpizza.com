<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Scopes;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;
use Modules\Sigma\Models\Contracts\DateRangeFieldsContract;

/**
 * Scope condivisi per intervalli date — logica query qui, nomi colonne sul modello.
 *
 * Ogni consumer deve estendere BaseDateRangeModel e implementare
 * {@see DateRangeFieldsContract}.
 *
 * @see DateRangeFieldsContract
 *
 * @phpstan-require-implements DateRangeFieldsContract
 */
trait CommonScope
{
    /**
     * @return literal-string
     */
    abstract public function rangeFromField(): string;

    /**
     * @return literal-string
     */
    abstract public function rangeToField(): string;

    /**
     * @return literal-string
     */
    abstract public function annFieldName(): string;

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeOfQuarter(Builder $query, ?int $quarter, ?int $year): Builder
    {
        if ($quarter === null || $year === null) {
            return $query;
        }

        $m_from = (($quarter - 1) * 3) + 1;
        $from = Date::create($year, $m_from, 1, 0, 0, 0);
        $to = Date::create($year, $m_from, 1, 0, 0, 0);
        if (! $from instanceof Carbon) {
            throw new Exception('$from==null');
        }

        if (! $to instanceof Carbon) {
            throw new Exception('$to==null');
        }

        $to = $to->addMonths(3)->subDay();
        $fromField = $this->rangeFromField();
        $toField = $this->rangeToField();

        return $query
            ->where($fromField, '>=', (int) $from->format('Ymd'))
            ->where($toField, '<=', (int) $to->format('Ymd'));
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeOfFourMonthPeriod(Builder $query, ?int $fourMonthPeriod, ?int $year): Builder
    {
        if ($fourMonthPeriod === null || $year === null) {
            return $query;
        }

        $m_from = (($fourMonthPeriod - 1) * 4) + 1;
        $from = Date::create($year, $m_from, 1, 0, 0, 0);
        $to = Date::create($year, $m_from, 1, 0, 0, 0);
        if (! $from instanceof Carbon) {
            throw new Exception('$from==null');
        }

        if (! $to instanceof Carbon) {
            throw new Exception('$to==null');
        }

        $to = $to->addMonths(3)->subDay();
        $fromField = $this->rangeFromField();
        $toField = $this->rangeToField();

        return $query
            ->where($fromField, '>=', (int) $from->format('Ymd'))
            ->where($toField, '<=', (int) $to->format('Ymd'));
    }

    /**
     * Scope per filtrare per anno.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeOfYear(Builder $query, ?int $year): Builder
    {
        if ($year === null) {
            return $query;
        }

        if (isset($this->getAttributes()['anno'])) {
            return $query->where('anno', $year);
        }

        $fromField = $this->rangeFromField();
        $toField = $this->rangeToField();

        return $query->where(static function ($q) use ($year, $fromField, $toField): void {
            $q->where($fromField, '<=', ($year * 10000) + 1231)->where(static function ($q2) use ($year, $toField): void {
                $q2->where($toField, '>=', ($year * 10000) + 101)->orWhere($toField, '=', 0);
            });
        });
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeOfEnteYear(Builder $query, ?int $ente, ?int $year): Builder
    {
        if ($ente === null || $year === null) {
            return $query;
        }

        $annField = $this->annFieldName();
        $query = $query->where('ente', $ente)->where($annField, '');

        return $this->scopeOfYear($query, $year);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeOfEnte(Builder $query, ?int $ente): Builder
    {
        if ($ente === null) {
            return $query;
        }

        return $query->where('ente', $ente);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeOfDate(Builder $query, ?int $date): Builder
    {
        if ($date === null) {
            return $query;
        }

        $fromField = $this->rangeFromField();
        $toField = $this->rangeToField();

        return $query->where(static function (Builder $q) use ($date, $fromField, $toField): void {
            $q->where(static function (Builder $inner) use ($date, $fromField, $toField): void {
                $inner->where($fromField, '<=', $date)->where($toField, '>=', $date);
            })->orWhere(static function (Builder $inner) use ($date, $fromField, $toField): void {
                $inner->where($fromField, '<=', $date)->where($toField, '=', 0);
            });
        });
    }

    /**
     * @param  int|null  $date_start  Start date in Ymd format
     * @param  int|null  $date_end  End date in Ymd format (0 means no end date)
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    protected function scopeOfRangeDate(Builder $query, ?int $date_start, ?int $date_end): Builder
    {
        if ($date_start === null) {
            return $query;
        }

        $fromField = $this->rangeFromField();
        $toField = $this->rangeToField();

        if ($date_end === null || $date_end === 0) {
            return $query->where(static function (Builder $q) use ($date_start, $toField): void {
                $q->where($toField, '>=', $date_start)->orWhere($toField, '=', 0);
            });
        }

        return $query->where(static function (Builder $q) use ($date_start, $date_end, $fromField, $toField): void {
            $q->where(static function (Builder $inner) use ($date_start, $fromField, $toField): void {
                $inner->where(static function (Builder $i) use ($date_start, $fromField, $toField): void {
                    $i->where($fromField, '<=', $date_start)->where($toField, '>=', $date_start);
                })->orWhere(static function (Builder $i) use ($date_start, $fromField, $toField): void {
                    $i->where($fromField, '<=', $date_start)->where($toField, '=', 0);
                });
            })->orWhere(static function (Builder $inner) use ($date_end, $fromField, $toField): void {
                $inner->where(static function (Builder $i) use ($date_end, $fromField, $toField): void {
                    $i->where($fromField, '<=', $date_end)->where($toField, '>=', $date_end);
                })->orWhere(static function (Builder $i) use ($date_end, $fromField, $toField): void {
                    $i->where($fromField, '<=', $date_end)->where($toField, '=', 0);
                });
            })->orWhere(static function (Builder $inner) use ($date_start, $date_end, $fromField): void {
                $inner->whereBetween($fromField, [$date_start, $date_end]);
            });
        });
    }
}
