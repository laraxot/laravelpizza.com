<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sigma\Models\Contracts\DateRangeFieldsContract;
use Modules\Sigma\Models\Contracts\EnteMatrFieldsContract;
use Modules\Sigma\Models\Qua00f;

/**
 * Trait EnteMatrDateRangeRelationship.
 *
 * @phpstan-require-implements EnteMatrFieldsContract
 * @phpstan-require-implements DateRangeFieldsContract
 *
 * @property string $from_field Nome campo data inizio (via proprietà o accessor)
 * @property string $to_field Nome campo data fine (via proprietà o accessor)
 */
trait EnteMatrDateRangeRelationship
{
    // forse meglio tradurlo in uno scope
    /**
     * Get Qua00f records for date range.
     *
     * @return HasMany<Qua00f, static>|null
     */
    public function qua00fDaterange(): ?HasMany
    {
        // Accesso a from_field: prima proprietà pubblica, poi accessor Eloquent, poi default
        // @phpstan-ignore-next-line - Dynamic property access: from_field può essere proprietà o accessor
        $from_field = isset($this->from_field) && is_string($this->from_field) ? $this->from_field : 'dal';

        // Accesso a to_field: prima proprietà pubblica, poi accessor Eloquent, poi default
        // @phpstan-ignore-next-line - Dynamic property access: to_field può essere proprietà o accessor
        $to_field = isset($this->to_field) && is_string($this->to_field) ? $this->to_field : 'al';

        // @phpstan-ignore-next-line - Strict comparison using === between non-empty-string and '' will always evaluate to false
        if ($from_field === '') {
            $msg = [
                'err' => 'impostare mutator from_field',
                'class_basename' => class_basename($this),
                'get_class' => static::class,
                'from_field' => $from_field,
                'line' => __LINE__,
                'file' => __FILE__,
            ];
            echo '<pre>'.print_r($msg, true).'</pre>';

            return null;
        }

        $dal = 0;
        $al = 0;
        if (isset($this->$from_field, $this->$to_field)) {
            /*
             * dddx(
             * [
             * 'from_field' => $from_field,
             * 'val' => $this->{$from_field},
             * ]
             * );
             */
            $fromValue = $this->{$from_field};
            $toValue = $this->{$to_field};

            // Gestione tipi per from_field
            if ($fromValue instanceof \DateTimeInterface) {
                $dal = $fromValue->format('Ymd');
            } elseif (is_numeric($fromValue)) {
                $dal = (int) $fromValue;
            } elseif (is_string($fromValue)) {
                $dal = (int) $fromValue;
            } else {
                $dal = 0;
            }

            // Gestione tipi per to_field
            if ($toValue instanceof \DateTimeInterface) {
                $al = $toValue->format('Ymd');
            } elseif (is_numeric($toValue)) {
                $al = (int) $toValue;
            } elseif (is_string($toValue)) {
                $al = (int) $toValue;
            } else {
                $al = 0;
            }
        }

        $dalInt = (int) $dal;
        $alInt = (int) $al;

        $sql = '(
		(? between qua2kd and qua2ka ) or
		(? >= year(qua2kd) and qua2ka=0) or
		(? between qua2kd and qua2ka ) or
		(? between qua2kd and qua2ka ) or
		(qua2kd between ? and ? )
		)';

        // @phpstan-ignore-next-line - Template type TDeclaringModel on HasMany is not covariant
        return $this->hasManyByEnteMatr(Qua00f::class)
            ->selectRaw(
                'ente,matr,propro,posfun,posiz,disci1,codqua
                ,cont,tipco,ruolo
				,if(oree=0,36,oree) as oree
				,if(oret=0,36,oret) as oret

				,datediff(if(qua2ka=0 or qua2ka>?, ?, qua2ka),if(qua2kd<?,?,qua2kd))+1 as giorni
				',
                [$alInt, $alInt, $dalInt, $dalInt],
            )
            ->whereRaw('quaann=""')
            ->whereRaw($sql, [$dalInt, $dalInt, $alInt, $alInt, $dalInt, $alInt]);
    }
}
