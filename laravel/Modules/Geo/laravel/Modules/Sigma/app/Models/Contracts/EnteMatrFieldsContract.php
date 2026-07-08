<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Contracts;

use Modules\Sigma\Models\BaseModel;

/**
 * Contratto per modelli Sigma ancorati a ente + matricola.
 *
 * I nomi colonna vivono sul modello owner (legacy Sigma: spesso `ente`/`matr`,
 * eccezioni `enteap`/`dtmatr`, `wtmatr`, …). Le relazioni HasMany verso
 * Qua00f, Rep00f, Sto00f, … usano questi metodi invece di hardcodare stringhe.
 *
 * Non sono accessor Eloquent: restituiscono il nome colonna, non il valore.
 * Per i valori usare `$model->matr` / `$model->ente` o `getMatrAttribute()`.
 *
 * @see BaseModel::hasManyByEnteMatr()
 */
interface EnteMatrFieldsContract
{
    public function matrField(): string;

    public function enteField(): string;

    public function yearField(): string;
}
