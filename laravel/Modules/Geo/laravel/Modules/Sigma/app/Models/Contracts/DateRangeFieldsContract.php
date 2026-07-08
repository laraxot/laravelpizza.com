<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Contracts;

/**
 * Contratto per modelli Sigma che gestiscono intervalli date (dal/al + anno).
 *
 * Modelli che implementano questo contratto devono utilizzare il trait
 * {@see Modules\Sigma\Models\Traits\Scopes\CommonScope} e fornire i nomi
 * delle colonne che rappresentano l'inizio, la fine e l'anno dell'intervallo.
 *
 * @see Modules\Sigma\Models\BaseDateRangeModel
 * @see Modules\Sigma\Models\Traits\Scopes\CommonScope
 */
interface DateRangeFieldsContract
{
    /**
     * Nome della colonna che rappresenta la data di inizio intervallo (formato Ymd).
     *
     * @return literal-string
     */
    public function rangeFromField(): string;

    /**
     * Nome della colonna che rappresenta la data di fine intervallo (formato Ymd).
     * Valore 0 = nessuna data finale.
     *
     * @return literal-string
     */
    public function rangeToField(): string;

    /**
     * Nome della colonna che rappresenta l'anno dell'intervallo.
     *
     * @return literal-string
     */
    public function annFieldName(): string;
}
